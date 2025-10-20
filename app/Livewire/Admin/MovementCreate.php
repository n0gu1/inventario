<?php

namespace App\Livewire\Admin;

use App\Facades\Kardex;
use App\Models\Inventory;
use App\Models\Movement;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use App\Services\KardexService;
use Livewire\Component;

class MovementCreate extends Component
{
    public $type = 1;
    public $serie = 'M001';
    public $correlative;
    public $date;
    public $warehouse_id;
    public $reason_id;
    public $total = 0;
    public $observations;
    public $product_id;
    public $products = [];

    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                $html = '<ul class="text-left">';

                foreach ($errors as $error) {
                    $html .= "<li>- {$error[0]}</li>";
                }

                $html .= '</ul>';

                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => 'Error de validación',
                    'html' => $html,
                ]);
            }
        });
    }

    public function mount()
    {
        $this->correlative = Movement::max('correlative') + 1;
    }

    public function updated($property, $value)
    {
        if ($property == 'type') {
            $this->reset('reason_id');
        }
    }

    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
        ], [], [
            'product_id' => 'producto',
        ]);

        $existing = collect($this->products)
            ->firstWhere('id', $this->product_id);

        if ($existing) {
            $this->dispatch('swal', [
                'icon' => 'warning',
                'title' => 'El producto ya fue agregado',
                'text' => 'El producto ya fue agregado a la lista.',
            ]);

            return;
        }

        $product = Product::find($this->product_id);

        $lastRecord = Inventory::where('product_id', $product->id)
            ->where('warehouse_id', $this->warehouse_id)
            ->latest('id')
            ->first();

        $costBalance = $lastRecord?->cost_balance ?? 0;

        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' =>  $costBalance,
            'subtotal' => $costBalance,
        ];

        $this->reset('product_id');
    }

    public function save()
    {
        $this->validate([
            'type' => 'required|in:1,2',
            'serie' => 'required|string|max:10',
            'correlative' => 'required|numeric|min:1',
            'date' => 'nullable|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'reason_id' => 'required|exists:reasons,id',
            'total' => 'required|numeric|min:0',
            'observations' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ], [], [
            'type' => 'tipo de comprobante',
            'date' => 'fecha',
            'warehouse_id' => 'almacén',
            'reason_id' => 'motivo',
            'total' => 'total',
            'observations' => 'observaciones',
            'products' => 'productos',
            'products.*.id' => 'producto',
            'products.*.quantity' => 'cantidad',
            'products.*.price' => 'precio',
        ]);

        $movement = Movement::create([
            'type' => $this->type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date,
            'warehouse_id' => $this->warehouse_id,
            'total' => $this->total,
            'observations' => $this->observations,
            'reason_id' => $this->reason_id,
        ]);

        foreach ($this->products as $product) {
            $movement->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);

            // $lastRecord = Inventory::where('product_id', $product['id'])
            //     ->where('warehouse_id', $this->warehouse_id)
            //     ->latest('id')
            //     ->first();

            // $lastQuantityBalance =  $lastRecord?->quantity_balance ?? 0;
            // $lastTotalBalance =  $lastRecord?->total_balance ?? 0;


            // if ($this->type == 1) {
            //     $newQuantityBalance = $lastQuantityBalance + $product['quantity'];
            //     $newTotalBalance = $lastTotalBalance + ($product['quantity'] * $product['price']);
            //     $newCostBalance =  $newTotalBalance / ($newQuantityBalance ?: 1);

            //     $movement->inventories()->create([
            //         'detail' => 'Venta',
            //         'quantity_in' => $product['quantity'],
            //         'cost_in' => $product['price'],
            //         'total_in' => $product['quantity'] * $product['price'],
            //         'quantity_balance' => $newQuantityBalance,
            //         'cost_balance' => $newCostBalance,
            //         'total_balance' => $newTotalBalance,
            //         'product_id' => $product['id'],
            //         'warehouse_id' => $this->warehouse_id,
            //     ]);
            // } elseif ($this->type == 2) {
            //     $newQuantityBalance = $lastQuantityBalance - $product['quantity'];
            //     $newTotalBalance = $lastTotalBalance - ($product['quantity'] * $product['price']);
            //     $newCostBalance =  $newTotalBalance / ($newQuantityBalance ?: 1);

            //     $movement->inventories()->create([
            //         'detail' => 'Venta',
            //         'quantity_out' => $product['quantity'],
            //         'cost_out' => $product['price'],
            //         'total_out' => $product['quantity'] * $product['price'],
            //         'quantity_balance' => $newQuantityBalance,
            //         'cost_balance' => $newCostBalance,
            //         'total_balance' => $newTotalBalance,
            //         'product_id' => $product['id'],
            //         'warehouse_id' => $this->warehouse_id,
            //     ]);
            // }
           
            if ($this->type == 1) {
                Kardex::registryEntry($movement, $product, $this->warehouse_id, 'Movimiento');
            } elseif ($this->type == 2) {
                Kardex::registryExit($movement, $product, $this->warehouse_id, 'Movimiento');
            }

        }

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Movimiento creado',
            'text'  => 'El movimiento se ha creado exitosamente',
        ]);

        return redirect()->route('admin.movements.index');
    }



    public function render()
    {
        return view('livewire.admin.movement-create');
    }
}
