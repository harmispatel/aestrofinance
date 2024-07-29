<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportantGrah extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function grahWiseData(){
        return $this->hasMany(GrahViseData::class,'id','grah_wise_id');
    }
}
