<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revoke extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'file_id',
        'date',
        'parts',
        'type',
   ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
