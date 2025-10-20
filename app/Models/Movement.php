<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [
        'type',
        'serie',
        'correlative',
        'date',
        'warehouse_id',
        'total',
        'observation',
        'reason_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    //Relación uno a muchos inversa
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    //Relación uno a muchos inversa
    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

    //Relación muchos a muchos polimórfica
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')
            ->withPivot('quantity', 'price', 'subtotal')
            ->withTimestamps();
    }

    //Relación uno a polimórfica uno
    public function inventories()
    {
        return $this->morphMany(Inventory::class, 'inventoryable');
    }
}
