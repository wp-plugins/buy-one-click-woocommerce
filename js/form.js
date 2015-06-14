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
    //Доп сообщение

    jQuery('.popummessage .close_message, .overlay_message').click(function () {
        jQuery('.popummessage, .overlay_message').css({'opacity': '0', 'visibility': 'hidden'});

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
            var obj = JSON.parse(response);
            if (obj.num == "1") { //Действие по умолчанию
                jQuery(".buyButtonOkForm").after("<span>" + obj.result + "</span>");
            }
            if (obj.num == "2") { // Закрытие формы через action мил сек
                jQuery(".buyButtonOkForm").after("<span>" + obj.result + "</span>");
                jQuery('.popup, .overlay').fadeOut(obj.action);


            }
            if (obj.num == "3") { // Показать сообщение action
                jQuery('.popup, .overlay').hide();
                jQuery('.popummessage, .overlay_message').css('opacity', '1');
                jQuery('.popummessage, .overlay_message').css('visibility', 'visible');
                //alert("Готово");

            }
            if (obj.num == "4") { // Сделать редирект action
                jQuery(".buyButtonOkForm").after("<span>" + obj.result + "</span>");
                self.location = obj.action;
            }
            //alert(obj.num);

            //jQuery(".buyButtonOkForm").after("<span>" + obj.result + "</span>");

        }
    });

}


jQuery(document).ready(function () {

    jQuery('.buyButtonOkForm').click(function (e) {
        var allRequired;
        var errorSending = "no";
        jQuery(".b1c-form").find(".buyvalide").each(function () {
            if (jQuery(this).attr("required") != undefined) { // если хотя бы одно поле обязательно
                allRequired = "no";
                //alert("0");
            }

        });
        jQuery(".b1c-form").find(".buyvalide").each(function () {  // проверяем заполенность полей

            if (jQuery(this).val().length < 1) {

                if (allRequired == "no" && jQuery(this).attr("required") != undefined) {

                    errorSending = 1;
                }
                if (allRequired == 1) {

                    errorSending = 1;
                }
            }
        });

        if (errorSending === "no") {
            //alert("2");
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
        }

    });

});