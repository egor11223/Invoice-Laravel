$(document).ready(() => {
    if($(window).width() >= 576) {
        let el = document.getElementById('list-items');
        let sortable = new Sortable(el, {
            onEnd: (event) => {
                $('tbody tr').each(function (index) {
                    $(this).find('th[scope="row"]').text(index + 1);
                });
            }
        });
    }

    let items = [];
    let row = $('#items tbody>tr:last').clone(true);

    window.getItemByID = function(id) {
        return items.find(elem => elem.id == id);
    }

    function recalculatedSubTotal() {
        let subTotal = 0;
        $('tbody tr').each(function () {
            let total = $(this).find('input[name="total"]').val();
            subTotal += parseFloat(total);
        });
        $('input[name="subtotal"]').val(subTotal.toFixed(2));
        $('input[name="subtotal"]').trigger('change');
        $('input[name="tax_rate"]').trigger('change');
    }

    function checkDuplicateItem(id) {
        let flag = false;
        let count = 0;
        document.querySelectorAll('table#items tbody td select[name="item"]').forEach(elem => {
            if (elem.value == id) {
                count++;
            }
            if (count > 1) {
                flag = true;
            }
        });

        return flag;
    }

    function getItemsHTML(excludedID = null) {
        let itemsHTML = getUnicalItems(excludedID).map(elem => {
            return `<option value="${elem.id}">${elem.name}</option>`;
        });

        return '<option value="" disabled selected>Select</option>>' + itemsHTML;
    }

    function getUnicalItems(excludedID = null) {
        let itemsCurrent = [];
        document.querySelectorAll('table#items tbody td select[name="item"]').forEach(elem => {
            if (elem.value) {
                itemsCurrent.push(parseInt(elem.value));
            }
        });
        return items.filter(elem => !itemsCurrent.includes(elem.id) && elem.id != excludedID);
    }

    function getCustomerByID(id, callback){
        $.get('/customerByID/'+id, (res) => {
            callback(res);
        });
    }

    $('input[name="date"]').val(new Date().toLocaleDateString("en-US"));

    $.get('/items', (res) => {
        items = JSON.parse(res);
    });

    $('body').on('click', '#add', () => {
        let lastRow = $('#items tbody>tr:last');

        if (lastRow.length > 0) {
            let lastNumber = lastRow.find('th').text();
            let newRow = lastRow.clone(false, false);
            newRow.find('input, select').val('').end();
            newRow.find('th').text((parseInt(lastNumber) + 1).toString()).end();
            newRow.find('select[name="item"]').html(getItemsHTML()).end();
            newRow.find('input[name="qty"]').val(0);
            newRow.find('input[name="price"]').val(0);
            newRow.find('input[name="total"]').val(0);
            newRow.css('display', 'none');
            newRow.insertAfter('#items tbody>tr:last').fadeIn(250);

            let countRow = $('#items tbody>tr').length;
            if(countRow === items.length) $('#add').prop('disabled', true);
        } else {
            let newRow = row.clone(true).find('select[name="item"]').append(getItemsHTML()).end();
            $('#items tbody').append(newRow);
        }
    });
    $('body').on('keyup', 'input[type="number"]', event => {
        if (event.target.value < 0) {
            event.target.value = 0;
        }
    });
    $('body').on('change', 'input[type="number"]', event => {
        if (event.target.value < 0) {
            event.target.value = 0;
        }
    });
    $('body').on('keyup change', 'input[name="qty"]', function (event) {
        let itemSelected = $(event.target).closest('tr').find('select[name="item"]');
        if(itemSelected.val()){
            let item = getItemByID(itemSelected.val());
            let qty = $(this).val();
            if(qty > item.stock){
                qty = $(this).val(0).val();
            }
            let price = $(event.target).parent().closest('tr').find('td > input.lineitem-price').val();
            let lineTotal = $(event.target)
                .parent()
                .closest('tr')
                .find('td > input[name="total"]');
            if(qty){
                lineTotal.val((price * qty).toFixed(2)).end();
                lineTotal.trigger('change');
            }
        }
    });

    $('body').on('change', 'select[name="customer"]', event => {
        getCustomerByID(event.target.value, function (elem) {
            $('input[name="street"]').val(elem.street);
            $('input[name="state"]').val(elem.state);
            $('select[name="country"]').val(elem.country);
            $('input[name="city"]').val(elem.city);
            $('input[name="zip_code"]').val(elem.zip_code);
        });
    });

    $('body').on('change', 'select[name="item"]',  function (event) {
        let itemsHTML = getItemsHTML(event.target.value);
        $('body table#items tbody tr select[name="item"]').not(this).each(function () {
            let curValue = $(this).val();
            if(curValue){
                let curHTML = $(this).find(':selected').html();
                $(this).html(itemsHTML+`<option value="${curValue}" selected>${curHTML}</option>`);
            }else{
                $(this).html(itemsHTML);
            }
        });
        let item = getItemByID(event.target.value);
        let line = $(this).parent().parent();
        line.find('input[name="price"]').val(item.price);
        $(this).parent().parent().find('input[name="qty"]').trigger('change');
    });


    $('body').on('click', 'button.delete-button', function(event){
        if($('tbody tr').length > 1){
            $(event.target).parent().parent().fadeOut(250, function () {
               $(this).remove();
                $('tbody tr').each(function (index) {
                    $(this).find('th[scope="row"]').text(index + 1);
                });
                recalculatedSubTotal();

                let itemsHTML = getItemsHTML();
                $('body table#items tbody tr select[name="item"]').each(function () {
                    let curValue = $(this).val();
                    if(curValue){
                        let curHTML = $(this).find(':selected').html();
                        $(this).html(itemsHTML+`<option value="${curValue}" selected>${curHTML}</option>`);
                    }else{
                        $(this).html(itemsHTML);
                    }
                });

                let countRow = $('#items tbody>tr').length;
                if(countRow < items.length) $('#add').prop('disabled', false);
            });

        }
    });

    $('body').on('change', 'input[name="total"]', function() {
        recalculatedSubTotal();
    });

    $('body').on('change', 'input[name="subtotal"]', () => {
        let tax = $('input[name="tax"]').val();
        let subTotal = $('input[name="subtotal"]').val();

        $('input[name="total-due"]').val((parseFloat(tax) + parseFloat(subTotal)).toFixed(2));
    })

    $('body').on('keyup change', 'input[name="tax_rate"]', (event) => {
        if (event.target.value > 99) {
            event.target.value = 0;
            $('input[name="tax"]').val(0);
        } else {
            let subTotal = $('input[name="subtotal"]').val();
            let taxTotal = (parseFloat(subTotal) * (event.target.value / 100)).toFixed(2);
            $('input[name="tax"]').val(taxTotal);
        }
        $('input[name="subtotal"]').trigger('change');
    });

    $('body').on('keyup', 'input[name="tax"]', function (event) {
        if (event.target.value) {
            let tax = parseFloat(event.target.value);
            let subtotal = parseFloat($('input[name="subtotal"]').val());

            if (tax >= subtotal) {
                event.target.value = 0;
                $('input[name="tax_rate"]').val(0);
                $('input[name="subtotal"]').trigger('change');
            } else {
                $('input[name="tax_rate"]').val((100 / (subtotal / tax)).toFixed(2));
                $('input[name="subtotal"]').trigger('change');
            }
        }
    });

    window.validate = function () {
        let customer = $('select[name="customer"]');
        let error = false;
        $('tbody tr input, tbody tr select, select[name="customer"]').removeClass('error');

        $('tbody tr').each(function () {
            let item = $(this).find('select[name="item"]');

            let qty = $(this).find('input[name="qty"]');
            if (!item.val()) {
                console.log('dsa')
                item.addClass('error');
                error = true;
            }
            if (!qty.val() || qty.val() == 0) {
                qty.addClass('error');
                error = true;
            }
        });

        if(!customer.val()){
            customer.addClass('error');
            error = true;
        }

        return error;
    }
});
