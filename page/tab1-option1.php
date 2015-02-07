<h3>Общие настройки дополнения <?php echo BuyCore::NAME_PLUGIN; ?></h3>
<p>Не забывайте нажимать кнопку сохранить после изменения настроек в каждой вкладке.</p>
<?php
$buyoptions = get_option('buyoptions'); //Массив настроек
?>

<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <table class="form-table">

        <tr valign="top">
            <th scope="row">Название кнопки на сайте</th>
            <td>
                <input type="text" name="buyoptions[namebutton]" value="<?php echo $buyoptions['namebutton']; ?>" />
                <span class="description">Наппример "Купить в один клик"</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Положение кнопки</th>
            <td>

                <select name="buyoptions[positionbutton]">
                    <option value="woocommerce_simple_add_to_cart" <?php selected($buyoptions['positionbutton'], 'woocommerce_simple_add_to_cart', true); ?>>Над кнопкой количества</option>
                    <option value="woocommerce_product_description_heading" <?php selected($buyoptions['positionbutton'], 'woocommerce_product_description_heading', true); ?>>В вкладке описания товара</option>
                    <option value="woocommerce_before_single_product" <?php selected($buyoptions['positionbutton'], 'woocommerce_before_single_product', true); ?>>Над изображением товара</option>
                    <option value="woocommerce_before_single_product_summary" <?php selected($buyoptions['positionbutton'], 'woocommerce_before_single_product_summary', true); ?>>Над полной информацией о товаре</option>
                    <option value="woocommerce_after_single_product_summary" <?php selected($buyoptions['positionbutton'], 'woocommerce_after_single_product_summary', true); ?>>Под полной информацией о товаре</option>

                </select>
                <span class="description">Место где будет распологаться кнопка в карточке товара</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Какую информацию запрашивать в форме у покупателя </th>
            <td>
                <span class="description">Поставьте галочки напротив тех полей которые должны быть отображены для покупателя в форме заказа</span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">Показывать информацию о товаре?</th>
            <td>
                <input type="checkbox" name="buyoptions[infotovar_chek]" <?php checked($buyoptions['infotovar_chek'], 'on', 1); ?>/>
                <span class="description">Будет или не будет отображаться информация о товаре в модальном окне? Галочка стоит - будет отображаться</span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">Спрашивать ФИО</th>
            <td>
                <input type="checkbox" name="buyoptions[fio_chek]" <?php checked($buyoptions['fio_chek'], 'on', 1); ?>/>
                <span class="description">Предлагать ли покупателю вводить своё имя?Галочка стоит - предлагать</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Спрашивать телефон</th>
            <td>
                <input type="checkbox" name="buyoptions[fon_chek]" <?php checked($buyoptions['fon_chek'], 'on', 1); ?>/>
                <span class="description">Предлагать ли покупателю вводить свой телефон? Галочка стоит - предлагать</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Спрашивать Email</th>
            <td>
                <input type="checkbox" name="buyoptions[email_chek]" <?php checked($buyoptions['email_chek'], 'on', 1); ?>/>
                <span class="description">Предлагать ли покупателю вводить свой email? Галочка стоит - предлагать</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Поле доп.информации</th>
            <td>
                <input type="checkbox" name="buyoptions[dopik_chek]" <?php checked($buyoptions['dopik_chek'], 'on', 1); ?>/>
                <span class="description">Предлагать ли покупателю ввод дополнительной информации? Галочка стоит - предлагать</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Описания полей </th>
            <td>
                <span class="description">Описание активных полей в форме "быстрого заказа", показывать или не показывать поле — определяется настройками выше</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Поле ФИО</th>
            <td>
                <input type="text" name="buyoptions[fio_descript]" value="<?php echo $buyoptions['fio_descript']; ?>" />
                <span class="description">Например "Ваше имя?"</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Поле телефон</th>
            <td>
                <input type="text" name="buyoptions[fon_descript]" value="<?php echo $buyoptions['fon_descript']; ?>" />
                <span class="description">Например "Ваш телефон?"</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Поле email</th>
            <td>
                <input type="text" name="buyoptions[email_descript]" value="<?php echo $buyoptions['email_descript']; ?>" />
                <span class="description">Например "Ваш email?"</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Поле "Дополнительно"</th>
            <td>
                <input type="text" name="buyoptions[dopik_descript]" value="<?php echo $buyoptions['dopik_descript']; ?>" />
                <span class="description">Например "Адрес доставки"</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Имя кнопки в форме</th>
            <td>
                <input type="text" name="buyoptions[butform_descript]" value="<?php echo $buyoptions['butform_descript']; ?>" />
                <span class="description">Например "Заказать"</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Сообщение в форме</th>
            <td>
                <input type="text" name="buyoptions[success]" value="<?php echo $buyoptions['success']; ?>" />
                <span class="description">Сообщение об успешном оформление заказа. Например: "Спасибо за заказ!". Сообщение появляется в форме заказа «В один клик», после того как пользователь нажал кнопку подтверждения заказа. Сообщение должно быть коротким.</span>
            </td>
        </tr>
    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="buyoptions" />
    <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
<a class="clickBuyButton" href="<?php echo admin_url('admin.php?page=buyone&testform'); ?>">Посмотреть форму</a>

<?php
BuyFunction::viewBuyForm();

?>