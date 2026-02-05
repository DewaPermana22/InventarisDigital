<div
    x-data
    x-init="$dispatch('init-barcode-scanner')">
    <div class="barcode-scanner-container" id="reader"></div>
</div>

<style>
    /* Minimalist Scanner */
    #reader {
        width: 100% !important;
        border-radius: 8px !important;
        overflow: hidden !important;
        background: #fff !important;
    }

    #reader video {
        border-radius: 8px 8px 0 0 !important;
    }

    #reader__scan_region img {
        border: 2px solid #000 !important;
        border-radius: 4px !important;
    }

    #reader__dashboard {
        background: #f9fafb !important;
        padding: 12px !important;

    }

    button,
    select {
        font-family: system-ui, -apple-system, sans-serif !important;
    }

    button#html5-qrcode-button-camera-start,
    button#html5-qrcode-button-camera-stop {
        background: #000 !important;
        color: #fff !important;
        border: none !important;
        padding: 8px 16px !important;
        border-radius: 4px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        margin-top: 20px;
    }

    button#html5-qrcode-button-camera-start:hover,
    button#html5-qrcode-button-camera-stop:hover {
        background: #333 !important;

    }

    select#html5-qrcode-select-camera {
        background: #fff !important;
        border: 1px solid #d1d5db !important;
        padding: 6px 10px !important;
        border-radius: 4px !important;
        font-size: 13px !important;
    }

    #reader__dashboard_section_csr,
    #reader__status_span {
        font-size: 13px !important;
        color: #6b7280 !important;
    }
</style>