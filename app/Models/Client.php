<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name', 'deploy_date', 'end_contract_date',
        'bill_value', 'expiration_bill_date'
    ];
    use HasFactory;

    public $timestamps = false;
    
    protected $hidden = [
        'pivot'
    ];
    
    public function system()
    {
        return $this->belongsToMany(System::class);
    }

    public function bills(){
        return $this->hasMany(Bill::class);
    }
}
