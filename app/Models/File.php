<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'court_id',
        'crime',
        'date_registered',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class); 
    }

}
