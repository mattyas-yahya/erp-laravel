<?php

namespace App\Exports;

use App\Models\PurchaseOrderDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseApprovalExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // protected $approval;
    // function __construct($approval)
    // {
    //     $this->approval = $approval;
    // }
    public function collection()
    {
        $data = PurchaseOrderDetail::select('po_number','purchase_requests.pr_number','sku','product_name','qty','product_service_units.name as unit',
        'purchase_order_details.description','purchase_order_details.price',
        DB::raw('(purchase_order_details.qty * purchase_order_details.price) AS sub_total'),'purchase_order_details.approval');
        // $data->where('approval',$this->approval);
        $data->leftjoin('purchase_requests', 'purchase_order_details.pr_id', '=', 'purchase_requests.id');
        $data->leftjoin('product_services', 'purchase_order_details.product_services_id', '=', 'product_services.id');
        $data->leftjoin('product_service_units', 'purchase_order_details.unit_id', '=', 'product_service_units.id');
        $data = $data->get();
        foreach ($data as $key => $item) {
            // unset($item->);
            $data[$key]["po_number"]            = $item->po_number;
            $data[$key]["pr_number"]            = $item->pr_number;
            $data[$key]["price"]     = \Auth::user()->priceFormat($item->price);
            $data[$key]["sub_total"]     = \Auth::user()->priceFormat($item->sub_total);
        }
        return $data;
    }
    public function headings(): array
    {
        return [
            "PO_Number",
            "PR_Number",
            "SKU",
            "SPEC",
            "Quantity",
            "Satuan",
            "Deskripsi",
            "Harga",
            "Sub_Total",
            "Approval",
        ];
    }
}
