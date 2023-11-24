@push('script-page')
    <script>
        var purchaseOrderApiUrl = '{{ route('json.purchase-order') }}';

        $(document).on('change', '#vender', function() {
            $('#vender_detail').removeClass('d-none');
            $('#vender_detail').addClass('d-block');
            $('#vender-box').removeClass('d-block');
            $('#vender-box').addClass('d-none');

            var venderId = $(this).val();
            var url = $(this).data('url');

            const template = document.querySelector('.spinner-template');
            const clone = template.content.cloneNode(true);
            $('#vender_detail').html(clone);

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'id': venderId
                },
                cache: false,
                success: function(data) {
                    if (data != '') {
                        $('#vender_detail').html(data);
                    } else {
                        $('#vender-box').removeClass('d-none');
                        $('#vender-box').addClass('d-block');
                        $('#vender_detail').removeClass('d-block');
                        $('#vender_detail').addClass('d-none');
                    }
                },
            });

            $.ajax({
                url: purchaseOrderApiUrl,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'vender_id': venderId
                },
                cache: false,
                success: function(data) {
                    $('.purchase-order-select').empty();
                    let options =
                        `<select class="form-control select2" name="purchase_order_id" id="purchase_order_id"></select>`;
                    $('.purchase-order-select').html(options);

                    $('#purchase_order_id').append('<option value=""></option>');
                    data.forEach(item => {
                        $('#purchase_order_id').append('<option value="' + item.id + '">' + item
                            .po_number +
                            '</option>');
                    });

                    new Choices('#purchase_order_id', {
                        removeItemButton: true,
                    });
                },
            });
        });

        $(document).on('click', '#remove', function() {
            $('#vender-box').removeClass('d-none');
            $('#vender-box').addClass('d-block');
            $('#vender_detail').removeClass('d-block');
            $('#vender_detail').addClass('d-none');

            $('#vender').val(null).change();

            $('.purchase-order-select').empty();
            let options =
                `<select class="form-control select2" name="purchase_order_id" id="purchase_order_id"></select>`;
            $('.purchase-order-select').html(options);
            $('#purchase_order_id').append('<option value=""></option>');

            new Choices('#purchase_order_id', {
                removeItemButton: true,
            });

            $('.purchase-order-details').empty();
        });

        $(document).on('change', '#purchase_order_id', function() {
            var purchaseOrderId = $(this).val();

            if (!purchaseOrderId) {
                return;
            }

            $('.purchase-order-details').empty();

            const template = document.querySelector('.spinner-template');
            const clone = template.content.cloneNode(true);
            $('.purchase-order-details').html('<tr><td colspan="8" class="text-center"></td></tr>');
            $('.purchase-order-details td').html(clone);

            $.ajax({
                url: `${purchaseOrderApiUrl}/${purchaseOrderId}/details`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                cache: false,
                success: function(data) {
                    setDetails(data);
                },
            });
        });

        function setDetails(data) {
            let subTotals = {
                subTotal: 0,
                discountSubTotal: 0,
                taxSubTotal: 0,
            }

            $('.purchase-order-details').empty();

            data.forEach(item => {
                const tbody = document.querySelector('.purchase-order-details');
                const template = document.querySelector('.purchase-order-details-items');
                const clone = template.content.cloneNode(true);
                let tr = clone.querySelectorAll('tr');

                tr[0].querySelector('.purchase-order-number').textContent = item.po_number
                tr[0].querySelector('.contract-number').textContent = item.no_kontrak
                tr[0].querySelector('.product-name').textContent = item.product_name
                tr[0].querySelector('.dimensions').textContent = item.dimensions
                tr[0].querySelector('.unit').textContent = item?.product_service_unit?.name
                tr[0].querySelector('.weight').textContent = item.weight
                tr[0].querySelector('.quantity').textContent = item.qty ?? 0

                let quantityAmount = item.product_service_unit.name === 'Kg' ? item.weight : item.qty;
                let taxPpn = item.tax_ppn ? (0.11 * (item.price * quantityAmount)) : 0;
                let taxPph = item.tax_pph ? (0.003 * (item.price * quantityAmount)) : 0;

                tr[0].querySelector('.tax-ppn').innerHTML = item.tax_ppn ?
                    '<span class="badge bg-primary mt-1 mr-2">PPN 11%</span>' : '-';
                tr[0].querySelector('.tax-pph').innerHTML = item.tax_pph ?
                    '<span class="badge bg-primary mt-1 mr-2">PPh 0.3%</span>' : '-';

                tr[0].querySelector('.discount').textContent =
                    `Rp ${parseFloat(item.discount ?? 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`
                tr[0].querySelector('.price').textContent =
                    `Rp ${parseFloat(item.price ?? 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`
                tr[0].querySelector('.total').textContent =
                    `Rp ${parseFloat(quantityAmount * item.price).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

                tr[0].querySelector('.pph-amount').textContent =
                    `Rp ${parseFloat(taxPph ?? 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`
                tr[0].querySelector('.ppn-amount').textContent =
                    `Rp ${parseFloat(taxPpn ?? 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`
                tr[0].querySelector('.price-include').textContent =
                    `Rp ${parseFloat(item?.goods_receipt_detail?.price_include ?? 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`

                tr[1].querySelector('.description').textContent = item.description

                subTotals.subTotal += parseFloat(quantityAmount * item.price);
                subTotals.discountSubTotal += parseFloat(item.discount ?? 0);
                subTotals.taxSubTotal += parseFloat(taxPph + taxPpn);

                tbody.appendChild(clone);
            });

            const tfoot = document.querySelector('.purchase-order-details-summary');
            tfoot.querySelector('.sub-total').textContent =
                `Rp ${parseFloat(subTotals.subTotal).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            tfoot.querySelector('.total-discount').textContent =
                `Rp ${parseFloat(subTotals.discountSubTotal).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            tfoot.querySelector('.total-tax').textContent =
                `Rp ${parseFloat(subTotals.taxSubTotal).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            tfoot.querySelector('.total-amount').textContent =
                `Rp ${parseFloat(subTotals.subTotal + subTotals.taxSubTotal - subTotals.discountSubTotal).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        }

        var vendorId = '{{ $vendorId }}';
        if (vendorId > 0) {
            $('#vender').val(vendorId).change();
        }
    </script>
@endpush
