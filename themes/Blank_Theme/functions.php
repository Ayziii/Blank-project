<?php
    
    function custom_post_type_projects()
    {
    //Project Post Type
       register_post_type('Projects', array(
           'show_in_rest' => true,
           'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'projetcs'),
        'public' => true,
        'has_archive' => true,
    'labels' => array(
    'name' => 'Projects',
    'add_new_item' => 'Add New Projects',
    'edit_item' => 'Edit Projects',
    'all_items' => 'All Projects',
    'singular_name' => 'Projects'
    
    ),
    'menu_icon' => 'dashicons-project'
    
    
       ));
    }
add_action('init', 'custom_post_type_projects', 0);

function custom_taxonomy_project_type() {
    $labels = array(
        'name'                       => _x('Project Types', 'Taxonomy General Name', 'text_domain'),
        'add_new_item'               => __('Add New Project Type', 'text_domain'),
        'edit_item'                  => __('Edit Project Type', 'text_domain'),
        'all_items'                  => __('All Project Types', 'text_domain'),
        'update_item'                => __('Update Project Type', 'text_domain'),
        'view_item'                  => __('View Project Type', 'text_domain'),
        'separate_items_with_commas' => __('Separate project types with commas', 'text_domain'),
        'add_or_remove_items'        => __('Add or remove project types', 'text_domain'),
        'choose_from_most_used'      => __('Choose from the most used', 'text_domain'),
        'popular_items'              => __('Popular Project Types', 'text_domain'),
        'search_items'               => __('Search Project Types', 'text_domain'),
        'not_found'                  => __('Not Found', 'text_domain'),
        'no_terms'                   => __('No project types', 'text_domain'),
        'items_list'                 => __('Project types list', 'text_domain'),
        'items_list_navigation'      => __('Project types list navigation', 'text_domain'),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
    );
    register_taxonomy('project_type', array('projects'), $args);
}
add_action('init', 'custom_taxonomy_project_type', 0);



/**
 * Function to get a direct link to a cup of coffee from Random Coffee API.
 *
 * @return string|WP_Error The direct link to a cup of coffee, or WP_Error on failure.
 */
function hs_give_me_coffee() {
    // The URL of the Random Coffee API
    $api_url = 'https://coffee.alexflipnote.dev/random.json';

    // Make the HTTP request to the Random Coffee API
    $response = wp_remote_get( $api_url );

    // Check if the request was successful
    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        // If the request failed, return an error or handle it accordingly
        return new WP_Error( 'coffee_api_error', 'Failed to fetch coffee link.' );
    }

    // Parse the JSON response
    $coffee_data = json_decode( wp_remote_retrieve_body( $response ), true );

    // Check if the JSON data was properly decoded
    if ( ! is_array( $coffee_data ) ) {
        return new WP_Error( 'coffee_api_error', 'Invalid coffee data received.' );
    }

    // Assuming the API response contains a "file" field with the direct link to the coffee
    if ( isset( $coffee_data['file'] ) && ! empty( $coffee_data['file'] ) ) {
        // Return the direct link to the coffee
        return esc_url( $coffee_data['file'] );
    } else {
        return new WP_Error( 'coffee_api_error', 'Coffee link not found in API response.' );
    }
}
/**
 * Function to fetch Kanye West quotes from the API.
 *
 * @param int $number_of_quotes Number of quotes to fetch.
 * @return array|WP_Error An array of Kanye West quotes, or WP_Error on failure.
 */
function get_kanye_quotes( $number_of_quotes = 5 ) {
    $api_url = 'https://api.kanye.rest/';
    $quotes = array();

    // Fetch quotes one by one
    for ( $i = 0; $i < $number_of_quotes; $i++ ) {
        $response = wp_remote_get( $api_url );

        // Check if the request was successful
        if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
            // Parse the JSON response
            $quote_data = json_decode( wp_remote_retrieve_body( $response ), true );

            // Check if the JSON data was properly decoded
            if ( is_array( $quote_data ) && ! empty( $quote_data['quote'] ) ) {
                // Add the quote to the array
                $quotes[] = $quote_data['quote'];
            }
        }
    }

    // Check if we fetched enough quotes
    if ( count( $quotes ) >= $number_of_quotes ) {
        return $quotes;
    } else {
        return new WP_Error( 'kanye_api_error', 'Failed to fetch enough Kanye quotes.' );
    }
}

/**
 * Function to display Kanye West quotes on the page.
 */
function display_kanye_quotes() {
    $number_of_quotes = 5;
    $quotes = get_kanye_quotes( $number_of_quotes );

    if ( is_wp_error( $quotes ) ) {
        echo 'Sorry, we couldn\'t fetch Kanye quotes right now. Please try again later.';
        return;
    }

    echo '<h2>Kanye West Quotes</h2>';
    echo '<ul>';
    foreach ( $quotes as $quote ) {
        echo '<li>' . esc_html( $quote ) . '</li>';
    }
    echo '</ul>';
}

?>