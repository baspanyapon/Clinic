<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class drugs_list extends Model
{
    use HasFactory;
    protected $fillable = [
        'drug_id',
        'drug_name',
        'unit_id',
        'cost_price',
        'sell_price',
        'item_qty',
        'description'
    ];
    public function unitname()
    {
        return $this->hasOne(typedrugs::class, 'id', 'unit_id');
    }
}
