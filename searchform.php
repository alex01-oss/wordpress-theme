<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>" class="searchform form-group">
    <div class="search-container">
        <input type="text" placeholder="search" class="form-control" name="s" value="<?php echo get_search_query(); ?>">
        <button class="searchform-button">
            <i class="fa fa-search"></i>
        </button>
    </div>
</form>