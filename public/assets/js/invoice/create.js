$(document).ready(() => {


    $('form').submit(function (event) {
        event.preventDefault();

        if (!validate()) {
            let itemsToSend = [];
            let invoiceToSend = {};

            invoiceToSend.number = $('#number').text();
            invoiceToSend.date = $(this).find('input[name="date"]').val();
            invoiceToSend.tax = $(this).find('input[name="tax"]').val();
            invoiceToSend.tax_rate = $(this).find('input[name="tax_rate"]').val();
            invoiceToSend.total = $(this).find('input[name="total-due"]').val();
            invoiceToSend.subtotal = $(this).find('input[name="subtotal"]').val();
            invoiceToSend.customer_id = $(this).find('select[name="customer"]').val();
            invoiceToSend.city = $(this).find('input[name="city"]').val();
            invoiceToSend.state = $(this).find('input[name="state"]').val();
            invoiceToSend.zip_code = $(this).find('input[name="zip_code"]').val();
            invoiceToSend.country = $(this).find('select[name="country"]').val();
            invoiceToSend.street = $(this).find('input[name="street"]').val();
            $('table tbody tr').each(function () {
                let item = {};
                item.item_id = $(this).find('select[name="item"]').val();
                item.qty = $(this).find('input[name="qty"]').val();
                item.price = $(this).find('input[name="price"]').val();
                item.invoice_id = "";
                item.stock = getItemByID(item.item_id).stock;
                itemsToSend.push(item);
            });

            $.ajax({
                url: '/invoice',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {invoice: invoiceToSend, lineItems: itemsToSend},
                success: function (res) {
                    window.location.replace('/invoice');
                }
            })
        }else{
            $('button[type="submit"]').removeAttr('disabled');
        }
    })
});
