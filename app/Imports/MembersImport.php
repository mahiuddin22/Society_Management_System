<?php

namespace App\Imports;

use App\Models\PlotAndUnit;
use App\Models\PlotType;
use App\Models\Road;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MembersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows->shift();
        foreach ($rows as $row) {
        
            $plotAndUnit = new PlotAndUnit();

            $road = Road::where('name', $row[0])->first();

            if ($road) {
                $plotAndUnit->road = $road->id;
            } else {
                $newRoad = new Road();
                $newRoad->name = $row[0];
                $newRoad->save();

                $plotAndUnit->road = $newRoad->id;
            }

            $plotAndUnit->holding_no = $row[1];

            $buildingType = PlotType::where('name', $row[2])->first();
            if ($buildingType) {
                $plotAndUnit->building_type = $buildingType->id;
            } else {
                $newBuildingType = new PlotType();
                $newBuildingType->name = $row[2];
                $newBuildingType->save();

                $plotAndUnit->building_type = $newBuildingType->id;
            }

            $plotAndUnit->total_flat        = $row[3];
            $plotAndUnit->occupied_flat     = $row[4];
            $plotAndUnit->building_name     = $row[5];
            $plotAndUnit->collection_type   = $row[6];
            $plotAndUnit->collection_rate   = $row[7];
            $plotAndUnit->discount          = $row[8];
            $plotAndUnit->collection_amount = $row[9];
            $plotAndUnit->date              = Carbon::instance(Date::excelToDateTimeObject($row[10]));
            $plotAndUnit->name              = $row[11];
            $plotAndUnit->flat_no           = $row[12];
            $plotAndUnit->number            = $row[13];
            $plotAndUnit->email             = $row[14];
            
            $paymentStatus = $row[15];
            if($paymentStatus == 'Paid'){
                $plotAndUnit->payment_status    = 1;
                }else{
                $plotAndUnit->payment_status    = 0;
            }

            $plotAndUnit->save();

            $plotAndUnit->unique_id = 'UT03' . $plotAndUnit->road . $row[1] . $plotAndUnit->id . $row[3];
            $plotAndUnit->save();
        }
    }
}
