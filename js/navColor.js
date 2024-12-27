document.addEventListener("DOMContentLoaded", () => {
    const currentPage = new URLSearchParams(window.location.search).get("page");

    const menuLinks = document.querySelectorAll(".nav-link");

    menuLinks.forEach(link => {
        const linkPage = new URL(link.href).searchParams.get("page");
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });
});