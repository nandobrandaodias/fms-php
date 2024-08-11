<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'cost', 'client_id', 'billing_id', 'reference_month',
        'expiration_date', 'is_open'
    ];

    public $timestamps = false;

    use HasFactory;

    public function clients(){
        return $this->belongsTo(Client::class);
    }

    public function billings(){
        return $this->belongsTo(Billing::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
