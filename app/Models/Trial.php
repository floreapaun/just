<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trial extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'court_id',
        'file_id',
        'status_id',
	'type',
	'document',
	'solution',
        'date',
   ];
}
