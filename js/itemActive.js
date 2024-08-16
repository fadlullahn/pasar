document.addEventListener("DOMContentLoaded", function() {
    const currentUrl = window.location.href;
    const currentUrlSidebar = window.location.href;

    const navItemsSidebar = {
        "": "dashboard",
        "page=users": "users",
        "page=pasar": "pasar",
        "page=sentral": "sentral",
         "page=mapbox": "mapbox"
    };

    const navItems = {
        "": "home",
        "?page=about": "about"
    };

    Object.keys(navItemsSidebar).forEach(key => {
        if (currentUrlSidebar.includes(key)) {
            const elementSidebar = document.getElementById(navItemsSidebar[key]);
            if (elementSidebar) {
                elementSidebar.classList.add("bg-gray-800", "text-white");
                elementSidebar.classList.remove("text-gray-400", "hover:text-white", "hover:bg-gray-800");
            }
        }
    });

    Object.keys(navItems).forEach(key => {
        if (currentUrl.includes(key)) {
            const element = document.getElementById(navItems[key]);
            if (element) {
                element.classList.add("border-b-2", "border-indigo-500", "text-gray-900");
                element.classList.remove("border-transparent");
            }
        }
    });
});