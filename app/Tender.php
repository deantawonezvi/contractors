<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $guarded = [];

    public function tenderType(){
        return $this->belongsTo(TenderType::class);
    }

    public function businessType(){
        return $this->belongsTo(BusinessType::class);
    }

    public function organisation(){
        return $this->belongsTo(Organisation::class);
    }
}
