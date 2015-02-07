//(function (jQuery, undefinde) {

jQuery(document).ready(function () {
    jQuery('.popup .close_order, .overlay').click(function () {
        jQuery('.popup, .overlay').css({'opacity': '0', 'visibility': 'hidden'});
        jQuery('#contactform input:checkbox').removeAttr("checked");
        jQuery('#contactform input[type=hidden].valTrFal').val('valTrFal_disabled');
    });
    jQuery('a.clickBuyButton').click(function (e) {
        jQuery('.popup, .overlay').css('opacity', '1');
        jQuery('.popup, .overlay').css('visibility', 'visible');
        e.preventDefault();
    });
    jQuery(function () {
        jQuery('#contactform input:checkbox').change(function () {
            if (jQuery(this).is(':checked')) {
                jQuery('#contactform input[type=hidden].valTrFal').val('valTrFal_true');
            }
            else {
              
                jQuery('#contactform input[type=hidden].valTrFal').val('valTrFal_disabled');
            }
        });
    });
});
//Обработка клика по кнопке
// Для формы - отправка в ajax class
function saveButton(text, url) {
    jQuery.ajax({
        type: "POST",
        url: url,
        async: false,
        data: {
            action: 'buybuttonform',
            text: text
        },
        success: function (response) {
            jQuery(".buyButtonOkForm").after("<span>" + response + "</span>");
            
        }
    });

}


jQuery(document).ready(function () {

    jQuery('.buyButtonOkForm').click(function (e) {
        var txtname = jQuery("input[name='txtname']").val();
        var txtphone = jQuery("input[name='txtphone']").val();
        var txtemail = jQuery("input[name='txtemail']").val();
        var message = jQuery(".buymessage").val();
        var buy_nametovar = jQuery("input[name='buy_nametovar']").val();
        var buy_pricetovar = jQuery("input[name='buy_pricetovar']").val();
        var buy_idtovar = jQuery("input[name='buy_idtovar']").val();




        var infozakaz = {
            txtname: txtname,
            txtphone: txtphone,
            txtemail: txtemail,
            message: message,
            nametovar: buy_nametovar,
            pricetovar: buy_pricetovar,
            idtovar: buy_idtovar
        };
       
        saveButton(infozakaz, '/wp-admin/admin-ajax.php');
        e.preventDefault();
    });


});
