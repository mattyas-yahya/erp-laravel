<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Domains\Tax\TaxValue;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\GoodsReceiptDetail;
use App\Models\PaymentTerm;
use App\Models\ProductServiceCategory;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\Utility;
use App\Models\warehouse;
use App\Services\Marketing\SalesOrderService;
use App\Services\Customer\CustomerService;
use Carbon\Carbon;

class SalesOrderController extends Controller
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

    public function index()
    {
        if (!\Auth::user()->can('manage sales order')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        try {
            $this->salesOrderService->updateExpiredBookingStatus();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

        $salesOrders = $this->salesOrderService->getSalesOrders(null);

        return view('sales_order.index', [
            'salesOrders' => $salesOrders,
        ]);
    }

    public function create()
    {
        if (!\Auth::user()->can('manage sales order')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $customers = $this->customerService->getCustomers();

        $warehouse = warehouse::where('created_by', \Auth::user()->creatorId())->get();
        $terms = PaymentTerm::where('created_by', \Auth::user()->creatorId())->get();
        $category = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get();

        if (\Auth::user()->type == 'company') {
            $employees = Employee::whereRelation('designation', 'name', 'LIKE', '%' . 'Marketing' . '%')->where('created_by', '=', \Auth::user()->creatorId())->get();
        } else {
            $employees = Employee::where('user_id', \Auth::user()->id)->get();
        }

        $delivery = $this->salesOrderService->getDeliveryValues();

        return view('sales_order.create', [
            'customers' => $customers,
            'warehouse' => $warehouse,
            'employees' => $employees,
            'terms' => $terms,
            'category' => $category,
            'delivery' => $delivery,
        ]);
    }

    public function store(Request $request)
    {
        if (!\Auth::user()->can('manage sales order')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $validator = \Validator::make(
            $request->all(),
            [
                'customer_id' => 'required',
                'warehouse_id' => 'required',
                'reff_po_cust' => 'required',
                'date_order' => 'required',
                'employee_id' => 'required',
                'payment_term_id' => 'required',
                'delivery' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        // expdate booking 1 day
        $date = Carbon::create($request->date_order)->addDay();
        // generate gr_number
        $id = DB::select("SHOW TABLE STATUS LIKE 'sales_orders'");
        $next_id = $id[0]->Auto_increment;
        // dd($request->all());
        // insert table
        $so                     = new SalesOrder();
        $so->so_number          = 'SO-0' . sprintf("%05d", $next_id);
        $so->customer_id      = $request->customer_id;
        $so->warehouse_id      = $request->warehouse_id;
        $so->reff_po_cust        = $request->reff_po_cust;
        $so->date_order       = $request->date_order;
        $so->employee_id             = $request->employee_id;
        $so->payment_term_id             = $request->payment_term_id;
        $so->delivery             = $request->delivery;
        $so->product_service_category_id             = $request->product_service_category_id;
        $so->status             = $request->status;
        if ($request->status == 'Booking') {
            $so->exp_date_order       = $date->toDateString();
        }
        $so->created_by         = \Auth::user()->creatorId();
        $so->save();

        return redirect()->back()->with('success', __('Sales Order successfully created.'));
    }

    public function show($id)
    {
        $so = SalesOrder::find($id);
        $so_det = SalesOrderDetail::where('so_id', $id)->get();
        return view('sales_order.show', compact('so', 'so_det'));
    }

    public function edit($id)
    {
        if (!\Auth::user()->can('manage sales order')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $so = SalesOrder::find($id);
        $warehouse = warehouse::where('created_by', \Auth::user()->creatorId())->get();
        $customers = Customer::where('created_by', \Auth::user()->creatorId())->get();
        $employees = Employee::where('created_by', '=', \Auth::user()->creatorId())->get();
        $terms = PaymentTerm::where('created_by', \Auth::user()->creatorId())->get();
        $category     = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get();

        if ($so->created_by == \Auth::user()->creatorId()) {
            return view('sales_order.edit', compact('so', 'customers', 'warehouse', 'employees', 'terms', 'category'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('manage sales order')) {
            $so = SalesOrder::find($id);
            if ($so->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'customer_id' => 'required',
                        'warehouse_id' => 'required',
                        'reff_po_cust' => 'required',
                        'date_order' => 'required',
                        'employee_id' => 'required',
                        'payment_term_id' => 'required',
                        'delivery' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $so->customer_id      = $request->customer_id;
                $so->warehouse_id      = $request->warehouse_id;
                $so->reff_po_cust        = $request->reff_po_cust;
                $so->date_order       = $request->date_order;
                $so->employee_id             = $request->employee_id;
                $so->payment_term_id             = $request->payment_term_id;
                $so->delivery             = $request->delivery;
                $so->product_service_category_id             = $request->product_service_category_id;
                $so->status             = $request->status;
                $so->save();
                return redirect()->back()->with('success', __('Sales Order successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('manage sales order')) {
            $so = SalesOrder::find($id);
            if ($so->created_by == \Auth::user()->creatorId()) {
                SalesOrderDetail::where('so_id', $id)->delete();
                $so->delete();
                return redirect()->back()->with('success', __('Sales Order successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function index_detail($id)
    {
        if (!\Auth::user()->can('manage sales order')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $so = SalesOrder::find($id);

        if ($so->created_by != \Auth::user()->creatorId()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $datadetail = SalesOrderDetail::where('so_id', $id)->get();
        $taxValues = TaxValue::get();

        return view('sales_order.detail_index', compact('so', 'id', 'datadetail', 'taxValues'));
    }

    public function create_detail($id)
    {
        if (\Auth::user()->can('manage sales order')) {
            $so = SalesOrder::find($id);
            if ($so->created_by == \Auth::user()->creatorId()) {
                $dataproduct = GoodsReceiptDetail::where('created_by', \Auth::user()->creatorId())->get();
                $unit = ['Lembar', 'Kg'];
                $dataproduction = ['Non', 'SH', 'SL', 'SL+SH', 'Packing'];
                return view('sales_order.detail_create', compact('so', 'dataproduct', 'unit', 'dataproduction'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store_detail(Request $request)
    {
        if (!\Auth::user()->can('manage sales order')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $validator = \Validator::make(
            $request->all(),
            [
                'goods_receipt_details_id' => 'required',
                'sale_price' => 'required',
                'qty' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        // insert table
        $so_det                     = new SalesOrderDetail();
        $so_det->so_id          = $request->so_id;
        $so_det->so_number          = $request->so_number;
        $so_det->goods_receipt_details_id      = $request->goods_receipt_details_id;
        $so_det->no_coil          = $request->no_coil;
        $so_det->qty          = $request->qty;
        $so_det->sale_price          = $request->sale_price;
        $so_det->tax_ppn = !empty($request->tax_ppn) ? true : false;
        $so_det->tax_pph = !empty($request->tax_pph) ? true : false;
        $so_det->unit          = $request->unit;
        $so_det->production      = $request->production;
        $so_det->discount      = $request->discount;
        $so_det->description      = $request->description;
        $so_det->created_by         = \Auth::user()->creatorId();
        $so_det->save();

        return redirect()->back()->with('success', __('Sales Order successfully created.'));
    }

    public function edit_detail($id)
    {
        if (\Auth::user()->can('manage sales order')) {
            $so_det = SalesOrderDetail::find($id);
            if ($so_det->created_by == \Auth::user()->creatorId()) {

                return view('sales_order.detail_edit', compact('so_det'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update_detail(Request $request, $id)
    {
        if (\Auth::user()->can('manage sales order')) {
            $so_det = SalesOrderDetail::find($id);
            if ($so_det->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'qty' => 'required',
                        'sale_price' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $so_det->qty      = $request->qty;
                $so_det->discount      = $request->discount;
                $so_det->sale_price      = $request->sale_price;
                $so_det->save();

                return redirect()->back()->with('success', __('Sales Order successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy_detail($id)
    {
        if (\Auth::user()->can('manage purchase order')) {
            $so_det = SalesOrderDetail::find($id);
            if ($so_det->created_by == \Auth::user()->creatorId()) {
                $so_det->delete();

                return redirect()->back()->with('success', __('Sales Order successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // gr detail
    public function getgrDetail(Request $request)
    {
        $grDetail['grDetail'] = GoodsReceiptDetail::where('created_by', \Auth::user()->creatorId())
            ->where('id', $request->goods_receipt_details_id)
            ->first();

        return response()->json($grDetail);
    }
}
