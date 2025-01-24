<?php wp_head(); ?>

<nav class="navbar navbar-expand-lg fixed-top trans-navigation">
    <div class="container">
        <?php
        if (has_custom_logo()) {
            echo get_custom_logo();
        }
        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fa fa-bars"></i>
            </span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
            <?php wp_nav_menu([
                'theme_location'  => 'header',
                'container'       => false,
                'menu_class'      => 'navbar-nav',
                'menu_id'         => false,
                'echo'            => true,
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'walker'          => new bootstrap_4_walker_nav_menu(),
                'depth'           => 2
            ]); ?>
        </div>
    </div>
</nav>