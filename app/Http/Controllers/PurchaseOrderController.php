<?php

namespace App\Http\Controllers;

use App\Domains\ProductService\ProductServiceCategoryTypeValue;
use App\Domains\Tax\TaxValue;
use App\Models\PaymentTerm;
use App\Models\ProductService;
use App\Models\ProductServiceUnit;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequisition;
use App\Models\Tax;
use App\Models\Utility;
use App\Models\Vender;
use App\Models\warehouse;
use App\Models\ProductServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\User\UserService;


class PurchaseOrderController extends Controller
{
    private $userService;

    public function __construct(
        UserService $userService,
    ) {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\Auth::user()->can('manage purchase order')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $po = PurchaseOrder::with(['creator']);

        if (Auth::user()->type == 'company') {
            $po = $po->get();
        } else {
            $po = $po->where('created_by', '=', \Auth::id())->get();
        }

        return view('purchase_order.index', compact('po'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\Auth::user()->can('manage purchase order')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $vender = Vender::where('created_by', '=', \Auth::user()->creatorId())->get();
        $warehouse = warehouse::where('created_by', \Auth::user()->creatorId())->get();
        $pr = PurchaseRequest::where('status', 'Created')
            ->where('created_by', \Auth::user()->creatorId())
            ->orWhere('created_by', \Auth::user()->id)
            ->get();
        $terms = PaymentTerm::where('created_by', \Auth::user()->creatorId())->get();
        $categories = ProductServiceCategory::where('type', ProductServiceCategoryTypeValue::getIndex(ProductServiceCategoryTypeValue::TYPE_EXPENSE))->get();

        return view('purchase_order.create', compact('vender', 'warehouse', 'pr', 'terms', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!\Auth::user()->can('manage purchase order')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $validator = \Validator::make(
            $request->all(),
            [
                'vender_id' => 'required',
                'no_kontrak' => 'required',
                'warehouse_id' => 'required',
                'send_date' => 'required',
                'payment_term_id' => 'required',
                'category_id' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        // generate po_number
        $id = DB::select("SHOW TABLE STATUS LIKE 'purchase_orders'");
        $next_id = $id[0]->Auto_increment;

        // insert table
        $po = new PurchaseOrder();
        $po->po_number = 'PO-0' . sprintf("%05d", $next_id);
        $po->vender_id = $request->vender_id;
        $po->no_kontrak = $request->no_kontrak;
        $po->warehouse_id = $request->warehouse_id;
        $po->pr_id = $request->pr_id;
        $po->send_date = $request->send_date;
        $po->payment_term_id = $request->payment_term_id;
        $po->status = 'Draf';
        $po->description = $request->description;
        $po->category_id = $request->category_id;
        $po->note = $request->note;
        $po->created_by = \Auth::id();

        if (Auth::user()->type == 'company') {
            $po->created_by = \Auth::user()->creatorId();
        }

        $po->save();

        PurchaseRequest::whereId($request->pr_id)->update(['status' => 'WIP']);
        $po_det = PurchaseRequisition::where('pr_id', $request->pr_id)->get();
        foreach ($po_det as $item) {
            PurchaseOrderDetail::create([
                'po_id' => $po->id,
                'no_kontrak' => $po->no_kontrak,
                'pr_id' => $item->pr_id,
                'po_number' => $po->po_number,
                'product_services_id' => $item->product_services_id,
                'sku_number' => $item->sku_number,
                'product_name' => $item->product_name,
                'qty' => $item->qty,
                'unit_id' => $item->unit_id,
                'dimensions' => $item->dimensions,
                'manufacture' => $item->manufacture,
                'weight' => $item->weight,
                'tax_id' => !empty($item->productservices()) ? $item->productservices()->tax_id : '1',
                'discount' => '0',
                'price' => !empty($item->productservices()) ? $item->productservices()->purchase_price : '0',
                'description' => $item->note,
                'created_by' => \Auth::user()->creatorId(),
            ]);
        }
        return redirect()->back()->with('success', __('Purchase successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $po = PurchaseOrder::find($id);
        $po_det = PurchaseOrderDetail::with(['goodsReceiptDetail'])->where('po_id', $id)->get();
        $taxes = collect(Utility::tax('1,2'));

        return view('purchase_order.show', compact('po', 'po_det', 'taxes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->can('manage purchase order')) {
            $po = PurchaseOrder::find($id);
            $vender = Vender::where('created_by', '=', \Auth::user()->creatorId())->get();
            $warehouse = warehouse::where('created_by', \Auth::user()->creatorId())->get();
            $pr = PurchaseRequest::where('created_by', \Auth::user()->creatorId())->get();
            $terms = PaymentTerm::where('created_by', \Auth::user()->creatorId())->get();
            $categories = ProductServiceCategory::where('type', ProductServiceCategoryTypeValue::getIndex(ProductServiceCategoryTypeValue::TYPE_EXPENSE))->get();

            if (
                $po->created_by == \Auth::user()->creatorId()
                || $this->userService->findCreator($po->created_by) == \Auth::user()->authId()
            ) {
                return view('purchase_order.edit', compact('po', 'vender', 'warehouse', 'pr', 'terms', 'categories'));
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
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('manage purchase request')) {
            $po = PurchaseOrder::find($id);
            if ($po->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'vender_id' => 'required',
                        'no_kontrak' => 'required',
                        'warehouse_id' => 'required',
                        'send_date' => 'required',
                        'payment_term_id' => 'required',
                        'category_id' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $po->vender_id          = $request->vender_id;
                $po->warehouse_id          = $request->warehouse_id;
                $po->no_kontrak      = $request->no_kontrak;
                $po->send_date        = $request->send_date;
                $po->payment_term_id       = $request->payment_term_id;
                $po->description             = $request->description;
                $po->status             = $request->status;
                $po->category_id = $request->category_id;
                $po->save();

                PurchaseOrderDetail::where('po_id', $id)->update(['no_kontrak' => $request->no_kontrak]);
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
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('manage purchase order')) {
            $po = PurchaseOrder::find($id);
            if ($po->created_by == \Auth::user()->creatorId()) {
                PurchaseOrderDetail::where('po_id', $id)->delete();
                PurchaseRequest::where('id', $po->pr_id)->update(['status' => 'Created']);
                $po->delete();

                return redirect()->back()->with('success', __('Purchase successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function index_detail($id)
    {
        if (!\Auth::user()->can('manage purchase order')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $po = PurchaseOrder::find($id);
        $datadetail = PurchaseOrderDetail::with(['productService', 'goodsReceiptDetail'])->where('po_id', $id)->where('approval', '!=', 'Rejected')->get();
        $datadetail_reject = PurchaseOrderDetail::with(['productService', 'goodsReceiptDetail'])->where('po_id', $id)->where('approval', '=', 'Rejected')->get();
        $taxValues = TaxValue::get();

        return view('purchase_order.detail_index', compact('po', 'id', 'datadetail', 'datadetail_reject', 'taxValues'));
    }

    public function create_detail($id)
    {
        if (\Auth::user()->can('manage purchase order')) {
            $po = PurchaseOrder::find($id);
            if (
                $po->created_by == \Auth::user()->creatorId()
                || $po->created_by == \Auth::user()->id
                || $this->userService->findCreator($po->created_by) == \Auth::user()->id
            ) {
                $unit = ProductServiceUnit::where('created_by', \Auth::user()->creatorId())->get();
                $dataproduct = ProductService::where('created_by', \Auth::user()->creatorId())->get();
                $tax          = Tax::where('created_by', '=', \Auth::user()->creatorId())->get();
                return view('purchase_order.detail_create', compact('po', 'dataproduct', 'unit', 'tax'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store_detail(Request $request)
    {
        if (\Auth::user()->can('manage purchase order')) {
            if ($request->copypaste) {
                $data = PurchaseOrderDetail::find($request->copypaste);
                $po_det                     = new PurchaseOrderDetail();
                $po_det->po_id          = $data->po_id;
                $po_det->no_kontrak          = $data->no_kontrak;
                $po_det->pr_id          = $data->pr_id;
                $po_det->po_number      = $data->po_number;
                $po_det->product_services_id      = $data->product_services_id;
                $po_det->sku_number        = $data->sku_number;
                $po_det->product_name       = $data->product_name;
                $po_det->qty      = $data->qty;
                $po_det->unit_id               = $data->unit_id;
                $po_det->dimensions        = $data->dimensions;
                $po_det->manufacture        = $data->manufacture;
                $po_det->weight        = $data->weight;
                $po_det->tax_id        = 0;
                $po_det->discount        = $data->discount;
                $po_det->price        = $data->price;
                $po_det->description          = $data->description;
                $po_det->created_by         = \Auth::user()->creatorId();
                $po_det->save();
                return redirect()->back()->with('success', __('Purchase successfully created.'));
            } else {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'product_name' => 'required',
                        'price' => 'required',
                        'qty' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                // insert table
                $po_det                     = new PurchaseOrderDetail();
                $po_det->po_id          = $request->po_id;
                $po_det->no_kontrak          = $request->no_kontrak;
                $po_det->pr_id          = $request->pr_id;
                $po_det->po_number      = $request->po_number;
                $po_det->product_services_id      = $request->product_services_id;
                $po_det->sku_number        = $request->sku_number;
                $po_det->product_name       = $request->product_name;
                $po_det->qty      = $request->qty;
                $po_det->unit_id               = $request->unit_id;
                $po_det->dimensions        = $request->dimensions;
                $po_det->manufacture        = $request->manufacture;
                $po_det->weight        = $request->weight;
                $po_det->tax_id        = 0;
                $po_det->tax_ppn        = $request->tax_ppn === 'true';
                $po_det->tax_pph        = $request->tax_pph === 'true';
                $po_det->discount        = $request->discount;
                $po_det->price        = $request->price;
                $po_det->description          = $request->description;
                $po_det->created_by         = \Auth::user()->creatorId();
                $po_det->save();

                return redirect()->back()->with('success', __('Purchase successfully created.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit_detail($id)
    {
        if (\Auth::user()->can('manage purchase order')) {
            $po_det = PurchaseOrderDetail::find($id);
            if ($po_det->created_by == \Auth::user()->creatorId()) {
                return view('purchase_order.detail_edit', compact('po_det'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update_detail(Request $request, $id)
    {
        if (\Auth::user()->can('manage purchase order')) {
            $po_det = PurchaseOrderDetail::find($id);
            if ($po_det->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'qty' => 'required',
                        'price' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $po_det->qty = $request->qty;
                $po_det->price = $request->price;
                $po_det->tax_ppn = $request->tax_ppn === 'true';
                $po_det->tax_pph = $request->tax_pph === 'true';
                $po_det->save();

                return redirect()->back()->with('success', __('Purchase successfully updated.'));
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
            $po_det = PurchaseOrderDetail::find($id);
            if ($po_det->created_by == \Auth::user()->creatorId()) {
                $po_det->delete();

                return redirect()->back()->with('success', __('Purchase successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
