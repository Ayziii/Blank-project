This is our brand new Blabk Theme
<?php
$coffee_link = hs_give_me_coffee();

if ( ! is_wp_error( $coffee_link ) ) {
    echo '<a href="' . $coffee_link . '">Here is your coffee!</a>';
} else {
    echo 'Sorry, we couldn\'t get your coffee right now. Please try again later.';
}
?>


            <div class="entry-content">
                <?php display_kanye_quotes(); ?>
            </div>
        </article>
    </main>
</div>
