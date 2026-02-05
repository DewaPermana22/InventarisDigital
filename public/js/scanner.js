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
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.85);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        border-radius: 12px;
    `;

    overlay.innerHTML = `
        <div style="text-align: center; color: white;">
            <div style="
                width: 48px;
                height: 48px;
                margin: 0 auto 16px;
                border: 4px solid rgba(255, 255, 255, 0.3);
                border-top-color: white;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            "></div>
            <p style="
                font-size: 16px;
                font-weight: 600;
                margin: 0;
                color: white;
            ">${message}</p>
        </div>
        <style>
            @keyframes spin {
                to { transform: rotate(360deg); }
            }
        </style>
    `;

    reader.style.position = "relative";
    reader.appendChild(overlay);
}

function hideLoadingOverlay() {
    const overlay = document.getElementById("scan-loading-overlay");
    if (overlay) overlay.remove();
    isProcessing = false;
}

function onScanSuccess(decodedText, decodedResult) {
    if (isProcessing) {
        console.log("⏳ Already processing...");
        return;
    }

    isProcessing = true;
    console.log("✅ Scanned:", decodedText);

    showLoadingOverlay("Sedang memproses kode barang...");

    fetch("/scan-barcode", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify({ barcode: decodedText }),
    })
        .then((response) => response.json())
        .then((data) => console.log("Backend response:", data))
        .catch((error) => {
            console.error("Scan error:", error);
            hideLoadingOverlay();
        });

    Livewire.dispatch("barcodeScannedRealtime", decodedText);
}

function onScanFailure(error) {
    // Scanner tetap berjalan
}

document.addEventListener("init-barcode-scanner", () => {
    console.log("🎥 Initializing scanner...");

    if (!document.getElementById("reader")) {
        console.warn("Reader element not found");
        return;
    }

    if (html5QrcodeScanner) {
        console.log("Scanner already initialized");
        return;
    }

    isProcessing = false;

    html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            facingMode: "environment",
        },
        false,
    );

    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    console.log("Scanner ready");
});

window.addEventListener("scan-processed", (event) => {
    console.log("✅ Processed:", event.detail);
    hideLoadingOverlay();

    // Success overlay dengan icon
    const reader = document.getElementById("reader");
    if (!reader) return;

    const successOverlay = document.createElement("div");
    successOverlay.id = "scan-loading-overlay";
    successOverlay.style.cssText = `
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(16, 185, 129, 0.95);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        border-radius: 12px;
        animation: fadeIn 0.3s ease-in-out;
    `;

    successOverlay.innerHTML = `
        <div style="text-align: center; color: white;">
            <svg style="
                width: 64px;
                height: 64px;
                margin: 0 auto 16px;
                animation: checkmark 0.5s ease-in-out;
            " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
            <p style="
                font-size: 18px;
                font-weight: 700;
                margin: 0;
                color: white;
            ">✅ Berhasil Diproses!</p>
        </div>
        <style>
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes checkmark {
                0% { transform: scale(0); }
                50% { transform: scale(1.2); }
                100% { transform: scale(1); }
            }
        </style>
    `;

    reader.appendChild(successOverlay);
    setTimeout(() => successOverlay.remove(), 1500);
});

window.addEventListener("scan-error", (event) => {
    console.log("❌ Error:", event.detail);
    hideLoadingOverlay();

    // Error overlay dengan icon
    const reader = document.getElementById("reader");
    if (!reader) return;

    const errorOverlay = document.createElement("div");
    errorOverlay.id = "scan-loading-overlay";
    errorOverlay.style.cssText = `
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(239, 68, 68, 0.95);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        border-radius: 12px;
        animation: shake 0.5s ease-in-out;
    `;

    errorOverlay.innerHTML = `
        <div style="text-align: center; color: white;">
            <svg style="
                width: 64px;
                height: 64px;
                margin: 0 auto 16px;
            " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <p style="
                font-size: 16px;
                font-weight: 700;
                margin: 0;
                color: white;
            ">❌ ${event.detail.message}</p>
        </div>
        <style>
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
        </style>
    `;

    reader.appendChild(errorOverlay);
    setTimeout(() => errorOverlay.remove(), 2000);
});

window.addEventListener("cleanup-scanner", () => {
    console.log("🧹 Cleaning up...");
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear().then(() => {
            html5QrcodeScanner = null;
            isProcessing = false;
        });
    }
});

document.addEventListener("livewire:navigated", function () {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear();
        html5QrcodeScanner = null;
    }
    isProcessing = false;
});
