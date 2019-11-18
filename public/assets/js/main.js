$(document).ready(() => {
    window.validateForm = function () {
        let error = false;

        $('input').each(function () {
            let label = $(this).closest('.form-group').find('label');
            console.log(label.html());
            if (label.hasClass('required')) {
                $(this).removeClass('error');
                if (!$(this).val()) {
                    $(this).addClass('error');
                    error = true;
                }
            }
        })

        return error;
    }


    let deleteModal = $('#deleteModal form');
    let actionDelete = deleteModal.attr('action');

    $('form').on('submit', () => {
        $('button[type="submit"]').prop('disabled', true);
    });
    $('body').on('click', '.delete-button', function () {
        let id = $(this).data('id');
        let attr = actionDelete + '/' + id;
        deleteModal.attr('action', attr);
    });
    $('.alert').fadeIn().delay(5000).fadeOut();

    $('tr.line-item > td').on('click', function () {
        if($(this).find('button').length === 0){
            $('tr.accordion').not($(this).parent().next()).fadeOut(200);
            $(this).parent().next().fadeToggle(250, function () {
                $(this)[0].scrollIntoView({
                    behavior: 'smooth'
                });
            });
        }
    });
});
