@extends('Component.main')
@section('title')
    Visitor
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
    <div class="modal fade" id="formAddVisitor" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Form Add Visitor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('visitor.create') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="visitor_total" class="form-label">Visitor Total</label><span
                                class="text-danger">*</span>
                            <input type="number" class="form-control" name="visitor_total" id="visitor_total" required>
                        </div>
                        <div class="mb-3">
                            <label for="visitor_category_id" class="form-label">Visitor Category</label><span
                                class="text-danger">*</span>
                            <select name="visitor_category_id" id="visitor_category_id" class="form-control" required>
                                <option value="-">--- Choose Visitor Category ---</option>
                                @foreach ($visitor_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View --}}
    @foreach ($visitors as $visitor)
        <div class="modal fade" id="detailVisitor{{ $visitor->id }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $visitor->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $visitor->id }}">Detail Visitor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Visitor Total:</strong> {{ $visitor->visitor_total }}</p>
                        <p><strong>Visitor Category:</strong> {{ $visitor->visitor_category['name'] }}</p>
                        <p><strong>Created By:</strong> {{ $visitor->created_by }}</p>
                        <p><strong>Created At:</strong> {{ $visitor->created_at }}</p>
                        <p><strong>Updated At:</strong> {{ $visitor->updated_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    @foreach ($visitors as $visitor)
        <div class="modal fade" id="formUpdateVisitor{{ $visitor->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Form Update Visitor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('visitor.update', ['id' => $visitor->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="visitor_total" class="form-label">Visitor Total</label><span
                                    class="text-danger">*</span>
                                <input type="number" class="form-control" name="visitor_total" id="visitor_total"
                                    value="{{ $visitor->visitor_total }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="visitor_category_id" class="form-label">Visitor Category</label><span
                                    class="text-danger">*</span>
                                <select name="visitor_category_id" id="visitor_category_id" class="form-control" required>
                                    <option value="-">--- Choose Visitor Category ---</option>
                                    @foreach ($visitor_categories as $visitor_category)
                                        <option value="{{ $visitor_category->id }}"
                                            {{ $visitor->visitor_category['id'] == $visitor_category->id ? 'selected' : '' }}>
                                            {{ $visitor_category->name }}
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
    @foreach ($visitors as $visitor)
        <div class="modal fade" id="formDeleteVisitor{{ $visitor->id }}" tabindex="1" aria-labelledby="modalTitle"
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
                            action="{{ route('visitor.delete', ['id' => $visitor->id]) }}">
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
            <h1>Visitor Data</h1>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#formAddVisitor">Add Visitor</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Visitor Total</th>
                            <th>Visitor Category</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitors as $key => $visitor)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $visitor->visitor_total }}</td>
                                <td>{{ $visitor->visitor_category['name'] }}</td>
                                <td>{{ $visitor->created_by }}</td>
                                <td>{{ $visitor->created_at }}</td>
                                <td> {{ $visitor->updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#detailVisitor{{ $visitor->id }}">
                                        <i class="ph-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#formUpdateVisitor{{ $visitor->id }}">
                                        <i class="ph-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formDeleteVisitor{{ $visitor->id }}">
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
