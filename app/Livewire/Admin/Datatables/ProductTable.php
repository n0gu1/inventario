<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Image;
use App\Models\Inventory;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;


class ProductTable extends DataTableComponent
{
    // protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');

        $this->setConfigurableAreas([
            'after-wrapper' => [
                'admin.products.modal',
            ]
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            ImageColumn::make("Imagen", "image")
                ->location(
                    fn($row) => $row->image
                )->attributes(function ($row) {
                    return [
                        'class' => 'image-product',
                    ];
                }),
            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),
            Column::make("Categoria", "category.name")
                ->searchable()
                ->sortable(),
            Column::make("Precio", "price")
                ->sortable(),
            Column::make("Stock", "stock")
                ->sortable()
                ->format(function ($value, $row) {
                    return view('admin.products.stock', [
                        'stock' => $value,
                        'product' => $row
                    ]);
                }),
            Column::make('Acciones')
                ->label(function ($row) {
                    return view('admin.products.action', ['product' => $row]);
                }),
        ];
    }

    public function builder(): Builder
    {
        return Product::query()
            ->with(['category', 'images']);
    }

    public $openModal = false;

    public $inventories = [];

    public function showStock($productId)
    {
        $this->openModal = true;

        $latestInventories = Inventory::where('product_id', $productId)
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('warehouse_id')
            ->pluck('id');

        $this->inventories = Inventory::whereIn('id', $latestInventories)
            ->with(['warehouse'])
            ->get();
    }
}
