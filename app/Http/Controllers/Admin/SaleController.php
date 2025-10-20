<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class SaleController extends Controller
{
    public function index()
    {
        Gate::authorize('read-sales');
        return view('admin.sales.index');
    }

    public function create()
    {
        Gate::authorize('create-sales');
        return view('admin.sales.create');
    }

    public function pdf(Sale $sale)
    {
        Gate::authorize('read-sales');
        $pdf = Pdf::loadView('admin.sales.pdf', [
            'sale' => $sale,
        ]);

        return $pdf->download("venta_{$sale->id}.pdf");
    }
}
