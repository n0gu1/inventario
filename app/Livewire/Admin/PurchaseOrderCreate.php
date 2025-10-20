<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use Livewire\Component;

class PurchaseOrderCreate extends Component
{
    public $voucher_type = 1;
    public $serie = 'OC01';
    public $correlative;
    public $date;
    public $supplier_id;
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
        $this->correlative = PurchaseOrder::max('correlative') + 1;
    }



    public function addProduct()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
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
        

        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => 0,
            'subtotal' => 0,
        ];

        $this->reset('product_id');
    }

    public function save()
    {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'date' => 'nullable|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'total' => 'required|numeric|min:0',
            'observations' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ], [], [
            'voucher_type' => 'tipo de comprobante',
            'date' => 'fecha',
            'supplier_id' => 'proveedor',
            'total' => 'total',
            'observations' => 'observaciones',
            'products' => 'productos',
            'products.*.id' => 'producto',
            'products.*.quantity' => 'cantidad',
            'products.*.price' => 'precio',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date,
            'supplier_id' => $this->supplier_id,
            'total' => $this->total,
            'observations' => $this->observations,
        ]);

        foreach ($this->products as $product) {
            $purchaseOrder->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Orden de compra creada',
            'text'  => 'La orden de compra se ha creado exitosamente',
        ]);

        return redirect()->route('admin.purchase-orders.index');
    }



    public function render()
    {
        return view('livewire.admin.purchase-order-create');
    }
}
