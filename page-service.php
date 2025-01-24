<?php get_header(); ?>

<!--MAIN BANNER AREA START -->
<div class="page-banner-area page-service" id="page-banner">
    <div class="overlay dark-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
                <div class="banner-content content-padding">
                    <h1 class="text-white"><?php the_title(); ?></h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Unde, perferendis?</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MAIN BANNER AREA END -->

<section id="service-2" class="section-padding pb-5">
    <div class="container">
        <?php the_content(); ?>
    </div>
</section>

<?php echo get_template_part('template-parts/content', 'service', ['class' => 'service-style-two']); ?>

<?php echo get_template_part('template-parts/content', 'partner'); ?>

<?php get_footer(); ?>