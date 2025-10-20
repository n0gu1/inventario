<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function topProducts()
    {
        Gate::authorize('read-top-products');
        return view('admin.reports.top-products');
    }

    public function topCustomers()
    {
        Gate::authorize('read-top-customers');
        return view('admin.reports.top-customers');
    }

    public function lowStock()
    {
        Gate::authorize('read-low-stock');
        return view('admin.reports.low-stock');
    }
}
