<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;

class ApiPurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->user()->type == 'company') {
            $po = PurchaseOrder::with(['creator']);
        } else{
            $po = PurchaseOrder::with(['creator'])->where('created_by', '=', \Auth::id());
        }

        if (!empty($request->vender_id)) {
            $po = $po->where('vender_id', $request->vender_id);
        }

        return $po->doesntHave('bill')
            ->get();
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, string $purchaseOrderId)
    {
        if (empty($purchaseOrderId)) {
            return [];
        }

        $details = PurchaseOrderDetail::with(['productService', 'productServiceUnit', 'goodsReceiptDetail'])
            ->where('po_id', $purchaseOrderId);

        return $details->get();
    }
}
