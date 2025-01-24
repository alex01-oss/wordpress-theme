<section id="clients" class="section-padding ">
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
            <?php
            global $post;

            $myposts = get_posts([
                'numberposts' => 4,
                'post_type'   => 'partner'
            ]);

            if ($myposts) {
                foreach ($myposts as $post) {
                    setup_postdata($post);
            ?>
                    <div class="col-lg-3 col-sm-6 col-md-3 text-center">
                        <?php the_post_thumbnail('full', ['class' => 'img-fluid', 'alt' => get_the_title()]); ?>
                    </div>
            <?php
                }
            } else {
                echo '<p>No partners found.</p>';
            }

            wp_reset_postdata(); // Reset $post
            ?>
        </div>
    </div>
</section>