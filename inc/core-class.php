<?php

/**
 * Базовый класс плагина
 * Создаёт настройки, отображает опции в админки
 * Вызывает хуки ВордПресс
 */
class BuyCore {

    /**
     * Полное название плагина
     */
    const NAME_PLUGIN = 'Buy one click WooCommerce';

    /**
     * Имя папки с плагином без слэшей
     */
    const PATCH_PLUGIN = 'buy-one-click-woocommerce';

    /**
     * Название пункта подменю
     */
    const NAME_SUB_MENU = 'BuyOneClick';

    /**
     * URL страницы подменю
     */
    const URL_SUB_MENU = 'buyone';

    /**
     * Путь до страницы опций плагина HTML
     */
    const OPTIONS_NAME_PAGE = 'page/option1.php';

    /**
     * Имя индексного файла
     */
    const INDEX_NAME_FILE = 'buycli-index.php';

    /**
     * Настройки плагина
     * @uses [namebutton] - Название кнопки "купить"
     * @uses [positionbutton]- Расположение кнопк "купить"
     * @uses [infotovar_chek] - Показывать или нет информацию о товаре в окне
     * @uses [fio_chek] - Запрос на ФИО
     * @uses [fon_chek] - Запрос телефона
     * @uses [email_chek] - Запрос email
     * @uses [dopik_chek] - Показывать поле дополнительной информации
     * @uses [fio_descript] - Описание поля ФИО
     * @uses [fon_descript] - Описание поля телефон
     * @uses [email_descript] - Описание поля email
     * @uses [dopik_descript] - Описание поля email
     * @uses [butform_descript] - Название кнопки в форме отправки данных о покупателе
     * @uses [infotovar_chek] - Показывать или нет информацию о товаре в окне
     * @uses [success] - Сообщение об успешном совершение заказа в форме
     */
    static $buyoptions;

    /**
     * Настройки уведомлений плагина
     * @uses [namemag] - Название магазина
     * @uses [emailfrom] - Email для ответов
     * @uses [emailbbc] - Email для копий
     * @uses [infozakaz_chek] - Отправка клиенту сообщения о заказе
     * @uses [dopiczakaz_chek] - Отправка клиенту доп сообщения
     * @uses [dopiczakaz] - Дополнительная информация
     */
    static $buynotification;

    /**
     *
     * Журнал заказов. Вложенные массивы имеют следующие данные
     * @uses [time] - Время создания заказа
     * @uses [idtovar] - ID товара или записи Wordpress
     * @uses [txtname] - ФИО клиента
     * @uses [txtphone] - Номер телефона клиента
     * @uses [txtemail] - Email клиента
     * @uses [nametovar] - Название товара
     * @uses [pricetovar] - Цена товара
     * @uses [message] - Сообщение от клиента
     * @uses [linktovar] - ссылка на товар вместе с тегами и подписью
     */
    static $buyzakaz;

    /**
     * Конструктор класса
     */
    public function __construct() {
        $this->addAction();
        $this->addOptions();
        self::$buyoptions = get_option('buyoptions'); //Загрука опций из базы
        self::$buyzakaz = get_option('buyzakaz'); //Загрука опций из базы
        self::$buynotification = get_option('buynotification'); //Загрука опций из базы
    }

    /**
     * Подключение функций через add_action Wordpress
     */
    public function addAction() {

        $buyoptions = get_option('buyoptions');
        if (isset($buyoptions['positionbutton'])) {
            $position = $buyoptions['positionbutton']; //Позиция кнопки

            add_action($position, array($this, 'styleAddFrontPage')); //Стили фронта
            add_action($position, array($this, 'scriptAddFrontPage')); //Скрипты фронта
            add_action($position, array('BuyFunction', 'viewBuyButton')); //Кнопка заказать
            add_action($position, array('BuyFunction', 'viewBuyForm')); //Форма заказа
        }
        add_action('admin_menu', array($this, 'adminOptions'));
        add_action('woocommerce_receipt_buyclik', array('BuyFunction', 'viewBuyForm')); // Подтверждение заказа


        add_filter('plugin_action_links', array($this, 'pluginLinkSetting'), 10, 2); //Настройка на странице плагинов
    }

    /**
     * Операции выполняемые при деактивации плагина
     */
    public function deactivationPlugin() {
        delete_option('buyoptions');
        delete_option('buyzakaz');
        delete_option('buynotification');
    }

    /**
     * Добавление опций в базу Wordpress
     */
    public function addOptions() {
        add_option('buyoptions', array()); //массив настроек плагина
        add_option('buyzakaz', array()); //массив Заказов через форму
        add_option('buynotification', array()); //Массив настроек уведомлений
    }

    /**
     * Меню или суб меню плагина
     */
    public function adminOptions() {
        //Подключается если есть менюя от Woocommerce
        $page_option = add_submenu_page('woocommerce', self::NAME_SUB_MENU, self::NAME_SUB_MENU, 'manage_woocommerce', self::URL_SUB_MENU, array($this, 'showSettingPage'));
        add_action('admin_print_styles-' . $page_option, array($this, 'styleAddpage')); //загружаем стили только для страницы плагина
        add_action('admin_print_scripts-' . $page_option, array($this, 'scriptAddpage')); //Скрипты
    }

    /**
     * Стили для страницы плагина
     */
    public function styleAddpage() {
        wp_register_style('buyonclickcss', plugins_url() . '/' . self::PATCH_PLUGIN . '/' . 'css/form.css');
        wp_enqueue_style('buyonclickcss');
        wp_register_style('buybootstrapcss1', plugins_url() . '/' . self::PATCH_PLUGIN . '/' . 'bootstrap/css/bootstrap.css');
        wp_enqueue_style('buybootstrapcss1');
    }

    /**
     * Скрипты для страницы плагина
     */
    public function scriptAddpage() {
        wp_register_script('buyonclickjs', plugins_url() . '/' . self::PATCH_PLUGIN . '/' . 'js/form.js');
        wp_enqueue_script('buyonclickjs');
        wp_register_script('buybootstrapjs1', plugins_url() . '/' . self::PATCH_PLUGIN . '/' . 'bootstrap/js/bootstrap.js');
        wp_enqueue_script('buybootstrapjs1');
        wp_register_script('buyorder', plugins_url() . '/' . self::PATCH_PLUGIN . '/' . 'js/admin_order.js');
        wp_enqueue_script('buyorder');
    }

    /**
     * Стили для фронтэнда
     */
    public function styleAddFrontPage() {
        wp_register_style('buyonclickfrontcss', plugins_url() . '/' . self::PATCH_PLUGIN . '/' . 'css/button21.css');
        wp_enqueue_style('buyonclickfrontcss');
        wp_register_style('buyonclickcss2', plugins_url() . '/' . self::PATCH_PLUGIN . '/' . 'css/form.css');
        wp_enqueue_style('buyonclickcss2');
    }

    /**
     * Скрипты для фронтэнда
     */
    public function scriptAddFrontPage() {
        wp_register_script('buyonclickfrontjs', plugins_url() . '/' . self::PATCH_PLUGIN . '/' . 'js/form.js');
        wp_enqueue_script('buyonclickfrontjs');
    }

    /**
     * Страница плагина
     */
    public function showSettingPage() {
        include_once WP_PLUGIN_DIR . '/' . self::PATCH_PLUGIN . '/' . self::OPTIONS_NAME_PAGE;
    }

    /**
     * Активная вкладка в админпанели плагина
     * @return string css Класс для активной вкладки
     */
    static public function adminActiveTab($tab_name = null, $tab = null) {

        if (isset($_GET['tab']) && !$tab)
            $tab = $_GET['tab'];
        else
            $tab = 'general';

        $output = '';
        if (isset($tab_name) && $tab_name) {
            if ($tab_name == $tab)
                $output = ' nav-tab-active';
        }
        echo $output;
    }

    /**
     * Подключает нужную страницу исходя из вкладки на страницы настроек плагина
     * @result include_once tab{номер вкладки}-option1.php
     */
    static public function tabViwer() {
        if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
            switch ($tab) {
                case 'notification':
                    include_once WP_PLUGIN_DIR . '/' . self::PATCH_PLUGIN . '/page/tab2-option1.php';
                    break;
                case 'orders':
                    include_once WP_PLUGIN_DIR . '/' . self::PATCH_PLUGIN . '/page/tab3-option1.php';
                    break;
                case 'help':
                    include_once WP_PLUGIN_DIR . '/' . self::PATCH_PLUGIN . '/page/tab4-option1.php';
                    break;
                default :
                    include_once WP_PLUGIN_DIR . '/' . self::PATCH_PLUGIN . '/page/tab1-option1.php';
            }
        } else {
            include_once WP_PLUGIN_DIR . '/' . self::PATCH_PLUGIN . '/page/tab1-option1.php';
        }
    }

    /**
     * Добавляет пункт настроек на странице активированных плагинов
     */
    public function pluginLinkSetting($links, $file) {
        $this_plugin = self::PATCH_PLUGIN . '/' . self::INDEX_NAME_FILE;
        if ($file == $this_plugin) {
            $settings_link1 = '<a href="admin.php?page=' . self::URL_SUB_MENU . '">' . __("Settings", "default") . '</a>';
            array_unshift($links, $settings_link1);
        }
        return $links;
    }

}
