<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $fillable = [
        'name', 'description'
    ];
    use HasFactory;

    public $timestamps = false;

    protected $hidden = [
        'pivot'
    ];

    public function client(){
        return $this->belongsToMany(Client::class);
    }
}
