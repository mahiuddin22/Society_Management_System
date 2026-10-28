<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\PlotAndUnit;
use App\Models\Road;
use App\Models\PlotType;
use App\Models\Bulksms;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function plotManagement(Request $request)
    {
        $filters = $this->dateFilters($request, 'created_at');
        $query = PlotAndUnit::with(['road', 'plotType'])->whereBetween('created_at', [$filters['from'].' 00:00:00', $filters['to'].' 23:59:59']);
        foreach (['status', 'collection_type'] as $filter) if ($request->filled($filter)) $query->where($filter, $request->input($filter));
        if ($request->filled('road_id')) $query->where('road_id', $request->road_id);
        if ($request->filled('plot_type_id')) $query->where('plot_type_id', $request->plot_type_id);
        if ($request->filled('search')) { $s=trim($request->search); $query->where(fn($q)=>$q->where('holding_no','like',"%$s%")->orWhere('name','like',"%$s%")->orWhere('phone','like',"%$s%")); }
        $rows = $query->latest('created_at')->get();
        if ($response = $this->export($request, 'plotmanagement', 'Plot Management Report', ['Date','Holding','Building','Road','Plot type','Contact','Phone','Collection type','Status'], $rows->map(fn($p)=>[$p->created_at?->format('Y-m-d'),$p->holding_no,$p->building_name,$p->road?->number,$p->plotType?->name,$p->name,$p->phone,$p->collection_type,$p->status])->all())) return $response;
        return view('admin.report.plotmanagement', ['rows'=>$query->paginate(30)->withQueryString(),'filters'=>$filters,'roads'=>Road::orderBy('number')->get(),'plotTypes'=>PlotType::orderBy('name')->get()]);
    }

    public function billCollections(Request $request)
    {
        $filters=$this->dateFilters($request,'payment_date');
        $query=Payment::with(['bill.plotAndUnit.road','collector'])->whereBetween('payment_date',[$filters['from'],$filters['to']]);
        if($request->filled('method')) $query->where('method',$request->method);
        if($request->filled('road_id')) $query->whereHas('bill.plotAndUnit',fn($q)=>$q->where('road_id',$request->road_id));
        if($request->filled('search')) { $s=trim($request->search); $query->where(fn($q)=>$q->where('payment_number','like',"%$s%")->orWhere('transaction_ref','like',"%$s%")->orWhereHas('bill.plotAndUnit',fn($p)=>$p->where('holding_no','like',"%$s%")->orWhere('name','like',"%$s%"))); }
        $rows=$query->latest('payment_date')->latest('id')->get();
        if($response=$this->export($request,'billcollections','Bill Collections Report',['Date','Receipt','Holding','Resident','Road','Method','Transaction ref','Collector','Amount'],$rows->map(fn($p)=>[$p->payment_date?->format('Y-m-d'),$p->payment_number,$p->bill?->plotAndUnit?->holding_no,$p->bill?->plotAndUnit?->name,$p->bill?->plotAndUnit?->road?->number,$p->method,$p->transaction_ref,$p->collector?->name,$p->amount])->all())) return $response;
        return view('admin.report.billcollections',['rows'=>$query->paginate(30)->withQueryString(),'filters'=>$filters,'roads'=>Road::orderBy('number')->get(),'total'=>$rows->sum('amount')]);
    }

    public function bulkSms(Request $request)
    {
        $filters=$this->dateFilters($request,'created_at');
        $query=Bulksms::with('draftsms')->whereBetween('created_at',[$filters['from'].' 00:00:00',$filters['to'].' 23:59:59']);
        foreach(['status','sms_type','sending_method'] as $filter) if($request->filled($filter)) $query->where($filter,$request->input($filter));
        if($request->filled('mobile_no')) $query->where('phone_no','like','%'.trim($request->mobile_no).'%');
        $rows=$query->latest('created_at')->get();
        if($response=$this->export($request,'bulksms','Bulk SMS Report',['Sent at','Phone','Type','Language','Message','Sending method','Scheduled at','Status'],$rows->map(fn($s)=>[$s->created_at?->format('Y-m-d H:i'),$s->phone_no,$s->sms_type,$s->language,$s->sms_type==='draft'?($s->draftsms?->message ?? ''):$s->custom_sms,$s->sending_method,$s->schedule_time,$s->status])->all())) return $response;
        return view('admin.report.bulksms',['rows'=>$query->paginate(30)->withQueryString(),'filters'=>$filters]);
    }

    private function dateFilters(Request $request, string $field): array
    {
        $request->merge([
            'date_from' => $request->input('date_from', now()->startOfMonth()->toDateString()),
            'date_to' => $request->input('date_to', now()->toDateString()),
        ]);
        $data=$request->validate(['date_from'=>['required','date'],'date_to'=>['required','date','after_or_equal:date_from']]);
        return ['from'=>$data['date_from'],'to'=>$data['date_to']];
    }

    private function export(Request $request,string $name,string $title,array $headings,array $rows)
    {
        $type=strtolower((string)$request->query('export'));
        if(!in_array($type,['csv','xlsx','pdf'],true)) return null;
        if($type==='pdf') return $this->pdf($title,$headings,$rows,$name);
        return Excel::download(new ReportExport($headings,$rows),$name.'.'.($type==='csv'?'csv':'xlsx'),$type==='csv'?\Maatwebsite\Excel\Excel::CSV:\Maatwebsite\Excel\Excel::XLSX);
    }

    private function pdf(string $title,array $headings,array $rows,string $name): StreamedResponse
    {
        // Small self-contained PDF writer keeps reporting usable without an optional PDF package.
        $lines=[$title,implode(' | ',$headings),''];
        foreach($rows as $row) $lines[]=implode(' | ',array_map(fn($v)=>preg_replace('/\s+/u',' ',(string)($v??'')),$row));
        $escape=fn($value)=>str_replace([chr(92),'(',')'],[chr(92).chr(92),chr(92).'(',chr(92).')'],iconv('UTF-8','ASCII//TRANSLIT//IGNORE',(string)$value) ?: '');
        $stream="BT /F1 8 Tf 35 805 Td 11 TL\n";
        foreach($lines as $line) $stream.='('.$escape($line).") Tj T*\n";
        $stream.="ET";
        $objects=["<< /Type /Catalog /Pages 2 0 R >>","<< /Type /Pages /Kids [3 0 R] /Count 1 >>","<< /Type /Page /Parent 2 0 R /MediaBox [0 0 842 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>","<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>",'<< /Length '.strlen($stream)." >>\nstream\n$stream\nendstream"];
        $pdf="%PDF-1.4\n";$offsets=[0];foreach($objects as $i=>$object){$offsets[]=strlen($pdf);$pdf.=($i+1)." 0 obj\n$object\nendobj\n";}$xref=strlen($pdf);$pdf.="xref\n0 ".(count($objects)+1)."\n0000000000 65535 f \n";for($i=1;$i<count($offsets);$i++)$pdf.=sprintf('%010d 00000 n ',$offsets[$i])."\n";$pdf.="trailer << /Size ".(count($objects)+1)." /Root 1 0 R >>\nstartxref\n$xref\n%%EOF";
        return response()->streamDownload(fn()=>print($pdf),$name.'.pdf',['Content-Type'=>'application/pdf']);
    }
}



