<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseApprovalExport;
use App\Models\PurchaseOrderDetail;
use App\Models\Utility;
use App\Domains\Tax\TaxValue;

class PurchaseApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (\Auth::user()->can('manage purchase approval')) {
            $dataapproval = $request->approval;
            if (!empty($dataapproval)) {
                $approval_po = PurchaseOrderDetail::where('approval', $dataapproval)->where('created_by', Auth::user()->creatorId())->orderBy('id', 'desc')->get();
            } else {
                $approval_po = PurchaseOrderDetail::where('created_by', Auth::user()->creatorId())->orderBy('id', 'desc')->get();
            }

            $taxValues = TaxValue::get();

            return view('purchase_approval.index', compact('approval_po', 'dataapproval', 'taxValues'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('manage purchase approval')) {
            $po_det = PurchaseOrderDetail::find($id);
            if ($po_det->created_by == \Auth::user()->creatorId()) {

                $po_det->approval          = $request->approval;
                $po_det->save();

                return redirect()->back()->with('success', __('Purchase successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function export()
    {
        $approval = '';
        $name = 'purchase_approval_' . date('Y-m-d i:h:s');
        $data = Excel::download(new PurchaseApprovalExport(), $name . '.xlsx');

        return $data;
    }

    public function destroy($id)
    {
        //
    }
}
