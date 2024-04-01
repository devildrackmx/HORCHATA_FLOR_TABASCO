<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Compra;
use App\Models\Insumo;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.compras.index')->only('index');
        $this->middleware('can:admin.compras.create')->only('create', 'store');
        $this->middleware('can:admin.compras.edit')->only('edit', 'update');
        $this->middleware('can:admin.compras.destroy')->only('destroy');
    }

    public function index()
    {
        //
        $compras = Compra::all();
        return view('admin.compras.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $insumos = Insumo::all();
        $proveedores = Proveedor::all();
        return view('admin.compras.create', compact('insumos', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'fecha_compra' => 'required|date',
            'numero_orden' => 'required|string',
            'proveedor_id' => 'required|exists:proveedors,id',
            /* 'estado' => 'required|in:En proceso,Recibido,Devuelto,Cancelado', */
            'insumos' => 'required|array',
            'tipo_compra' => 'required|in:CREDITO,CONTADO',
            'tipo_moneda' => 'required|in:US,MXN',
        ]);

        $compra = new Compra();
        $compra->fecha_compra = $request->fecha_compra;
        $compra->numero_orden = $request->numero_orden;
        $compra->proveedor_id = $request->proveedor_id;
        $compra->tipo_compra = $request->tipo_compra;
        $compra->tipo_moneda = $request->tipo_moneda;
        $compra->save();

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
                $compra->insumos()->attach($insumoId, [
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'importe' => $importe,
                ]);

                // Calcular el subtotal
                $subtotal += $importe;

                if ($compra->estado === 'Recibido') {
                    // Actualizar la cantidad disponible del insumo solo cuando el estado sea "Recibido"
                    $insumo->actualizarCantidadComprada($cantidad);
                }
            }
        }

        // Asignar el subtotal a la compra
        $compra->subtotal = $subtotal;
        $compra->save();

        // Verificar si se proporcionó el IVA
        if ($request->has('iva')) {
            $iva = $request->iva;

            // Calcular el total con IVA
            $total = $subtotal + ($subtotal * ($iva / 100));

            // Asignar el IVA y el total a la compra
            $compra->iva = $iva;
            $compra->total = $total;
            $compra->save();
        }

        return redirect()->route('admin.compras.index')
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
    public function edit(Compra $compra)
    {
        //

        if ($compra->estado === 'Recibido' || $compra->estado === 'Cancelado') {
            abort(404); // Mostrar página de error 404
        }

        $insumos = Insumo::all();
        $proveedores = Proveedor::all();
        return view('admin.compras.edit', compact('compra', 'insumos', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compra $compra)
    {
        //

        $request->validate([
            'estado' => 'required|in:En proceso,Recibido,Devuelto,Cancelado',
        ]);

        // Verificar si el estado cambió a "Recibido"
        if ($request->estado === 'Recibido' && $compra->estado !== 'Recibido') {
            // Iterar a través de los insumos de la compra
            foreach ($compra->insumos as $insumo) {
                $cantidad = $insumo->pivot->cantidad;

                // Actualizar la cantidad disponible del insumo
                $insumo->actualizarCantidadComprada($cantidad);
            }
        }

        $compra->update(['estado' => $request->estado]);

        return redirect()->route('admin.compras.index')
            ->with('success', 'Compra actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compra $compra)
    {
        //
        $compra->delete();

        return redirect()->route('admin.compras.index')
            ->with('success', 'Compra eliminada exitosamente.');
    }

    public function generarOrdenCompraPDF(Compra $compra)
    {
        // Cargar la vista PDF con los datos de la compra
        $pdf = Pdf::loadView('admin.compras.orden_de_compra', compact('compra'));

        // Opcional: Personalizar el nombre del archivo PDF
        $nombreArchivo = 'OrdenCompra_' . $compra->numero_orden . '.pdf';

        // Mostrar el PDF en el navegador
        return $pdf->stream($nombreArchivo);
    }
}
