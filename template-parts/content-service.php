<section id="service-head" class="<?php echo $args['class']; ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 m-auto">
                <div class="section-heading text-white">
                    <h4 class="section-title">Full stack digital marketing solution</h4>
                    <p>We’re full service which means we’ve got you covered on design & content right through to digital. You’ll
                        form a lasting relationship with us.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="service">
    <div class="container">
        <div class="row">
            <?php
            global $post;

            $myposts = get_posts([
                'numberposts' => 6,
                'post_type'   => 'service'
            ]);

            if ($myposts) {
                foreach ($myposts as $post) {
                    setup_postdata($post);
            ?>
                    <div class="col-lg-4 col-sm-6 col-md-6">
                        <div class="service-box">
                            <div class="service-img-icon">
                                <?php the_post_thumbnail('full', ['class' => 'img-fluid', 'alt' => get_the_title()]); ?>
                            </div>
                            <div class=" service-inner">
                                <h4><?php the_title(); ?></h4>
                                <p><?php the_excerpt(); ?></p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No services found.</p>';
            }

            wp_reset_postdata(); // Reset $post
            ?>
        </div>
    </div>
</section>