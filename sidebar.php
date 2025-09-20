<aside class="sidebar">
    <?php if (is_active_sidebar('right-sidebar')) : ?>
        <?php dynamic_sidebar('right-sidebar'); ?>
    <?php else: ?>
        <div class="frame-container sidebar-widget">
            <h4>Páginas</h4>
            <ul><?php wp_list_pages(array('title_li' => '')); ?></ul>
        </div>

        <div class="frame-container sidebar-widget">
            <h4>Archivos</h4>
            <ul><?php wp_get_archives(); ?></ul>
        </div>

        <div class="frame-container sidebar-widget">
            <h4>Categorías</h4>
            <ul><?php wp_list_categories(array('title_li' => '')); ?></ul>
        </div>
    <?php endif; ?>
</aside>