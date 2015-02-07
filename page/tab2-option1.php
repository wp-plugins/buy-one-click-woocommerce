<h3>Настройка уведомлений для  <?php echo BuyCore::NAME_PLUGIN; ?></h3>
<p>Способы и настройки уведомлений для клиента</p>
<?php
$buynotification = get_option('buynotification');
?>

<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <table class="form-table">

        <tr valign="top">
            <th scope="row">Имя от кого</th>
            <td>
                <input type="text" name="buynotification[namemag]" value="<?php echo $buynotification['namemag']; ?>" />
                <span class="description">Например "<?php bloginfo('name'); ?>"</span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Email От кого</th>
            <td>
                <input type="text" name="buynotification[emailfrom]" value="<?php echo $buynotification['emailfrom']; ?>" />
                <span class="description">Например "izm@zixn.ru" </span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Копия на email</th>
            <td>
                <input type="text" name="buynotification[emailbbc]" value="<?php echo $buynotification['emailbbc']; ?>" />
                <span class="description">На этот email будут приходить копии сообщений о заказе. Через знак "," можно указывать несколько Email. Пример:
                    shop@mail.ru, jora@mail.ru, obama@google.com</span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">Опции по выбору</th>
            <td>
                <span class="description">Поставьте галочки напротив тех полей которые должны быть отправлены</span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">Информацию о заказе</th>
            <td>
                <input type="checkbox" name="buynotification[infozakaz_chek]" <?php checked($buynotification['infozakaz_chek'], 'on', 1); ?>/>
                <span class="description">Отправлять клиенту данные о заказе. Галочка стоит - отправлять!</span>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row">Произвольная информация</th>
            <td>
                <input type="checkbox" name="buynotification[dopiczakaz_chek]" <?php checked($buynotification['dopiczakaz_chek'], 'on', 1); ?>/>
                <span class="description">Отправлять дополнительные данные. Вы можете указать произвольный текст.</span>
            </td>
        </tr>


        <tr valign="top">
            <th scope="row">Произвольная информация</th>
            <td>
                <textarea cols="100" rows="10" name="buynotification[dopiczakaz]"><?php echo $buynotification['dopiczakaz']; ?></textarea>
                <span class="description">Произвольная информация, например контакты или пожелание. Есть возможность указывать HTML тэги</span>
            </td>
        </tr>

    </table>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="buynotification" />
    <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>