<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];

    const TYPE_LAND             = 'land';
    const TYPE_RESIDENTIAL      = 'residential';
    const TYPE_COMMERCIAL       = 'commercial';

    const TYPE_PURCHASING_BUY   = 'buy';
    const TYPE_PURCHASING_RENT  = 'rent';
}
