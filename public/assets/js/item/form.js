$(document).ready(() => {
    $('form').submit(function (event) {
        if(validateForm()){
            event.preventDefault();
            $('button[type="submit"]').removeAttr('disabled');
        }
    })
});
