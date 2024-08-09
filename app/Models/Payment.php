<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'bill_id', 'value', 'created_at',
        'payment_method', 'payment_date' 
    ];

    use HasFactory;

    public $timestamps = false;
    public function bills(){
        return $this->belongsTo(Bill::class);
    }
}
