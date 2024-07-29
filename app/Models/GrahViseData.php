<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrahViseData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function importantGrah(){
        return $this->belongsTo(ImportantGrah::class,'grah_wise_id','id');
    }
}
