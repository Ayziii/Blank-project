<?php
/*
Plugin Name: Architecture Projects Ajax
Description: Ajax endpoint to retrieve the last published projects of "Architecture" project type.
*/

function architecture_projects_ajax_init() {
    add_action('wp_ajax_nopriv_architecture_projects', 'architecture_projects_ajax_callback');
    add_action('wp_ajax_architecture_projects', 'architecture_projects_ajax_callback');
}
add_action('init', 'architecture_projects_ajax_init');

function architecture_projects_ajax_callback() {
    $response = array();

    // Check if the user is logged in
    $is_user_logged_in = is_user_logged_in();

    // Set the number of projects to retrieve based on user login status
    $projects_count = $is_user_logged_in ? 6 : 3;

    // Query arguments for the projects
    $args = array(
        'post_type'      => 'projects',
        'posts_per_page' => $projects_count,
        'tax_query'      => array(
            array(
                'taxonomy' => 'project_type',
                'field'    => 'slug',
                'terms'    => 'architecture',
            ),
        ),
    );

    // The query
    $projects_query = new WP_Query($args);

    if ($projects_query->have_posts()) {
        $projects = array();
        while ($projects_query->have_posts()) {
            $projects_query->the_post();
            $project_id = get_the_ID();
            $project_title = get_the_title();
            $project_link = get_permalink();

            // Create the project object
            $project_object = array(
                'id'    => $project_id,
                'title' => $project_title,
                'link'  => $project_link,
            );

            // Add the project object to the projects array
            $projects[] = $project_object;
        }

        // Restore original post data
        wp_reset_postdata();

        // Prepare the JSON response
        $response['success'] = true;
        $response['data'] = $projects;
    } else {
        // No projects found
        $response['success'] = false;
        $response['data'] = array();
    }

    // Return the JSON response
    wp_send_json($response);
}
