<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'issue_date',
        'due_date',
        'ref_number',
        'status',
        'category_id',
        'note',
        'delivery_order_number',
        'faktur_penjualan_number',
        'created_by',
    ];

    public static $statues = [
        'Draft',
        'Sent',
        'Unpaid',
        'Partialy Paid',
        'Paid',
    ];

    // TODO: unused
    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id');
    }

    public function salesOrder()
    {
        return $this->hasOne('App\Models\SalesOrder', 'id', 'ref_number');
    }

    public function items()
    {
        return $this->hasMany('App\Models\InvoiceProduct', 'invoice_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\InvoicePayment', 'invoice_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function getSubTotal()
    {
        $subTotal = 0;
        $items = SalesOrderDetail::with('gr_from_so.productServiceUnit')
            ->where('so_id', $this->ref_number)
            ->get();

        foreach ($items as $item) {
            $quantityAmount = $item?->gr_from_so?->productServiceUnit->name === 'Kg' ? $item?->gr_from_so?->weight : $item->qty;

            $subTotal += ($quantityAmount * $item->sale_price);
        }

        return $subTotal;
    }

    public function getTotalPpnTax()
    {
        $totalTax = 0;
        $items = SalesOrderDetail::with('gr_from_so.productServiceUnit')
            ->where('so_id', $this->ref_number)
            ->get();

        foreach ($items as $item) {
            $quantityAmount = $item?->gr_from_so?->productServiceUnit->name === 'Kg' ? $item?->gr_from_so?->weight : $item->qty;
            $taxPpn = $item->tax_ppn ? (0.11 * $item->sale_price * $quantityAmount) : 0;

            $totalTax += $taxPpn;
        }

        return $totalTax;
    }

    public function getTotalPphTax()
    {
        $totalTax = 0;
        $items = SalesOrderDetail::with('gr_from_so.productServiceUnit')
            ->where('so_id', $this->ref_number)
            ->get();

        foreach ($items as $item) {
            $quantityAmount = $item?->gr_from_so?->productServiceUnit->name === 'Kg' ? $item?->gr_from_so?->weight : $item->qty;
            $taxPph = $item->tax_pph ? (0.003 * $item->sale_price * $quantityAmount) : 0;

            $totalTax += $taxPph;
        }

        return $totalTax;
    }

    public function getTotalTax()
    {
        $totalTax = 0;
        $items = SalesOrderDetail::with('gr_from_so.productServiceUnit')
            ->where('so_id', $this->ref_number)
            ->get();

        foreach ($items as $item) {
            $quantityAmount = $item?->gr_from_so?->productServiceUnit->name === 'Kg' ? $item?->gr_from_so?->weight : $item->qty;
            $taxPpn = $item->tax_ppn ? (0.11 * $item->sale_price * $quantityAmount) : 0;
            $taxPph = $item->tax_pph ? (0.003 * $item->sale_price * $quantityAmount) : 0;

            $totalTax += $taxPph + $taxPpn;
        }

        return $totalTax;
    }

    public function getTotalDiscount()
    {
        $totalDiscount = 0;
        $items = SalesOrderDetail::with('gr_from_so.productServiceUnit')
            ->where('so_id', $this->ref_number)
            ->get();

        foreach ($items as $item) {
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
        foreach ($this->payments as $payment) {
            $payments += $payment->amount;
        }

        return ($this->getTotal() - $payments) - ($this->invoiceTotalCreditNote());
    }

    public static function change_status($invoice_id, $status)
    {

        $invoice         = Invoice::find($invoice_id);
        $invoice->status = $status;
        $invoice->update();
    }

    public function category()
    {
        return $this->hasOne('App\Models\ProductServiceCategory', 'id', 'category_id');
    }

    public function creditNote()
    {

        return $this->hasMany('App\Models\CreditNote', 'invoice', 'id');
    }

    public function invoiceTotalCreditNote()
    {
        return $this->hasMany('App\Models\CreditNote', 'invoice', 'id')->sum('amount');
    }

    public function lastPayments()
    {
        return $this->hasOne('App\Models\InvoicePayment', 'id', 'invoice_id');
    }

    public function taxes()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax');
    }
}
