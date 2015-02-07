<h3>Информация о  <?php echo BuyCore::NAME_PLUGIN; ?></h3>
<p>Информационная страница</p>
Поддержка и жалобы, а так же предложения по улучшению плагина <a href="http://www.zixn.ru/plagin-zakazat-v-odin-klik-dlya-woocommerce.html">здесь</a>
<br>
Другие плагины автора <a href="https://profiles.wordpress.org/northmule/#content-plugins">здесь</a>

<h3>Ниже отладочная информация</h3>
<p>Опции общие в базе WP buyoptions</p>
<?php
echo '<pre>';
print_r(BuyCore::$buyoptions);
echo '</pre>';
?>
<p>Опции уведомлений в базе WP buynotification</p>
<?php
echo '<pre>';
print_r(BuyCore::$buynotification);
echo '</pre>'
?>