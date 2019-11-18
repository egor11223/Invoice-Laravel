$(document).ready(() => {
    let cleave = new Cleave('input[name="phone"]', {
        phone: true,
        phoneRegionCode: 'US'
    });

    $('#select-country').change(function(){
        cleave.setPhoneRegionCode(this.value);
        cleave.setRawValue('');
    });

    $('form').submit(function (event) {
        if(validateForm()){
            event.preventDefault();
            $('button[type="submit"]').removeAttr('disabled');
        }
    })

});
