<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function memberdetails($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'flat_no' => $member->flat_no,
            'number'  => $member->number,
            'email'   => $member->email,
        ]);
    }
}
