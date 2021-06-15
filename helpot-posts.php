function helpot_posts_function($atts){

    // Using shortcode [helpot_posts post_type="post" taxonomy="category" terms="abc" posts_per_page="1"]
    // You can use multiple post types and taxonomy terms like [helpot_posts post_type="post, cpt" taxonomy="category" terms="abc, def"]

    // Shortcode attributes
    $atts = shortcode_atts(
        array(
            'post_type' => '', // Post type like post, page, cpt
            'taxonomy' => '', // If articles then category, if custom taxonomies then custom taxonomy type
            'terms' => '', // If articles then category name, if custom taxonomies then custom taxonomy name
            'posts_per_page' => '', // How many posts
            // 'your_own_att' => '',
        ),
        $atts,
        'helpot_posts' // Shortcode name
    );

    // Extracting shortcode attributes to $atts, you can use it like 'your_own_att' -> $your_own_att
    extract($atts);
  
    // Official WP_Query query args
    $args = array(
    'post_type' => explode(' ', $post_type),
    'posts_per_page' => $posts_per_page
    // 'x' => $your_own_att - Find all args here https://developer.wordpress.org/reference/classes/wp_query/
    );

    // If not term or taxonomy, loop posts anyway
    if ( $terms || $taxonomy ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => $taxonomy,
            'field' => 'slug',
            'terms' => explode(' ', $terms),
        ),
    );
    }
  
    // Defining what to return
    $return_string = '';

    // Initializing new WP_Query
    $query = new WP_Query( $args );

    if ($query->have_posts()) :

    $return_string .= '<ul>';

        while ($query->have_posts()) : $query->the_post();

        $return_string .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
        // $return_string .= ''; content na to
        
        endwhile;

    $return_string .= '</ul>';

    endif;

    wp_reset_postdata();

    // Output
    return $return_string;
}
add_shortcode('helpot_posts', 'helpot_posts_function'); // Shortcode name & function name
