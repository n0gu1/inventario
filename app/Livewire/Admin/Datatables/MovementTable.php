<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Movement;
use App\Models\Purchase;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;

class MovementTable extends DataTableComponent
{
    // protected $model = PurchaseOrder::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Fecha", "date")
                ->sortable()
                ->format(fn($value) => $value->format('d/m/Y')),
            Column::make("Tipo", "type")
                ->sortable()
                ->format(fn($value) => match ($value) {
                    1 => 'Ingreso',
                    2 => 'Salida',
                    default => 'Desconocido',
                }),
            Column::make("Serie", "serie")
                ->sortable(),
            Column::make("Correlativo", "correlative")
                ->sortable(),
            Column::make("Almacen", "warehouse.name")
                ->sortable(),
            Column::make("Motivo", "reason.name")
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()
                ->format(fn($value) => "Q/" . number_format($value, 2, '.', ',')),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.movements.actions', [
                        'movement' => $row
                    ]);
                }),
        ];
    }

    public function builder(): Builder
    {
        return Movement::query()
            ->with(['warehouse', 'reason']);
    }
}
