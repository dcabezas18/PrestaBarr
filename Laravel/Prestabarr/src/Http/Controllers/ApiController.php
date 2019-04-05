<?php

namespace Prestabarr\Http\Controllers;

use Prestabarr\Events\DolibarrChangeProductPriceEvent;
use Prestabarr\Events\DolibarrChangeProductStockEvent;
use Prestabarr\Events\CheckNewReferedPurchasedEvent;
use Prestabarr\Events\DolibarrCreateBarcodeUserEvent;
use Prestabarr\Events\DolibarrToPrestashopProductEvent;
use Prestabarr\Events\PrestashopToDolibarOrderEvent;
use Prestabarr\Events\PrestashopToDolibarUpdateProductEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller {

    public function dolibarrStock(Request $request)
    {
        if ($request->get('ref')) {
            event(new DolibarrChangeProductStockEvent($request->ref, $request->params));
            return response()->json([
                'status' => 200,
                'msg' => 'Registro creado correctamente.'
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'msg' => 'No se han enviado los parámetros obligatorios.'
            ]);
        }
    }
    public function dolibarrPrice(Request $request)
    {
        if ($request->get('ref') && $request->get('params')) {
            event(new DolibarrChangeProductPriceEvent($request->ref, $request->params));
            return response()->json([
                'status' => 200,
                'msg' => 'Registro creado correctamente.'
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'msg' => 'No se han enviado los parámetros obligatorios.'
            ]);
        }
    }

    public function dolibarrProduct(Request $request)
    {
        if ($request->get('ref')) {
            event(new DolibarrToPrestashopProductEvent($request->ref));
            return response()->json([
                'status' => 200,
                'msg' => 'Registro creado correctamente.'
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'msg' => 'No se han enviado los parámetros obligatorios.'
            ]);
        }
    }

    public function prestashopUpdateOrder(Request $request)
    {
        if ($request->get('ref')) {
            event(new PrestashopToDolibarOrderEvent($request->ref));
            return response()->json([
                'status' => 200,
                'msg' => 'Registro creado correctamente.'
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'msg' => 'No se han enviado los parámetros obligatorios.'
            ]);
        }
    }

    public function prestashopUpdateProduct(Request $request)
    {
        if ($request->get('ref') && $request->get('price')) {

            event(new PrestashopToDolibarUpdateProductEvent($request->ref, $request->get('price')));

            return response()->json([
                'status' => 200,
                'msg' => 'Registro creado correctamente.'
            ]);

        } else {
            return response()->json([
                'status' => 422,
                'msg' => 'No se han enviado los parámetros obligatorios.'
            ]);
        }
    }
}