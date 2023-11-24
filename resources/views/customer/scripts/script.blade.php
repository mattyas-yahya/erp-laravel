<script>
    $(document).on('click', '#billing_data', function() {
        if ($("[name='shipping_name[]']").length > 0) {
            $("[name='shipping_name[]']").first().val($("[name='billing_name']").val());
            $("[name='shipping_country[]']").first().val($("[name='billing_country']").val());
            $("[name='shipping_state[]']").first().val($("[name='billing_state']").val());
            $("[name='shipping_city[]']").first().val($("[name='billing_city']").val());
            $("[name='shipping_phone[]']").first().val($("[name='billing_phone']").val());
            $("[name='shipping_zip[]']").first().val($("[name='billing_zip']").val());
            $("[name='shipping_address[]']").first().val($("[name='billing_address']").val());
        }
    })

    $(document).on('click', '#add-shipping-data', function() {
        $('.shipping-address-data').append($('#shipping-address-template').html());
    })

    $(document).on('click', '#delete-shipping-data', function() {
        $('.shipping-address-form').last().remove();
    })

    $(document).on('show.bs.modal','#commonModal', function () {
        let mode = $('#commonModal .modal-body').data('mode');

        if (mode === 'create') {
            $('.shipping-address-data').append($('#shipping-address-template').html());
        }
    })
</script>
