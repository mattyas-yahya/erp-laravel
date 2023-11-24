<tfoot class="purchase-order-details-summary">
    <tr>
        <td colspan="11"></td>
        <td><strong>{{ __('Sub Total') }} ({{ \Auth::user()->currencySymbol() }})</strong>
        </td>
        <td class="text-end sub-total">0.00</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="11"></td>
        <td><strong>{{ __('Discount') }} ({{ \Auth::user()->currencySymbol() }})</strong></td>
        <td class="text-end total-discount">0.00</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="11"></td>
        <td><strong>{{ __('Tax') }} ({{ \Auth::user()->currencySymbol() }})</strong></td>
        <td class="text-end total-tax">0.00</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="11"></td>
        <td class="blue-text"><strong>{{ __('Total Amount') }}
                ({{ \Auth::user()->currencySymbol() }})</strong></td>
        <td class="blue-text text-end total-amount"></td>
        <td></td>
    </tr>
</tfoot>
