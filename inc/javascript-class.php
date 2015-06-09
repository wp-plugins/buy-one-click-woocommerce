<?php

/**
 * Класс для работы с JavaScript функциями отправляемыми через скрипты
 */
class BuyJavaScript {

    /**
     * Конструктор класса
     */
    public function __construct() {
        $this->addaction();
    }

    /**
     * Адды
     */
    public function addaction() {
        add_action('wp_ajax_buybuttonform', array($this, 'ajaxBuyButtonForm')); //buybuttonform Посылается из js файла
        add_action('wp_ajax_nopriv_buybuttonform', array($this, 'ajaxBuyButtonForm')); //buybuttonform Посылается из js файла
        add_action('wp_ajax_removeorder', array($this, 'ajaxRemoveOrderId'));
        add_action('wp_ajax_nopriv_removeorder', array($this, 'ajaxRemoveOrderId'));
        add_action('wp_ajax_updatestatus', array($this, 'ajaxStatusOrderId'));
        add_action('wp_ajax_nopriv_updatestatus', array($this, 'ajaxStatusOrderId'));
    }

    /**
     * Функция выполняется после нажатия на кнопку в форме заказа
     */
    static public function ajaxBuyButtonForm() {

        $textjson = $_POST['text'];

        if (!empty($textjson['txtname'])) {
            $txtname = wp_specialchars_decode(esc_html($textjson['txtname']), ENT_QUOTES);
        } else {
            $txtname = '';
        }
        if (!empty($textjson['txtphone'])) {
            $txtphone = $textjson['txtphone'];
        } else {
            $txtphone = '';
        }

        $txtemail = sanitize_email($textjson['txtemail']);
        $nametovar = $textjson['nametovar'];
        $pricetovar = $textjson['pricetovar'];
        $idtovar = $textjson['idtovar'];
        $message = wp_specialchars_decode(esc_html($textjson['message']), ENT_QUOTES);
        $linktovar = '<a href="' . get_the_permalink($idtovar) . '" target="_blank"><span class="glyphicon glyphicon-share"></span></a>';
        $infotovar_old = get_option('buyzakaz');
        $time = current_time('mysql');
        $status = '1'; //По умолчанию статус - новый
        $infotovar_temp = array('time' => $time, 'idtovar' => $idtovar, 'txtname' => $txtname, 'txtphone' => $txtphone,
            'txtemail' => $txtemail, 'nametovar' => $nametovar, 'pricetovar' => $pricetovar, 'message' => $message, 'status' => $status, 'linktovar' => $linktovar
        );
        if (isset(BuyCore::$buynotification['namemag'])) {
            $namemag = BuyCore::$buynotification['namemag'];
        } else {
            $namemag = '';
        }
        if (isset(BuyCore::$buynotification['dopiczakaz'])) {
            $dopiczakaz = BuyCore::$buynotification['dopiczakaz'];
        } else {
            $dopiczakaz = '';
        }
        if (isset(BuyCore::$buyoptions['success_action'])) { // опции "действия после нажатия кнопки в форме"
            if (!empty(BuyCore::$buyoptions['success_action_close'])) {
                $success_time = BuyCore::$buyoptions['success_action_close']; // 2 Закрытие формы через мсек
            }
            if (!empty(BuyCore::$buyoptions['success_action_message'])) {
                $success_message = BuyCore::$buyoptions['success_action_message']; // 3 Сообщение после нажатия кнопки в форме
            }
            if (!empty(BuyCore::$buyoptions['success_action_redirect'])) {
                $success_redirect = BuyCore::$buyoptions['success_action_redirect']; // 4  Редирект на страницу после нажатия на кнопку в форме
            }
            switch (BuyCore::$buyoptions['success_action']) {
                case 1: $success_action = 'no'; //Ни чего не делать, пользователь сам закроет форму
                    $num = 1;
                    break;
                case 2: $success_action = $success_time;
                    $num = 2;
                    break;
                case 3: $success_action = $success_message;
                    $num = 3;
                    break;
                case 4: $success_action = $success_redirect;
                    $num = 4;
                    break;
                default: $success_action = 'no';
                    $num = 2; //Ни чего не делать, пользователь сам закроет форму
            }
        } //конец IF действий после нажатия кнопки в форме



        $infotovar_new = $infotovar_old;
        array_push($infotovar_new, $infotovar_temp);
        update_option('buyzakaz', $infotovar_new);

        $message = array(
            'time' => $time,
            'url' => '<a href="' . get_the_permalink($idtovar) . '" target="_blank">Посмотреть</a>',
            'price' => $pricetovar,
            'nametov' => $nametovar,
            'namemag' => $namemag,
            'dopinfo' => $dopiczakaz,
            'fon' => $txtphone,
            'fio' => $txtname
        );
        if (!empty($txtemail) and ! empty(BuyCore::$buynotification['infozakaz_chek'])) {

            BuyFunction::BuyEmailNotification($txtemail, BuyCore::$buynotification['namemag'], $message);
        }
        if (!empty(BuyCore::$buynotification['emailbbc'])) {
            BuyFunction::BuyEmailNotification(BuyCore::$buynotification['emailbbc'], BuyCore::$buynotification['namemag'], $message);
        }
        $returnresult = array('result' => BuyCore::$buyoptions['success'], 'num' => $num, 'action' => $success_action);
        //$returnresult = array('result' => '123');
//echo '<strong>' . BuyCore::$buyoptions['success'] . '</strong>';
        echo json_encode($returnresult);
        wp_die();
    }

    /**
     * Функция удаляет элемент заказа из таблицы
     * Данные отправляются из файла admin_order.js
     */
    public function ajaxRemoveOrderId() {
        $id = $_POST['text'];
        $infotovar_old = get_option('buyzakaz');
        unset($infotovar_old[$id]);
        $infotovar_new = $infotovar_old;
        update_option('buyzakaz', $infotovar_new);
        wp_die();
    }

    /**
     * Функция Изменения статуса заказа
     * Данные отправляются из файла admin_order.js
     */
    public function ajaxStatusOrderId() {
        $text = $_POST['text'];
        $id = $text['id'];
        $infotovar_old = get_option('buyzakaz');
        $infotovar_old[$id]['status'] = $text['status'];
        $infotovar_new = $infotovar_old;
        update_option('buyzakaz', $infotovar_new);

        wp_die();
    }

}
