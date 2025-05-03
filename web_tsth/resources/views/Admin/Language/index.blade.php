@extends('component.main')
@section('menu', 'Home')
@section('title', 'Language')
@section('icon')
    <i class="ph-globe"></i>
@endsection
@push('resource')
    <script>
        $(document).ready(function() {
            $('#langTable').DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true
            });
        });
    </script>
@endpush
@section('content')
    {{-- Modal Create --}}
    <div class="modal fade" id="formAddLanguage" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Form Add Language</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('language.create') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name Language</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Code Language</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="code" id="code" required>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    @foreach ($languages as $language)
        <div class="modal fade" id="formUpdateLang{{ $language->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Form Update Language</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('language.edit', $language->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name Language</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $language->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="code" class="form-label">Code Language</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control" name="code" id="code"
                                    value="{{ $language->code }}" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Delete --}}
    @foreach ($languages as $language)
        <div class="modal fade" id="DeleteLang{{ $language->id }}" tabindex="1" aria-labelledby="modalTitle"
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
                            action="{{ route('language.delete', ['id' => $language->id]) }}">
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
            <h1 class="mb-0">Language Data</h1>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#formAddLanguage">
                <i class="ph ph-plus me-1"></i>Add Language
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="langTable" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($languages as $key => $language)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $language->name }}</td>
                                <td>{{ $language->code }}</td>
                                <td>{{ $language->created_by }}</td>
                                <td>{{ $language->created_at }}</td>
                                <td>{{ $language->updated_at }}</td>
                                <td class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-warning"><i class="ph-pencil"
                                            data-bs-toggle="modal"
                                            data-bs-target="#formUpdateLang{{ $language->id }}"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#DeleteLang{{ $language->id }}"><i class="ph-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
