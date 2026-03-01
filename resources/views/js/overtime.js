/**
 * overtime.js
 * Semua logika halaman Overtime Requests.
 * Nilai PHP (route, csrf) dibaca dari data-attribute HTML — bukan dari Blade syntax.
 *
 * Letakkan file ini di: resources/js/overtime.js
 * Daftarkan di vite.config.js jika perlu, atau sudah ter-include lewat app.js
 */

document.addEventListener("DOMContentLoaded", function () {
    // ── Baca nilai PHP dari data-attribute ────────────────
    var pageData = document.getElementById("overtime-page-data");
    var storeRoute = pageData ? pageData.dataset.storeRoute : "";
    var csrfToken = pageData ? pageData.dataset.csrf : "";

    // ── Element references ─────────────────────────────────
    var otModal = document.getElementById("overtime-modal");
    var otModalPanel = document.getElementById("ot-modal-panel");
    var overtimeForm = document.getElementById("overtime-form");
    var proofUpload = document.getElementById("proof-upload");
    var uploadLabelText = document.getElementById("upload-label-text");
    var dropdownWrapper = document.getElementById("activity-dropdown-wrapper");
    var dropdown = document.getElementById("activity-dropdown");
    var chevron = document.getElementById("activity-chevron");
    var filterLabel = document.getElementById("activity-filter-label");
    var filterEmptyState = document.getElementById("filter-empty-state");

    var dropdownOpen = false;

    // ════════════════════════════════════════════════════════
    // MODAL
    // ════════════════════════════════════════════════════════

    window.openOvertimeModal = function () {
        otModal.classList.remove("hidden");
        document.body.style.overflow = "hidden";
        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                otModalPanel.classList.remove("translate-y-4", "opacity-0");
                otModalPanel.classList.add("translate-y-0", "opacity-100");
            });
        });
    };

    window.closeOvertimeModal = function () {
        otModalPanel.classList.remove("translate-y-0", "opacity-100");
        otModalPanel.classList.add("translate-y-4", "opacity-0");
        setTimeout(function () {
            otModal.classList.add("hidden");
            document.body.style.overflow = "";
            overtimeForm.reset();
            uploadLabelText.innerHTML =
                '<p class="text-sm font-black text-zinc-900">Upload Proof</p>' +
                '<p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-0.5">JPG, PNG &bull; MAX 5MB</p>';
        }, 200);
    };

    // Submit form via fetch
    if (overtimeForm) {
        overtimeForm.addEventListener("submit", function (e) {
            e.preventDefault();
            fetch(storeRoute, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
                body: new FormData(overtimeForm),
            })
                .then(function (res) {
                    return res.json();
                })
                .then(function () {
                    window.closeOvertimeModal();
                    location.reload();
                })
                .catch(function (err) {
                    console.error("Submit error:", err);
                    alert("Gagal mengirim. Silakan coba lagi.");
                });
        });
    }

    // File upload preview
    if (proofUpload) {
        proofUpload.addEventListener("change", function () {
            if (!this.files || !this.files[0]) return;
            var file = this.files[0];
            if (file.size > 5 * 1024 * 1024) {
                alert("File terlalu besar. Maksimal 5MB.");
                this.value = "";
                return;
            }
            uploadLabelText.innerHTML =
                '<p class="text-sm font-black text-emerald-600">\u2713 ' +
                file.name +
                "</p>" +
                '<p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-0.5">Siap diupload</p>';
        });
    }

    // Tutup modal dengan ESC
    document.addEventListener("keydown", function (e) {
        if (
            e.key === "Escape" &&
            otModal &&
            !otModal.classList.contains("hidden")
        ) {
            window.closeOvertimeModal();
        }
    });

    // ════════════════════════════════════════════════════════
    // RECENT ACTIVITY FILTER DROPDOWN
    // ════════════════════════════════════════════════════════

    window.toggleActivityDropdown = function () {
        dropdownOpen = !dropdownOpen;
        if (dropdownOpen) {
            dropdown.classList.remove(
                "opacity-0",
                "invisible",
                "translate-y-1",
            );
            dropdown.classList.add("opacity-100", "visible", "translate-y-0");
            chevron.style.transform = "rotate(180deg)";
        } else {
            closeActivityDropdown();
        }
    };

    function closeActivityDropdown() {
        dropdownOpen = false;
        if (!dropdown) return;
        dropdown.classList.add("opacity-0", "invisible", "translate-y-1");
        dropdown.classList.remove("opacity-100", "visible", "translate-y-0");
        if (chevron) chevron.style.transform = "";
    }

    window.filterByStatus = function (status, label) {
        if (filterLabel) filterLabel.textContent = label;
        closeActivityDropdown();

        var rows = document.querySelectorAll(".ot-row");
        var visible = 0;

        rows.forEach(function (row) {
            if (status === "all" || row.dataset.status === status) {
                row.classList.remove("hidden");
                visible++;
            } else {
                row.classList.add("hidden");
            }
        });

        document.querySelectorAll(".filter-option").forEach(function (btn) {
            if (btn.dataset.filter === status) {
                btn.classList.add("bg-purple-50", "text-purple-700");
            } else {
                btn.classList.remove("bg-purple-50", "text-purple-700");
            }
        });

        if (filterEmptyState) {
            filterEmptyState.classList.toggle("hidden", visible > 0);
        }
    };

    // Tutup dropdown klik di luar
    document.addEventListener("click", function (e) {
        if (dropdownWrapper && !dropdownWrapper.contains(e.target)) {
            closeActivityDropdown();
        }
    });
});
