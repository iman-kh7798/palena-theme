<?php

get_header(); ?>

    <main>
        <div class="container mt-4 text-center d-flex justify-content-center flex-column">
            <p class="mt-3">
                 404 Error
            </p>
                    <p class="mt-1">
                        Page Not Found
                    </p>
                    <p class="mt-3">
                    </p>
            <div class="d-flex justify-content-center mt-3">
                <a class="nav-link text-center" href="<?php echo esc_url( home_url( '' ) ); ?>">
                        Return to home page
                </a>
            </div>
                </div>

    </main>

<?php get_footer(); ?>