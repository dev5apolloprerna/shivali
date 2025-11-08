<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    public $table = 'inquiry';
    protected $fillable = [
        'inquiry_id',
        'name',
        'mobileNumber',
        'email',
        'subject',
        'message',
        'business_type',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'strIp'
    ];
}
