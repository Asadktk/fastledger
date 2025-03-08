<footer class="footer mt-auto py-3 bg-white text-center">
    <div class="container">
        <span class="text-muted"> Copyright © <span id="year"></span> <a href="javascript:void(0);"
                class="text-dark fw-medium">Mamix</a>. Designed with <span
                class="bi bi-heart-fill text-danger"></span> by
            <a href="javascript:void(0);">
                <span class="fw-medium text-primary">Spruko</span>
            </a> All rights reserved
        </span>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".open-ul").hover(
            function () {
                $(this).addClass("open");
                $(this).find(".slide-menu.child1").css("display", "block");
            },
            function () {
                $(this).removeClass("open");
                $(this).find(".slide-menu.child1").css("display", "none");
            }
        );
    });
    document.addEventListener("DOMContentLoaded", function () {
    let theme = localStorage.getItem("theme") || "light"; 
    document.body.classList.add(theme);

    // Example theme toggle button
    document.getElementById("theme-toggle").addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");
        let newTheme = document.body.classList.contains("dark-mode") ? "dark" : "light";
        localStorage.setItem("theme", newTheme);
    });
});
document.addEventListener("DOMContentLoaded", function () {
    let navLinks = document.querySelectorAll(".nav-link");

    navLinks.forEach(link => {
        link.addEventListener("click", function () {
            navLinks.forEach(l => l.classList.remove("active"));
            this.classList.add("active");
        });
    });
});

</script>

