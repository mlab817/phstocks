<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    protected $casts = [
        'last_traded_date' => 'date:Y-m-d',
        'last_traded_price' => 'float',
        'outstanding_shares' => 'int',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function findBySymbol($name = '')
    {
        $stock = static::where('symbol', strtoupper($name))->first();

        if (! $stock) {
            return null;
        }

        return $stock;
    }

    public function histories(): HasMany
    {
        return $this->hasMany(StockHistory::class);
    }
}
