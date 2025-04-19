@extends('component.main')
@section('title')
    Land
@endsection
@section('menu')
    Home
@endsection
@section('icon')
    <i class="ph-browser"></i>
@endsection
@push('resource')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "--- Choose Plants ---",
                allowClear: true,
                width: "100%"
            });
            $('#landTable').DataTable({
                "responsive": true,
                "autoWidth": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true
            });

            @foreach ($lands as $land)
                FilePond.create(document.querySelector('#image-{{ $land->id }}'), {
                    instantUpload: false,
                    storeAsFile: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg']
                });
            @endforeach

            FilePond.create(document.querySelector('.filepond'), {
                instantUpload: false,
                storeAsFile: true,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg']
            });

        });
    </script>
@endpush
@section('content')
    {{-- Modal Create --}}
    <div class="modal fade" id="formAddLand" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Form Add Land</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('land.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="plants" class="form-label">Plants</label>
                            <select name="plants[]" id="plants" class="form-control select2" multiple>
                                @foreach ($plants as $plant)
                                    <option value="{{ $plant->id }}">{{ $plant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image">Image</label><span class="text-danger">*</span>
                            <input type="file" name="image" class="filepond form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View --}}
    @foreach ($lands as $land)
        <div class="modal fade" id="detailLand{{ $land->id }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $land->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Land</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Land Name:</strong> {{ $land->name }}</p>
                        <p><strong>Plants:</strong> {{ collect($land->plants)->pluck('name')->implode(', ') }}</p>
                        <p><strong>Land Image:</strong></p>
                        <div class="row d-flex gap-2">
                            <div class="col-md-3 text-center">
                                <a href="{{ asset($land->image) }}" data-lightbox="plant-gallery-{{ $land->id }}"
                                    data-title="Land Image">
                                    <img src="{{ asset($land->image) }}" class="img-fluid rounded border p-2"
                                        alt="Land Image" style="width: 100%; height: 100%; cursor: pointer;" />
                                </a>
                            </div>
                        </div>
                        <p><strong>Created By:</strong> {{ $land->created_by }}</p>
                        <p><strong>Created At:</strong> {{ $land->created_at }}</p>
                        <p><strong>Updated At:</strong> {{ $land->updated_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    @foreach ($lands as $land)
        <div class="modal fade" id="updateLand{{ $land->id }}" tabindex="1" aria-label="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Update Land</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('land.update', ['id' => $land->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Land Name</label><span class="text-danger">*</span>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $land->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="plants" class="form-label">Plants</label>
                                <select name="plants[]" id="plants-{{ $land->id }}" class="form-control select2"
                                    multiple required>
                                    @foreach ($plants as $plant)
                                        <option value="{{ $plant->id }}"
                                            {{ in_array($plant->id, collect($land->plants)->pluck('id')->toArray()) == $plant->id ? 'selected' : '' }}>
                                            {{ $plant->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Current Images</label>
                                <div class="row">
                                    @if (!empty($land->image))
                                        <div class="col-md-3 text-center">
                                            <a href="{{ $land->image }}"
                                                data-lightbox="land-gallery-{{ $land->id }}" data-title="Land Image">
                                                <img src="{{ $land->image }}" class="img-fluid rounded border p-2"
                                                    alt="land Image"
                                                    style="width: 300px; height: 100px; cursor: pointer;">
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-muted">No images uploaded</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="filepond form-control"
                                    id="image-{{ $land->id }}" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Delete --}}
    @foreach ($lands as $land)
        <div class="modal fade" id="formDeleteLand{{ $land->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <form id="deleteForm" method="POST" action="{{ route('land.delete', ['id' => $land->id]) }}">
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
            <h1>Land Data</h1>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#formAddLand">Add
                Land</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="landTable" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lands as $key => $land)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $land->name }}</td>
                                <td>{{ $land->created_by }}</td>
                                <td>{{ $land->created_at }}</td>
                                <td>{{ $land->updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#detailLand{{ $land->id }}"><i class="ph-eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#updateLand{{ $land->id }}"><i
                                            class="ph-pencil"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formDeleteLand{{ $land->id }}"><i
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
