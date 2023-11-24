<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{
    use HasFactory;

    protected $table = 'demo';
    protected $fillable = [
        'full_name',
        'company',
        'email',
        'no_telp',
        'industri',
        'solusi',
        'keterangan'
    ];
}
