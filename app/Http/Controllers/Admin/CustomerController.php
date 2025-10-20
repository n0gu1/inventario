<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Identity;
use Illuminate\Support\Facades\Gate;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read-customers');
        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-customers');
        $identities = Identity::all();
        return view('admin.customers.create', compact('identities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-customers');
        $data = $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|string|max:20|unique:customers,document_number',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $customer = Customer::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cliente creado con éxito',
            'text' => 'El cliente ha sido creado correctamente.',
        ]);

        return redirect()->route('admin.customers.edit', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        Gate::authorize('update-customers');
        $identities = Identity::all();
        return view('admin.customers.edit', compact('customer', 'identities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        Gate::authorize('update-customers');
        $data = $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'document_number' => 'required|string|max:20|unique:customers,document_number,' . $customer->id,
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $customer->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cliente actualizado con éxito',
            'text' => 'El cliente ha sido actualizado correctamente.',
        ]);

        return redirect()->route('admin.customers.edit', $customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        Gate::authorize('delete-customers');
        if ($customer->quotes()->exists()  || $customer->sales()->exists()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'No se puede eliminar el cliente',
                'text' => 'El cliente tiene ventas asociadas y no puede ser eliminado.',
            ]);

            return redirect()->route('admin.customers.index');
        }

        $customer->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cliente eliminado con éxito',
            'text' => 'El cliente ha sido eliminado correctamente.',
        ]);

        return redirect()->route('admin.customers.index');
    }
}
