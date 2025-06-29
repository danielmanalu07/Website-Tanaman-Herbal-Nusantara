@extends('Component.main')

@section('menu', 'Home')
@section('title', 'Staff')
@section('icon')
    <i class="ph ph-user-list"></i>
@endsection

@push('resource')
    <style>
        .custom-select {
            transition: all 0.3s ease;
            padding: 0.375rem 1.75rem 0.375rem 0.75rem;
            cursor: pointer;
            min-width: 100px;
        }

        .custom-select:hover {
            opacity: 0.9;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .custom-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#staffTable').DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true
            });
        });

        let selectedElement = null;
        let previousValue = null;

        function showConfirmModal(id, newValue, oldValue, element) {
            newValue = parseInt(newValue);
            oldValue = parseInt(oldValue);

            if (newValue === oldValue) return;

            selectedElement = element;
            previousValue = oldValue;

            const form = document.getElementById(`statusForm${id}`);
            form.action = `/admin/staff/${id}/update-status`;
            document.getElementById(`statusValue${id}`).value = newValue;

            const modal = new bootstrap.Modal(document.getElementById(`formUpdateStatusStaff${id}`));
            modal.show();

            document.getElementById(`formUpdateStatusStaff${id}`).addEventListener('hidden.bs.modal', function() {
                resetDropdown();
            }, {
                once: true
            });
        }

        function resetDropdown() {
            if (selectedElement && previousValue !== null) {
                selectedElement.value = previousValue;
                updateDropdownStyle(selectedElement, previousValue);
            }
        }

        function updateDropdownStyle(element, value) {
            if (parseInt(value) === 1) {
                element.classList.remove('bg-danger');
                element.classList.add('bg-success');
            } else {
                element.classList.remove('bg-success');
                element.classList.add('bg-danger');
            }
        }

        document.querySelectorAll('.custom-select').forEach(select => {
            select.addEventListener('change', function() {
                updateDropdownStyle(this, this.value);
            });
        });
    </script>
@endpush

@section('content')
    <!-- Modal Create -->
    <div class="modal fade" id="formAddStaff" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('staff.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="full_name" id="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="phone" id="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">--- Pilih Jabatan ---</option>
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

    <!-- Modal View -->
    @foreach ($staffs as $staff)
        <div class="modal fade" id="detailStaff{{ $staff->id }}" tabindex="-1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Full Name:</strong> {{ $staff->full_name }}</p>
                        <p><strong>Email:</strong> {{ $staff->email }}</p>
                        <p><strong>Username:</strong> {{ $staff->username }}</p>
                        <p><strong>Phone:</strong> {{ $staff->phone }}</p>
                        <p><strong>Jabatan:</strong> {{ implode(', ', $staff->roles) }}</p>
                        <p><strong>Status:</strong> {{ $staff->active ? 'Active' : 'Inactive' }}</p>
                        <p><strong>Created By:</strong> {{ $staff->created_by }}</p>
                        <p><strong>Created At:</strong> {{ $staff->created_at }}</p>
                        <p><strong>Updated At:</strong> {{ $staff->updated_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Edit -->
    @foreach ($staffs as $staff)
        <div class="modal fade" id="updateStaff{{ $staff->id }}" tabindex="-1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Update Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('staff.update', ['id' => $staff->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="full_name{{ $staff->id }}" class="form-label">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="full_name"
                                    id="full_name{{ $staff->id }}" value="{{ $staff->full_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email{{ $staff->id }}" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email{{ $staff->id }}"
                                    value="{{ $staff->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone{{ $staff->id }}" class="form-label">Phone <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="phone" id="phone{{ $staff->id }}"
                                    value="{{ $staff->phone }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="username{{ $staff->id }}" class="form-label">Username <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username"
                                    id="username{{ $staff->id }}" value="{{ $staff->username }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password{{ $staff->id }}" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password"
                                    id="password{{ $staff->id }}">
                            </div>
                            <div class="mb-3">
                                <label for="role{{ $staff->id }}" class="form-label">Jabatan <span
                                        class="text-danger">*</span></label>
                                <select name="role" id="role{{ $staff->id }}" class="form-control" required>
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

    <!-- Modal Delete -->
    @foreach ($staffs as $staff)
        <div class="modal fade" id="formDeleteStaff{{ $staff->id }}" tabindex="-1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <form method="POST" action="{{ route('staff.delete', ['id' => $staff->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-success">Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Update Status -->
    @foreach ($staffs as $staff)
        <div class="modal fade" id="formUpdateStatusStaff{{ $staff->id }}" tabindex="-1"
            aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Status Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to update the status of this user?</p>
                        <form id="statusForm{{ $staff->id }}" method="POST"
                            action="{{ route('staff.update.status', ['id' => $staff->id]) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="active" id="statusValue{{ $staff->id }}">
                            <button type="submit" class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                onclick="resetDropdown()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Main Content -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0">Staff Data</h1>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#formAddStaff">
                <i class="ph ph-plus me-1"></i>Add Staff
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="staffTable" class="table table-hover">
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
                                <td>
                                    <select
                                        class="form-select form-select-sm custom-select {{ $staff->active ? 'bg-success text-white' : 'bg-danger text-white' }}"
                                        onchange="showConfirmModal({{ $staff->id }}, this.value, {{ $staff->active ? 1 : 0 }}, this)">
                                        <option value="1" {{ $staff->active ? 'selected' : '' }}
                                            class="bg-white text-dark">Active</option>
                                        <option value="0" {{ !$staff->active ? 'selected' : '' }}
                                            class="bg-white text-dark">Inactive</option>
                                    </select>
                                </td>
                                <td>{{ $staff->created_by }}</td>
                                <td>{{ $staff->created_at }}</td>
                                <td>{{ $staff->updated_at }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#detailStaff{{ $staff->id }}" title="View">
                                            <i class="ph ph-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#updateStaff{{ $staff->id }}" title="Edit">
                                            <i class="ph ph-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#formDeleteStaff{{ $staff->id }}" title="Delete">
                                            <i class="ph ph-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
