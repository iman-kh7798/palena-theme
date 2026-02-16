<?php get_header(); ?>
<?php if (function_exists('yoast_breadcrumb')) :
    ?>
    <div class="container-fluid navbar_dark">
        <?php
        yoast_breadcrumb('<p id="breadcrumbs"  class="container navbar_dark breadcrumb-item active pt-2 pb-2">', '</p>');
        ?>
    </div>
<?php
endif; ?>
	<div class="container-fluid mt-4">

		<div class="row">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>
					<div class="col-12" >
						<h5 class=" page_title_about px-4 py-3"><?php the_title(); ?></h5>
						<div class="content">
							<?php the_content(); ?>
						</div>
					</div>
				<?php endwhile; else: ?>
			<?php endif; ?>
		</div>
	</div>
<?php get_footer();

