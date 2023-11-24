<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\ProductService;
use App\Models\ProductServiceUnit;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseOrderDetail;
use App\Models\GoodsReceiptDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!\Auth::user()->can('manage purchase request')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        if (Auth::user()->type == 'company') {
            $branch = Branch::query();
            $pr = PurchaseRequest::with('purchaseOrder.purchaseOrderDetails.goodsReceiptDetail');
            if (!empty($request->branch)) {
                $pr->where('branch_id', $request->branch);
            }

            if (!empty($request->department)) {
                $pr->where('department_id', $request->department);
            }
            // by employee
            if (!empty($request->employee)) {
                $pr->where('employee_id', $request->employee);
            }
            $pr = $pr->get();
            $getBranch = $request->branch;

            return view('purchase_request.index', compact('pr', 'branch', 'getBranch'));
        } else {
            $employee = Employee::where('user_id', \Auth::user()->id)->first();
            $branch = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();
            $branch = $branch->where('id', $employee->branch_id)->first();
            $department = Department::where('id', $employee->department_id)->first();

            $pr = PurchaseRequest::with('purchaseOrder.purchaseOrderDetails.goodsReceiptDetail')
                ->where('created_by', \Auth::id())
                ->orWhere('employee_id', \Auth::user()->employee->id);

            $pr = $pr->get();

            return view('purchase_request.non_company_index', [
                'pr' => $pr,
                'branch' => $branch,
                'department' => $department,
                'employee' => $employee,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\Auth::user()->can('manage purchase request')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $branch = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();

        if (\Auth::user()->type == 'company') {
            return view('purchase_request.create', [
                'branch' => $branch,
            ]);
        }

        $employee = Employee::where('user_id', \Auth::user()->id)->first();
        $branch = $branch->where('id', $employee->branch_id)->first();
        $department = Department::where('id', $employee->department_id)->first();

        return view('purchase_request.non_company_create', [
            'branch' => $branch,
            'department' => $department,
            'employee' => $employee,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!\Auth::user()->can('manage purchase request')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $validator = \Validator::make(
            $request->all(),
            [
                'branch_id' => 'required',
                'department_id' => 'required',
                'employee_id' => 'required',
                'request_date' => 'required',
                'date_required' => 'required',
                'name' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        // generate pr_number
        $id = DB::select("SHOW TABLE STATUS LIKE 'purchase_requests'");
        $next_id = $id[0]->Auto_increment;

        // insert table
        $pr                     = new PurchaseRequest();
        $pr->branch_id          = $request->branch_id;
        $pr->department_id      = $request->department_id;
        $pr->employee_id        = $request->employee_id;
        $pr->request_date       = $request->request_date;
        $pr->date_required      = $request->date_required;
        $pr->name               = $request->name;
        $pr->pr_number          = 'PR-0' . sprintf("%05d", $next_id);
        $pr->status             = 'Draf';
        $pr->created_by = \Auth::id();
        if (\Auth::user()->type == 'company') {
            $pr->created_by = \Auth::user()->creatorId();
        }
        $pr->save();

        return redirect()->back()->with('success', __('Purchase successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pr = PurchaseRequest::find($id);
        $datarequisition = PurchaseRequisition::where('pr_id', $id)->get();
        $poDetails = PurchaseOrderDetail::where('pr_id', $pr->id)
            ->where('approval', 'Approved')
            ->get();
        $goodsReceiptDetails = GoodsReceiptDetail::whereIn('purchase_order_detail_id', $poDetails->map(function ($item) { return $item->id; }))
            ->where('status', 'Complete')
            ->get();

        return view('purchase_request.show', compact('pr','datarequisition', 'goodsReceiptDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->can('manage purchase request')) {
            $branch      = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employees = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $pr = PurchaseRequest::find($id);

            if ($pr->created_by == \Auth::user()->creatorId() || $pr->employee_id == \Auth::user()->employee->id) {
                return view('purchase_request.edit', compact('pr', 'employees', 'branch', 'departments'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('manage purchase request')) {
            $pr = PurchaseRequest::find($id);
            if ($pr->created_by == \Auth::user()->creatorId() || $pr->employee_id == \Auth::user()->employee->id) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'branch_id' => 'required',
                        'department_id' => 'required',
                        'employee_id' => 'required',
                        'request_date' => 'required',
                        'date_required' => 'required',
                        'name' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $pr->branch_id      = $request->branch_id;
                $pr->department_id  = $request->department_id;
                $pr->employee_id    = $request->employee_id;
                $pr->name      = $request->name;
                $pr->request_date = $request->request_date;
                $pr->date_required = $request->date_required;
                $pr->status = $request->status;
                $pr->save();

                return redirect()->back()->with('success', __('Purchase successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('manage purchase request')) {
            $pr = PurchaseRequest::find($id);
            if ($pr->created_by == \Auth::user()->creatorId() || $pr->employee_id == \Auth::user()->employee->id) {
                PurchaseRequisition::where('pr_id',$id)->delete();
                $pr->delete();

                return redirect()->back()->with('success', __('Purchase successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function index_requisition($id)
    {
        if (\Auth::user()->can('manage purchase request')) {
            $pr = PurchaseRequest::find($id);
            if ($pr->created_by == \Auth::user()->creatorId() || $pr->employee_id == \Auth::user()->employee()->first()->id) {
                $datarequisition = PurchaseRequisition::where('pr_id', $id)->get();
                return view('purchase_request.requisition_index', compact('pr', 'datarequisition'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function create_requisition($id)
    {
        if (\Auth::user()->can('manage purchase request')) {
            $pr = PurchaseRequest::find($id);
            if ($pr->created_by == \Auth::user()->creatorId() || $pr->employee_id == \Auth::user()->employee->id) {
                $unit = ProductServiceUnit::where('created_by', \Auth::user()->creatorId())->get();
                $dataproduct = ProductService::where('created_by', \Auth::user()->creatorId())->get();
                return view('purchase_request.requisition_create', compact('pr', 'unit', 'dataproduct'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store_requisition(Request $request)
    {
        if (\Auth::user()->can('manage purchase request')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'sku_number' => 'required',
                    'product_name' => 'required',
                    'qty' => 'required',
                    'unit_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            // insert table
            $pr                     = new PurchaseRequisition();
            $pr->pr_id          = $request->pr_id;
            $pr->pr_number      = $request->pr_number;
            $pr->product_services_id      = $request->product_services_id;
            $pr->sku_number        = $request->sku_number;
            $pr->product_name       = $request->product_name;
            $pr->qty      = $request->qty;
            $pr->unit_id               = $request->unit_id;
            $pr->note          = $request->note;
            $pr->dimensions        = $request->dimensions;
            $pr->manufacture        = $request->manufacture;
            $pr->weight        = $request->weight;
            $pr->created_by         = \Auth::user()->creatorId();
            $pr->save();

            return redirect()->back()->with('success', __('Purchase successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function destroy_requisition($id)
    {
        if (\Auth::user()->can('manage purchase request')) {
            $requisition = PurchaseRequisition::find($id);
            if ($requisition->created_by == \Auth::user()->creatorId()) {
                $requisition->delete();

                return redirect()->back()->with('success', __('Purchase successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    // search
    public function getdepartmentsearch(Request $request)
    {
        $departments['departments'] = Department::where('created_by', '=', \Auth::user()->creatorId())->where('branch_id', $request->branch)->get();
        return response()->json($departments);
    }

    public function getemployeesearch(Request $request)
    {
        $employees['employees'] = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('department_id', $request->department)->get();
        return response()->json($employees);
    }

    // inputan
    public function getdepartment(Request $request)
    {
        $departments['departments'] = Department::where('created_by', '=', \Auth::user()->creatorId())->where('branch_id', $request->branch_id)->get();
        return response()->json($departments);
    }

    public function getemployee(Request $request)
    {
        $employees['employees'] = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('department_id', $request->department_id)->get();
        return response()->json($employees);
    }

    // product services
    public function getproductservice(Request $request)
    {
        $productservice['productservice'] = ProductService::where('created_by', '=', \Auth::user()->creatorId())->where('id', $request->product_services_id)->first();
        return response()->json($productservice);
    }
}
