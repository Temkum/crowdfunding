<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_amount',
        'current_amount',
        'description',
        'completed',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contributors()
    {
        return $this->belongsToMany(User::class)->withPivot('amount')->using(UserDonation::class);
    }

    // Helper methods

    public function isCompleted()
    {
        return $this->current_amount >= $this->target_amount;
    }

    public function remainingAmount()
    {
        return max(0, $this->target_amount - $this->current_amount);
    }
}
