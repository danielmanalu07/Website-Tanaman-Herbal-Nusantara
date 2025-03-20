@extends('component.main')

@section('menu')
    Home
@endsection

@section('title')
    Habitus
@endsection

@section('icon')
    <i class="ph-layout"></i>
@endsection
@push('resource')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
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
    {{-- Modal Create --}}
    <div class="modal fade" id="formAddHabitus" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Form Add Habitus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('habitus.create') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label><span class="text-danger">*</span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View --}}
    @foreach ($habitus as $habitus_item)
        <div class="modal fade" id="detailHabitus{{ $habitus_item->id }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $habitus_item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $habitus_item->id }}">Detail Habitus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Habitus Name:</strong> {{ $habitus_item->name }}</p>
                        <p><strong>Created By:</strong> {{ $habitus_item->created_by }}</p>
                        <p><strong>Created At:</strong> {{ $habitus_item->created_at }}</p>
                        <p><strong>Updated At:</strong> {{ $habitus_item->updated_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    @foreach ($habitus as $habitus_item)
        <div class="modal fade" id="formUpdateHabitus{{ $habitus_item->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Form Update Habitus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('habitus.update', ['id' => $habitus_item->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name{{ $habitus_item->id }}" class="form-label">Name</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name{{ $habitus_item->id }}" value="{{ $habitus_item->name }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    {{-- Modal Delete --}}
    @foreach ($habitus as $habitus_item)
        <div class="modal fade" id="formDeleteHabitus{{ $habitus_item->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <form id="deleteForm" method="POST"
                            action="{{ route('habitus.delete', ['id' => $habitus_item->id]) }}">
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
            <h1>Habitus Data</h1>
            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                data-bs-target="#formAddHabitus">Add
                Habitus</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display">
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
                        @foreach ($habitus as $key => $habitus_item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $habitus_item->name }}</td>
                                <td>{{ $habitus_item->created_by }}</td>
                                <td>{{ $habitus_item->created_at }}</td>
                                <td>{{ $habitus_item->updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#detailHabitus{{ $habitus_item->id }}">
                                        <i class="ph-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#formUpdateHabitus{{ $habitus_item->id }}">
                                        <i class="ph-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formDeleteHabitus{{ $habitus_item->id }}"
                                        data-id="{{ $habitus_item->id }}">
                                        <i class="ph-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
