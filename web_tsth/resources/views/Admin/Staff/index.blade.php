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

            // Event handler untuk toggle switch
            $('.toggle-switch').on('change', function() {
                let staffId = $(this).data('id');
                openModal(staffId);
            });

            // Sinkronisasi status setelah modal ditutup
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    let staffId = this.getAttribute('id').replace('formUpdateStatusStaff', '');
                    let checkbox = document.querySelector(`input[data-id='${staffId}']`);
                    let statusInput = document.getElementById(`statusInput${staffId}`);
                    // Jika form belum disubmit (Cancel), kembalikan ke status awal
                    if (statusInput.dataset.submitted !== 'true') {
                        checkbox.checked = !checkbox.checked;
                    }
                });
            });

            // Set flag submitted saat form disubmit
            $('form[id^="updateStatusForm"]').on('submit', function() {
                let staffId = this.id.replace('updateStatusForm', '');
                let statusInput = document.getElementById(`statusInput${staffId}`);
                statusInput.dataset.submitted = 'true';
            });
        });

        function openModal(staffId) {
            let checkbox = document.querySelector(`input[data-id='${staffId}']`);
            let statusInput = document.getElementById(`statusInput${staffId}`);
            // Set status berdasarkan posisi checkbox: checked = 1 (true), unchecked = 0 (false)
            statusInput.value = checkbox.checked ? 1 : 0;
            // Reset flag submitted
            statusInput.dataset.submitted = 'false';

            let modalId = `#formUpdateStatusStaff${staffId}`;
            let modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
        }
    </script>
@endpush

@section('content')
    {{-- modal create --}}
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

    {{-- modal view --}}
    @foreach ($staffs as $staff)
        <div class="modal fade" id="detailStaff{{ $staff->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Detail Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Full Name: </strong> {{ $staff->full_name }}</p>
                        <p><strong>Email: </strong> {{ $staff->email }}</p>
                        <p><strong>Username: </strong> {{ $staff->username }}</p>
                        <p><strong>Phone: </strong> {{ $staff->phone }}</p>
                        <p><strong>Jabatan: </strong> {{ implode(', ', $staff->roles) }}</p>
                        <p><strong>Status: </strong> {{ $staff->active }}</p>
                        <p><strong>Created By: </strong> {{ $staff->created_by }}</p>
                        <p><strong>Created At: </strong> {{ $staff->created_at }}</p>
                        <p><strong>Updated At: </strong> {{ $staff->updated_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal edit --}}
    @foreach ($staffs as $staff)
        <div class="modal fade" id="updateStaff{{ $staff->id }}" tabindex="1" aria-label="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Form Update Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('staff.update', ['id' => $staff->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label><span
                                    class="text-danger"></span>
                                <input type="text" class="form-control" name="full_name" id="full_name"
                                    value="{{ $staff->full_name }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label><span class="text-danger"></span>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="{{ $staff->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label><span class="text-danger"></span>
                                <input type="number" class="form-control" name="phone" id="phone"
                                    value="{{ $staff->phone }}">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label><span
                                    class="text-danger"></span>
                                <input type="text" class="form-control" name="username" id="username"
                                    value="{{ $staff->username }}">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label><span
                                    class="text-danger"></span>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Jabatan</label><span
                                    class="text-danger">*</span>
                                <select name="role" id="role" class="form-control">
                                    <option value="koordinator"
                                        {{ in_array('koordinator', (array) $staff->roles) ? 'selected' : '' }}>Koordinator
                                    </option>
                                    <option value="agronom"
                                        {{ in_array('agronom', (array) $staff->roles) ? 'selected' : '' }}>Agronom</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal delete --}}
    @foreach ($staffs as $staff)
        <div class="modal fade" id="formDeleteStaff{{ $staff->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Hapus Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <form id="deleteStaff" method="POST"
                            action="{{ route('staff.delete', ['id' => $staff->id]) }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" id="deleteId">
                            <button type="submit" class="btn btn-success">Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal update status --}}
    @foreach ($staffs as $staff)
        <div class="modal fade" id="formUpdateStatusStaff{{ $staff->id }}" tabindex="-1"
            aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Update Status Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to update the status of this user?</p>
                        <form id="updateStatusForm{{ $staff->id }}" method="POST"
                            action="{{ route('staff.update.status', ['id' => $staff->id]) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="active" id="statusInput{{ $staff->id }}">
                            <button type="submit" class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>Staff Data</h1>
            <button class="btn btn-sm btn-primary" type="submit" data-bs-toggle="modal"
                data-bs-target="#formAddStaff">Add
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
                                <td>{{ $staff->active ? 'Active' : 'inActive' }}</td>
                                <td>{{ $staff->created_by }}</td>
                                <td>{{ $staff->created_at }}</td>
                                <td>{{ $staff->updated_at }}</td>
                                <td class="d-flex gap-2">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input toggle-switch"
                                            data-id="{{ $staff->id }}" {{ $staff->active ? 'checked' : '' }}>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#detailStaff{{ $staff->id }}"><i class="ph-eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#updateStaff{{ $staff->id }}"><i
                                            class="ph-pencil"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formDeleteStaff{{ $staff->id }}"><i
                                            class="ph-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
