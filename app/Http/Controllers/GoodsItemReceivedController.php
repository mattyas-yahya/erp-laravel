<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceiptDetail;
use Illuminate\Http\Request;

class GoodsItemReceivedController extends Controller
{
    public function index(Request $request)
    {
        if (!\Auth::user()->can('manage goods receipt')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $allproduct = GoodsReceiptDetail::select('product_name')->groupBy('product_name')->get();
        $gr = GoodsReceiptDetail::where('created_by', \Auth::user()->creatorId())->orderBy('id', 'desc');

        if (!empty($request->date)) {
            $gr->whereRelation('gr', 'date_goodscome', 'LIKE', '%' . $request->date . '%');
        }

        if (!empty($request->product)) {
            $gr->where('product_name', $request->product);
        }

        $gr = $gr->get();

        return view('goods_itemreceived.index', [
            'gr' => $gr,
            'allproduct' => $allproduct,
            'date' => $request->date,
            'product' => $request->product,
        ]);
    }

    public function generateQrCode(Request $request)
    {
        if (!\Auth::user()->can('manage goods receipt')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $grs = GoodsReceiptDetail::whereIn('id', $request->ids)->get();

        return view('goods_itemreceived.qrcode-print-template', [
            'grs' => $grs,
        ]);
    }

    function generatePdf()
    {
        if (!\Auth::user()->can('manage goods receipt')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $gr = GoodsReceiptDetail::all();

        return view('goods_itemreceived.pdf-template', [
            'gr' => $gr,
        ]);
    }
}
