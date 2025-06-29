@extends('Component.main')
@section('menu', 'Home')
@section('title', 'Contact Us')
@section('icon')
    <i class="ph-article"></i>
@endsection
@push('resource')
    <script>
        $(document).ready(function() {
            $('#contactTable').DataTable();
            ClassicEditor.create(document.querySelector('#text'), {
                    ckfinder: {
                        uploadUrl: "{{ route('contact.updload') }}?_token={{ csrf_token() }}",
                    },
                    mediaEmbed: {
                        previewsInData: true
                    }
                })
                .then(editor => {
                    console.log('Editor was initialized', editor);
                })
                .catch(error => console.error(error));

            @foreach ($contacts as $contact)
                ClassicEditor.create(document.querySelector('#text-{{ $contact->id }}'), {
                        ckfinder: {
                            uploadUrl: "{{ route('contact.updload') }}?_token={{ csrf_token() }}",
                        },
                        mediaEmbed: {
                            previewsInData: true
                        }
                    })
                    .then(editor => {
                        console.log('Editor for content {{ $contact->id }} initialized', editor);
                    })
                    .catch(error => console.error(error));
            @endforeach
        });
    </script>
@endpush
@section('content')
    {{-- Modal Create --}}
    <div class="modal fade" id="formAddContact" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Add Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contact.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required />
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Content</label><span class="text-danger">*</span>
                            <textarea name="text" class="form-control w-100 h-100 me-auto" id="text"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal View --}}
    @foreach ($contacts as $contact)
        <div class="modal fade" id="detailContact{{ $contact->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Detail Contact</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Title:</strong>{{ $contact->title }}</p>
                        <p><strong>Text:</strong>{!! $contact->text !!}</p>
                        <p><strong>Created By:</strong>{{ $contact->created_by }}</p>
                        <p><strong>Updated By:</strong>{{ $contact->created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    @foreach ($contacts as $contact)
        <div class="modal fade" id="formEditContact{{ $contact->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Edit Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('contact.edit', $contact->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $contact->title }}" required />
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Text</label><span class="text-danger">*</span>
                                <textarea name="text" class="form-control w-100 h-100 me-auto" id="text-{{ $contact->id }}">{!! $contact->text !!}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Delete --}}
    @foreach ($contacts as $contact)
        <div class="modal fade" id="formDeleteContact{{ $contact->id }}" tabindex="-1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <form method="POST" action="{{ route('contact.delete', $contact->id) }}">
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
            <h1 class="mb-0">Contact Data</h1>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#formAddContact">
                <i class="ph ph-plus me-1"></i>Add Contact
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="contactTable" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $key => $contact)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $contact->title }}</td>
                                <td>{!! Str::limit(preg_replace('/<(img|iframe|video)[^>]*>/i', '', $contact->text), 200) !!}</td>
                                <td>{{ $contact->created_at }}</td>
                                <td class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#detailContact{{ $contact->id }}"><i
                                            class="ph-eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#formEditContact{{ $contact->id }}"><i
                                            class="ph-pencil"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formDeleteContact{{ $contact->id }}"><i
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
