const darkToggle = document.getElementById("darkModeToggle");
const darkIcon = document.getElementById("darkIcon");
const mainContainer = document.getElementById("mainContainer");
const header = document.getElementById("header");
const footer = document.getElementById("footer");
const body = document.body;
const sidebar = document.getElementById("sidebar");
const sidebarToggle = document.getElementById("sidebarToggle");

// ===== Apply saved dark mode on page load =====
document.addEventListener("DOMContentLoaded", () => {
    const isDarkMode = localStorage.getItem("darkMode") === "true";

    if (isDarkMode) {
        body.classList.add("dark-mode");
        header?.classList.add("dark");
        footer?.classList.add("dark");
        darkIcon?.classList.add("glow");
    }
});

// ===== Dark mode toggle =====
darkToggle.addEventListener("click", () => {
    const isDark = body.classList.toggle("dark-mode");

    header?.classList.toggle("dark", isDark);
    footer?.classList.toggle("dark", isDark);
    darkIcon?.classList.toggle("glow", isDark);

    localStorage.setItem("darkMode", isDark);
});

// ===== Load sidebar state from localStorage =====
document.addEventListener("DOMContentLoaded", () => {
    // ===== Load sidebar state from localStorage =====
    const sidebarState = localStorage.getItem("sidebarExpanded");

    if (sidebarState === "true") {
        sidebar.classList.add("expanded");
        mainContainer.classList.add("expanded");
    } else {
        sidebar.classList.remove("expanded");
        mainContainer.classList.remove("expanded");
    }

    // ===== Sidebar toggle =====
    sidebarToggle.addEventListener("click", () => {
        const isNowExpanded = sidebar.classList.toggle("expanded");
        mainContainer.classList.toggle("expanded", isNowExpanded);

        localStorage.setItem("sidebarExpanded", isNowExpanded);

        if (!isNowExpanded) {
            // Store open submenu keys
            const openMenus = [];
            document.querySelectorAll(".submenu.show").forEach((submenu) => {
                const key = submenu.getAttribute("data-menu-key");
                if (key) openMenus.push(key);
                submenu.classList.remove("show");
                submenu.style.maxHeight = "0";
            });
            localStorage.setItem("openSubmenus", JSON.stringify(openMenus));

            // Collapse toggles
            document.querySelectorAll(".toggle-submenu").forEach((toggle) => {
                toggle.classList.add("collapsed");
                toggle.classList.remove("active");
            });
        } else {
            // Restore submenus
            const openMenus = JSON.parse(
                localStorage.getItem("openSubmenus") || "[]"
            );

            document.querySelectorAll(".submenu").forEach((submenu) => {
                const key = submenu.getAttribute("data-menu-key");
                if (key && openMenus.includes(key)) {
                    submenu.classList.add("show");
                    submenu.style.maxHeight = submenu.scrollHeight + "px";

                    const toggle = submenu.previousElementSibling;
                    if (toggle && toggle.classList.contains("toggle-submenu")) {
                        toggle.classList.remove("collapsed");
                        toggle.classList.add("active");
                    }
                }
            });
        }
    });

    // ===== Sidebar hover expand =====
    sidebar.addEventListener("mouseenter", () => {
        if (!sidebar.classList.contains("expanded")) {
            sidebar.classList.add("expanded");
            sidebar.classList.remove("collapsed");

            const openMenus = JSON.parse(
                localStorage.getItem("openSubmenus") || "[]"
            );

            document.querySelectorAll(".submenu").forEach((submenu) => {
                const key = submenu.getAttribute("data-menu-key");
                if (key && openMenus.includes(key)) {
                    submenu.classList.add("show");
                    submenu.style.maxHeight = submenu.scrollHeight + "px";

                    const toggle = submenu.previousElementSibling;
                    if (toggle && toggle.classList.contains("toggle-submenu")) {
                        toggle.classList.remove("collapsed");
                        toggle.classList.add("active");
                    }
                }
            });
        }
    });

    // ===== Sidebar hover collapse =====
    sidebar.addEventListener("mouseleave", () => {
        if (
            !localStorage.getItem("sidebarExpanded") ||
            localStorage.getItem("sidebarExpanded") === "false"
        ) {
            sidebar.classList.remove("expanded");
            sidebar.classList.add("collapsed");

            const openMenus = [];
            document.querySelectorAll(".submenu.show").forEach((submenu) => {
                const key = submenu.getAttribute("data-menu-key");
                if (key) openMenus.push(key);
                submenu.classList.remove("show");
                submenu.style.maxHeight = "0";
            });
            localStorage.setItem("openSubmenus", JSON.stringify(openMenus));

            document.querySelectorAll(".toggle-submenu").forEach((toggle) => {
                toggle.classList.add("collapsed");
                toggle.classList.remove("active");
            });
        }
    });

    // ===== Submenu toggle =====
    document.querySelectorAll(".toggle-submenu").forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            if (!sidebar.classList.contains("expanded")) return;

            const submenu = this.nextElementSibling;
            const isOpen = submenu.classList.contains("show");

            // Close all submenus first
            document.querySelectorAll(".submenu.show").forEach((el) => {
                el.style.maxHeight = "0";
                el.classList.remove("show");
            });

            document.querySelectorAll(".toggle-submenu").forEach((el) => {
                el.classList.add("collapsed");
                el.classList.remove("active");
            });

            // Open clicked one
            if (!isOpen) {
                submenu.classList.add("show");
                submenu.style.maxHeight = submenu.scrollHeight + "px";
                this.classList.remove("collapsed");
                this.classList.add("active");
            }
        });
    });
});

// <===== for Datatable =====>
$(document).ready(function () {
    const heading = $("h4").first().text().trim();

    // Initialize DataTable and store the instance in a variable
    const table = $("#myTable").DataTable({
        dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>tip',
        scrollX: true,
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: "btn btn-dark btn-sm-tight",
                title: heading,
            },
            {
                extend: "pdfHtml5",
                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                className: "btn btn-dark btn-sm-tight",
                orientation: "portrait",
                pageSize: "A4",
                title: heading,
            },
            {
                extend: "print",
                text: '<i class="bi bi-printer"></i> Print',
                className: "btn btn-dark btn-sm-tight",
                title: heading,
            },
        ],
        language: {
            search: "",
            searchPlaceholder: "Search...",
        },
    });

    // <===== Sidebar toggle fix: adjust table columns after sidebar expands/collapses =====>
    const sidebarToggleBtn = document.getElementById("sidebarToggle");
    if (sidebarToggleBtn && typeof table !== "undefined" && table.columns) {
        sidebarToggleBtn.addEventListener("click", function () {
            setTimeout(function () {
                try {
                    table.columns.adjust();
                    if (
                        table.responsive &&
                        typeof table.responsive.recalc === "function"
                    ) {
                        table.responsive.recalc();
                    }
                } catch (error) {
                    console.warn("Table resize error:", error);
                }
            }, 300);
        });
    }
});

// <===== For Sweetalert2 =====>
document.addEventListener("DOMContentLoaded", function () {
    const deleteForms = document.querySelectorAll(".delete-form");

    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete!",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
});

// ==== For Modal Validation ====
(() => {
    "use strict";
    // Fetch the form we want to apply validation to
    const form = document.querySelector("#createUserForm");
    if (form) {
        form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add("was-validated");
            },
            false
        );
    }
})();

// <==== For Bootstrap 5 Toast ====>
document.addEventListener("DOMContentLoaded", () => {
    const toastEl = document.getElementById("liveToast");
    const toast = new bootstrap.Toast(toastEl, {
        delay: 3000, // 3 seconds
    });
    toast.show();
});

// Date Picker
$(document).ready(function () {
    $("#datePicker").flatpickr({
        dateFormat: "d-m-Y",
        altInput: true,
        altFormat: "d-m-Y",
        allowInput: true,
        clickOpens: true,
    });
});

// Date and Time Picker
$(document).ready(function () {
    $("#datetimePicker").flatpickr({
        dateFormat: "d-m-Y H:i",
        altInput: true,
        altFormat: "d-m-Y h:i K",
        allowInput: true,
        clickOpens: true,
        enableTime: true,
    });
});

// multiple Select
$("#multiSelect").select2({
    placeholder: "Select technologies",
    allowClear: true,
});

// Image Drag and Drop Upload
const dropArea = document.getElementById("dropArea");
const fileInput = document.getElementById("fileInput");
const imgPreview = document.getElementById("img-preview");

dropArea.addEventListener("click", () => fileInput.click());

function previewFile(file) {
    if (file && file.type.startsWith("image/")) {
        imgPreview.src = URL.createObjectURL(file);
        imgPreview.style.display = "block";
    }
}

fileInput.addEventListener("change", function () {
    previewFile(this.files[0]);
});

dropArea.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropArea.classList.add("dragover");
});

dropArea.addEventListener("dragleave", () => {
    dropArea.classList.remove("dragover");
});

dropArea.addEventListener("drop", (e) => {
    e.preventDefault();
    dropArea.classList.remove("dragover");
    const file = e.dataTransfer.files[0];
    fileInput.files = e.dataTransfer.files;
    previewFile(file);
});

// Bootstrap native validation
(() => {
    "use strict";
    const forms = document.querySelectorAll(".needs-validation");

    Array.from(forms).forEach((form) => {
        form.addEventListener(
            "submit",
            (event) => {
                // Validate editor content
                const editor = document.getElementById("editor");
                const editorValue = editor.value.trim();
                if (editorValue === "") {
                    editor.classList.add("is-invalid");
                } else {
                    editor.classList.remove("is-invalid");
                }

                // Validate file input
                const fileInput = document.getElementById("fileInput");
                if (!fileInput.files.length) {
                    fileInput.classList.add("is-invalid");
                } else {
                    fileInput.classList.remove("is-invalid");
                }

                if (
                    !form.checkValidity() ||
                    editorValue === "" ||
                    !fileInput.files.length
                ) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
        );
    });
})();
