<?php get_header(); ?>
<p>this is page</p>
<?php if (have_posts()): while (have_posts()):the_post(); ?>
<?php the_title(); ?>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>