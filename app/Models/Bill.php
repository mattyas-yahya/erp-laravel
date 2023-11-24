<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'vender_id',
        'currency',
        'bill_date',
        'due_date',
        'bill_id',
        'order_number',
        'ref_invoice',
        'category_id',
        'created_by',
    ];

    public static $statues = [
        'Draft',
        'Sent',
        'Unpaid',
        'Partialy Paid',
        'Paid',
    ];

    public function vender()
    {
        return $this->hasOne('App\Models\Vender', 'id', 'vender_id');
    }

    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\BillProduct', 'bill_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\BillPayment', 'bill_id', 'id');
    }

    public function getSubTotal()
    {
        $subTotal = 0;
        $items = PurchaseOrderDetail::with([
                'productService',
                'productServiceUnit',
                'goodsReceiptDetail'
            ])
            ->where('po_id', $this->order_number)
            ->get();

        foreach($items as $item) {
            $quantityAmount = $item->productServiceUnit?->name === 'Kg' ? $item->weight : $item->qty;

            $subTotal += ($quantityAmount * $item->price);
        }

        return $subTotal;
    }

    public function getTotalTax()
    {
        $totalTax = 0;
        $items = PurchaseOrderDetail::with([
            'productService',
            'productServiceUnit',
            'goodsReceiptDetail'
        ])
        ->where('po_id', $this->order_number)
        ->get();

        foreach ($items as $item) {
            $quantityAmount = $item->productServiceUnit?->name === 'Kg' ? $item->weight : $item->qty;
            $taxPpn = $item->tax_ppn ? (0.11 * $item->price * $quantityAmount) : 0;
            $taxPph = $item->tax_pph ? (0.003 * $item->price * $quantityAmount) : 0;

            $totalTax += $taxPph + $taxPpn;
        }

        return $totalTax;
    }

    public function getTotalDiscount()
    {
        $totalDiscount = 0;
        $items = PurchaseOrderDetail::with([
            'productService',
            'productServiceUnit',
            'goodsReceiptDetail'
        ])
        ->where('po_id', $this->order_number)
        ->get();

        foreach($items as $item) {
            $totalDiscount += $item->discount ?? 0;
        }

        return $totalDiscount;
    }

    public function getTotal()
    {
        return ($this->getSubTotal() + $this->getTotalTax()) - $this->getTotalDiscount();
    }

    public function getPaid()
    {
        $paid = 0;
        foreach ($this->payments as $payment) {
            $paid += $payment->amount;
        }

        return $paid;
    }

    public function getDue()
    {
        $payments = 0;
        foreach($this->payments as $payment)
        {
            $payments += $payment->amount;
        }

        return ($this->getTotal() - $payments) - ($this->billTotalDebitNote());
    }

    public function category()
    {
        return $this->hasOne('App\Models\ProductServiceCategory', 'id', 'category_id');
    }

    public function debitNote()
    {
        return $this->hasMany('App\Models\DebitNote', 'bill', 'id');
    }

    public function billTotalDebitNote()
    {
        return $this->hasMany('App\Models\DebitNote', 'bill', 'id')->sum('amount');
    }

    public function lastPayments()
    {
        return $this->hasOne('App\Models\BillPayment', 'id', 'bill_id');
    }

    public function taxes()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax');
    }

    public function purchaseOrder()
    {
        return $this->hasOne('App\Models\PurchaseOrder', 'id', 'owner_number');
    }
}
