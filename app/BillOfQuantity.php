<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillOfQuantity extends Model
{
    protected $guarded = [];

    protected $hidden = ['created_at','updated_at'];

    public function Tender(){
        return $this->belongsTo(Tender::class);
    }
    public function SubContractor(){
        return $this->belongsTo(SubContractor::class);
    }
}
