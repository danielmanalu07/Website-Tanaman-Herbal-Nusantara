@extends('component.main')
@section('menu', 'Home')
@section('title', 'Content')
@section('icon')
    <i class="ph-article"></i>
@endsection
@push('resource')
    <script>
        $(document).ready(function() {
            $('#contentTable').DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true
            });

            ClassicEditor.create(document.querySelector('#content'), {
                    ckfinder: {
                        uploadUrl: "{{ route('content.upload') }}?_token={{ csrf_token() }}",
                    },
                    mediaEmbed: {
                        previewsInData: true
                    }
                })
                .then(editor => {
                    console.log('Editor was initialized', editor);
                })
                .catch(error => console.error(error));

            @foreach ($contents as $content)
                ClassicEditor.create(document.querySelector('#content-{{ $content->id }}'), {
                        ckfinder: {
                            uploadUrl: "{{ route('content.upload') }}?_token={{ csrf_token() }}",
                        },
                        mediaEmbed: {
                            previewsInData: true
                        }
                    })
                    .then(editor => {
                        console.log('Editor for content {{ $content->id }} initialized', editor);
                    })
                    .catch(error => console.error(error));
            @endforeach

        });
    </script>
@endpush
@section('content')

    {{-- Modal Create --}}
    <div class="modal fade" id="formAddContent" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Add Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('content.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="key" class="form-label">Key <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="key" name="key" required />
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required />
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label><span class="text-danger">*</span>
                            <textarea name="content" class="form-control w-100 h-100 me-auto" id="content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View --}}
    @foreach ($contents as $content)
        <div class="modal fade" id="detailContent{{ $content->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Detail Content</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Key:</strong>{{ $content->key }}</p>
                        <p><strong>Title:</strong>{{ $content->title }}</p>
                        <p><strong>Content:</strong>{!! $content->content !!}</p>
                        <p><strong>Created By:</strong>{{ $content->created_by }}</p>
                        <p><strong>Updated By:</strong>{{ $content->created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    @foreach ($contents as $content)
        <div class="modal fade" id="formEditContent{{ $content->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Edit Content</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('content.edit', $content->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="key" class="form-label">Key <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="key" name="key"
                                    value="{{ $content->key }}" required />
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $content->title }}" required />
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label><span class="text-danger">*</span>
                                <textarea name="content" class="form-control w-100 h-100 me-auto" id="content-{{ $content->id }}">{!! $content->content !!}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Delete --}}
    @foreach ($contents as $content)
        <div class="modal fade" id="formDeleteContent{{ $content->id }}" tabindex="-1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Content</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <form method="POST" action="{{ route('content.delete', $content->id) }}">
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

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0">Content Data</h1>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#formAddContent">
                <i class="ph ph-plus me-1"></i>Add Content
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="contentTable" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Key</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contents as $key => $content)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $content->key }}</td>
                                <td>{{ $content->title }}</td>
                                <td>{!! $content->content !!}</td>
                                <td class="d-flex gap-2">
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#detailContent{{ $content->id }}"
                                        class="btn btn-sm btn-success"><i class="ph-eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#formEditContent{{ $content->id }}"><i
                                            class="ph-pencil"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formDeleteContent{{ $content->id }}"><i
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
