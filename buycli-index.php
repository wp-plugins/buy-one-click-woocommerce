<?php

/*
  Plugin Name: Buy one click WooCommerce
  Plugin URI: http://www.zixn.ru/
  Description: Дополнение для Woocommerce - Купить в один клик. Добавляет кнопку "Заказать в один клик" в карточку товара.
  Version: 1.0
  Author: Djon
  Author URI: http://zixn.ru
 */

/*  Copyright 2015  Djon  (email: izm@zixn.ru)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 */


require_once (WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/inc/core-class.php');
require_once (WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/inc/function-class.php');
require_once (WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/inc/javascript-class.php');
//require_once (WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/lib/smtp.php');

if (class_exists('BuyCore')) {
    $bcore = new BuyCore();
    $bjava = new BuyJavaScript();
    register_deactivation_hook(__FILE__, array($bcore, 'deactivationPlugin'));
}


