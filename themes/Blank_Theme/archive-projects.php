<?php
get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        $projects_per_page = 6;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
            'post_type' => 'projects',
            'posts_per_page' => $projects_per_page,
            'paged' => $paged,
        );

        $projects_query = new WP_Query($args);

        if ($projects_query->have_posts()) :
            while ($projects_query->have_posts()) : $projects_query->the_post();
                // Display your project content here
                the_title('<h2>', '</h2>');
                the_content();
            endwhile;

            // Display pagination links
            the_posts_pagination(array(
                'prev_text' => __('Previous', 'text_domain'),
                'next_text' => __('Next', 'text_domain'),
            ));

            wp_reset_postdata();
        else :
            // If no projects are found, display a message
            echo '<p>No projects found.</p>';
        endif;
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
?>
