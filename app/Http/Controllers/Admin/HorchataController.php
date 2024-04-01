<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Horchata;
use Illuminate\Http\Request;

class HorchataController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.horchatas.index')->only('index');
        $this->middleware('can:admin.horchatas.create')->only('create', 'store');
        $this->middleware('can:admin.horchatas.edit')->only('edit', 'update');
        $this->middleware('can:admin.horchatas.destroy')->only('destroy');
    }

    public function index()
    {
        //
        $horchatas = Horchata::all();
        return view('admin.horchatas.index', compact('horchatas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.horchatas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos = $request->validate([
            'presentacion' => 'required',
        ]);

        Horchata::create($datos);

        return redirect()->route('admin.horchatas.index')->with('success', 'Horchata creada exitosamente.');
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
    public function edit(Horchata $horchata)
    {
        //
        return view('admin.horchatas.edit', compact('horchata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horchata $horchata)
    {
        //
        $datos = $request->validate([
            'presentacion' => 'required',
        ]);

        $horchata->update($datos);

        return redirect()->route('admin.horchatas.index')->with('success', 'Horchata editada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horchata $horchata)
    {
        //
        $horchata->delete();
        return redirect()->route('admin.horchatas.index');
    }
}
