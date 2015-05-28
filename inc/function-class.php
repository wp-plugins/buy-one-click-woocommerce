<?php

/**
 * Некоторый функционал плагина
 * 
 */
class BuyFunction {

    /**
     * Форма для быстрого заказа
     */
    static function viewBuyForm() {
        $cartinfo = self::BuyInfoCart();
        $idtovar = $cartinfo['article']; //Номер товара или страницы WP
        $nametovar = $cartinfo['name']; // Название товара или title страницы
        $pricetovar = $cartinfo['amount']; // Цена
        $imagetovar = '<img src="' . $cartinfo['imageurl'] . '" width="80" height="80">'; // Изображение
        ?>
        <div class="overlay" title="окно"></div>
        <div class="popup">
            <div class="close_order">x</div>
            <form method="post" action="#" id="contactform">
                <h2><?php echo BuyCore::$buyoptions['namebutton']; ?></h2>
                <?php if (!empty(BuyCore::$buyoptions['infotovar_chek'])) { ?>
                    <table>
                        <tr valign="top">
                            <th scope="row">Наименование</th>
                            <td>
                                <span class="description">Цена</span>
                            </td>
                            <td>
                                <span class="description">Фото</span>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php echo $nametovar; ?></th>
                            <td>
                                <span class="description"><?php echo $pricetovar; ?></span>
                            </td>
                            <td>
                                <span class="description"><?php echo $imagetovar; ?></span>
                            </td>
                        </tr>
                    </table>
                <?php } ?>

                <?php if (!empty(BuyCore::$buyoptions['fio_chek'])) { ?>
                    <input type="text" required="" placeholder="<?php echo BuyCore::$buyoptions['fio_descript']; ?>" name="txtname">	
                <?php } ?>
                <?php if (!empty(BuyCore::$buyoptions['fon_chek'])) { ?>
                    <input type="tel" pattern="^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$" required="" placeholder="<?php echo BuyCore::$buyoptions['fon_descript']; ?>" name="txtphone">
                    <p class="phoneFormat">формат +7 XXX XXX XX XX</p>
                <?php } ?>
                <?php if (!empty(BuyCore::$buyoptions['email_chek'])) { ?>
                    <input type="email" placeholder="<?php echo BuyCore::$buyoptions['email_descript']; ?>" name="txtemail">
                <?php } ?>
                <?php if (!empty(BuyCore::$buyoptions['dopik_chek'])) { ?>
                    <textarea class="buymessage" name="message" placeholder="<?php echo BuyCore::$buyoptions['dopik_descript']; ?>" rows="10" value=""></textarea>
                <?php } ?>

                <input type="hidden" name="buy_nametovar" value="<?php echo $nametovar; ?>" />
                <input type="hidden" name="buy_pricetovar" value="<?php echo $pricetovar; ?>" />
                <input type="hidden" name="buy_idtovar" value="<?php echo $idtovar; ?>" /> 

                <input type="submit" class="button buyButtonOkForm" value="<?php echo BuyCore::$buyoptions['butform_descript']; ?>" name="btnsend">
            </form>
        </div>
        <?php
    }

    /**
     * HTML форма кнопки "Заказать в один клик"
     */
    static function viewBuyButton() {
        if (!empty(BuyCore::$buyoptions['namebutton']) and ! empty(BuyCore::$buyoptions['positionbutton'])) {
            ?>

            <a class="clickBuyButton button21" href="#"><?php echo BuyCore::$buyoptions['namebutton']; ?></a>

            <?php
        }
    }

    /**
     * Собираем информацию о товаре, для формы
     * Этот вариант кнопки расположен в карточке товара и подразумевает заказ 1й еденицы
     * товара (покупка в один клик, минуя корзину)
     * @return array 'article' - код товара, 'name'-наименование,'imageurl'-url картинки,'amount'-цена,
     * 'quantity' -количество
     */
    static function BuyInfoCart() {
        global $post; // Что бы получать данные о посте Wordpress

        $product_id = $post->ID; //ID продукта (ID поста Wordpress)
        $product = new WC_Product($product_id); // Класс Woo для работы с товаром
        if (method_exists($product, 'get_image_id')) {


            $article = $product_id; //Код товара по классификации Wordpress (ID продукта)
            $name = $product->get_post_data()->post_title; //Название товара
            $imageurl = wp_get_attachment_image_src($product->get_image_id()); //Урл картинки товара
            $amount = $product->get_price(); //Цена товара
            $quantity = '1'; //Количество товаров - не использую
            //Данные о товаре
            $datacart = array(
                'article' => $article,
                'name' => $name,
                'imageurl' => $imageurl[0],
                'amount' => $amount,
                'quantity' => $quantity
            );

            return $datacart;
        } else {
            return FALSE;
        }
    }

    /**
     * Отправка Email через функцию PHP mail
     */
    static function BuyEmailNotification($to, $subject, $message) {

        $namemag = $message['namemag'];
        $date = $message['time'];
        $urltovar = $message['url'];
        $price = $message['price'];
        $nametovar = $message['nametov'];
        $dopinfo = $message['dopinfo'];
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8 \r\n";
        $headers .= "From: " . $namemag . " <" . BuyCore::$buynotification['emailfrom'] . ">\r\n";
//Функция Wordpress иногда ломается, можно использовать просто mail
        wp_mail($to, $subject, self::htmlEmailTemplate($namemag, $date, $urltovar, $price, $nametovar, $dopinfo), $headers);
    }

    /**
     * Шаблон emial сообщения
     */
    static function htmlEmailTemplate($namemag, $date, $urltovar, $price, $nametovar, $dopinfo) {
        $message = ' 
<table style="height: 255px; border-color: #1b0dd9;" border="2" width="579">
<tbody>
<tr>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;" colspan="2">' . $namemag . '</td>
</tr>
<tr>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;"> Дата: </td>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;">' . $date . '</td>
</tr>
<tr>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;">Ссылка на товар: </td>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;">' . $urltovar . '</td>
</tr>
<tr>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;"> Цена: </td>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;">' . $price . '</td>
</tr>
<tr>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;">Наименование</td>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;">' . $nametovar . '</td>
</tr>
<tr>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;"> ----- </td>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;">  ----- </td>
</tr>
<tr>
<td style="border-color: #132cba; text-align: center; vertical-align: middle;" colspan="2">' . $dopinfo . '</td>
</tr>
</tbody>
</table>
&nbsp;
        ';
        return $message;
    }

}
