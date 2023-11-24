<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Tms\Assignment as TmsAssignment;
use App\Models\Tms\AssignmentDetail as TmsAssignmentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Tms\AssignmentDetailRequest as TmsAssignmentDetailRequest;
use App\Services\Customer\CustomerService;
use App\Services\Marketing\SalesOrderService;

class AssignmentDetailController extends Controller
{
    private $customerService;
    private $salesOrderService;

    public function __construct(
        CustomerService $customerService,
        SalesOrderService $salesOrderService,
    ) {
        $this->customerService = $customerService;
        $this->salesOrderService = $salesOrderService;
    }

    function index(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $assignment = TmsAssignment::with(['vehicle', 'driver', 'details.salesOrderDetail.gr_from_so', 'details.salesOrderDetail.productionSchedule'])
            ->find($id);

        return view('tms.assignment.detail.index', [
            'assignment' => $assignment,
        ]);
    }

    function create($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $assignment = TmsAssignment::findOrFail($id);
        $customers = $this->customerService->getCustomers();
        $salesOrderDetails = $this->salesOrderService->getFinishedSalesOrderDetails();

        return view('tms.assignment.detail.create', [
            'assignment' => $assignment,
            'customers' => $customers,
            'salesOrderDetails' => $salesOrderDetails,
        ]);
    }

    // function edit($id)
    // {
    //     // if (!Auth::user()->can('manage production')) {
    //     //     return response()->json(['error' => __('Permission denied.')], 401);
    //     // }

    //     $assignment = TmsAssignment::findOrFail($id);
    //     $detail = TmsAssignmentDetail::findOrFail($id);
    //     $customers = $this->customerService->getCustomers();
    //     $salesOrderDetails = $this->salesOrderService->getFinishedSalesOrderDetails();

    //     return view('tms.assignment.detail.edit', [
    //         'assignment' => $assignment,
    //         'detail' => $detail,
    //         'customers' => $customers,
    //         'salesOrderDetails' => $salesOrderDetails,
    //     ]);
    // }

    function store(TmsAssignmentDetailRequest $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            TmsAssignmentDetail::create([
                'tms_assignment_id' => $id,
                'customer_id' => $request->customer_id,
                'sales_order_detail_id' => $request->sales_order_detail_id,
            ]);

            DB::commit();

            return redirect()->route('tms.assignment.detail.index', ['id' => $id])->with('success', __('Assignment successfully created.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    // function update(TmsAssignmentDetailRequest $request, $id)
    // {
    //     // if (!Auth::user()->can('manage production')) {
    //     //     return redirect()->back()->with('error', __('Permission Denied.'));
    //     // }

    //     try {
    //         DB::beginTransaction();

    //         $detail = TmsAssignmentDetail::findOrFail($id);

    //         $detail->fill($request->all());
    //         $detail->save();

    //         DB::commit();

    //         return redirect()->route('tms.assignment.detail.index')->with('success', __('Assignment successfully updated.'));
    //     } catch (\Throwable $e) {
    //         return redirect()->back()->with(['error' => 'Update data gagal!']);
    //     }
    // }

    function destroy($id, $detailId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $detail = TmsAssignmentDetail::find($detailId);
            $detail->delete();

            DB::commit();

            return redirect()->route('tms.assignment.detail.index', ['id' => $id])->with('success', __('Assignment successfully deleted.'));
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }
}
