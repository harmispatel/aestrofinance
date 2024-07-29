<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntraValue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function intraday()
    {
        return $this->belongsTo(Intraday::class);
    }
}
