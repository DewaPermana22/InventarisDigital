<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Peminjam - InventarisDigital</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background-color: #ffffff;
            color: #334155;
        }

        .page-container {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            page-break-after: always;
        }

        /* ✅ Table Layout untuk Kartu */
        .cards-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 12mm 10mm;
        }

        .card-cell {
            width: 50%;
            padding: 0;
            vertical-align: top;
        }

        .card {
            width: 85.6mm;
            height: 54mm;
            position: relative;
            border: 1px solid #94a3b8;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
        }

        /* Header menggunakan table */
        .card-front-header {
            padding: 15px 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
            padding: 0;
        }

        .header-table .logo-cell {
            width: 24px;
            text-align: right;
        }

        .card-label {
            font-size: 7px;
            text-transform: uppercase;
            font-weight: 700;
            color: #94a3b8;
            letter-spacing: 0.1em;
            margin-bottom: 2px;
        }

        .logo-text {
            font-weight: 800;
            font-size: 14px;
            color: #6366f1;
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        .user-info {
            padding: 0 20px;
            margin-top: 5px;
        }

        .user-name {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .user-detail {
            font-size: 9px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .status-label {
            font-size: 6px;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 2px;
        }

        .status-value {
            font-size: 9px;
            font-weight: 600;
            color: #059669;
        }

        .status-dot {
            display: inline-block;
            width: 5px;
            height: 5px;
            background: #059669;
            border-radius: 50%;
            margin-right: 4px;
            vertical-align: middle;
        }

        .qr-wrapper {
            position: absolute;
            bottom: 15px;
            right: 20px;
            width: 45px;
            height: 45px;
            border: 1px solid #e2e8f0;
            padding: 2px;
        }

        .qr-wrapper img {
            width: 100%;
            height: 100%;
            display: block;
        }

        .id-badge {
            position: absolute;
            bottom: 15px;
            left: 20px;
            background: #f8fafc;
            padding: 4px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 9px;
            font-weight: 600;
            color: #475569;
        }

        /* Back Card Styles */
        .card-back-content {
            padding: 20px;
        }

        .rules-title {
            font-size: 10px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
            border-left: 3px solid #6366f1;
            padding-left: 8px;
            text-transform: uppercase;
        }

        .rules-list {
            list-style: none;
            font-size: 8px;
            line-height: 1.6;
            color: #475569;
            padding: 0;
            margin: 0;
        }

        .rules-list li {
            margin-bottom: 5px;
        }

        .rules-number {
            color: #6366f1;
            font-weight: 700;
            margin-right: 8px;
        }

        .logo-bottom {
            text-align: right;
            margin-top: 15px;
        }

        .logo-bottom img {
            height: 28px;
            opacity: 0.4;
        }

        .footer-back {
            position: absolute;
            bottom: 12px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 7px;
            color: #94a3b8;
        }

        /* Empty cell untuk spacing */
        .empty-cell {
            border: none !important;
        }
    </style>
</head>

<body>

    <!-- ========== HALAMAN DEPAN ========== -->
    @foreach ($users->chunk(8) as $pageChunk)
    <div class="page-container">
        <table class="cards-table">
            @foreach ($pageChunk->chunk(2) as $rowChunk)
            <tr>
                @foreach ($rowChunk as $user)
                <td class="card-cell">
                    <div class="card">
                        <!-- Header dengan Table -->
                        <div class="card-front-header">
                            <table class="header-table">
                                <tr>
                                    <td>
                                        <div class="card-label">Identity Card</div>
                                        <img src="{{ public_path('logo/inventarisdg_light.png') }}" style="height: 24px; width: auto; display: block;">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- User Info -->
                        <div class="user-info">
                            <div class="user-name">{{ strtoupper($user->name) }}</div>
                            <div class="user-detail">{{ $user->email }}</div>
                            <div class="user-detail">{{ $user->phone_number }}</div>

                            <div class="status-label">Status</div>
                            <div class="status-value">
                                <span class="status-dot"></span>Verified Member
                            </div>
                        </div>

                        <!-- ID Badge -->
                        <div class="id-badge">{{ $user->kode }}</div>

                        <!-- QR Code -->
                        <div class="qr-wrapper">
                            <img src="data:image/png;base64,{{ $user->barcode }}" alt="QR Code">
                        </div>
                    </div>
                </td>
                @endforeach

                {{-- Isi cell kosong jika ganjil --}}
                @if($rowChunk->count() == 1)
                <td class="card-cell empty-cell"></td>
                @endif
            </tr>
            @endforeach
        </table>
    </div>
    @endforeach

    <!-- ========== HALAMAN BELAKANG ========== -->
    @foreach ($users->chunk(8) as $pageChunk)
    <div class="page-container">
        <table class="cards-table">
            @foreach ($pageChunk->chunk(2) as $rowChunk)
            <tr>
                @foreach ($rowChunk as $user)
                <td class="card-cell">
                    <div class="card">
                        <div class="card-back-content">
                            <div class="rules-title">Ketentuan Penggunaan</div>

                            <ul class="rules-list">
                                <li><span class="rules-number">01</span> Kartu ini merupakan properti resmi InventarisDigital.</li>
                                <li><span class="rules-number">02</span> Wajib ditunjukkan saat proses peminjaman aset.</li>
                                <li><span class="rules-number">03</span> Segala kerusakan aset menjadi tanggung jawab pemegang kartu.</li>
                                <li><span class="rules-number">04</span> Jika ditemukan, mohon kembalikan ke kantor administrasi terdekat.</li>
                            </ul>

                            <div class="logo-bottom">
                                <!-- <img src="data:image/png;base64,{{ $logo }}" alt="Logo"> -->
                            </div>
                        </div>

                        <div class="footer-back">
                            inventarisdigital.web.id &bull; inventarisdigital@help.com
                        </div>
                    </div>
                </td>
                @endforeach

                {{-- Isi cell kosong jika ganjil --}}
                @if($rowChunk->count() == 1)
                <td class="card-cell empty-cell"></td>
                @endif
            </tr>
            @endforeach
        </table>
    </div>
    @endforeach

</body>

</html>
