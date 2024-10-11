<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDonation extends Model
{
    use HasFactory;

    protected $table = 'user_donations';

    protected $fillable = ['donation_id', 'user_id', 'amount'];
}
