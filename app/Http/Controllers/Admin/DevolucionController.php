<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use App\Models\Devolucion;
use App\Models\Insumo;
use App\Models\Proveedor;

class DevolucionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:admin.devoluciones.index')->only('index');
        $this->middleware('can:admin.devoluciones.create')->only('create', 'store');
        $this->middleware('can:admin.devoluciones.edit')->only('edit', 'update');
        $this->middleware('can:admin.devoluciones.destroy')->only('destroy');
    }

    public function index()
    {
        //

        $devoluciones = Devolucion::all();
        return view('admin.devoluciones.index', compact('devoluciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $insumos = Insumo::all();
        $proveedores = Proveedor::all();
        return view('admin.devoluciones.create', compact('insumos', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $request->validate([
            'fecha_devolucion' => 'required|date',
            'numero_orden' => 'required|string',
            'proveedor_id' => 'required|exists:proveedors,id',
            /* 'estado' => 'required|in:En proceso,Recibido,Devuelto,Cancelado', */
            'insumos' => 'required|array',
            'tipo_compra' => 'required|in:CREDITO,CONTADO',
            'tipo_moneda' => 'required|in:US,MXN',
        ]);

        $devolucion = new Devolucion();
        $devolucion->fecha_devolucion = $request->fecha_devolucion;
        $devolucion->numero_orden = $request->numero_orden;
        $devolucion->proveedor_id = $request->proveedor_id;
        $devolucion->tipo_compra = $request->tipo_compra;
        $devolucion->tipo_moneda = $request->tipo_moneda;
        $devolucion->save();

        // Variables para el cálculo del total
        $subtotal = 0;
        $iva = 0;

        foreach ($request->insumos as $insumoId => $data) {
            $insumo = Insumo::find($insumoId);
            if ($insumo) {
                $cantidad = $data['cantidad'];
                $precioUnitario = $data['precio_unitario'];

                // Calcular el importe
                $importe = $cantidad * $precioUnitario;

                // Adjuntar insumos a la compra con cantidad, precio unitario e importe
                $devolucion->insumos()->attach($insumoId, [
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'importe' => $importe,
                ]);

                // Calcular el subtotal
                $subtotal += $importe;

                /* if ($devolucion->estado === 'Devuelto') {
                    // Actualizar la cantidad disponible del insumo solo cuando el estado sea "Devuelto"
                    $insumo->actualizarCantidadDevuelta($cantidad);
                } */
            }
        }

        // Asignar el subtotal a la compra
        $devolucion->subtotal = $subtotal;
        $devolucion->save();

        // Verificar si se proporcionó el IVA
        if ($request->has('iva')) {
            $iva = $request->iva;

            // Calcular el total con IVA
            $total = $subtotal + ($subtotal * ($iva / 100));

            // Asignar el IVA y el total a la compra
            $devolucion->iva = $iva;
            $devolucion->total = $total;
            $devolucion->save();
        }

        return redirect()->route('admin.devoluciones.index')
            ->with('success', 'Compra creada exitosamente.');
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
    public function edit(Devolucion $devolucione)
    {
        //

        /* if ($devolucion->estado === 'Devuelto' || $devolucion->estado === 'Cancelado') {
            abort(404); // Mostrar página de error 404
        } */

        $insumos = Insumo::all();
        $proveedores = Proveedor::all();
        return view('admin.devoluciones.edit', compact('devolucione', 'insumos', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Devolucion $devolucione)
    {
        //

        $request->validate([
            'estado' => 'required|in:En proceso,Devuelto,Cancelado',
        ]);

        // Verificar si el estado cambió a "Devuelto"
        if ($request->estado === 'Devuelto' && $devolucione->estado !== 'Devuelto') {
            // Iterar a través de los insumos de la devolución
            foreach ($devolucione->insumos as $insumo) {
                $cantidadDevolver = $request->input('insumos.' . $insumo->id . '.cantidad');

                // Verificar si la cantidad a devolver es válida
                if ($cantidadDevolver > 0 && $cantidadDevolver <= $insumo->pivot->cantidad) {
                    // Actualizar la cantidad disponible del insumo
                    $insumo->actualizarCantidadDevuelta($cantidadDevolver);
                } else {
                    // Manejar el error si la cantidad a devolver no es válida
                    return redirect()->back()->withErrors(['insumos.' . $insumo->id . '.cantidad' => 'Cantidad a devolver no válida.']);
                }
            }
        }

        // Actualizar el estado de la devolución
        $devolucione->update(['estado' => $request->estado]);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('admin.devoluciones.index')
            ->with('success', 'Devolución actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Devolucion $devolucione)
    {
        //

        $devolucione->delete();

        return redirect()->route('admin.devoluciones.index')
            ->with('success', 'Devolución eliminada exitosamente.');
    }

    public function DevolucionPDF(Devolucion $devolucion)
    {
        // Cargar la vista PDF con los datos de la compra
        $pdf = Pdf::loadView('admin.devoluciones.devolucion', compact('devolucion'));

        // Opcional: Personalizar el nombre del archivo PDF
        $nombreArchivo = 'Devolucion_' . $devolucion->numero_orden . '.pdf';

        // Mostrar el PDF en el navegador
        return $pdf->stream($nombreArchivo);
    }
}
