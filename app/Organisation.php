<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    public function businessType(){
        return $this->belongsTo(BusinessType::class);
    }
}
