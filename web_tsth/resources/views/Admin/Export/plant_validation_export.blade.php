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
            <th><strong>Tanaman</strong></th>
            <th><strong>Validator</strong></th>
            <th><strong>Tanggal Validasi</strong></th>
            <th><strong>Kondisi Tanaman</strong></th>
            <th><strong>Tanggal Update</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($plant_validations as $key => $plant_validation)
            <tr style="text-align: center">
                <td>{{ $key + 1 }}</td>
                <td>{{ $plant_validation->plant['name'] }}</td>
                <td>{{ $plant_validation->validator['full_name'] }}</td>
                <td>{{ $plant_validation->date_validation }}</td>
                <td>{{ $plant_validation->condition }}</td>
                <td>{{ $plant_validation->updated_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
