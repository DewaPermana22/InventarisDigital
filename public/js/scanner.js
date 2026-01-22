let html5QrcodeScanner = null;

function onScanSuccess(decodedText, decodedResult) {
    console.log("Code:", decodedText);

    const el = document.getElementById("reader");
    if (!el || !window.Livewire) return;

    const wireId = el.closest("[wire\\:id]")?.getAttribute("wire:id");
    if (!wireId) return;

    const livewire = Livewire.find(wireId);

    livewire.set("barcode", decodedText);

    html5QrcodeScanner.clear();
    livewire.dispatch("close-modal");
}

function onScanFailure(error) {
    // ignore
}

// 🔥 INIT SAAT MODAL TERBUKA
document.addEventListener("init-barcode-scanner", () => {
    if (!document.getElementById("reader")) return;

    // cegah dobel init
    if (html5QrcodeScanner) return;

    html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            facingMode: "user",
        },
        false,
    );

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
});
