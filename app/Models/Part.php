<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'file_id',
        'name',
        'type',
   ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

}
