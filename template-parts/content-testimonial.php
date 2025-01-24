<section id="testimonial" class="section-padding">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8 text-center">
				<div class="mb-5">
					<h3 class="mb-2">Trusted by hundred over years</h3>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis, dignissimos?</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-8 m-auto col-sm-12 col-md-12">
				<div id="test-carousel2" class="carousel slide" data-ride="carousel">
					<?php
					global $post;
					$myposts = get_posts([
						'numberposts' => 3,
						'post_type'   => 'testimonial'
					]);

					if ($myposts) : ?>
						<ol class="carousel-indicators">
							<?php foreach ($myposts as $index => $post) : ?>
								<li data-target="#test-carousel2" data-slide-to="<?php echo $index; ?>" class="<?php echo ($index === 0) ? 'active' : ''; ?>"></li>
							<?php endforeach; ?>
						</ol>

						<div class="carousel-inner">
							<?php foreach ($myposts as $index => $post) :
								setup_postdata($post);
							?>
								<div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="testimonial-content style-2">
												<div class="author-info">
													<div class="author-img">
														<?php the_post_thumbnail('full', ['class' => 'img-fluid', 'alt' => get_the_title()]); ?>
													</div>
												</div>
												<p>
													<i class="icofont icofont-quote-left"></i>
													<?php echo get_the_excerpt(); ?>
													<i class="icofont icofont-quote-right"></i>
												</p>
												<div class="author-text">
													<h5><?php the_title(); ?></h5>
													<p><?php echo get_post_meta($post->ID, 'role', true); ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach;
							wp_reset_postdata(); ?>
						</div>
					<?php else : ?>
						<p>No testimonials found.</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>