<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;

    protected $dates = [
        'date'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'open' => 'float',
        'high' => 'float',
        'low' => 'float',
        'close' => 'float',
        'average' => 'float',
        'volume' => 'int',
        'value' => 'float'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function stock(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
