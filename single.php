<?php get_header(); ?>
<?php if (have_posts()): while (have_posts()):the_post(); ?>tween text-right">
<?php the_title(); ?>
<?php the_content(); ?>
<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>