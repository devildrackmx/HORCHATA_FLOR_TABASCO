<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insumo;

class InsumoController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.insumos.index')->only('index');
        $this->middleware('can:admin.insumos.create')->only('create', 'store');
        $this->middleware('can:admin.insumos.edit')->only('edit', 'update');
        $this->middleware('can:admin.insumos.destroy')->only('destroy');
    }

    public function index()
    {
        //
        $insumos = Insumo::all();
        return view('admin.insumos.index', compact('insumos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.insumos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:100',
            'cantidad_disponible' => 'numeric|nullable',
            'unidad_medida' => 'required|in:Kilos,Piezas',
            'stock' => 'required|integer',
        ]);

        Insumo::create($datos);

        return redirect()->route('admin.insumos.index')
            ->with('success', 'Insumo creado exitosamente.');
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
    public function edit(Insumo $insumo)
    {
        //
        return view('admin.insumos.edit', compact('insumo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Insumo $insumo)
    {
        //
        $datos = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:100',
            'cantidad_disponible' => 'numeric|nullable',
            'unidad_medida' => 'required|in:Kilos,Piezas',
            'stock' => 'required|integer',
        ]);

        $insumo->update($datos);

        return redirect()->route('admin.insumos.index')
            ->with('success', 'Insumo creado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insumo $insumo)
    {
        //
        $insumo->delete();
        return redirect()->route('admin.insumos.index');
    }
}
