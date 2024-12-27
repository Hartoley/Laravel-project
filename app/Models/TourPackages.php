<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackages extends Model
{
    use HasFactory;
    protected $fillable = [
        'destination',
        'tour_decs',
        'tourDuration',
        'tour_name',
        'tour_prices',
        'images',
        'boarding_date',
        'boarding_time'
    ];
}
