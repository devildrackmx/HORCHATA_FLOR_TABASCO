<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Horchata;
use App\Models\Insumo;
use App\Models\Proveedor;
use App\Models\Compra;

class AdminController extends Controller
{


    public function index()
    {

        $insumosSum = Insumo::count();
        $horchatasSum = Horchata::count();
        $proveedoresSum = Proveedor::count();
        $comprasSum = Compra::count();

        $insumos = Insumo::all();

        // Verificar las notificaciones de insumos
        $notificacionesInsumos = [];
        foreach ($insumos as $insumo) {
            $notificacion = $insumo->notificarCantidadBaja();
            if ($notificacion) {
                $notificacionesInsumos[] = $notificacion;
            }
        }

        /* $pedidosHoyData = $this->getPedidosPorPresentacion('today');

        $pedidosMesData = $this->getPedidosPorPresentacion('month');

        $pedidosAnoData = $this->getPedidosPorPresentacion('year'); */

        return view('admin.index', compact(
            'insumosSum',
            'horchatasSum',
            'proveedoresSum',
            'comprasSum',
            /* 'pedidosHoyData',
            'pedidosMesData',
            'pedidosAnoData', */
            'notificacionesInsumos'
        ));
    }

    public function getInsumosNotifications()
    {
        // Obtener todas las instancias de Insumo
        $insumos = Insumo::all();

        // Array para almacenar las notificaciones
        $notifications = [];

        foreach ($insumos as $insumo) {
            // Llama a la función notificarCantidadBaja para obtener el mensaje de notificación.
            $notificationMessage = $insumo->notificarCantidadBaja();

            if ($notificationMessage) {
                // Agregar la notificación al array
                $notifications[] = [
                    'icon' => 'fas fa fa-exclamation-triangle text-danger',
                    'text' => $notificationMessage,
                ];
            }
        }

        // Construir el HTML de las notificaciones
        $dropdownHtml = '';

        foreach ($notifications as $key => $notification) {
            $icon = "<i class='mr-2 {$notification['icon']}'></i>";

            $dropdownHtml .= "<a href='#' class='dropdown-item'>
                                {$icon}{$notification['text']}
                              </a>";

            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        return [
            'label'       => count($notifications),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
            'dropdown'    => $dropdownHtml,
        ];
    }

    /* private function getPedidosPorPresentacion($interval)
    {
        $query = Pedido::join('pedido_horchata', 'pedidos.id', '=', 'pedido_horchata.pedido_id')
            ->join('horchatas', 'pedido_horchata.horchata_id', '=', 'horchatas.id')
            ->select('horchatas.presentacion', DB::raw('SUM(pedido_horchata.cantidad) as cantidad'))
            ->groupBy('horchatas.presentacion');

        $fechaInicio = null;
        $fechaFin = null;

        if ($interval === 'today') {
            $fechaInicio = now()->startOfDay();
            $fechaFin = now()->endOfDay();
        } elseif ($interval === 'month') {
            $fechaInicio = now()->subMonth()->startOfMonth();
            $fechaFin = now()->subMonth()->endOfMonth();
        } elseif ($interval === 'year') {
            $fechaInicio = now()->subYear()->startOfYear();
            $fechaFin = now()->subYear()->endOfYear();
        }

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('pedidos.fecha_pedido', [$fechaInicio, $fechaFin]);
        }

        return $query->get();
    } */
}
