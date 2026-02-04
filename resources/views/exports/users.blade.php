<table>
    <thead>
        <tr>
            <th colspan="7" style="font-size: 16px; font-weight: bold;">DATA PENGGUNA SISTEM</th>
        </tr>
        <tr>
            <th colspan="7" style="font-size: 14px;">{{ $filter }}</th>
        </tr>
        <tr>
            <th colspan="7"></th>
        </tr>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Tanggal Bergabung</th>
            <th>Role</th>
            <th>Status</th>
            <th>Password Default</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $index => $user)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('d-m-Y') }}</td>
            <td>{{ $user->role->value }}</td>
            <td>{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</td>
            <td>{{ strtolower($user->role->value) }}-12345</td>
        </tr>
        @endforeach
    </tbody>
</table>
