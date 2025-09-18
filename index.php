<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article <?php post_class('frame-container'); ?> id="post-<?php the_ID(); ?>">
    <h2><?php the_title(); ?></h2>
    <div><?php the_content(); ?></div>
</article>
<?php endwhile; endif; ?>

<?php get_footer(); ?>

