<section id="footer" class="section-padding">
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-lg-4">
                <?php if (!dynamic_sidebar('sidebar-footer-text')) : dynamic_sidebar('sidebar-footer-text') ?>
                <?php endif; ?>
                <!-- <div class="footer-widget footer-link">
                    <h4>We concern about you<br> to grow business rapidly.</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore ipsam hic non sunt recusandae atque unde saepe nihil earum voluptatibus aliquid optio suscipit nobis quia vel quod, iure quae.</p>
                </div> -->
            </div>

            <div class="col-lg-2 col-md-4 col-6">
                <?php wp_nav_menu([
                    'theme_location'  => 'footer_left',
                    'container'       => 'div',
                    'container_class' => 'footer-widget footer-text',
                    'echo'            => true,
                    'items_wrap'      => '<h4>About</h4><ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'           => 2
                ]) ?>
            </div>

            <div class="col-lg-2 col-md-4 col-6">
                <?php wp_nav_menu([
                    'theme_location'  => 'footer_right',
                    'container'       => 'div',
                    'container_class' => 'footer-widget footer-text',
                    'echo'            => true,
                    'items_wrap'      => '<h4>Quick Links</h4><ul id="%1$s" class="%2$s">%3$s</ul>',
                    'depth'           => 2
                ]) ?>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-12">
                <?php if (!dynamic_sidebar('sidebar-footer-contact')) : dynamic_sidebar('sidebar-footer-contact') ?>
                <?php endif; ?>
                <!-- <div class="footer-widget footer-text">
                    <h4>Our location</h4>
                    <p class="mail"><span>Mail:</span> promdise@gmail.com</p>
                    <p><span>Phone :</span>+202-277-3894</p>
                    <p><span>Location:</span> 455 West Orchard Street Kings Mountain, NC 28086,NOC building</p>
                </div> -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="footer-copy">
                    Copyright &copy; <?php echo date('Y') ?>, Designed &amp; Developed by <?php echo get_bloginfo('name') ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php wp_footer(); ?>