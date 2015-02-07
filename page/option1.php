
    <h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
        <a class="nav-tab <?php BuyCore::adminActiveTab('general'); ?>" href="<?php echo add_query_arg( array( 'page' => BuyCore::URL_SUB_MENU, 'tab' => 'general' ), 'admin.php' ); ?>"><span class="glyphicon glyphicon-cog"></span> Общие</a>
        <a class="nav-tab <?php BuyCore::adminActiveTab('notification'); ?>" href="<?php echo add_query_arg( array( 'page' => BuyCore::URL_SUB_MENU, 'tab' => 'notification' ), 'admin.php' ); ?>"><span class="glyphicon glyphicon-envelope"></span> Уведомления</a>
        <a class="nav-tab <?php BuyCore::adminActiveTab('orders'); ?>" href="<?php echo add_query_arg( array( 'page' => BuyCore::URL_SUB_MENU, 'tab' => 'orders' ), 'admin.php' ); ?>"><span class="glyphicon glyphicon-list"></span> Заказы</a>
        <a class="nav-tab <?php BuyCore::adminActiveTab('help'); ?>" href="<?php echo add_query_arg( array( 'page' => BuyCore::URL_SUB_MENU, 'tab' => 'help' ), 'admin.php' ); ?>"><span class="glyphicon glyphicon-thumbs-up"></span> ....</a>
    </h2>
    <?php BuyCore::tabViwer();//Показать страницу в зависимости от закладки ?>

