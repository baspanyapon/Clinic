<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stocks_log extends Model
{
    use HasFactory;
    protected $fillable = [
        'stock_id',
        'status'
    ];

}
