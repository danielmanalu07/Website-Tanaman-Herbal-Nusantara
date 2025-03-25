@extends('component.main')
@section('title')
    Visitor Category
@endsection
@section('menu')
    Home
@endsection
@section('icon')
    <i class="ph-users-three"></i>
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
@endpush
@section('content')
    {{-- Modal Create --}}
    <div class="modal fade" id="formAddVisitorCategory" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Form Add Visitor Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('visitor.category.create') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name Visitor Category</label><span
                                class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View --}}
    @foreach ($visitor_categories as $visitor_category)
        <div class="modal fade" id="detailVisitorCategory{{ $visitor_category->id }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $visitor_category->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $visitor_category->id }}">Detail Visitor Category
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Visitor Category Name:</strong> {{ $visitor_category->name }}</p>
                        <p><strong>Created By:</strong> {{ $visitor_category->created_by }}</p>
                        <p><strong>Created At:</strong> {{ $visitor_category->created_at }}</p>
                        <p><strong>Updated At:</strong> {{ $visitor_category->updated_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    @foreach ($visitor_categories as $visitor_category)
        <div class="modal fade" id="formUpdateVisitorCategory{{ $visitor_category->id }}" tabindex="1"
            aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Form Update Visitor Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST"
                            action="{{ route('visitor.category.update', ['id' => $visitor_category->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label><span class="text-danger">*</span>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $visitor_category->name }}" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Delete --}}
    @foreach ($visitor_categories as $visitor_category)
        <div class="modal fade" id="formDeleteVisitorCategory{{ $visitor_category->id }}" tabindex="1"
            aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <form id="deleteForm" method="POST"
                            action="{{ route('visitor.category.delete', ['id' => $visitor_category->id]) }}">
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
            <h1>Visitor Category Data</h1>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#formAddVisitorCategory">Add Visitor Category</button>
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
                        @foreach ($visitor_categories as $key => $visitor_category)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $visitor_category->name }}</td>
                                <td>{{ $visitor_category->created_by }}</td>
                                <td>{{ $visitor_category->created_at }}</td>
                                <td>{{ $visitor_category->updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#detailVisitorCategory{{ $visitor_category->id }}">
                                        <i class="ph-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#formUpdateVisitorCategory{{ $visitor_category->id }}">
                                        <i class="ph-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formDeleteVisitorCategory{{ $visitor_category->id }}">
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
