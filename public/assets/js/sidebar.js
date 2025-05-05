document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const toggleBtn = document.getElementById("chevron");


    if (toggleBtn) {
        const isCollapsed = localStorage.getItem("sidebar-collapsed") === "true";
        if (isCollapsed) {
            body.classList.add("sb-collapse");
        } else {
            body.classList.remove("sb-collapse");
        }

        toggleBtn.addEventListener("click", () => {
            body.classList.toggle("sb-collapse");
            const collapsed = body.classList.contains("sb-collapse");
            localStorage.setItem("sidebar-collapsed", collapsed);
        });
    } else {
        console.warn("Sidebar toggle button not found.");
    }
});