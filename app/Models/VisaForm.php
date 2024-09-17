<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaForm extends Model
{
    use HasFactory;
    protected $fillable =[
        'email',
        'surname',
        'first_name',
        'residence',
        'marital_status',
        'national_identity_number',
        'travel_document',
        'journey_purpose',
        'arrival',
        'departure',
        'travel_companion',
        'transaction_id',
        'status'
    ];
    protected $casts = [
        'travel_companion' => 'array',
    ];
}
