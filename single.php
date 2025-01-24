<?php get_header(); ?>

<!--MAIN BANNER AREA START -->
<div class="page-banner-area page-contact" id="page-banner" style="background: url(
<?php
if (has_post_thumbnail()) {
	the_post_thumbnail_url();
} else {
	echo get_template_directory_uri() . '/images/banner/1.jpg';
} ?>) no-repeat center / cover">
	<div class="overlay dark-overlay"></div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
				<div class="banner-content content-padding">
					<h1 class="text-white"><?php the_title(); ?></h1>
					<p>
						<?php if (has_excerpt()) {
							the_excerpt();
						} else {
						} ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!--MAIN HEADER AREA END -->

<section class="section blog-wrap">
	<div class="container">
		<div class="row">
			<main class="col-lg-8">
				<div class="row">
					<div class="col-lg-12">
						<?php
						while (have_posts()) :
							the_post();

							get_template_part('template-parts/content', get_post_type());

							the_post_navigation(
								array(
									'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'my-theme') . '</span> <span class="nav-title">%title</span>',
									'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'my-theme') . '</span> <span class="nav-title">%title</span>',
								)
							);

							if (comments_open() || get_comments_number()) :
								comments_template();
							endif;

						endwhile;
						?>
					</div>
				</div>
			</main>

			<?php get_sidebar(); ?>

		</div>
	</div>
</section>

<?php get_footer(); ?>