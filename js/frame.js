document.addEventListener("DOMContentLoaded", function () {
    const frameSelectGlobal = document.getElementById("frameSelectGlobal");

    const frameUrlDefault = `${pokemonTheme.templateUrl}/img/frame_${pokemonTheme.defaultFrame}.png`;
    document.querySelectorAll(".frame-container").forEach(el => {
        el.style.borderImageSource = `url("${frameUrlDefault}")`;
    });

    if (frameSelectGlobal) {
        frameSelectGlobal.addEventListener("change", function () {
            const frameUrl = `url("${pokemonTheme.templateUrl}/img/frame_${this.value}.png")`;
            document.querySelectorAll(".frame-container").forEach(el => {
                el.style.borderImageSource = frameUrl;
            });
        });
    }

    const fontSelect = document.getElementById("fontSelect");
    const fontColor = document.getElementById("fontColor");
    const fontItalic = document.getElementById("fontItalic");

    function updateTypography() {
        document.querySelectorAll(".frame-container").forEach(el => {
            el.style.fontFamily = fontSelect.value;
            el.style.color = fontColor.value;
            el.style.fontStyle = fontItalic.checked ? "italic" : "normal";
        });
    }

    if (fontSelect) fontSelect.addEventListener("change", updateTypography);
    if (fontColor) fontColor.addEventListener("input", updateTypography);
    if (fontItalic) fontItalic.addEventListener("change", updateTypography);
});


