<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revoltura;
use App\Models\Insumo;

class RevolturaController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.revolturas.index')->only('index');
        $this->middleware('can:admin.revolturas.create')->only('create', 'store');
        $this->middleware('can:admin.revolturas.edit')->only('edit', 'update');
        $this->middleware('can:admin.revolturas.destroy')->only('destroy');
    }

    public function index()
    {
        //
        $revolturas = Revoltura::all();
        return view('admin.revolturas.index', compact('revolturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        /* $insumos = Insumo::all(); */
        return view('admin.revolturas.create'/* , compact('insumos') */);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        try {
            DB::beginTransaction();

            $revoltura = Revoltura::create([
                'fecha_realizacion' => $request->input('fecha_realizacion'),
                'turno' => $request->input('turno'),
                'num_revoltura' => $request->input('num_revoltura'),
            ]);

            $insumos = [
                'Azúcar' => 300,
                'Arroz' => 75,
                'Canela' => 1.200,
                'Benzoato de Sodio' => 0.600,
                'Goma Xantana' => 0.900,
                'Sorbato de Potasio' => 3,
                'Dióxido de Titanio' => 1,

            ];


            $errorsArray = [];

            foreach ($insumos as $insumoNombre => $cantidad) {
                $insumo = Insumo::where('nombre', $insumoNombre)->first();

                if ($insumo) {
                    $cantidadAUsar = $cantidad * $revoltura->num_revoltura;

                    if ($insumo->cantidad_disponible >= $cantidadAUsar) {
                        $insumo->cantidad_disponible -= $cantidadAUsar;
                        $insumo->save();

                        $revoltura->insumos()->attach($insumo->id, ['cantidad' => $cantidad]);
                    } else {
                        $errorsArray[] = 'No hay suficiente cantidad de ' . $insumoNombre . ' disponible.';
                    }
                } else {
                    $errorsArray[] = 'El insumo ' . $insumoNombre . ' no existe en la base de datos.';
                }
            }

            if (!empty($errorsArray)) {
                DB::rollBack();
                return redirect()->route('admin.revolturas.create')->withErrors($errorsArray);
            }

            DB::commit();
            return redirect()->route('admin.revolturas.index')->with('success', 'Revoltura creada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.revolturas.create')->withErrors(['error' => 'Ha ocurrido un error al guardar la revoltura.']);
        }
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
    public function edit(Revoltura $revoltura)
    {
        //
        /* $insumos = Insumo::all() */
        return view('admin.revolturas.edit', compact('revoltura', /* 'insumos' */));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Revoltura $revoltura)
    {

        try {
            DB::beginTransaction();

            // Validar los datos de entrada, esto es un ejemplo, debes adaptarlo a tus necesidades
            $request->validate([
                'fecha_realizacion' => 'required',
                'turno' => 'required',
                'num_revoltura' => 'required',
            ]);

            // Obtener el número de revolturas antes de la actualización
            $numRevolturaAntes = $revoltura->num_revoltura;

            // Guardar la revoltura con los nuevos datos
            $revoltura->fecha_realizacion = $request->input('fecha_realizacion');
            $revoltura->turno = $request->input('turno');
            $revoltura->num_revoltura = $request->input('num_revoltura');
            $revoltura->save();

            // Definir los insumos
            $insumos = [
                'Azucar' => 300,
                'Arroz' => 75,
                'Canela' => 1.200,
                'Venzuato de sodio' => 0.600,
                'Goma xantac' => 0.900,
                'Sourato de sodio' => 3,
                'Dioxido de titanio' => 1,
                // Puedes agregar más insumos según tus necesidades
            ];

            $errorsArray = [];

            // Calcular la diferencia en el número de revolturas
            $diferenciaRevolturas = $revoltura->num_revoltura - $numRevolturaAntes;

            if ($diferenciaRevolturas != 0) {
                foreach ($insumos as $insumoNombre => $cantidad) {
                    $insumo = Insumo::where('nombre', $insumoNombre)->first();

                    if ($insumo) {
                        $cantidadAUsar = $cantidad * abs($diferenciaRevolturas);

                        if ($diferenciaRevolturas > 0) {
                            // Si el número de revolturas aumentó, disminuir la cantidad de insumos utilizados
                            if ($insumo->cantidad_disponible >= $cantidadAUsar) {
                                $insumo->cantidad_disponible -= $cantidadAUsar;
                                $insumo->save();

                                // Actualizar la relación entre la revoltura y el insumo si ya existe
                                $existingRelation = $revoltura->insumos->where('id', $insumo->id)->first();
                                if ($existingRelation) {
                                    $existingRelation->pivot->cantidad = $cantidad;
                                    $existingRelation->pivot->save();
                                } else {
                                    // Si no existe la relación, crearla
                                    $revoltura->insumos()->attach($insumo->id, ['cantidad' => $cantidad]);
                                }
                            } else {
                                $errorsArray[] = 'No hay suficiente cantidad de ' . $insumoNombre . ' disponible.';
                            }
                        } elseif ($diferenciaRevolturas < 0) {
                            // Si el número de revolturas disminuyó, aumentar la cantidad de insumos utilizados
                            $insumo->cantidad_disponible += $cantidadAUsar;
                            $insumo->save();

                            // Actualizar la relación entre la revoltura y el insumo si ya existe
                            $existingRelation = $revoltura->insumos->where('id', $insumo->id)->first();
                            if ($existingRelation) {
                                $existingRelation->pivot->cantidad = $cantidad;
                                $existingRelation->pivot->save();
                            } else {
                                // Si no existe la relación, crearla
                                $revoltura->insumos()->attach($insumo->id, ['cantidad' => $cantidad]);
                            }
                        }
                    } else {
                        $errorsArray[] = 'El insumo ' . $insumoNombre . ' no existe en la base de datos.';
                    }
                }
            }

            if (!empty($errorsArray)) {
                DB::rollBack();
                return redirect()->route('admin.revolturas.edit', $revoltura)->withErrors($errorsArray);
            }

            DB::commit();
            return redirect()->route('admin.revolturas.index')->with('success', 'Revoltura actualizada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.revolturas.edit', $revoltura)->withErrors(['error' => 'Ha ocurrido un error al actualizar la revoltura.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revoltura $revoltura)
    {
        //
        foreach ($revoltura->insumos as $insumo) {
            $insumo->actualizarCantidadUsada(-$insumo->pivot->cantidad_utilizada);
        }

        $revoltura->delete();

        return redirect()->route('admin.revolturas.index')->with('success', 'Revoltura eliminada con éxito.');
    }
}
