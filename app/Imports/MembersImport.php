<?php

namespace App\Imports;

use App\Models\PlotAndUnit;
use App\Models\PlotType;
use App\Models\Road;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $plotAndUnit = new PlotAndUnit();
            $road = Road::class::where('name', $row['road'])->first();
            if ($road) {
                $plotAndUnit->road_id = $road->id;
            } else {
                $newRoad = new Road();
                $newRoad->name = $row['road'];
                $newRoad->save();

                $plotAndUnit->road_id = $newRoad->id;
            }
            $plotAndUnit->holding_no         = $row['holding_no'];
            $buildingType = PlotType::class::where('name', $row['plot type'])->first();
            if ($buildingType) {
                $plotAndUnit->building_type  = $buildingType->id;
            } else {
                $newBuildingType = new PlotType();
                $newBuildingType->name  = $row['plot type'];
                $newBuildingType->save();
                $plotAndUnit->building_type  = $newBuildingType->id;
            }
            $plotAndUnit->total_flat         = $row['total_flat'];
            $plotAndUnit->occupied_flat      = $row['occupied_flat'];
            $plotAndUnit->building_name      = $row['building name'];
            $plotAndUnit->collection_type    = $row['collection_type'];
            $plotAndUnit->contact_person     = $row['contact person'];
            $plotAndUnit->collection_rate    = $row['collection rate'];
            $plotAndUnit->discount           = $row['discount'];
            $plotAndUnit->collection_amount  = $row['collection amount'];
            $plotAndUnit->date               = $row['issue date']->format('Y-m-d');
            $plotAndUnit->name               = $row['contact person name'];
            $plotAndUnit->flat_no            = $row['flat no'];
            $plotAndUnit->number             = $row['mobile number'];
            $plotAndUnit->email              = $row['email'];
            $plotAndUnit->amount             = $row['amount'];
            $plotAndUnit->save();

            $plotAndUnit->unique_id          = 'UT03'. $road->id. $row['holding_no']. $plotAndUnit->id. $row['total_flat'];
        }
    }
}