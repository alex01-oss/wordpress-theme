<?php get_header(); ?>

<!--  MAIN BANNER AREA START -->
<div class="banner-area banner-3">
    <div class="overlay dark-overlay"></div>
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
                        <div class="banner-content content-padding">
                            <h5 class="subtitle">
                                <?php echo get_post_meta($post->ID, 'subtitle', true) ?>
                            </h5>
                            <h1 class="banner-title">
                                <?php echo get_post_meta($post->ID, 'banner-title', true) ?>
                            </h1>
                            <p class="banner-description">
                                <?php echo get_post_meta($post->ID, 'banner-description', true) ?>
                            </p>

                            <a href="contact.html" class="btn btn-white btn-circled">lets start</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  MAIN BANNER AREA END -->

<section id="intro" class="section-padding">
    <div class="container">
        <?php the_content(); ?>
    </div>
</section>

<?php echo get_template_part('template-parts/content', 'service', ['class' => 'bg-feature']); ?>

<?php echo get_template_part('template-parts/content', 'price'); ?>

<?php echo get_template_part('template-parts/content', 'testimonial'); ?>

<?php echo get_template_part('template-parts/content', 'partner'); ?>

<!--  BLOG AREA START  -->
<section id="blog" class="section-padding bg-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 m-auto">
                <div class="section-heading">
                    <h4 class="section-title">Latest Blog news</h4>
                    <div class="line"></div>
                    <p>Our blog journey may come handy to build a community to make more effective success for business. Latest and trend tricks will help a lot </p>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            global $post;

            $myposts = get_posts([
                'numberposts' => 3,
                'post_type'   => 'post'
            ]);

            if ($myposts) {
                foreach ($myposts as $post) {
                    setup_postdata($post);
            ?>
                    <div class="col-lg-4 col-sm-6 col-md-4">
                        <div class="blog-block ">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('post-thumbnail', array('class' => 'img-fluid w-100'));
                            } else {
                                echo '<img class="img-fluid w-100" src="' . get_template_directory_uri() . '/images/blog/blog-2.jpg" />';
                            }
                            ?>
                            <div class="blog-text">
                                <h6 class="author-name">
                                    <a href="<?php echo get_category_link(get_the_category()[0]->term_id); ?>">
                                        <span><?php echo get_the_category()[0]->name; ?></span>
                                    </a>
                                    <?php the_author(); ?>
                                </h6>
                                <a href="<?php echo get_the_permalink(); ?>" class="h5 my-2 d-inline-block"><?php the_title(); ?></a>
                                <p><?php the_excerpt(); ?></p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No posts found.</p>';
            }

            wp_reset_postdata(); // Reset $post
            ?>
        </div>
    </div>
</section>
<!--  BLOG AREA END  -->

<?php echo get_template_part('template-parts/content', 'counter'); ?>

<?php get_footer(); ?>