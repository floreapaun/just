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
        'date_registered',
        'date_appeal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function revokes()
    {
        return $this->hasMany(Revoke::class);
    }

    public function trials()
    {
        return $this->hasMany(Trial::class);
    }

    public function crimes()
    {
        return $this->belongsToMany(Crime::class);
    }

    public function courts()
    {
        return $this->belongsToMany(Court::class, 'trials')->using(Trial::class);
    }
}
