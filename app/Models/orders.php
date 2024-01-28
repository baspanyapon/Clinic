<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'order_id',
        'discount',
        'date_order'
    ];
    public function pname()
    {
        return $this->hasOne(patient_list::class, 'patient_id', 'patient_id');
    }
}
