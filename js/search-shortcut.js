document.addEventListener("keydown", function(e) {
    if (e.ctrlKey && e.key.toLowerCase() === "f") {
        e.preventDefault();
        const searchContainer = document.getElementById("theme-search-container");
        if (searchContainer.style.display === "none") {
            searchContainer.style.display = "block";
            const input = searchContainer.querySelector(".search-field");
            input.focus();
        } else {
            searchContainer.style.display = "none";
        }
    }

    if (e.key === "Escape") {
        const searchContainer = document.getElementById("theme-search-container");
        if (searchContainer.style.display === "block") {
            searchContainer.style.display = "none";
        }
    }
});
