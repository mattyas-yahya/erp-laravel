<?php

namespace App\Exports;

use App\Models\GoodsReceiptDetail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MarketingStockExport implements FromCollection,WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = GoodsReceiptDetail::select('product_name','dimensions','date_goodscome','sku_number','goods_location','no_coil',
        'goods_receipt_details.no_kontrak AS no_kontrak_detail',
        'manufacture','actual_thick','qty','weight','claim_note','remarks');
        $data->leftjoin('goods_receipts', 'goods_receipt_details.gr_id', '=', 'goods_receipts.id');
        $data = $data->get();
        $now = Carbon::now();
        foreach ($data as $key => $item) {
            // unset($item->);
            $data[$key]["date_goodscome"] = Carbon::parse($item->date_goodscome)->diffInDays($now);
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            __('SPEC'),
            __('Dimensions'),
            __('Age'),
            __('ID SJB'),
            __('Location'),
            __('No. Coil'),
            __('No. Kontrak'),
            __('Mill'),
            __('Actual Thick'),
            __('Sum of Pcs'),
            __('Sum of Kg Mill'),
            "Keterangan Klaim",
            "Remarks"

        ];
    }
}
