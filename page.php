<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article class="frame-container">
    <h2><?php the_title(); ?></h2>
    <div class="entry-content">
        <?php the_content(); ?>
    </div>
</article>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
