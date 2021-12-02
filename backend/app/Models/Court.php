<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;
   
    public $timestamps = false;

    protected $fillable = [
        'active',
    ];

    public function files()
    {
        return $this->belongsToMany(File::class, 'trials')->using(Trial::class);
    }
}
