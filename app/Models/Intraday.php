<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intraday extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function intravalues()
    {
        return $this->hasMany(IntraValue::class);
    }
}
