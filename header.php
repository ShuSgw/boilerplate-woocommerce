<?php wp_head(); ?>

<body>
    <?php wp_nav_menu(
array(
    //カスタムメニュー名
    'theme_location' => 'header-navigation',
    'container' => false,
)
); ?>