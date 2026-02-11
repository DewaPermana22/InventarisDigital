<div class="bg-white p-8">
    <style>
        @media print {
            body {
                margin: 5mm;
            }

            .barcode-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                page-break-inside: avoid;
            }
        }

        .barcode-table {
            width: 100%;
            border-collapse: collapse;
        }

        .barcode-cell {
            width: 25%;
            padding: 8px;
            border: 1px solid #e5e7eb;
            text-align: center;
            vertical-align: top;
        }

        .barcode-img {
            max-width: 100%;
            height: auto;
            margin: 0 auto;
            display: block;
        }

        .barcode-code {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            font-size: 14px;
            font-weight: 600;
            margin: 8px 0 4px 0;
            color: #111827;
        }

        .barcode-info {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            font-size: 11px;
            color: #6b7280;
            line-height: 1.4;
        }
    </style>

    @if(count($barcodes) > 0)
    <table class="barcode-table">
        @foreach(array_chunk($barcodes, 4) as $chunk)
        <tr>
            @foreach($chunk as $barcode)
            <td class="barcode-cell">
                <img
                    src="{{ $barcode['barcode_image'] }}"
                    alt="Barcode {{ $barcode['kode_barang'] }}"
                    class="barcode-img">

                <div class="barcode-code">
                    {{ $barcode['kode_barang'] }}
                </div>

                <div class="barcode-info">
                    {{ $barcode['name'] }}<br>
                </div>
            </td>
            @endforeach

            @for($i = count($chunk); $i < 4; $i++)
                <td class="barcode-cell" style="border: none;"></td>
            @endfor
        </tr>
        @endforeach
    </table>
    @else
    <div style="border: 2px dashed #d1d5db; border-radius: 8px; padding: 40px; text-align: center; color: #9ca3af; font-family: sans-serif;">
        Tidak ada barcode untuk dicetak
    </div>
    @endif
</div>
