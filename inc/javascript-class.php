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

        $txtname = wp_specialchars_decode(esc_html($textjson['txtname']), ENT_QUOTES);
        $txtphone = $textjson['txtphone'];
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


        $infotovar_new = $infotovar_old;
        array_push($infotovar_new, $infotovar_temp);
        update_option('buyzakaz', $infotovar_new);

        $message = array(
            'time' => $time,
            'url' => '<a href="' . get_the_permalink($idtovar) . '" target="_blank">Посмотреть</a>',
            'price' => $pricetovar,
            'nametov' => $nametovar,
            'namemag' => BuyCore::$buynotification['namemag'],
            'dopinfo' => BuyCore::$buynotification['dopiczakaz']
        );
        if (!empty($txtemail) and !empty(BuyCore::$buynotification['infozakaz_chek'])) {

            BuyFunction::BuyEmailNotification($txtemail, BuyCore::$buynotification['namemag'], $message);
        }
        if (!empty(BuyCore::$buynotification['emailbbc'])) {
            BuyFunction::BuyEmailNotification(BuyCore::$buynotification['emailbbc'], BuyCore::$buynotification['namemag'], $message);
        }
        echo '<strong>' . BuyCore::$buyoptions['success'] . '</strong>';

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
