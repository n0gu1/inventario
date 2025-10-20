<?php

namespace App\Livewire\Admin;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Livewire\Component;
use Livewire\WithPagination;

class Kardex extends Component
{
    use WithPagination;

    public Product $product;

    public $warehouses;
    public $warehouse_id;

    public $fecha_inicial;
    public $fecha_final;

    public function mount()
    {
        $this->warehouses = Warehouse::all();
        $this->warehouse_id = $this->warehouses->first()->id ?? null;
    }


    public function render()
    {
        $inventories = Inventory::query()
            ->where('product_id', $this->product->id)
            ->when(
                $this->warehouse_id,
                fn($q) =>
                $q->where('warehouse_id', $this->warehouse_id)
            )
            ->when(
                $this->fecha_inicial,
                fn($q) =>
                $q->whereDate('created_at', '>=', $this->fecha_inicial)
            )
            ->when(
                $this->fecha_final,
                fn($q) =>
                $q->whereDate('created_at', '<=', $this->fecha_final)
            )
            ->orderByDesc('created_at')
            ->paginate();

        return view('livewire.admin.kardex', compact('inventories'));
    }
}
