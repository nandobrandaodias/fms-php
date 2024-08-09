<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'user_id', 'reference_month',
        'created_at', 'is_approved'
    ];

    public $timestamps = false;

    use HasFactory;

    public function users(){
        return $this->belongTo(User::class);
    }

    public function bills(){
        return $this->hasMany(Bill::class);
    }
}
