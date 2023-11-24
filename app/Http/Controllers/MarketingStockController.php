<?php

namespace App\Http\Controllers;

use App\Exports\MarketingStockExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GoodsReceiptDetail;
use Maatwebsite\Excel\Facades\Excel;

class MarketingStockController extends Controller
{
    public function __construct()
    {
    }

    function index(Request $request)
    {
        if (!Auth::user()->can('manage sales order')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $gr = GoodsReceiptDetail::where('created_by', \Auth::user()->creatorId())
            ->orderBy('product_name', 'ASC')
            ->get();

        return view('marketing.stock.index', [
            'gr' => $gr,
        ]);
    }

    public function edit($id)
    {
        if (!Auth::user()->can('manage sales order')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $grDetail = GoodsReceiptDetail::find($id);
        if ($grDetail?->created_by != \Auth::user()->creatorId()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return view('marketing.stock.edit', compact('grDetail'));
    }

    public function update(Request $request, $id)
    {
        if (!\Auth::user()->can('manage sales order')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $grDetail = GoodsReceiptDetail::find($id);
        if ($grDetail?->created_by != \Auth::user()->creatorId()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $grDetail->remarks = $request->remarks;
        $grDetail->claim_note = $request->claim_note;
        $grDetail->save();

        return redirect()->back()->with('success', __('Stock successfully updated.'));
    }

    public function export()
    {
        $name = 'stock_xls_' . date('Y-m-d i:h:s');
        $data = Excel::download(new MarketingStockExport(), $name . '.xlsx');

        return $data;
    }
}
