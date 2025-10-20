<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuoteController extends Controller
{
    public function index()
    {
        Gate::authorize('read-quotes');
        return view('admin.quotes.index');
    }

    public function create()
    {
        Gate::authorize('create-quotes');
        return view('admin.quotes.create');
    }

    public function pdf(Quote $quote)
    {
        Gate::authorize('read-quotes');
        $pdf = Pdf::loadView('admin.quotes.pdf', [
            'quote' => $quote,
        ]);

        return $pdf->download("cotizacion_{$quote->id}.pdf");
    }
}
