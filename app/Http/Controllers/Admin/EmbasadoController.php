<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Exception;
use Illuminate\Support\Facades\DB;

use App\Models\Embasado;
use App\Models\Insumo;
use App\Models\Horchata;

class EmbasadoController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.embasados.index')->only('index');
        $this->middleware('can:admin.embasados.create')->only('create', 'store');
        $this->middleware('can:admin.embasados.edit')->only('edit', 'update');
        $this->middleware('can:admin.embasados.destroy')->only('destroy');
    }

    public function index()
    {
        //
        $embasados = Embasado::all();
        return view('admin.embasados.index', compact('embasados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $horchatas = Horchata::all();
        return view('admin.embasados.create', compact('horchatas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $errors = []; // Inicializa un array para almacenar los errores

        try {
            $validatedData = $request->validate([
                'fecha' => 'required|date',
                'turno' => 'required|string|max:50',
                'presentaciones' => 'required|array',
                'num_cajas' => 'required|array',
                'num_cajas.*' => 'integer|min:0',
            ]);

            // Inicia una transacción de la base de datos
            DB::beginTransaction();

            // Obtener una lista de todas las presentaciones de horchata
            $presentacionesHorchata = Horchata::all()->pluck('presentacion');

            // Obtener nombres únicos de insumos requeridos
            $nombresInsumosRequeridos = [];
            $cantidadRequeridaPorInsumo = []; // Almacenar la cantidad requerida por cada insumo

            foreach ($presentacionesHorchata as $presentacion) {
                $nombresInsumosRequeridos[] = 'botellas de ' . $presentacion;
            }
            $nombresInsumosRequeridos = array_unique($nombresInsumosRequeridos);

            // Validar la existencia y disponibilidad de insumos
            foreach ($nombresInsumosRequeridos as $nombreInsumo) {
                $insumo = Insumo::where('nombre', $nombreInsumo)->first();

                if (!$insumo) {
                    $errors[] = 'El insumo ' . $nombreInsumo . ' no existe en la base de datos.';
                } else {
                    $cantidadRequerida = $this->calcularCantidadRequerida($nombreInsumo); // Llamada a la función dentro de la clase
                    $factor = $this->calcularFactor($insumo->nombre); // Llamada a la función dentro de la clase

                    if ($insumo->cantidad_disponible < $cantidadRequerida) {
                        $errors[] = 'No hay suficiente cantidad disponible de ' . $nombreInsumo . ' para hacer el embasado.';
                    } else {
                        // Almacenar la cantidad requerida por este insumo para su posterior validación
                        $cantidadRequeridaPorInsumo[$nombreInsumo] = $cantidadRequerida;
                    }
                }
            }

            // Si hay errores, no se crea el embasado y se realiza un rollback
            if (!empty($errors)) {
                DB::rollBack();
                return redirect()->route('admin.embasados.create')
                    ->withErrors($errors)
                    ->withInput();
            }

            // Ahora, después de todas las validaciones, puedes crear el registro de Embasado y restar las cantidades de insumos
            $embasado = Embasado::create([
                'fecha' => $validatedData['fecha'],
                'turno' => $validatedData['turno'],
            ]);

            // Almacenar los errores de insumos insuficientes
            $insufficientQuantityErrors = [];

            // Restar cantidades de insumos y crear el registro de Embasado
            foreach ($validatedData['presentaciones'] as $key => $presentacionId) {
                $horchata = Horchata::find($presentacionId);

                if ($horchata) {
                    $numCajasHorchata = $validatedData['num_cajas'][$key];
                    $botellasNombre = 'botellas de ' . $horchata->presentacion;

                    $cantidadRequeridaBotellas = $cantidadRequeridaPorInsumo[$botellasNombre];

                    // Verificar disponibilidad de insumos nuevamente antes de restar
                    if (
                        $insumo->cantidad_disponible < $cantidadRequeridaBotellas * $numCajasHorchata
                    ) {
                        $insufficientQuantityErrors[] = 'No hay suficiente cantidad disponible de ' . $botellasNombre . ' para hacer el embasado de ' . $horchata->presentacion . '.';
                    } else {
                        // Restar cantidades de insumos
                        Insumo::where('nombre', $botellasNombre)->decrement('cantidad_disponible', $cantidadRequeridaBotellas * $numCajasHorchata);

                        $embasado->horchatas()->attach($horchata, ['num_cajas' => $numCajasHorchata]);
                    }
                }
            }

            // Si hay errores de insumos insuficientes, realiza un rollback y muestra los errores
            if (!empty($insufficientQuantityErrors)) {
                DB::rollBack();
                return redirect()->route('admin.embasados.create')
                    ->withErrors($insufficientQuantityErrors)
                    ->withInput();
            }

            // Commit de la transacción
            DB::commit();

            return redirect()->route('admin.embasados.index');
        } catch (ValidationException $e) {
            return redirect()->route('admin.embasados.create')
                ->withErrors($e->validator)
                ->withInput();
        } catch (Exception $e) {
            // Si ocurre alguna otra excepción, realiza un rollback y muestra un mensaje de error
            DB::rollBack();
            return redirect()->route('admin.embasados.create')
                ->withErrors(['general' => 'Ha ocurrido un error al crear el embasado.'])
                ->withInput();
        }
    }

    protected function calcularCantidadRequerida($nombreInsumo)
    {
        // Implementa la lógica para calcular la cantidad requerida según el nombre del insumo
        // Ejemplo: return 20; para requerir siempre 20 unidades

        $nombreInsumo = strtolower($nombreInsumo);

        if (strpos($nombreInsumo, 'botellas de galón') !== false) {
            return 4; // 4 botellas de galón por caja
        } elseif (strpos($nombreInsumo, 'botellas de 2 litro') !== false) {
            return 6; // 6 botellas de 2 litros por caja
        } elseif (strpos($nombreInsumo, 'botellas de 1000 ml') !== false) {
            return 12; // 12 botellas de 1 litro por caja
        } elseif (strpos($nombreInsumo, 'botellas de 700 ml') !== false) {
            return 12; // 12 botellas de 700 ml por caja
        } elseif (strpos($nombreInsumo, 'botellas de 500 ml') !== false) {
            return 12; // 12 botellas de 500 ml por caja
        } elseif (strpos($nombreInsumo, 'botellas de 250 ml') !== false) {
            return 20; // 20 botellas de 250 ml por caja
        }

        return 0; // Valor predeterminado, no se requieren unidades
    }

    protected function calcularFactor($nombrePresentacion)
    {
        // Implementa la lógica para calcular el factor de conversión según la presentación de horchata
        // Ejemplo: return 20; para una presentación que requiere 20 botellas y 20 tapas por caja

        // Ejemplo de lógica basada en las presentaciones de horchata
        $nombrePresentacion = strtolower($nombrePresentacion);

        switch ($nombrePresentacion) {
            case 'galón':
                return 4; // 4 botellas y 4 tapas por caja
            case '2 litro':
                return 6; // 6 botellas y 6 tapas por caja
            case '1000 ml':
                return 12; // 12 botellas y 12 tapas por caja
            case '700 ml':
                return 12; // 12 botellas y 12 tapas por caja
            case '500 ml':
                return 12; // 12 botellas y 12 tapas por caja
            case '250 ml':
                return 20; // 20 botellas y 20 tapas por caja
            default:
                return 0; // Valor predeterminado, no se requiere conversión
        }
    }

    protected function restarInsumos($nombreInsumo, $cantidadARestar)
    {
        Insumo::where('nombre', $nombreInsumo)->decrement('cantidad_disponible', $cantidadARestar);
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
    public function edit(Embasado $embasado)
    {
        //
        $horchatas = Horchata::all(); // Obtén todas las horchatas disponibles
        $numCajas = $embasado->horchatas->pluck('pivot.num_cajas', 'id')->toArray();

        return view('admin.embasados.edit', compact('embasado', 'horchatas', 'numCajas'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Validación de datos
        $errors = [];

        try {
            $validatedData = $request->validate([
                'fecha' => 'required|date',
                'turno' => 'required|string|max:50',
                'presentaciones' => 'required|array',
                'num_cajas' => 'required|array',
                'num_cajas.*' => 'integer|min:0',
            ]);

            // Inicia una transacción de la base de datos
            DB::beginTransaction();

            // Obtener el embasado existente
            $embasado = Embasado::findOrFail($id);

            // Obtener una lista de todas las presentaciones de horchata
            $presentacionesHorchata = Horchata::all()->pluck('presentacion');

            // Obtener nombres únicos de insumos requeridos
            $nombresInsumosRequeridos = [];
            $cantidadRequeridaPorInsumo = [];

            foreach ($presentacionesHorchata as $presentacion) {
                $nombresInsumosRequeridos[] = 'botellas de ' . $presentacion;
            }
            $nombresInsumosRequeridos = array_unique($nombresInsumosRequeridos);

            // Validar la existencia y disponibilidad de insumos
            foreach ($nombresInsumosRequeridos as $nombreInsumo) {
                $insumo = Insumo::where('nombre', $nombreInsumo)->first();

                if (!$insumo) {
                    $errors[] = 'El insumo ' . $nombreInsumo . ' no existe en la base de datos.';
                } else {
                    $cantidadRequerida = $this->calcularCantidadRequerida($nombreInsumo);
                    $factor = $this->calcularFactor($insumo->nombre);

                    if ($insumo->cantidad_disponible < $cantidadRequerida) {
                        $errors[] = 'No hay suficiente cantidad disponible de ' . $nombreInsumo . ' para hacer el embasado.';
                    } else {
                        $cantidadRequeridaPorInsumo[$nombreInsumo] = $cantidadRequerida;
                    }
                }
            }

            // Si hay errores, no se actualiza el embasado y se realiza un rollback
            if (!empty($errors)) {
                DB::rollBack();
                return redirect()->route('admin.embasados.edit', $id)
                    ->withErrors($errors)
                    ->withInput();
            }

            // Ahora, después de todas las validaciones, actualiza el embasado y las cantidades de insumos
            $embasado->update([
                'fecha' => $validatedData['fecha'],
                'turno' => $validatedData['turno'],
            ]);

            foreach ($validatedData['presentaciones'] as $key => $presentacionId) {
                $horchata = Horchata::find($presentacionId);

                if ($horchata) {
                    $numCajasHorchata = $validatedData['num_cajas'][$key];
                    $botellasNombre = 'botellas de ' . $horchata->presentacion;
                    $cantidadRequeridaBotellas = $cantidadRequeridaPorInsumo[$botellasNombre];

                    // Calcular la diferencia entre las cantidades actuales y nuevas
                    $diferencia = $numCajasHorchata - $embasado->horchatas->find($horchata->id)->pivot->num_cajas;

                    // Ajustar la cantidad de botellas en base a la diferencia
                    $cantidadAjuste = $cantidadRequeridaBotellas * abs($diferencia);

                    // Restar o aumentar cantidades de insumos según la diferencia
                    if ($diferencia > 0) {
                        // Aumentar
                        Insumo::where('nombre', $botellasNombre)->decrement('cantidad_disponible', $cantidadAjuste);
                    } elseif ($diferencia < 0) {
                        // Restar
                        Insumo::where('nombre', $botellasNombre)->increment('cantidad_disponible', $cantidadAjuste);
                    }

                    // Actualizar la cantidad de cajas en la relación pivot
                    $embasado->horchatas()->updateExistingPivot($presentacionId, ['num_cajas' => $numCajasHorchata]);
                }
            }

            // Si hay errores, realiza un rollback y muestra los errores
            if (!empty($errors)) {
                DB::rollBack();
                return redirect()->route('admin.embasados.edit', $id)
                    ->withErrors($errors)
                    ->withInput();
            }

            // Commit de la transacción
            DB::commit();

            return redirect()->route('admin.embasados.index');
        } catch (ValidationException $e) {
            return redirect()->route('admin.embasados.edit', $id)
                ->withErrors($e->validator)
                ->withInput();
        } catch (Exception $e) {
            // Si ocurre alguna otra excepción, realiza un rollback y muestra un mensaje de error
            DB::rollBack();
            return redirect()->route('admin.embasados.edit', $id)
                ->withErrors(['general' => 'Ha ocurrido un error al actualizar el embasado.'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Embasado $embasado)
    {
        //
        $embasado->delete();

        return redirect()->route('admin.embasados.index');
    }
}
