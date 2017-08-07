<?php get_header(); ?>

<?php the_content(); ?>
	<main id="content" class="content">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content();  

		endwhile; ?>
		
	</main>
<?php get_footer(); ?>