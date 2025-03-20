@extends('component.main')
@section('menu')
    Home
@endsection
@section('title')
    Staff
@endsection
@section('icon')
    <i class="ph-users-three"></i>
@endsection
@push('resource')
    <script>
        $(document).ready(function() {
            $('#staffTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true
            });
        });
    </script>
    @if (Session::has('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    imageUrl: "https://cdn-icons-png.flaticon.com/512/190/190411.png",
                    imageWidth: 100,
                    imageHeight: 100,
                    imageAlt: "Checklist icon",
                    draggable: true
                });
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    icon: "error",
                });
            });
        </script>
    @endif
@endpush

@section('content')
    <div class="modal fade" id="formAddStaff" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Form Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('staff.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="full_name" id="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label><span class="text-danger">*</span>
                            <input type="number" class="form-control" name="phone" id="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label><span class="text-danger">*</span>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Jabatan</label><span class="text-danger">*</span>
                            <select name="role" id="role" class="form-control" required>
                                <option value="-">--- Pilih Jabatan ---</option>
                                <option value="koordinator">Koordinator</option>
                                <option value="agronom">Agronom</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>Staff Data</h1>
            <button class="btn btn-sm btn-primary" type="submit" data-bs-toggle="modal" data-bs-target="#formAddStaff">Add
                Staff</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="staffTable" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Phone</th>
                            <th>Jabatan</th>
                            <th>Active</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $key => $staff)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $staff->full_name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->username }}</td>
                                <td>{{ $staff->phone }}</td>
                                <td>{{ implode(', ', $staff->roles) }}</td>
                                <td>{{ $staff->active }}</td>
                                <td>{{ $staff->created_by }}</td>
                                <td>{{ $staff->created_at }}</td>
                                <td>{{ $staff->updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success"><i class="ph-eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-warning"><i class="ph-pencil"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger"><i class="ph-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
