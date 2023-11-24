<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptDetail;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Utility;
use App\Models\Vender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoodsReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manage goods receipt')) {
            $gr = GoodsReceipt::where('created_by', '=', \Auth::user()->creatorId())->get();
            return view('goods_receipt.index', compact('gr'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\Auth::user()->can('manage goods receipt')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $customers = Customer::where('created_by', \Auth::user()->creatorId())
            ->get();

        $po = PurchaseOrder::whereHas('purchaseOrderDetails', function ($query) {
                $query->doesntHave('goodsReceiptDetail');
            })
            ->where('status', 'Created');

        if (Auth::user()->type == 'company') {
            $po = $po->get();
        } else {
            $po = $po->where('created_by', \Auth::user()->creatorId())
                ->get();
        }

        return view('goods_receipt.create', compact('po', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('manage goods receipt')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'po_id' => 'required',
                    'no_sp' => 'required',
                    'date_goodscome' => 'required',
                    'customers_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            // generate gr_number
            $id = DB::select("SHOW TABLE STATUS LIKE 'goods_receipts'");
            $next_id = $id[0]->Auto_increment;
            // dd($request->all());
            $datapo = PurchaseOrder::find($request->po_id);
            // insert table
            $gr                     = new GoodsReceipt();
            $gr->gr_number          = 'GR-0' . sprintf("%05d", $next_id);
            $gr->po_id      = $request->po_id;
            $gr->no_sp      = $request->no_sp;
            $gr->no_kontrak      = $datapo->no_kontrak;
            $gr->vender_id          = $datapo->vender_id;
            $gr->date_goodscome        = $request->date_goodscome;
            $gr->customers_id       = $request->customers_id;
            $gr->description             = $request->description;
            $gr->status             = 'Draf';
            $gr->created_by         = \Auth::user()->creatorId();
            $gr->save();

            $purchaseOrderDetail = PurchaseOrderDetail::where('po_id', $request->po_id)
                ->where('approval', 'Approved')
                ->doesntHave('goodsReceiptDetail')
                ->get();

            foreach ($purchaseOrderDetail as $item) {
                GoodsReceiptDetail::create([
                    'gr_id' => $gr->id,
                    'po_id' => $item->po_id,
                    'purchase_order_detail_id' => $item->id,
                    'gr_number' => $gr->gr_number,
                    'no_kontrak' => $item->no_kontrak,
                    'sku_number' => $item->sku_number,
                    'product_name' => $item->product_name,
                    'qty' => $item->qty,
                    'unit_id' => $item->unit_id,
                    'dimensions' => $item->dimensions,
                    'manufacture' => $item->manufacture,
                    'weight' => $item->weight,
                    'tax_id' => null,
                    'tax_ppn' => $item->tax_ppn,
                    'tax_pph' => $item->tax_pph,
                    'discount' => '0',
                    'price' => $item->price,
                    'price_include' => round($item->price + ($item->tax_ppn ? ($item->price * 11 / 100) : 0) + ($item->tax_pph ? ($item->price * 0.3 / 100) : 0), 2, PHP_ROUND_HALF_DOWN),
                    'description' => $item->description,
                    'approval' => $item->approval,
                    'created_by' => \Auth::user()->creatorId(),
                ]);
            }
            return redirect()->back()->with('success', __('Goods receipt successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GoodsReceipt  $goodsReceipt
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gr = GoodsReceipt::find($id);
        $gr_det = GoodsReceiptDetail::where('gr_id', $id)->get();
        return view('goods_receipt.show', compact('gr', 'gr_det'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GoodsReceipt  $goodsReceipt
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->can('manage goods receipt')) {
            $gr = GoodsReceipt::find($id);
            $customers = Customer::where('created_by', \Auth::user()->creatorId())->get();
            if ($gr->created_by == \Auth::user()->creatorId()) {
                return view('goods_receipt.edit', compact('gr', 'customers'));
            } else {
                // return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoodsReceipt  $goodsReceipt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('manage goods receipt')) {
            $gr = GoodsReceipt::find($id);
            if ($gr->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'no_sp' => 'required',
                        'date_goodscome' => 'required',
                        'customers_id' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $gr->no_sp          = $request->no_sp;
                $gr->date_goodscome          = $request->date_goodscome;
                $gr->customers_id      = $request->customers_id;
                $gr->status      = $request->status;
                $gr->save();
                // if (!empty($request->status)) {
                //     PurchaseOrder::whereId($gr->po_id)->update(['status' => $request->status]);
                // }
                return redirect()->back()->with('success', __('Goods receipt successfully updated.'));
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
     * @param  \App\Models\GoodsReceipt  $goodsReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\Auth::user()->can('manage goods receipt')) {
            $gr = GoodsReceipt::find($id);
            if ($gr->created_by == \Auth::user()->creatorId()) {
                GoodsReceiptDetail::where('gr_id', $id)->delete();
                // PurchaseOrder::where('id', $gr->po_id)->update(['status' => 'Created']);
                $gr->delete();

                return redirect()->back()->with('success', __('Goods receipt successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function index_detail($id)
    {
        if (\Auth::user()->can('manage goods receipt')) {
            $gr = GoodsReceipt::find($id);
            if ($gr->created_by == \Auth::user()->creatorId()) {
                $datadetail = GoodsReceiptDetail::where('gr_id', $id)->get();
                return view('goods_receipt.detail_index', compact('gr', 'id', 'datadetail'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function edit_detail($id)
    {
        if (\Auth::user()->can('manage goods receipt')) {
            $gr_det = GoodsReceiptDetail::find($id);
            if ($gr_det->created_by == \Auth::user()->creatorId()) {

                return view('goods_receipt.detail_edit', compact('gr_det'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update_detail(Request $request, $id)
    {
        if (\Auth::user()->can('manage goods receipt')) {
            $gr_det = GoodsReceiptDetail::find($id);
            if ($gr_det->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'sku_number' => 'required',
                        'no_coil' => 'required',
                        'actual_thick' => 'required',
                        'goods_location' => 'required',
                        'qty' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $gr_det->sku_number = $request->sku_number;
                $gr_det->no_coil = $request->no_coil;
                $gr_det->actual_thick = $request->actual_thick;
                $gr_det->goods_location = $request->goods_location;
                $gr_det->qty = $request->qty;
                $gr_det->upload_certificate = $request->upload_certificate;
                $gr_det->code_certificate = $request->code_certificate;
                if (!empty($request->upload_certificate)) {
                    if ($gr_det->upload_certificate) {
                        $path = storage_path('uploads/goods_receipt_certificate' . $gr_det->upload_certificate);
                        if (file_exists($path)) {
                            \File::delete($path);
                        }
                    }
                    $fileName = time() . "_" . $request->upload_certificate->getClientOriginalName();
                    $gr_det->upload_certificate = $fileName;
                    $dir        = 'uploads/goods_receipt_certificate';
                    $path = Utility::upload_file($request, 'upload_certificate', $fileName, $dir, []);
                    if ($path['flag'] == 0) {
                        return redirect()->back()->with('error', __($path['msg']));
                    }
                }

                $gr_det->status      = $request->status;
                $gr_det->save();

                return redirect()->back()->with('success', __('Goods receipt successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy_detail($id)
    {
        if (\Auth::user()->can('manage goods receipt')) {
            $gr_det = GoodsReceiptDetail::find($id);
            if ($gr_det->created_by == \Auth::user()->creatorId()) {
                $gr_det->delete();

                return redirect()->back()->with('success', __('Goods receipt successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroyBulkDetail(Request $request)
    {
        if (!\Auth::user()->can('manage goods receipt')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $grDetails = GoodsReceiptDetail::whereIn('id', $request->id);

        if ($grDetails->where('created_by', '!=', \Auth::id())->count()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        GoodsReceiptDetail::whereIn('id', $request->id)->delete();

        return redirect()->back()->with('success', __('Goods receipt successfully deleted.'));
    }

    public function completeHeader($id)
    {
        if (!\Auth::user()->can('manage goods receipt')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $gr = GoodsReceipt::find($id);

        if ($gr->where('created_by', '!=', \Auth::id())->count()) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $gr = GoodsReceipt::find($id);
        $gr->status = 'Completed';
        $gr->save();

        GoodsReceiptDetail::where('gr_id', $id)
            ->update(['status' => 'Completed']);

        return redirect()->back()->with('success', __('Goods receipt successfully completed.'));
    }

    public function print($id)
    {
        $data_gr = GoodsReceipt::find($id);
        $datadetail_gr = GoodsReceiptDetail::where('gr_id', $id)->get();
        return view('goods_receipt.print_template.printview',['data_gr' => $data_gr, 'datadetail_gr'=> $datadetail_gr]);
    }
}
