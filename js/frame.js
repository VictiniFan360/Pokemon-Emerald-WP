document.addEventListener("DOMContentLoaded", function () {
    const frameSelectGlobal = document.getElementById("frameSelectGlobal");
    const fontSelect = document.getElementById("fontSelect");
    const fontColor = document.getElementById("fontColor");
    const fontItalic = document.getElementById("fontItalic");

    function applyFrame(frameNumber) {
        const frameUrl = `url("${pokemonTheme.templateUrl}/img/frame_${frameNumber}.png")`;
        document.querySelectorAll(".frame-container").forEach(el => {
            el.style.borderImageSource = frameUrl;
        });
    }

    function applyTypography() {
        document.querySelectorAll(".frame-container").forEach(el => {
            el.style.fontFamily = fontSelect.value;
            el.style.color = fontColor.value;
            el.style.fontStyle = fontItalic.checked ? "italic" : "normal";
        });
    }

    const savedFrame = localStorage.getItem("pokemonFrame") || pokemonTheme.defaultFrame;
    const savedFont = localStorage.getItem("pokemonFont") || (fontSelect ? fontSelect.value : "");
    const savedColor = localStorage.getItem("pokemonFontColor") || (fontColor ? fontColor.value : "#111111");
    const savedItalic = localStorage.getItem("pokemonFontItalic") === "true";

    applyFrame(savedFrame);
    if (frameSelectGlobal) frameSelectGlobal.value = savedFrame;

    if (fontSelect) fontSelect.value = savedFont;
    if (fontColor) fontColor.value = savedColor;
    if (fontItalic) fontItalic.checked = savedItalic;
    applyTypography();

    if (frameSelectGlobal) {
        frameSelectGlobal.addEventListener("change", function () {
            applyFrame(this.value);
            localStorage.setItem("pokemonFrame", this.value);
        });
    }

    if (fontSelect) fontSelect.addEventListener("change", function () {
        applyTypography();
        localStorage.setItem("pokemonFont", this.value);
    });

    if (fontColor) fontColor.addEventListener("input", function () {
        applyTypography();
        localStorage.setItem("pokemonFontColor", this.value);
    });

    if (fontItalic) fontItalic.addEventListener("change", function () {
        applyTypography();
        localStorage.setItem("pokemonFontItalic", this.checked);
    });
});




