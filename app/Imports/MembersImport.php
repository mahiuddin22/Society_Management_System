<?php

namespace App\Imports;

use App\Models\Member;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $member = new Member();
            $member->name = $row['name'];
            $member->flat_no = $row['flat_no'];
            $member->number = $row['phone_number'];
            $member->email = $row['email'];
            $member->save();
        }
    }
}