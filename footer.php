</main>

<footer class="frame-container footer-area" id="marco-footer">

    <p>
        &copy; 
        <?php 
        $start_year = get_theme_mod('pokemon_footer_start_year', '');
        $current_year = date('Y');
        if ($start_year && $start_year < $current_year) {
            echo esc_html($start_year . '–' . $current_year);
        } else {
            echo esc_html($current_year);
        }
        ?>
        <?php bloginfo('name'); ?> - 
        <?php echo esc_html(get_theme_mod('pokemon_footer_text', 'Todos los derechos reservados')); ?>
    </p>

    <!-- Marco global -->
    <div id="marco-global" style="margin-top:15px;">
        <p>Cambiar Marco de todo el sitio:</p>
        <label for="frameSelectGlobal">Marco/Ventana:</label>
        <select id="frameSelectGlobal">
            <?php for($i=1; $i<=10; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo $i===1?'selected':''; ?>>Marco <?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </div>

    <!-- Personalizar tipografía -->
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

    <!-- Widgets del footer -->
    <div class="footer-widgets" style="margin-top:20px;">
        <?php if (is_active_sidebar('footer-widget-area')) : ?>
            <?php dynamic_sidebar('footer-widget-area'); ?>
        <?php endif; ?>
    </div>

    <!-- Páginas / Archivos / Categorías -->
    <div style="margin-top:20px;">
        <label for="toggleFooterNavs">
            <input type="checkbox" id="toggleFooterNavs"> Mostrar Páginas / Archivos / Categorías
        </label>
    </div>

    <div class="footer-navs" id="footerNavs" style="margin-top:20px; display:none;">
        <h4>Páginas</h4>
        <ul><?php wp_list_pages(); ?></ul>

        <h4>Archivos</h4>
        <ul><?php wp_get_archives(); ?></ul>

        <h4>Categorías</h4>
        <ul><?php wp_list_categories(array('title_li' => '')); ?></ul>
    </div>

    <!-- Créditos -->
    <div class="site-credit" style="margin-top:20px;">
        Tema Pokémerald by Alejo
        <br>
        Tipografía <em>Pokémon Emerald</em> por 
        <a href="https://fontstruct.com/fontstructions/show/1975556" target="_blank">aztecwarrior28</a>, 
        licenciada bajo <a href="http://creativecommons.org/licenses/by-sa/3.0/" target="_blank">CC BY-SA 3.0</a>.
    </div>

</footer>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const frameSelect = document.getElementById('frameSelectGlobal');
    const fontSelect = document.getElementById('fontSelect');
    const fontColor = document.getElementById('fontColor');
    const fontItalic = document.getElementById('fontItalic');
    const toggleFooterNavs = document.getElementById('toggleFooterNavs');
    const footerNavs = document.getElementById('footerNavs');
    const body = document.body;

    function applyFrame(frameNumber) {
        document.querySelectorAll('.frame-container').forEach(el => {
            el.style.borderImageSource = `url('<?php echo get_template_directory_uri(); ?>/img/frame_${frameNumber}.png')`;
        });
    }
    const savedFrame = localStorage.getItem('pokemonFrame') || frameSelect.value;
    applyFrame(savedFrame);
    frameSelect.value = savedFrame;

    const savedFont = localStorage.getItem('pokemonFont') || fontSelect.value;
    body.style.fontFamily = savedFont;
    fontSelect.value = savedFont;

    const savedColor = localStorage.getItem('pokemonFontColor') || fontColor.value;
    body.style.color = savedColor;
    fontColor.value = savedColor;

    const savedItalic = localStorage.getItem('pokemonFontItalic') === 'true';
    if (savedItalic) body.style.fontStyle = 'italic';
    fontItalic.checked = savedItalic;

    const savedNavToggle = localStorage.getItem('pokemonFooterNavs') === 'true';
    footerNavs.style.display = savedNavToggle ? 'block' : 'none';
    toggleFooterNavs.checked = savedNavToggle;
    frameSelect.addEventListener('change', () => {
        localStorage.setItem('pokemonFrame', frameSelect.value);
        applyFrame(frameSelect.value);
    });

    fontSelect.addEventListener('change', () => {
        localStorage.setItem('pokemonFont', fontSelect.value);
        body.style.fontFamily = fontSelect.value;
    });

    fontColor.addEventListener('input', () => {
        localStorage.setItem('pokemonFontColor', fontColor.value);
        body.style.color = fontColor.value;
    });

    fontItalic.addEventListener('change', () => {
        localStorage.setItem('pokemonFontItalic', fontItalic.checked);
        body.style.fontStyle = fontItalic.checked ? 'italic' : 'normal';
    });

    toggleFooterNavs.addEventListener('change', () => {
        localStorage.setItem('pokemonFooterNavs', toggleFooterNavs.checked);
        footerNavs.style.display = toggleFooterNavs.checked ? 'block' : 'none';
    });
});
</script>

<?php wp_footer(); ?>
</body>
</html>