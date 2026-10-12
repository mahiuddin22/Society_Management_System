<?php

namespace App\Imports;

use App\Models\PlotAndUnit;
use App\Models\PlotType;
use App\Models\Road;
use Brick\Math\BigInteger;
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

            $buildingType = PlotType::where('name', $row[0])->first();
            if (!$buildingType) {
                throw new \Exception('Plot type not found: ' . $row[0]);
            }

            $roadNumber = trim(str_ireplace('Road', '', $row[1]));
            $roadNumber = trim($roadNumber);

            $road = Road::where('number', $roadNumber)->first();
            $plotAndUnit->plot_type_id      = (int) $buildingType->id;
            $plotAndUnit->road_id           = $road->id;
            $plotAndUnit->holding_no        = $row[2];
            $plotAndUnit->building_name     = $row[3];
            $plotAndUnit->total_flat        = $row[4];
            $plotAndUnit->occupied_flat     = $row[5];
            $plotAndUnit->collection_type   = $row[6];
            $plotAndUnit->flat_no           = $row[7];
            $plotAndUnit->name              = $row[8];
            $plotAndUnit->phone             = $row[10];
            $plotAndUnit->email             = $row[11];
            $plotAndUnit->collection_rate   = $row[12];
            $plotAndUnit->discount          = $row[13];
            $plotAndUnit->total_amount      = intval($row[14]);

            $plotAndUnit->unique_id = 'UTR03-' . $road->number . $row[2] . '-'
                . match (true) {
                    ((int) $row[5] === 0 || $row[5] === null) && $buildingType->id === 2 => 'CONS',
                    ((int) $row[5] === 0 || $row[5] === null) && $buildingType->id === 1 => 'EMT',
                    default => $row[7],
                };

            $plotAndUnit->save();
        }
    }
}
