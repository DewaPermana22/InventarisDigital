let html5QrcodeScanner = null;
let isProcessing = false;

function showLoadingOverlay(message = "Sedang memproses...") {
    const reader = document.getElementById("reader");
    if (!reader) return;

    const existingOverlay = document.getElementById("scan-loading-overlay");
    if (existingOverlay) existingOverlay.remove();

    const overlay = document.createElement("div");
    overlay.id = "scan-loading-overlay";
    overlay.style.cssText = `
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.85); display: flex; flex-direction: column;
        align-items: center; justify-content: center; z-index: 9999; border-radius: 12px;
    `;

    overlay.innerHTML = `
        <div style="text-align: center; color: white;">
            <div style="width: 48px; height: 48px; margin: 0 auto 16px; border: 4px solid rgba(255, 255, 255, 0.3); border-top-color: white; border-radius: 50%; animation: spin 1s linear infinite;"></div>
            <p style="font-size: 16px; font-weight: 600; margin: 0;">${message}</p>
        </div>
        <style>@keyframes spin { to { transform: rotate(360deg); } }</style>
    `;

    reader.style.position = "relative";
    reader.appendChild(overlay);
}

function hideLoadingOverlay() {
    const overlay = document.getElementById("scan-loading-overlay");
    if (overlay) overlay.remove();
    isProcessing = false;
}

function createStatusOverlay(type, message) {
    hideLoadingOverlay();
    const reader = document.getElementById("reader");
    if (!reader) return;

    const isSuccess = type === 'success';
    const overlay = document.createElement("div");
    overlay.id = "scan-status-overlay";
    overlay.style.cssText = `
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: ${isSuccess ? 'rgba(16, 185, 129, 0.95)' : 'rgba(239, 68, 68, 0.95)'};
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        z-index: 9999; border-radius: 12px; animation: ${isSuccess ? 'fadeIn 0.3s' : 'shake 0.5s'} ease-in-out;
    `;

    overlay.innerHTML = `
        <div style="text-align: center; color: white;">
            <svg style="width: 64px; height: 64px; margin: 0 auto 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${isSuccess
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>'}
            </svg>
            <p style="font-size: 16px; font-weight: 700; margin: 0;">${isSuccess ? 'Berhasil!' : message}</p>
        </div>
        <style>
            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-10px); } 75% { transform: translateX(10px); } }
        </style>
    `;

    reader.appendChild(overlay);
    setTimeout(() => overlay.remove(), isSuccess ? 1500 : 2000);
}

function onScanSuccess(decodedText) {
    if (isProcessing) return;

    isProcessing = true;
    showLoadingOverlay("Memproses...");

    fetch("/scan-barcode", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ barcode: decodedText }),
    }).catch(() => {
        // Silent catch for production
    });

    // Sync UI with Livewire
    Livewire.dispatch("barcodeScannedRealtime", { barcode: decodedText });
}

document.addEventListener("init-barcode-scanner", () => {
    if (!document.getElementById("reader") || html5QrcodeScanner) return;

    isProcessing = false;
    html5QrcodeScanner = new Html5QrcodeScanner("reader", {
        fps: 10,
        qrbox: { width: 250, height: 250 },
        facingMode: "environment",
    }, false);

    html5QrcodeScanner.render(onScanSuccess, () => {});
});

window.addEventListener("scan-processed", () => createStatusOverlay('success'));
window.addEventListener("scan-error", (event) => createStatusOverlay('error', event.detail.message));

window.addEventListener("cleanup-scanner", () => {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear().then(() => {
            html5QrcodeScanner = null;
            isProcessing = false;
        }).catch(() => {});
    }
});

document.addEventListener("livewire:navigated", () => {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear().catch(() => {});
        html5QrcodeScanner = null;
    }
    isProcessing = false;
});
