@push('script-page')
    <script>
        var salesOrderApiUrl = '{{ route('json.sales-order') }}';

        $(document).ready(function() {
            var salesOrderId = $('#sales_order_id').val();

            if (!salesOrderId) {
                return;
            }

            var customerId = $('#customer').val();
            var url = $('#customer').data('url');

            $('#customer_detail').removeClass('d-none');
            $('#customer_detail').addClass('d-block');
            $('#customer-box').removeClass('d-block');
            $('#customer-box').addClass('d-none');

            const template = document.querySelector('.spinner-template');
            const clone = template.content.cloneNode(true);
            $('#customer_detail').html(clone);

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'id': customerId
                },
                cache: false,
                success: function(data) {
                    if (data != '') {
                        $('#customer_detail').html(data);
                    } else {
                        $('#customer-box').removeClass('d-none');
                        $('#customer-box').addClass('d-block');
                        $('#customer_detail').removeClass('d-block');
                        $('#customer_detail').addClass('d-none');
                    }
                },
            });

            $('.sales-order-details').empty();

            $.ajax({
                url: `${salesOrderApiUrl}/${salesOrderId}/details`,
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

        $(document).on('change', '#customer', function() {
            $('#customer_detail').removeClass('d-none');
            $('#customer_detail').addClass('d-block');
            $('#customer-box').removeClass('d-block');
            $('#customer-box').addClass('d-none');

            var customerId = $(this).val();
            var url = $(this).data('url');

            const template = document.querySelector('.spinner-template');
            const clone = template.content.cloneNode(true);
            $('#customer_detail').html(clone);

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'id': customerId
                },
                cache: false,
                success: function(data) {
                    if (data != '') {
                        $('#customer_detail').html(data);
                    } else {
                        $('#customer-box').removeClass('d-none');
                        $('#customer-box').addClass('d-block');
                        $('#customer_detail').removeClass('d-block');
                        $('#customer_detail').addClass('d-none');
                    }
                },
            });

            $.ajax({
                url: salesOrderApiUrl,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'customer_id': customerId
                },
                cache: false,
                success: function(data) {
                    $('.sales-order-select').empty();
                    let options = `<select class="form-control select2" name="sales_order_id" id="sales_order_id"></select>`;
                    $('.sales-order-select').html(options);

                    $('#sales_order_id').append('<option value=""></option>');
                    data.forEach(item => {
                        $('#sales_order_id').append('<option value="' + item.id + '">' + item.so_number +
                                '</option>');
                    });

                    new Choices('#sales_order_id', {
                        removeItemButton: true,
                    });
                },
            });
        });

        $(document).on('click', '#remove', function() {
            $('#customer-box').removeClass('d-none');
            $('#customer-box').addClass('d-block');
            $('#customer_detail').removeClass('d-block');
            $('#customer_detail').addClass('d-none');

            $('#customer').val(null).change();

            $('.sales-order-select').empty();
            let options = `<select class="form-control select2" name="sales_order_id" id="sales_order_id"></select>`;
            $('.sales-order-select').html(options);
            $('#sales_order_id').append('<option value=""></option>');

            new Choices('#sales_order_id', {
                removeItemButton: true,
            });

            $('.sales-order-details').empty();
        });

        $(document).on('change', '#sales_order_id', function() {
            var salesOrderId = $(this).val();

            if (!salesOrderId) {
                return;
            }

            $('.sales-order-details').empty();

            const template = document.querySelector('.spinner-template');
            const clone = template.content.cloneNode(true);
            $('.sales-order-details').html('<tr><td colspan="8" class="text-center"></td></tr>');
            $('.sales-order-details td').html(clone);

            $.ajax({
                url: `${salesOrderApiUrl}/${salesOrderId}/details`,
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

            $('.sales-order-details').empty();

            data.forEach(item => {
                const tbody = document.querySelector('.sales-order-details');
                const template = document.querySelector('.sales-order-details-items');
                const clone = template.content.cloneNode(true);
                let tr = clone.querySelectorAll('tr');

                tr[0].querySelector('.sales-order-number').textContent = item.so_number
                tr[0].querySelector('.sku-number').textContent = item?.gr_from_so?.sku_number
                tr[0].querySelector('.coil-number').textContent = item.no_coil ?? ''
                tr[0].querySelector('.product-name').textContent = item?.gr_from_so?.product_name
                tr[0].querySelector('.dimensions').textContent = item?.gr_from_so?.dimensions
                tr[0].querySelector('.unit').textContent = item.gr_from_so?.product_service_unit?.name
                tr[0].querySelector('.weight').textContent = item?.gr_from_so?.weight ?? 0
                tr[0].querySelector('.quantity').textContent = item.qty ?? 0
                tr[0].querySelector('.production').textContent = item.production ?? ''

                let quantityAmount = item.gr_from_so?.product_service_unit?.name === 'Kg' ? item.gr_from_so.weight : item.qty;
                let taxPpn = item.tax_ppn ? (0.11 * (item.sale_price * quantityAmount)) : 0;
                let taxPph = item.tax_pph ? (0.003 * (item.sale_price * quantityAmount)) : 0;

                tr[0].querySelector('.tax-ppn').innerHTML = item.tax_ppn ? '<span class="badge bg-primary mt-1 mr-2">PPN 11%</span>' : '-';
                tr[0].querySelector('.tax-pph').innerHTML = item.tax_pph ? '<span class="badge bg-primary mt-1 mr-2">PPh 0.3%</span>' : '-';

                tr[0].querySelector('.discount').textContent = `Rp ${parseFloat(item.discount ?? 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`
                tr[0].querySelector('.price').textContent = `Rp ${parseFloat(item.sale_price ?? 0).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`

                tr[0].querySelector('.total').textContent = `Rp ${parseFloat(quantityAmount * item.sale_price).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

                tr[1].querySelector('.description').textContent = item.description

                subTotals.subTotal += parseFloat(quantityAmount * item.sale_price);
                subTotals.discountSubTotal += parseFloat(item.discount ?? 0);
                subTotals.taxSubTotal += parseFloat(taxPph + taxPpn);

                tbody.appendChild(clone);
            });

            const tfoot = document.querySelector('.sales-order-details-summary');
            tfoot.querySelector('.sub-total').textContent = `Rp ${parseFloat(subTotals.subTotal).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            tfoot.querySelector('.total-discount').textContent = `Rp ${parseFloat(subTotals.discountSubTotal).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            tfoot.querySelector('.total-tax').textContent = `Rp ${parseFloat(subTotals.taxSubTotal).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            tfoot.querySelector('.total-amount').textContent = `Rp ${parseFloat(subTotals.subTotal + subTotals.taxSubTotal - subTotals.discountSubTotal).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        }
    </script>
@endpush
