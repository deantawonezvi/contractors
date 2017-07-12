<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillOfQuantity extends Model
{
    public function Tender(){
        return $this->belongsTo(Tender::class);
    }
    public function SubContractor(){
        return $this->belongsTo(SubContractor::class);
    }
}
