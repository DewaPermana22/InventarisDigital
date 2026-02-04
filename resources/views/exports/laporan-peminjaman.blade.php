<table>
    <thead>
        <tr>
            <th colspan="8" style="font-size: 16px; font-weight: bold;">LAPORAN PEMINJAMAN BARANG</th>
        </tr>
        <tr>
            <th colspan="8" style="font-size: 14px;">{{ $periode }}</th>
        </tr>
        <tr>
            <th colspan="8"></th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Nama Barang</th>
            <th>Keperluan</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Lama Pinjam (Hari)</th>
            <th>Petugas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjamans as $index => $peminjaman)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $peminjaman->peminjam?->name ?? '-' }}</td>
            <td>{{ $peminjaman->barang?->name ?? '-' }}</td>
            <td>{{ $peminjaman->keperluan ?? '-' }}</td>
            <td>{{ $peminjaman->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
            <td>{{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
            <td>{{ $peminjaman->tanggal_pinjam && $peminjaman->tanggal_kembali ? $peminjaman->tanggal_pinjam->diffInDays($peminjaman->tanggal_kembali) : '-' }}</td>
            <td>{{ $peminjaman->petugas?->name ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
