<h3>Настройка уведомлений для  <?php echo BuyCore::NAME_PLUGIN; ?></h3>
<p>Способы и настройки уведомлений для клиента</p>
<?php
$buynotification = get_option('buynotification');
$buysmscoptions = get_option('buysmscoptions'); //настройки смсц
?>

<form method="post" action="options.php">
    <fieldset>
        <legend>Настройка E-mail уведомлений</legend>
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">

            <tr valign="top">
                <th scope="row">Имя от кого</th>
                <td>
                    <input type="text" name="buynotification[namemag]" value="<?php
                    if (isset($buynotification['namemag'])) {
                        echo $buynotification['namemag'];
                    }
                    ?>" />
                    <span class="description">Например "<?php bloginfo('name'); ?>"</span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Email От кого</th>
                <td>
                    <input type="text" name="buynotification[emailfrom]" value="<?php
                    if (isset($buynotification['emailfrom'])) {
                        echo $buynotification['emailfrom'];
                    }
                    ?>" />
                    <span class="description">Например "izm@zixn.ru" </span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Копия на email</th>
                <td>
                    <input type="text" name="buynotification[emailbbc]" value="<?php
                    if (isset($buynotification['emailbbc'])) {
                        echo $buynotification['emailbbc'];
                    }
                    ?>" />
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
                    <input type="checkbox" name="buynotification[infozakaz_chek]" <?php
                    if (isset($buynotification['infozakaz_chek'])) {
                        checked($buynotification['infozakaz_chek'], 'on', 1);
                    }
                    ?>/>
                    <span class="description">Отправлять клиенту данные о заказе. Галочка стоит - отправлять!</span>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Произвольная информация</th>
                <td>
                    <input type="checkbox" name="buynotification[dopiczakaz_chek]" <?php
                    if (isset($buynotification['dopiczakaz_chek'])) {
                        checked($buynotification['dopiczakaz_chek'], 'on', 1);
                    }
                    ?>/>
                    <span class="description">Отправлять дополнительные данные. Вы можете указать произвольный текст.</span>
                </td>
            </tr>


            <tr valign="top">
                <th scope="row">Произвольная информация</th>
                <td>
                    <textarea cols="50" rows="10" name="buynotification[dopiczakaz]"><?php
                        if (isset($buynotification['dopiczakaz'])) {
                            echo $buynotification['dopiczakaz'];
                        }
                        ?></textarea>
                    <span class="description">Произвольная информация, например контакты или пожелание. Есть возможность указывать HTML тэги</span>
                </td>
            </tr>

        </table>
    </fieldset>
    <fieldset>
        <legend>Настройка SMS уведомлений</legend>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Включить SMS уведомления</th>
                <td>
                    <input type="checkbox" name="buysmscoptions[enable_smsc]" <?php
                    if (isset($buysmscoptions['enable_smsc'])) {
                        checked($buysmscoptions['enable_smsc'], 'on', 1);
                    }
                    ?>/>
                    <span class="description">Включить функции СМС уведомлений через сервис "<a href="http://smsc.ru/?ppzixn.ru" target="_blank">SMSC</a>" для кнопки быстрого заказа. Если галочка установлена — смс уведомления будут работать.</span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Логин smsc</th>
                <td>
                    <input type="text" name="buysmscoptions[login]" value="<?php
                    if (isset($buysmscoptions['login'])) {
                        echo $buysmscoptions['login'];
                    }
                    ?>" />
                    <span class="description">Ваш логин от сервиса "<a href="http://smsc.ru/?ppzixn.ru" target="_blank">SMSC</a>"</span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Пароль smsc</th>
                <td>
                    <input type="password" name="buysmscoptions[password]" value="<?php
                    if (isset($buysmscoptions['password'])) {
                        echo $buysmscoptions['password'];
                    }
                    ?>" />
                    <span class="description">Ваш пароль от сервиса "SMSC"</span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Использовать метод POST</th>
                <td>
                    <select name="buysmscoptions[methodpost]">
                        <option value="0" <?php selected($buysmscoptions['methodpost'], '0', true); ?>>Не использовать</option>
                        <option value="1" <?php selected($buysmscoptions['methodpost'], '1', true); ?>>Использовать</option>

                    </select>
                    <span class="description">Использовать метод POST. По умолчанию - не использовать.</span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Использовать HTTPS протокол</th>
                <td>

                    <select name="buysmscoptions[https]">
                        <option value="0" <?php selected($buysmscoptions['https'], '0', true); ?>>Не использовать</option>
                        <option value="1" <?php selected($buysmscoptions['https'], '1', true); ?>>Использовать</option>

                    </select>

                    <span class="description">Использовать для смс HTTPS. По умолчанию - не использовать.</span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Кодировка sms</th>
                <td>
                    <select name="buysmscoptions[charset]">
                        <option value="utf-8" <?php selected($buysmscoptions['charset'], 'utf-8', true); ?>>UTF-8</option>
                        <option value="koi8-r" <?php selected($buysmscoptions['charset'], 'koi8-r', true); ?>>KOI8-R</option>
                        <option value="windows-1251" <?php selected($buysmscoptions['charset'], 'windows-1251', true); ?>>WINDOWS-1251</option>
                    </select>
                    <span class="description">Кодировка смс сообщений</span>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Шаблон SMS сообщения</th>
                <td>
                    <textarea cols="50" rows="5" name="buysmscoptions[smshablon]" required><?php
                        if (isset($buysmscoptions['smshablon'])) {
                            echo $buysmscoptions['smshablon'];
                        }
                        ?></textarea>
                    <span class="description">Указанный шаблон «%Имя шаблона%»  будут преобразован в информацию из формы. Так же вы можете вписать произвольный текст.
                        Например: "Здравствуйте %FIO%, спасибо за заказ в магазине Винтик и Шпунтик, сумма вашего заказа - %TPRICE%"</span>
                </td>

                <td>
                    <b>%FIO%</b> - Имя клиента<br>
                    <b>%FON%</b> - Телефон клиента<br>
                    <b>%EMAIL%</b> - Email клиента<br>
                    <b>%DOPINFO%</b> - Поле доп. информации из формы<br>
                    <b>%TPRICE%</b> - Цена товара<br>
                    <b>%TNAME%</b> - Наименование товара<br>

                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Debug режим</th>
                <td>

                    <select name="buysmscoptions[debug]">
                        <option value="0" <?php selected($buysmscoptions['debug'], '0', true); ?>>Выключить</option>
                        <option value="1" <?php selected($buysmscoptions['debug'], '1', true); ?>>Включить</option>

                    </select>

                    <span class="description">Включить режим отладки. По умолчанию - debub выключен.</span>
                </td>
            </tr>

        </table>
    </fieldset>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="buynotification,buysmscoptions" />
    <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
