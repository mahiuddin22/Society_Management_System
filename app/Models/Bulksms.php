<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulksms extends Model
{
    use HasFactory;
    protected $fillable = ['sms_type','draft_id','language','custom_sms','sending_method','schedule_time'];

    public function draftsms(){
        return $this->belongsTo(Draft::class,'draft_id');
    }

}
