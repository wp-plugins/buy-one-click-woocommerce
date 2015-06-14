<h3>Заказы через плагин <?php echo BuyCore::NAME_PLUGIN; ?></h3>
<p>Все заказы отправленные через кнопку "<?php
    if (isset(BuyCore::$buyoptions['namebutton'])) {
        echo BuyCore::$buyoptions['namebutton'];
    }
    ?>"</p>
<?php

?>
<input type="button" class="btn btn-default btn-sm removeallorder" value="Удалить историю"/>
<?php
$url_tab = add_query_arg(array('page' => BuyCore::URL_SUB_MENU, 'tab' => 'orders'), 'admin.php');
?>
<table class="table table-bordered table-hover table-condensed">
    <thead>
        <tr>
            <th>№ </th>
            <th>Дата и время добавления</th> 
            <th>Номер товара</th>
            <th>ФИО</th>
            <th>Телефон</th>
            <th>Email</th>
            <th>Название товара</th>
            <th>Цена</th>
            <th>Сообщение</th>
            <th>Товар</th>
            <th>СМС</th>
            <th>Статус</th>
            <th>Удалить</th>
        </tr>
    </thead>
    <tbody>
<?php foreach (BuyCore::$buyzakaz as $id => $zakaz) { ?>
            <tr class="success order<?php echo $id; ?>">
                <th><?php echo $id; ?></th>
                <th><?php echo $zakaz['time']; ?></th>
                <th><?php echo $zakaz['idtovar']; ?></th>
                <th><?php echo $zakaz['txtname']; ?></th>
                <th><?php echo $zakaz['txtphone']; ?></th>
                <th><?php echo $zakaz['txtemail']; ?></th>
                <th><?php echo $zakaz['nametovar']; ?></th>
                <th><?php echo $zakaz['pricetovar']; ?></th>
                <th><?php echo $zakaz['message']; ?></th>
                <th><?php echo $zakaz['linktovar']; ?></th>
                <th><?php echo 'id:'.$zakaz['smslog'][0].'</br>Кол.sms:'.$zakaz['smslog'][1].'</br>Стоимость:'.$zakaz['smslog'][2].'</br>Баланс:'.$zakaz['smslog'][3]; ?></th>
                <th><a orderstat="<?php
                    if ($zakaz['status'] == 2) {
                        echo '2';
                    } else {
                        echo '1';
                    }
                    ?>" class="updatestatus" id="<?php echo $id; ?>" href="<?php echo $url_tab . '#id=' . $id; ?>">
                        <?php
                        if ($zakaz['status'] == 1) {
                            echo '<span class="glyphicon glyphicon-ban-circle">НЕТ</span>';
                        } else {
                            echo '<span class="glyphicon glyphicon-ok-circle">ОК</span>';
                        }
                        ?>



                    </a></th>

                <th><?php echo '<a class="removeorder" id="' . $id . '" href="' . $url_tab . '#id=' . $id . '"><span class="glyphicon glyphicon-remove-circle"></span></a>'; ?></th>
            </tr>
<?php } ?>
    </tbody>



</table>