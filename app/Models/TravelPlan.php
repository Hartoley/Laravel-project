<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'surname',
        'email',
        'mobileNum',
        'tourName',
        'instructions',
        'paymentImage',
        'paymentStatus',
    ];
}
