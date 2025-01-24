<?php get_header(); ?>

<!--MAIN BANNER AREA START -->
<div class="page-banner-area page-contact" id="page-banner">
    <div class="overlay dark-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 text-center col-sm-12 col-md-12">
                <div class="banner-content content-padding">
                    <h1 class="text-white">
                        <?php
                        /* translators: %s: search query. */
                        printf(esc_html__('Search Results for: %s', '_s'), '<span>' . get_search_query() . '</span>');
                        ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MAIN BANNER AREA END -->

<section class="section blog-wrap ">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- POSTS AREA -->
                <div class="row">
                    <?php $cnt = 0;
                    if (have_posts()) : while (have_posts()) : the_post();
                            $cnt++;
                            switch ($cnt) {
                                case '3': ?>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="blog-post">
                                            <!-- post image stub -->
                                            <?php
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('post-thumbnail', array('class' => 'img-fluid w-100'));
                                            } else {
                                                echo '<img class="img-fluid w-100" src="' . get_template_directory_uri() . '/images/blog/blog-2.jpg" />';
                                            }
                                            ?>
                                            <div class="mt-4 mb-3 d-flex">
                                                <div class="post-author mr-3">
                                                    <!-- avatar -->
                                                    <?php
                                                    $avatar = get_avatar(get_the_author_meta('user_email'), 32);

                                                    if ($avatar) {
                                                        echo $avatar;
                                                    } else { ?>
                                                        <i class="fa fa-user"></i>
                                                    <?php }
                                                    ?>
                                                    <span class="h6 text-uppercase"><?php the_author(); ?></span>
                                                </div>

                                                <div class="post-info">
                                                    <i class="fa fa-calendar-check"></i>
                                                    <span><?php the_time('j F Y'); ?></span>
                                                </div>
                                            </div>
                                            <a href="<?php echo get_the_permalink(); ?>" class="h4 "><?php the_title(); ?></a>
                                            <p class="mt-3"><?php the_excerpt(); ?></p>
                                            <a href="<?php echo get_the_permalink(); ?>" class="read-more">Read More <i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                                <?php
                                    break;
                                default: ?>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="blog-post">
                                            <!-- post image stub -->
                                            <?php
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('post-thumbnail', array('class' => 'img-fluid w-100'));
                                            } else {
                                                echo '<img class="img-fluid w-100" src="' . get_template_directory_uri() . '/images/blog/blog-2.jpg" />';
                                            }
                                            ?>
                                            <div class="mt-4 mb-3 d-flex">
                                                <div class="post-author mr-3">
                                                    <!-- avatar -->
                                                    <?php
                                                    $avatar = get_avatar(get_the_author_meta('user_email'), 32);
                                                    if ($avatar) {
                                                        echo $avatar;
                                                    } else { ?>
                                                        <i class="fa fa-user"></i>
                                                    <?php }
                                                    ?>
                                                    <span class="h6 text-uppercase"><?php the_author(); ?></span>
                                                </div>

                                                <div class="post-info">
                                                    <i class="fa fa-calendar-check"></i>
                                                    <span><?php the_time('j F Y'); ?></span>
                                                </div>
                                            </div>
                                            <a href="<?php echo get_the_permalink(); ?>" class="h4 "><?php the_title(); ?></a>
                                            <p class="mt-3"><?php the_excerpt(); ?></p>
                                            <a href="<?php echo get_the_permalink(); ?>" class="read-more">Read More <i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                            <?php
                            } ?>
                        <?php endwhile;
                    else: ?>
                        No posts.
                    <?php endif; ?>
                    <div class="col-lg-12">
                        <?php the_posts_pagination(array(
                            'prev_text'    => '<span class="p-2 border">« Previous</span>',
                            'next_text'    => '<span class="p-2 border">Next »</span>',
                            'before_page_number' => '<span class="p-2 border">',
                            'after_page_number'  => '</span>'
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="row mt-5 mt-lg-0">
                    <div class="col-lg-12">
                        <?php if (!dynamic_sidebar('homepage-sidebar')) : dynamic_sidebar('homepage-sidebar') ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>