</main>

<footer class="frame-container" id="marco-footer">

    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> - <?php echo esc_html(get_theme_mod('pokemon_footer_text', 'Todos los derechos reservados')); ?></p>

    <div id="marco-global">
        <p>Cambiar Marco de todo el sitio:</p>
        <label for="frameSelectGlobal">Marco/Ventana:</label>
        <select id="frameSelectGlobal">
            <?php for($i=1; $i<=10; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo $i===1?'selected':''; ?>>Marco <?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </div>

    <details style="margin-top:20px;">
        <summary>Personalizar Tipografía</summary>
        <div style="margin-top:10px;">
            <label for="fontSelect">Fuente:</label>
            <select id="fontSelect">
                <option value="'pokemon_emeraldregular', sans-serif" selected>Pokémon Emerald</option>
                <option value="Arial, sans-serif">Arial</option>
                <option value="Georgia, serif">Georgia</option>
                <option value="Courier New, monospace">Courier New</option>
            </select>

            <label for="fontColor">Color:</label>
            <input type="color" id="fontColor" value="#111111">

            <label for="fontItalic">
                <input type="checkbox" id="fontItalic"> Cursiva
            </label>
        </div>
    </details>

    <div class="footer-widgets">
        <?php if (is_active_sidebar('footer-widget-area')) : ?>
            <?php dynamic_sidebar('footer-widget-area'); ?>
        <?php endif; ?>
    </div>

    <div class="footer-navs">
        <h4>Páginas</h4>
        <ul><?php wp_list_pages(); ?></ul>

        <h4>Archivos</h4>
        <ul><?php wp_get_archives(); ?></ul>

        <h4>Categorías</h4>
        <ul><?php wp_list_categories(array('title_li' => '')); ?></ul>
    </div>

    <div class="site-credit">
        Tema Pokémemerald by Alejo
        <br>
        Tipografía <em>Pokémon Emerald</em> por 
        <a href="https://fontstruct.com/fontstructions/show/1975556" target="_blank">aztecwarrior28</a>, 
        licenciada bajo <a href="http://creativecommons.org/licenses/by-sa/3.0/" target="_blank">CC BY-SA 3.0</a>.
    </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>