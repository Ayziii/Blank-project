<?php
/*
Template Name: Kanye Quotes Page
*/
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <?php display_kanye_quotes(); ?>
            </div>
        </article>
    </main>
</div>

<?php get_footer(); ?>
