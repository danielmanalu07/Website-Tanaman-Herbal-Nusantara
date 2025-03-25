@extends('component.main')
@section('title')
    Plant
@endsection
@section('menu')
    Home
@endsection
@section('icon')
    <i class="ph ph-leaf"></i>
@endsection
@push('resource')
    <script>
        $(document).ready(function() {
            $('#plantTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true
            });
            ClassicEditor
                .create(document.querySelector('#advantage-create'))
                .catch(error => {
                    console.error(error);
                });

            @foreach ($plants as $plant)
                ClassicEditor
                    .create(document.querySelector('#advantage-edit-{{ $plant->id }}'))
                    .catch(error => {
                        console.error(error);
                    });
            @endforeach
        });
    </script>
@endpush
@section('content')
    {{-- Modal Create --}}
    @foreach ($habitus as $habitus_item)
        <div class="modal fade" id="formAddPlant" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Form Add Plant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('plant.create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Plant Name</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="latin_name" class="form-label">Latin Name</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control" name="latin_name" id="latin_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="advantage" class="form-label">Advantage</label><span
                                    class="text-danger">*</span>
                                <textarea name="advantage" class="form-control w-100 h-100 me-auto" id="advantage"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="ecology" class="form-label">Ecology</label><span class="text-danger">*</span>
                                <input type="text" class="form-control" name="ecology" id="ecology" required>
                            </div>
                            <div class="mb-3">
                                <label for="endemic_information" class="form-label">endemic_information</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control" name="endemic_information"
                                    id="endemic_information" required>
                            </div>
                            <div class="mb-3">
                                <label for="habitus_id" class="form-label">Plant Habitus</label><span
                                    class="text-danger">*</span>
                                <select name="habitus_id" id="habitus_id" class="form-control" required>
                                    <option value="-">--- Choose Habitus ---</option>
                                    <option value="{{ $habitus_item->id }}">{{ $habitus_item->name }}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal view --}}
    @foreach ($plants as $plant)
        <div class="modal fade" id="detailPlant{{ $plant->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Detail Plant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Name: </strong> {{ $plant->name }}</p>
                        <p><strong>Latin Name: </strong> {{ $plant->latin_name }}</p>
                        <p><strong>Advantage: </strong> {!! $plant->advantage !!}</p>
                        <p><strong>Ecology: </strong> {{ $plant->ecology }}</p>
                        <p><strong>Endemic Information: </strong> {{ $plant->endemic_information }}</p>
                        <p><strong>Habitus: </strong> {{ $plant->habitus['name'] }}</p>
                        <p><strong>Status: </strong> {{ $plant->status ? 'Active' : 'InActive' }}</p>
                        <p><strong>Created By: </strong> {{ $plant->created_by }}</p>
                        <p><strong>Created At: </strong> {{ $plant->created_at }}</p>
                        <p><strong>Updated At: </strong> {{ $plant->updated_at }}</p>
                        <p><strong>QR Code:</strong></p><br>
                        <img src="{{ $plant->qrcode }}" alt="Qr Code">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    @foreach ($plants as $plant)
        <div class="modal fade" id="updatePlant{{ $plant->id }}" tabindex="1" aria-label="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Form Update Plant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('plant.update', ['id' => $plant->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Plant Name</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $plant->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="latin_name" class="form-label">Latin Name</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control" name="latin_name" id="latin_name"
                                    value="{{ $plant->latin_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="advantage-edit-{{ $plant->id }}" class="form-label">Advantage</label><span
                                    class="text-danger">*</span>
                                <textarea name="advantage" class="form-control w-100 h-100 me-auto" id="advantage-edit-{{ $plant->id }}">{{ $plant->advantage }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="ecology" class="form-label">Ecology</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control" name="ecology" id="ecology"
                                    value="{{ $plant->ecology }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="endemic_information" class="form-label">Endemic Information</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control" name="endemic_information"
                                    id="endemic_information" value="{{ $plant->endemic_information }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="habitus_id" class="form-label">Plant Habitus</label><span
                                    class="text-danger">*</span>
                                <select name="habitus_id" id="habitus_id" class="form-control" required>
                                    <option value="">-- Select Habitus --</option>
                                    @foreach ($habitus as $habitus_item)
                                        <option value="{{ $habitus_item->id }}"
                                            {{ $plant->habitus['id'] == $habitus_item->id ? 'selected' : '' }}>
                                            {{ $habitus_item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Delete --}}
    @foreach ($plants as $plant)
        <div class="modal fade" id="formDeletePlant{{ $plant->id }}" tabindex="1" aria-labelledby="modalTitle"
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
                            action="{{ route('plant.delete', ['id' => $plant->id]) }}">
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

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1>Plants Data</h1>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#formAddPlant">Add
                Plant</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="plantTable" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Latin Name</th>
                            <th>Advantage</th>
                            <th>Ecology</th>
                            <th>Endemic Information</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plants as $key => $plant)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $plant->name }}</td>
                                <td>{{ $plant->latin_name }}</td>
                                <td>{!! Str::limit($plant->advantage, 100) !!}</td>
                                <td>{{ $plant->ecology }}</td>
                                <td>{{ $plant->endemic_information }}</td>
                                <td>{{ $plant->status ? 'Active' : 'InActive' }}</td>
                                <td>{{ $plant->created_by }}</td>
                                <td>{{ $plant->created_at }}</td>
                                <td>{{ $plant->updated_at }}</td>
                                <td class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#detailPlant{{ $plant->id }}"><i class="ph-eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#updatePlant{{ $plant->id }}"><i
                                            class="ph-pencil"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formDeletePlant{{ $plant->id }}"><i
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
