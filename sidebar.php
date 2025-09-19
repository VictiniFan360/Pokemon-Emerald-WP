<aside class="sidebar">

    <div class="frame-container">
        <h4>Páginas</h4>
        <ul>
            <?php wp_list_pages(array('title_li' => '')); ?>
        </ul>
    </div>

    <div class="frame-container">
        <h4>Archivos</h4>
        <ul>
            <?php wp_get_archives(); ?>
        </ul>
    </div>

    <div class="frame-container">
        <h4>Categorías</h4>
        <ul>
            <?php wp_list_categories(array('title_li' => '')); ?>
        </ul>
    </div>

    <div class="frame-container">
        <h4>Meta</h4>
        <ul>
            <?php wp_register(); ?>
            <li><?php wp_loginout(); ?></li>
        </ul>
    </div>

</aside>