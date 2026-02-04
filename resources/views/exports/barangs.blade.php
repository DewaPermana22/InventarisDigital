<table>
    <thead>
        <tr>
            <th colspan="7" style="font-size: 16px; font-weight: bold;">DATA BARANG INVENTARIS</th>
        </tr>
        <tr>
            <th colspan="7" style="font-size: 14px;">Semua Data Barang</th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Ruangan</th>
            <th>Kondisi</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangs as $index => $barang)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $barang->kode_barang }}</td>
            <td>{{ $barang->name }}</td>
            <td>{{ $barang->category?->name ?? '-' }}</td>
            <td>{{ $barang->room?->name ?? '-' }}</td>
            <td>{{ $barang->kondisi->value }}</td>
            <td>{{ $barang->catatan ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
