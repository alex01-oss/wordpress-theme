<div class="page-banner-area page-contact" id="page-banner">
    <div class="overlay dark-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
                <div class="banner-content content-padding">
                    <h1 class="text-white">Standard Price plan</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Unde, perferendis?</p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 m-auto">
                <div class="section-heading">
                    <h4 class="section-title">Affordable pricing plan for you</h4>
                    <p>We have different type of pricing table to choose with your need. Check which one is most suitble for you and your business purpose. </p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            global $post;

            $myposts = get_posts([
                'numberposts' => 3,
                'post_type'   => 'price',
                'order'       => 'ASC'
            ]);

            if ($myposts) {
                foreach ($myposts as $post) {
                    setup_postdata($post);
            ?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="pricing-block ">
                            <div class="price-header">
                                <i class="icofont-<?php if (!empty(get_post_meta($post->ID, 'price-icon', true))) {
                                                        echo get_post_meta($post->ID, 'price-icon', true);
                                                    } else {
                                                        echo 'bag-alt';
                                                    } ?>"></i>
                                <h4 class="price"><small>$</small><?php the_title(); ?></h4>
                                <h5><?php the_excerpt(); ?></h5>
                            </div>
                            <div class="line"></div>
                            <?php the_content(); ?>
                            <a href="contact.html" class="btn btn-hero btn-circled">select plan</a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No prices found.</p>';
            }

            wp_reset_postdata(); // Reset $post
            ?>

        </div>
    </div>
</section>