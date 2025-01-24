<?php
if (!function_exists('my_theme_setup')) {

    // custom logo
    function my_theme_setup()
    {
        add_theme_support('custom-logo', [
            'height'      => 50,
            'width'       => 130,
            'flex-width'  => true,
            'flex-height' => true,
            'header-text' => ['site-title', 'site-description'],
            'unlink-homepage-logo' => true
        ]);

        // support html5
        add_theme_support('html 5', array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
            'script',
            'style'
        ));

        // dynamic <title>
        add_theme_support('title-tag');

        // post thumbnails
        add_theme_support('post-thumbnails');

        // image size
        set_post_thumbnail_size(730, 480, true);
    }
    add_action('after_setup_theme', 'my_theme_setup');
}

add_action('wp_enqueue_scripts', 'my_theme_scripts');

function my_theme_scripts()
{
    // STYLES

    // main css
    wp_enqueue_style('main', get_stylesheet_uri());
    // bootstrap css
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/plugins/bootstrap/bootstrap.min.css', array('main'), null);
    // icofont css
    wp_enqueue_style('icofont', get_template_directory_uri() . '/plugins/icofont/icofont.css', array('main'), null);
    // fonstawesome css
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/plugins/fontawesome/css/all.css', array('main'), null);
    // my theme css
    wp_enqueue_style('my_theme', get_template_directory_uri() . '/css/style.css', array('fontawesome'), null);

    // SCRIPTS

    // script js
    wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true);
    // contact js
    wp_enqueue_script('contact', get_template_directory_uri() . '/plugins/form/contact.js', array('jquery'), '1.0.0', true);
    // main jquery
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/plugins/jquery/jquery.min.js');
    wp_enqueue_script('jquery');
    // google map
    wp_enqueue_script('jquery', get_template_directory_uri() . '/plugins/google-map/map.js', array('jquery'), true);
    // bootstrap js
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/plugins/bootstrap/bootstrap.min.js', array('jquery'), true);
}

// Register navigation menus uses wp_nav_menu in five places.
function my_theme_menus()
{
    $locations = array(
        'header'  => __('Header Menu', 'my_theme'),
        'footer_left'  => __('Footer Left Menu', 'my_theme'),
        'footer_right'  => __('Footer Right Menu', 'my_theme'),
    );
    register_nav_menus($locations);
}
add_action('init', 'my_theme_menus');

class bootstrap_4_walker_nav_menu extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = !empty($args->walker->has_children);

        if ($depth === 0) {
            $classes[] = 'nav-item';
            if ($has_children) {
                $classes[] = 'dropdown';
            }
        }

        $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '#';

        if ($depth === 0) {
            $atts['class'] = 'nav-link';
            if ($has_children) {
                $atts['class'] .= ' dropdown-toggle';
                $atts['data-toggle'] = 'dropdown';
                $atts['aria-haspopup'] = 'true';
                $atts['aria-expanded'] = 'false';
            }
        } else {
            $atts['class'] = 'dropdown-item';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

## disable thumbnail creation for specified sizes
add_filter('intermediate_image_sizes', 'delete_intermediate_image_sizes');

## size of logo
add_filter('wp_get_attachment_image_attributes', function ($attr) {
    if (isset($attr['class']) && strpos($attr['class'], 'custom-logo') !== false) {
        unset($attr['width']);
        unset($attr['height']);
        $attr['style'] = 'height: 30px; width: auto;';
    }
    return $attr;
}, 10, 1);

function delete_intermediate_image_sizes($sizes)
{
    // sizes to be removed
    return array_diff($sizes, [
        'medium_large',
        'large',
        '1536x1536',
        '2048x2048',
    ]);
}

add_action('widgets_init', 'my_theme_widgets_init');

function my_theme_widgets_init()
{
    register_sidebar([
        'name'          => esc_html__('Sidebar on home page', 'my-theme'),
        'id'            => 'homepage-sidebar',
        'before_widget' => '<section id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</section>'
    ]);

    register_sidebar([
        'name'          => esc_html__('Text sidebar on footer', 'my-theme'),
        'id'            => 'sidebar-footer-text',
        'before_widget' => '<div class="footer-widget footer-link %2$s">',
        'after_widget'  => '</div>'
    ]);

    register_sidebar([
        'name'          => esc_html__('Contact sidebar on footer', 'my-theme'),
        'id'            => 'sidebar-footer-contact',
        'before_widget' => '<div class="footer-widget footer-link %2$s">',
        'after_widget'  => '</div>'
    ]);
}

add_action('widgets_init', 'register_download_widget');

class Download_Widget extends WP_Widget
{

    // Widget registration using the main class
    function __construct()
    {
        // the constructor call looks like this:
        // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
        parent::__construct(
            'download_widget', // widget ID, if not specified (leave ''), the ID will be equal to the class name in lowercase: download_widget
            'Useful files',
            array('description' => 'Attach links to useful files', 'classname' => 'download')
        );

        // widget scripts/styles, only if it is active
        if (is_active_widget(false, false, $this->id_base) || is_customize_preview()) {
            add_action('wp_enqueue_scripts', array($this, 'add_download_scripts'));
            add_action('wp_head', array($this, 'add_download_style'));
        }
    }

    /**
     * Widget output in the Front End
     *
     * @param array $args widget arguments.
     * @param array $instance saved data from settings
     */
    function widget($args, $instance)
    {
        $file_name = $instance['file_name'] ?? '';
        $file = $instance['file'] ?? '';

        echo $args['before_widget'];
        echo '<a href="' . $file . '"><i class="fa fa-file-pdf"></i>' . $file_name . '</a>';
        echo $args['after_widget'];
    }

    /**
     * The admin part of the widget
     *
     * @param array $instance saved data from settings
     */
    function form($instance)
    {
        $file_name = @$instance['file_name'] ?: 'File name';
        $file = @$instance['file'] ?: 'URL file';

?>
        <p>
            <label for="<?php echo $this->get_field_id('file'); ?>"><?php _e('File link:'); ?></label>
            <input class="widefat"
                id="<?php echo $this->get_field_id('file'); ?>"
                name="<?php echo $this->get_field_name('file'); ?>"
                type="text" value="<?php echo esc_attr($file); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('file_name'); ?>"><?php _e('File name:'); ?></label>
            <input class="widefat"
                id="<?php echo $this->get_field_id('file_name'); ?>"
                name="<?php echo $this->get_field_name('file_name'); ?>"
                type="text" value="<?php echo esc_attr($file_name); ?>">
        </p>
    <?php
    }

    /**
     * Saving the widget settings. Here the data must be cleared and returned to save it to the database.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance new settings
     * @param array $old_instance previous settings
     *
     * @return array data to be saved
     */
    function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['file_name'] = (! empty($new_instance['file_name'])) ? strip_tags($new_instance['file_name']) : '';
        $instance['file'] = (! empty($new_instance['file'])) ? strip_tags($new_instance['file']) : '';

        return $instance;
    }

    // widget script
    function add_download_scripts()
    {
        // filter so you can disable scripts
        if (! apply_filters('show_download_script', true, $this->id_base))
            return;

        // $theme_url = get_template_directory_uri();

        // wp_enqueue_script('download_script', $theme_url . 'js/download_script.js');
    }

    // widget styles
    function add_download_style()
    {
        // filter so that you can disable styles
        if (! apply_filters('show_download_style', true, $this->id_base))
            return;
    ?>
        <style type="text/css">
            .download a {
                display: inline;
            }
        </style>
    <?php
    }
}

add_action('widgets_init', 'register_download_widget');

// register Download_Widget in WordPress
function register_download_widget()
{
    register_widget('Download_Widget');
}

// comments template
class Bootstrap_Walker_Comment extends Walker
{

    /**
     * What the class handles.
     *
     * @since 2.7.0
     * @var string
     *
     * @see Walker::$tree_type
     */
    public $tree_type = 'comment';

    /**
     * Database fields to use.
     *
     * @since 2.7.0
     * @var string[]
     *
     * @see Walker::$db_fields
     * @todo Decouple this
     */
    public $db_fields = array(
        'parent' => 'comment_parent',
        'id'     => 'comment_ID',
    );

    /**
     * Starts the list before the elements are added.
     *
     * @since 2.7.0
     *
     * @see Walker::start_lvl()
     * @global int $comment_depth
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int    $depth  Optional. Depth of the current comment. Default 0.
     * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1;

        switch ($args['style']) {
            case 'div':
                break;
            case 'ol':
                $output .= '<ol class="children">' . "\n";
                break;
            case 'ul':
            default:
                $output .= '<ul class="children">' . "\n";
                break;
        }
    }

    /**
     * Ends the list of items after the elements are added.
     *
     * @since 2.7.0
     *
     * @see Walker::end_lvl()
     * @global int $comment_depth
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int    $depth  Optional. Depth of the current comment. Default 0.
     * @param array  $args   Optional. Will only append content if style argument value is 'ol' or 'ul'.
     *                       Default empty array.
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1;

        switch ($args['style']) {
            case 'div':
                break;
            case 'ol':
                $output .= "</ol><!-- .children -->\n";
                break;
            case 'ul':
            default:
                $output .= "</ul><!-- .children -->\n";
                break;
        }
    }

    /**
     * Traverses elements to create list from elements.
     *
     * This function is designed to enhance Walker::display_element() to
     * display children of higher nesting levels than selected inline on
     * the highest depth level displayed. This prevents them being orphaned
     * at the end of the comment list.
     *
     * Example: max_depth = 2, with 5 levels of nested content.
     *     1
     *      1.1
     *        1.1.1
     *        1.1.1.1
     *        1.1.1.1.1
     *        1.1.2
     *        1.1.2.1
     *     2
     *      2.2
     *
     * @since 2.7.0
     *
     * @see Walker::display_element()
     * @see wp_list_comments()
     *
     * @param WP_Comment $element           Comment data object.
     * @param array      $children_elements List of elements to continue traversing. Passed by reference.
     * @param int        $max_depth         Max depth to traverse.
     * @param int        $depth             Depth of the current element.
     * @param array      $args              An array of arguments.
     * @param string     $output            Used to append additional content. Passed by reference.
     */
    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (! $element) {
            return;
        }

        $id_field = $this->db_fields['id'];
        $id       = $element->$id_field;

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

        /*
		 * If at the max depth, and the current element still has children, loop over those
		 * and display them at this level. This is to prevent them being orphaned to the end
		 * of the list.
		 */
        if ($max_depth <= $depth + 1 && isset($children_elements[$id])) {
            foreach ($children_elements[$id] as $child) {
                $this->display_element($child, $children_elements, $max_depth, $depth, $args, $output);
            }

            unset($children_elements[$id]);
        }
    }

    /**
     * Starts the element output.
     *
     * @since 2.7.0
     * @since 5.9.0 Renamed `$comment` to `$data_object` and `$id` to `$current_object_id`
     *              to match parent class for PHP 8 named parameter support.
     *
     * @see Walker::start_el()
     * @see wp_list_comments()
     * @global int        $comment_depth
     * @global WP_Comment $comment       Global comment object.
     *
     * @param string     $output            Used to append additional content. Passed by reference.
     * @param WP_Comment $data_object       Comment data object.
     * @param int        $depth             Optional. Depth of the current comment in reference to parents. Default 0.
     * @param array      $args              Optional. An array of arguments. Default empty array.
     * @param int        $current_object_id Optional. ID of the current comment. Default 0.
     */
    public function start_el(&$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0)
    {
        // Restores the more descriptive, specific name for use within this method.
        $comment = $data_object;

        ++$depth;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment']       = $comment;

        if (! empty($args['callback'])) {
            ob_start();
            call_user_func($args['callback'], $comment, $args, $depth);
            $output .= ob_get_clean();
            return;
        }

        if ('comment' === $comment->comment_type) {
            add_filter('comment_text', array($this, 'filter_comment_text'), 40, 2);
        }

        if (('pingback' === $comment->comment_type || 'trackback' === $comment->comment_type) && $args['short_ping']) {
            ob_start();
            $this->ping($comment, $depth, $args);
            $output .= ob_get_clean();
        } elseif ('html5' === $args['format']) {
            ob_start();
            $this->html5_comment($comment, $depth, $args);
            $output .= ob_get_clean();
        } else {
            ob_start();
            $this->comment($comment, $depth, $args);
            $output .= ob_get_clean();
        }

        if ('comment' === $comment->comment_type) {
            remove_filter('comment_text', array($this, 'filter_comment_text'), 40);
        }
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 2.7.0
     * @since 5.9.0 Renamed `$comment` to `$data_object` to match parent class for PHP 8 named parameter support.
     *
     * @see Walker::end_el()
     * @see wp_list_comments()
     *
     * @param string     $output      Used to append additional content. Passed by reference.
     * @param WP_Comment $data_object Comment data object.
     * @param int        $depth       Optional. Depth of the current comment. Default 0.
     * @param array      $args        Optional. An array of arguments. Default empty array.
     */
    public function end_el(&$output, $data_object, $depth = 0, $args = array())
    {
        if (! empty($args['end-callback'])) {
            ob_start();
            call_user_func(
                $args['end-callback'],
                $data_object, // The current comment object.
                $args,
                $depth
            );
            $output .= ob_get_clean();
            return;
        }
        if ('div' === $args['style']) {
            $output .= "</div><!-- #comment-## -->\n";
        } else {
            $output .= "</li><!-- #comment-## -->\n";
        }
    }

    /**
     * Outputs a pingback comment.
     *
     * @since 3.6.0
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment The comment object.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function ping($comment, $depth, $args)
    {
        $tag = ('div' === $args['style']) ? 'div' : 'li';
    ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('', $comment); ?>>
            <div class="comment-body">
                <?php _e('Pingback:'); ?> <?php comment_author_link($comment); ?> <?php edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
            </div>
        <?php
    }

    /**
     * Filters the comment text.
     *
     * Removes links from the pending comment's text if the commenter did not consent
     * to the comment cookies.
     *
     * @since 5.4.2
     *
     * @param string          $comment_text Text of the current comment.
     * @param WP_Comment|null $comment      The comment object. Null if not found.
     * @return string Filtered text of the current comment.
     */
    public function filter_comment_text($comment_text, $comment)
    {
        $commenter          = wp_get_current_commenter();
        $show_pending_links = ! empty($commenter['comment_author']);

        if ($comment && '0' === $comment->comment_approved && ! $show_pending_links) {
            $comment_text = wp_kses($comment_text, array());
        }

        return $comment_text;
    }

    /**
     * Outputs a single comment.
     *
     * @since 3.6.0
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment Comment to display.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function comment($comment, $depth, $args)
    {
        if ('div' === $args['style']) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }

        $commenter          = wp_get_current_commenter();
        $show_pending_links = isset($commenter['comment_author']) && $commenter['comment_author'];

        if ($commenter['comment_author_email']) {
            $moderation_note = __('Your comment is awaiting moderation.');
        } else {
            $moderation_note = __('Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.');
        }
        ?>
            <<?php echo $tag; ?> <?php comment_class($this->has_children ? 'parent' : '', $comment); ?> id="comment-<?php comment_ID(); ?>">
                <?php if ('div' !== $args['style']) : ?>
                    <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
                    <?php endif; ?>

                    <div class="comment-author vcard">
                        <?php
                        if (0 !== $args['avatar_size']) {
                            echo get_avatar($comment, $args['avatar_size']);
                        }

                        $comment_author = get_comment_author_link($comment);

                        if ('0' === $comment->comment_approved && ! $show_pending_links) {
                            $comment_author = get_comment_author($comment);
                        }

                        printf(
                            /* translators: %s: Comment author link. */
                            __('%s <span class="says">says:</span>'),
                            sprintf('<cite class="fn">%s</cite>', $comment_author)
                        );
                        ?>
                    </div>

                    <?php if ('0' === $comment->comment_approved) : ?>
                        <em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
                        <br />
                    <?php endif; ?>

                    <div class="comment-meta commentmetadata">
                        <?php
                        printf(
                            '<a href="%s">%s</a>',
                            esc_url(get_comment_link($comment, $args)),
                            sprintf(
                                /* translators: 1: Comment date, 2: Comment time. */
                                __('%1$s at %2$s'),
                                get_comment_date('', $comment),
                                get_comment_time()
                            )
                        );

                        edit_comment_link(__('(Edit)'), ' &nbsp;&nbsp;', '');
                        ?>
                    </div>

                    <?php
                    comment_text(
                        $comment,
                        array_merge(
                            $args,
                            array(
                                'add_below' => $add_below,
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                            )
                        )
                    );
                    ?>

                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'add_below' => $add_below,
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                                'before'    => '<div class="reply">',
                                'after'     => '</div>',
                            )
                        )
                    );
                    ?>

                    <?php if ('div' !== $args['style']) : ?>
                    </div>
                <?php endif; ?>
            </<?php echo $tag; ?>>
        <?php
    }


    /**
     * Outputs a comment in the HTML5 format.
     *
     * @since 3.6.0
     *
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment Comment to display.
     * @param int        $depth   Depth of the current comment.
     * @param array      $args    An array of arguments.
     */
    protected function html5_comment($comment, $depth, $args)
    {
        $tag = ('div' === $args['style']) ? 'div' : 'li';

        $commenter          = wp_get_current_commenter();
        $show_pending_links = !empty($commenter['comment_author']);

        if ($commenter['comment_author_email']) {
            $moderation_note = __('Your comment is awaiting moderation.');
        } else {
            $moderation_note = __('Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.');
        }
        ?>
            <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'parent' : '', $comment); ?>>
                <article id="div-comment-<?php comment_ID(); ?>" class="media d-block d-sm-flex mb-5">
                    <?php
                    if (0 !== $args['avatar_size']) {
                        echo get_avatar($comment, $args['avatar_size'], 'mystery', '', array(
                            'class' => 'img-fluid d-flex mr-4 rounded mb-3 mb-sm-0'
                        ));
                    }
                    ?>
                    <footer>
                        <?php
                        $comment_author = get_comment_author_link($comment);

                        if ('0' === $comment->comment_approved && !$show_pending_links) {
                            $comment_author = get_comment_author($comment);
                        }

                        printf(
                            /* translators: %s: Comment author link. */
                            __('%s'),
                            sprintf('<h5>%s</h5>', $comment_author)
                        );
                        ?>

                        <div class="comment-metadata">
                            <?php
                            printf(
                                '<a href="%s" class="text-muted"><time datetime="%s">%s</time></a>',
                                esc_url(get_comment_link($comment, $args)),
                                get_comment_time('c'),
                                sprintf(
                                    /* translators: 1: Comment date, 2: Comment time. */
                                    __('%1$s at %2$s'),
                                    get_comment_date('j F Y', $comment),
                                    get_comment_time('')
                                )
                            );

                            edit_comment_link(__('Edit'), ' <span class="edit-link">', '</span>');
                            ?>
                        </div><!-- .comment-metadata -->

                        <?php if ('0' === $comment->comment_approved) : ?>
                            <em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
                        <?php endif; ?>

                        <div class="mt-2">
                            <?php comment_text(); ?>
                        </div><!-- .mt-2 -->

                        <?php
                        if ('1' === $comment->comment_approved || $show_pending_links) {
                            comment_reply_link(
                                array_merge(
                                    $args,
                                    array(
                                        'add_below' => 'div-comment',
                                        'depth'     => $depth,
                                        'max_depth' => $args['max_depth'],
                                        'before'    => '<div class="reply">',
                                        'after'     => '</div>',
                                        'reply_text' => __('Reply') . ' <i class="fa fa-reply"></i>',
                                    )
                                )
                            );
                        }
                        ?>
                    </footer><!-- .comment-meta -->

                </article><!-- .comment-body -->
        <?php
    }
}

// register new post type
add_action('init', 'my_service_init');

function my_service_init()
{
    register_post_type('service', [
        'labels'             => [
            'name'               => 'Services',
            'singular_name'      => 'Service',
            'add_new'            => 'Add new',
            'add_new_item'       => 'Add new service',
            'edit_item'          => 'Edit Service',
            'new_item'           => 'New service',
            'view_item'          => 'View service',
            'search_items'       => 'Find service',
            'not_found'          => 'No services found',
            'not_found_in_trash' => 'No services found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Services',
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'menu_icon'          => 'dashicons-cart',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt']
    ]);
}

add_action('init', 'my_partner_init');

// register partners
function my_partner_init()
{
    register_post_type('partner', [
        'labels'             => [
            'name'               => 'Partners',
            'singular_name'      => 'Partner',
            'add_new'            => 'Add new',
            'add_new_item'       => 'Add new partner',
            'edit_item'          => 'Edit Partner',
            'new_item'           => 'New partner',
            'view_item'          => 'View partner',
            'search_items'       => 'Find partner',
            'not_found'          => 'No partners found',
            'not_found_in_trash' => 'No partners found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Partners',
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'menu_icon'          => 'dashicons-businessperson',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'supports'           => ['thumbnail']
    ]);
}

add_action('init', 'my_testimonial_init');

// register testimonials
function my_testimonial_init()
{
    register_post_type('testimonial', [
        'labels'             => [
            'name'               => 'Testimonials',
            'singular_name'      => 'Testimonial',
            'add_new'            => 'Add new',
            'add_new_item'       => 'Add new testimonial',
            'edit_item'          => 'Edit Testimonial',
            'new_item'           => 'New testimonial',
            'view_item'          => 'View testimonial',
            'search_items'       => 'Find testimonial',
            'not_found'          => 'No testimonials found',
            'not_found_in_trash' => 'No testimonials found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Testimonials',
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'menu_icon'          => 'dashicons-format-status',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'supports'           => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields']
    ]);
}

add_action('init', 'my_price_init');

// register partner
function my_price_init()
{
    register_post_type('price', [
        'labels'             => [
            'name'               => 'Prices',
            'singular_name'      => 'Price',
            'add_new'            => 'Add new',
            'add_new_item'       => 'Add new price',
            'edit_item'          => 'Edit Price',
            'new_item'           => 'New price',
            'view_item'          => 'View price',
            'search_items'       => 'Find price',
            'not_found'          => 'No prices found',
            'not_found_in_trash' => 'No prices found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Prices',
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'menu_icon'          => 'dashicons-money-alt',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 8,
        'supports'           => ['title', 'thumbnail', 'excerpt', 'custom-fields']
    ]);
}

add_action('init', 'my_counter_init');

function my_counter_init()
{
    register_post_type('counter', [
        'labels'             => [
            'name'               => 'Counters',
            'singular_name'      => 'Counter',
            'add_new'            => 'Add new',
            'add_new_item'       => 'Add new counter',
            'edit_item'          => 'Edit Counter',
            'new_item'           => 'New counter',
            'view_item'          => 'View counter',
            'search_items'       => 'Find counter',
            'not_found'          => 'No counters found',
            'not_found_in_trash' => 'No counters found in trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Counters',
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'menu_icon'          => 'dashicons-performance',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 9,
        'supports'           => ['title', 'excerpt', 'custom-fields']
    ]);
}

add_action('wp_ajax_my_action', 'my_action_callback');
add_action('wp_ajax_nopriv_my_action', 'my_action_callback');

function my_action_callback()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # FIX: Replace this email with recipient email
        $mail_to = get_option('admin_email');

        # Sender Data
        $subject = trim($_POST["subject"]);
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $message = trim($_POST["message"]);

        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        # Mail Content
        $content = "Name: $name\n";
        $content .= "Email: $email\n\n";
        $content .= "Message:\n$message\n";

        # email headers.
        $headers = "From: $name <$email>";

        # Send the email.
        $success = wp_mail($mail_to, $subject, $content, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong, we couldn't send your message.";
        }
    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

    // exit is needed to ensure that the response contains nothing extra, only what the function returns
    wp_die();
}
