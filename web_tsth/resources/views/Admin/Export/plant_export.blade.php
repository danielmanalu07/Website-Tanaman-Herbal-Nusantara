<style>
    table,
    th,
    td {
        text-align: center;
    }
</style>

<table>
    <thead>
        <tr>
            <th><strong>No</strong></th>
            <th><strong>Nama</strong></th>
            <th><strong>Habitus</strong></th>
            <th><strong>Nama Latin</strong></th>
            <th><strong>Manfaat</strong></th>
            <th><strong>Ekologi</strong></th>
            <th><strong>Informasi Endemik</strong></th>
            <th><strong>Status</strong></th>
            <th><strong>QR Code</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($plants as $key => $plant)
            <tr style="text-align: center">
                <td>{{ $key + 1 }}</td>
                <td>{{ $plant->name }}</td>
                <td>{{ $plant->habitus['name'] }}</td>
                <td>{{ $plant->latin_name }}</td>
                <td>{!! strip_tags(preg_replace('/<(img|iframe|video)[^>]*>/i', '', $plant->advantage)) !!}</td>
                <td>{{ $plant->ecology }}</td>
                <td>{{ $plant->endemic_information }}</td>
                <td>{{ $plant->status ? 'Published' : 'Draft' }}</td>
                <td><img src="{{ $plant->qrcode }}" alt="Qr Code"></td>
            </tr>
        @endforeach
    </tbody>
</table>
