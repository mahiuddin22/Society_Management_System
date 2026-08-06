// ---------- Sidebar navigation ----------
// Every view is now its own HTML page. The sidebar anchors in each template
// point to the corresponding file, so the same script stays reusable.
const navItems = document.querySelectorAll(".nav-item");
const currentPanel = document
    .querySelector(".panel.active")
    ?.id?.replace("panel-", "");
if (currentPanel) {
    navItems.forEach((item) =>
        item.classList.toggle("active", item.dataset.panel === currentPanel),
    );
}

// On phones, the top bar is truly fixed. Measure it so the content always
// starts directly below it, including after fonts or the viewport changes.
const topbar = document.querySelector(".topbar");
const mobileTopbarMedia = window.matchMedia("(max-width: 991.98px)");
function syncMobileTopbarHeight() {
    if (topbar && mobileTopbarMedia.matches) {
        document.documentElement.style.setProperty(
            "--mobile-topbar-height",
            `${topbar.offsetHeight}px`,
        );
    }
}
syncMobileTopbarHeight();
window.addEventListener("resize", syncMobileTopbarHeight);
if (topbar && "ResizeObserver" in window)
    new ResizeObserver(syncMobileTopbarHeight).observe(topbar);

// ---------- Tabs (inline, cosmetic only in this prototype) ----------
document.querySelectorAll(".tabs-inline").forEach((group) => {
    group.querySelectorAll("button").forEach((btn) => {
        btn.addEventListener("click", () => {
            group
                .querySelectorAll("button")
                .forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");
        });
    });
});

// ---------- Date range preset -> fills from/to (illustrative only) ----------
const rangeFrom = document.getElementById("rangeFrom");
const rangeTo = document.getElementById("rangeTo");
const rangePreset = document.getElementById("rangePreset");
const applyRange = document.getElementById("applyRange");
rangePreset?.addEventListener("change", (e) => {
    const today = new Date("2026-07-23");
    const fmt = (d) => d.toISOString().slice(0, 10);
    let from = new Date(today);
    switch (e.target.value) {
        case "Today":
            from = today;
            break;
        case "This Week":
            from.setDate(today.getDate() - today.getDay());
            break;
        case "This Month":
            from = new Date(2026, 6, 1);
            break;
        case "This Year":
            from = new Date(2026, 0, 1);
            break;
        default:
            return; // custom: leave inputs editable
    }
    rangeFrom.value = fmt(from);
    rangeTo.value = fmt(today);
});
applyRange?.addEventListener("click", () => {
    // In the real app this re-queries the dashboard for rangeFrom.value..rangeTo.value
    document.getElementById("applyRange").textContent = "Applied ✓";
    setTimeout(() => {
        document.getElementById("applyRange").textContent = "Apply";
    }, 1200);
});

// ---------- Collection trend bar chart (hand-built SVG, no chart library) ----------
(function drawTrend() {
    const days = [
        ["1", 9, 2],
        ["3", 11, 1],
        ["5", 14, 3],
        ["7", 8, 4],
        ["9", 15, 2],
        ["11", 12, 1],
        ["13", 17, 3],
        ["15", 10, 2],
        ["17", 13, 5],
        ["19", 16, 1],
        ["21", 12, 3],
        ["23", 18.4, 0],
    ]; // [label, paid(k), due(k)]
    const g = document.getElementById("trendBars");
    if (!g) return;
    const x0 = 40,
        x1 = 630,
        top = 14,
        base = 180,
        maxK = 20;
    const bw = (x1 - x0) / days.length;
    const scaleY = (v) => base - (v / maxK) * (base - top);

    days.forEach((d, i) => {
        const [label, paid, due] = d;
        const cx = x0 + i * bw + bw / 2;
        const barW = Math.min(18, bw * 0.5);

        const yPaid = scaleY(paid);
        const rPaid = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "rect",
        );
        rPaid.setAttribute("x", cx - barW / 2);
        rPaid.setAttribute("y", yPaid);
        rPaid.setAttribute("width", barW);
        rPaid.setAttribute("height", base - yPaid);
        rPaid.setAttribute("fill", "#2b6242");
        rPaid.setAttribute("rx", 2);
        g.appendChild(rPaid);

        const yDue = scaleY(paid + due);
        const rDue = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "rect",
        );
        rDue.setAttribute("x", cx - barW / 2);
        rDue.setAttribute("y", yDue);
        rDue.setAttribute("width", barW);
        rDue.setAttribute("height", yPaid - yDue);
        rDue.setAttribute("fill", "#b8392c");
        rDue.setAttribute("rx", 2);
        g.appendChild(rDue);

        const t = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "text",
        );
        t.setAttribute("x", cx);
        t.setAttribute("y", 196);
        t.setAttribute("text-anchor", "middle");
        t.setAttribute("font-family", "IBM Plex Mono");
        t.setAttribute("font-size", "9");
        t.setAttribute("fill", "#a3a99c");
        t.textContent = label;
        g.appendChild(t);
    });
})();

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
