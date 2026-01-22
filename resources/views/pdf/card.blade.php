<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Peminjam - InventarisDigital</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #ffffff;
        }
    </style>
</head>

<body>

    <!-- ========================== HALAMAN DEPAN ========================== -->
    @foreach ($users->chunk(8) as $chunk)
    <div style="
        width: 210mm;
        height: 297mm;
        margin: 0;
        padding: 18mm 15mm;
        display: grid;
        grid-template-columns: repeat(2, 85.6mm);
        grid-template-rows: repeat(4, 54mm);
        gap: 10mm 12mm;
        justify-content: center;
        align-content: center;
        page-break-after: always;
    ">

        @foreach ($chunk as $user)
        <!-- CONTAINER DENGAN GARIS POTONG -->
        <div style="position: relative; width: 85.6mm; height: 54mm; margin-bottom: 10mm;">
            <!-- KARTU DEPAN -->
            <div style="
                border: 1px solid #94a3b8;
                width: 85.6mm;
                height: 54mm;
                background: #f8fafc;
                border-radius: 8px;
            ">
                <!-- Header Modern -->
                <div style="background: #4f46e5; border-radius: 8px 8px 0 0; padding: 8px 12px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="vertical-align: middle;">
                                <div style="font-size: 7px; color: #ffffff; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px;">Kartu Peminjam</div>
                                <div style="font-size: 12px; color: #ffffff; font-weight: 800; letter-spacing: 0.5px; margin-top: 2px;">InventarisDigital</div>
                            </td>
                            <td style="width: 20px; text-align: right; vertical-align: middle;">
                                <div style="width: 20px; height: 20px; background: #4f46e5; border-radius: 4px;"></div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Body - Foto & Info User -->
                <div style="padding: 10px 12px 32px 12px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 20mm; vertical-align: top; padding-right: 10px;">
                                <!-- Foto dengan Frame -->
                                <div>
                                    <img src="data:image/png;base64,{{ $user->photo_base64 }}"
                                        style="width: 18mm; height: 23mm; object-fit: cover; border-radius: 5px;">
                                </div>
                            </td>
                            <td style="vertical-align: top;">
                                <!-- Info User -->
                                <div style="margin-bottom: 6px;">
                                    <div style="font-size: 6px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Nama Lengkap</div>
                                    <div style="font-size: 10px; font-weight: 800; color: #0f172a; line-height: 1.3;">{{ $user->name }}</div>
                                </div>
                                <div style="margin-bottom: 6px;">
                                    <div style="font-size: 6px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Email</div>
                                    <div style="font-size: 8px; color: #334155; font-weight: 500; line-height: 1.2;">{{ $user->email }}</div>
                                </div>
                                <div>
                                    <div style="font-size: 6px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">ID Member</div>
                                    <div style="font-size: 8px; color: #334155; font-weight: 700; font-family: 'Courier New', monospace;">{{ $user->kode }}</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Barcode Area - Fixed ke Bottom -->
                <div style="
                    padding: 6px 12px;
                    background: #f8fafc;
                    border-top: 1px solid #e2e8f0;
                    text-align: center;
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    border-radius: 0 0 8px 8px;
                    width: 100%;
                ">
                    <img src="data:image/png;base64,{{ $user->barcode }}" style="height: 14px; margin-bottom: 2px; display: inline-block;">
                    <div style="font-size: 7px; font-family: 'Courier New', monospace; letter-spacing: 2px; font-weight: 900; color: #1e293b;">
                        {{ $user->kode }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    <!-- ========================== HALAMAN BELAKANG ========================== -->
    @foreach ($users->chunk(8) as $chunk)
    <div style="
        width: 210mm;
        height: 297mm;
        margin: 0;
        padding: 18mm 15mm;
        display: grid;
        grid-template-columns: repeat(2, 85.6mm);
        grid-template-rows: repeat(4, 54mm);
        gap: 10mm 12mm;
        justify-content: center;
        align-content: center;
        page-break-after: always;
    ">

        @foreach ($chunk as $user)
        <div style="position: relative; width: 85.6mm; height: 54mm; margin-bottom: 10mm;">

            <!-- KARTU BELAKANG -->
            <div style="
                width: 85.6mm;
                height: 54mm;
                background: #f8fafc;
                border-radius: 8px;
            ">
                <!-- Watermark Logo di Tengah -->
                <div style="
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 40mm;
                    opacity: 0.08;
                    z-index: 0;
                    pointer-events: none;
                ">
                    <img src="data:image/png;base64,{{ $logo }}" style="width: 100%; display: block;">
                </div>

                <div style="padding: 12px; z-index: 1; position: relative;">
                    <div style="font-size: 10px; font-weight: 800; color: #4f46e5; text-transform: uppercase; border-bottom: 1.5px solid #e2e8f0; padding-bottom: 5px; margin-bottom: 8px;">
                        Syarat & Ketentuan
                    </div>

                    <table style="width: 100%; border-collapse: collapse; font-size: 7.5px; line-height: 1.6; color: #334155;">
                        <tr>
                            <td style="width: 12px; vertical-align: top; color: #4f46e5; font-weight: 700;">1.</td>
                            <td style="padding-bottom: 3px;">Kartu ini wajib dibawa saat melakukan peminjaman/pengembalian barang.</td>
                        </tr>
                        <tr>
                            <td style="width: 12px; vertical-align: top; color: #4f46e5; font-weight: 700;">2.</td>
                            <td style="padding-bottom: 3px;">Peminjam bertanggung jawab penuh atas kerusakan atau kehilangan barang.</td>
                        </tr>
                        <tr>
                            <td style="width: 12px; vertical-align: top; color: #4f46e5; font-weight: 700;">3.</td>
                            <td style="padding-bottom: 3px;">Pengembalian yang melewati batas waktu akan dikenakan sanksi/denda.</td>
                        </tr>
                        <tr>
                            <td style="width: 12px; vertical-align: top; color: #4f46e5; font-weight: 700;">4.</td>
                            <td>Kartu ini tidak dapat dipindahtangankan kepada orang lain.</td>
                        </tr>
                    </table>
                </div>

                <!-- Footer Belakang - Fixed ke Bottom -->
                <div style="
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    width: 100%;
                    padding: 8px 12px;
                    text-align: center;
                    background: #f8fafc;
                    border-top: 1px solid #e2e8f0;
                    z-index: 1;
                ">
                    <div style="font-size: 7px; color: #94a3b8; font-weight: 600;">Hubungi Admin jika kartu hilang atau rusak.</div>
                    <div style="font-size: 7px; color: #4f46e5; font-weight: 800; margin-top: 2px;">www.inventarisdigital.com</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

</body>

</html>
