<table border="1">
    <thead>
        <tr>
            <th colspan="9">LAPORAN PEMINJAMAN BARANG</th>
        </tr>
        <tr>
            <th colspan="9">Sistem Inventaris Digital</th>
        </tr>
        <tr>
            <th colspan="9">Periode: {{ $periode }}</th>
        </tr>
        <tr>
            <th colspan="9"></th>
        </tr>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Nama Peminjam</th>
            <th>Nama Petugas</th>
            <th>Keperluan</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Disetujui</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peminjamans as $item)
            <tr>
                <td>{{ $item->barang->kode_barang ?? '-' }}</td>
                <td>{{ $item->barang->name ?? '-' }}</td>
                <td>{{ $item->peminjam->name ?? '-' }}</td>
                <td>{{ $item->petugas->name ?? '-' }}</td>
                <td>{{ $item->keperluan }}</td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>{{ $item->tanggal_disetujui }}</td>
                <td>{{ $item->tanggal_kembali }}</td>
                <td>{{ $item->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
