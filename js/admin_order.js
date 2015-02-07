
jQuery(document).ready(function () {
//Удалить элемент таблицы заказов
    jQuery('.removeorder').click(function () {

        var id = jQuery(this).attr('id');
        jQuery(".order" + id).hide("slow");
        jQuery.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            async: false,
            data: {
                action: 'removeorder',
                text: id
            }
        });
        //alert(id);


    });

    //Обновление статус
    jQuery('.updatestatus').click(function () {
        var id = jQuery(this).attr('id');
        var statusold = jQuery(this).attr('orderstat');
        //alert(statusold);
        if (statusold === "1") {
            var status = '2'
            jQuery(this).attr('2');
            jQuery(this).html('<span class="glyphicon glyphicon-ok-circle">ОК</span>');
            
            
        } else {
            var status = '1'
            jQuery(this).html('<span class="glyphicon glyphicon-ban-circle">НЕТ</span>');
                        
        }
        var info = {
            id: id,
            status: status
        };
        jQuery.ajax({
            type: "POST",
            url: '/wp-admin/admin-ajax.php',
            async: false,
            data: {
                action: 'updatestatus',
                text: info
            }

        });
        
    });


});

