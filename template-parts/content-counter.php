<section id="counter" class="section-padding">
    <div class="overlay dark-overlay"></div>
    <div class="container">
        <div class="row">
            <?php
            global $post;

            $myposts = get_posts([
                'numberposts' => 4,
                'post_type'   => 'counter',
                'order'       => 'ASC'
            ]);

            if ($myposts) {
                foreach ($myposts as $post) {
                    setup_postdata($post);
            ?>
                    <div class="col-lg-3 col-sm-6 col-md-6">
                        <div class="counter-stat">
                            <i class="icofont icofont-<?php echo get_post_meta($post->ID, 'icon', true) ?>"></i>
                            <span class="counter" data-count="<?php the_title(); ?>">0</span>
                            <h5><?php the_excerpt(); ?></h5>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No counters found.</p>';
            }

            wp_reset_postdata(); // Reset $post
            ?>
        </div>
    </div>
</section>