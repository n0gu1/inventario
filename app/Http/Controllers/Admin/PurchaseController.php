<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class PurchaseController extends Controller
{
    public function index()
    {
        Gate::authorize('read-purchases');
        return view('admin.purchases.index');
    }

    public function create()
    {
        Gate::authorize('create-purchases');
        return view('admin.purchases.create');
    }

    public function pdf(Purchase $purchase)
    {
        Gate::authorize('read-purchases');
        $pdf = Pdf::loadView('admin.purchases.pdf', [
            'purchase' => $purchase,
        ]);

        return $pdf->download("compra_{$purchase->id}.pdf");
    }
    
}
