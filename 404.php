<?php get_header(); ?>

<!--MAIN BANNER AREA START -->
<div class="banner-area banner-3">
    <div class="overlay dark-overlay"></div>
    <div class="d-table">
        <div class="d-table-cell">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
                        <div class="banner-content content-padding">
                            <h5 class="subtitle bg-danger">Error 404</h5>
                            <h1 class="banner-title">Page not found</h1>
                            <p>You are trying to access a page that does not exist. Perhaps it was at this address before, but now we have moved it to a new location. Try to find the information you need in the search or go to the home page.</p>
                            <?php the_widget('WP_Widget_Search'); ?>
                            <a href="/" class="btn btn-white btn-circled">Back to home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MAIN BANNER AREA END -->

<?php get_footer(); ?>