<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.proveedores.index')->only('index');
        $this->middleware('can:admin.proveedores.create')->only('create', 'store');
        $this->middleware('can:admin.proveedores.edit')->only('edit', 'update');
        $this->middleware('can:admin.proveedores.destroy')->only('destroy');
    }

    public function index()
    {
        //
        $proveedores = Proveedor::all();
        return view('admin.proveedores.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'calle' => 'required|string|max:50',
            'colonia' => 'required|string|max:50',
            'codigo_postal' => 'required|string|max:5',
            'ciudad' => 'required|string|max:50',
            'telefono' => 'required|string|max:10',
        ]);

        Proveedor::create($datos);

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedore)
    {
        //
        return view('admin.proveedores.edit', compact('proveedore'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedore)
    {
        //
        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'calle' => 'required|string|max:50',
            'colonia' => 'required|string|max:50',
            'codigo_postal' => 'required|string|max:5',
            'ciudad' => 'required|string|max:50',
            'telefono' => 'required|string|max:10',
        ]);

        $proveedore->update($datos);

        return redirect()->route('admin.proveedores.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedore)
    {
        //
        $proveedore->delete();
        return redirect()->route('admin.proveedores.index');
    }
}
