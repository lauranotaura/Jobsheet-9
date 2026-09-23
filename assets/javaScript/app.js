function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        
        if (!form.classList.contains("form-hapus")) return;

        const row = form.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        
        const yakin = confirm('Yakin ingin menghapus "' + nama.trim() + '"?');
        
        if (!yakin) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initHapusConfirm();
});