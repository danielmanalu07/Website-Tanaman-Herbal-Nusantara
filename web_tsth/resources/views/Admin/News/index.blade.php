@extends('component.main')

@section('menu', 'Home')
@section('title', 'News')
@section('icon')
    <i class="ph ph-newspaper"></i>
@endsection

@push('resource')
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                console.log("Form submitted");
            });

            $('#newsTable').DataTable({
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
                        uploadUrl: "{{ route('news.upload') }}?_token={{ csrf_token() }}",
                    },
                    mediaEmbed: {
                        previewsInData: true
                    }
                })
                .then(editor => {
                    console.log('Editor was initialized', editor);
                })
                .catch(error => console.error(error));


            FilePond.create(document.querySelector('.filepond'), {
                allowMultiple: true,
                instantUpload: false,
                storeAsFile: true,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                required: true,
                onaddfile: (error, file) => {
                    if (error) {
                        console.error('FilePond error:', error);
                    }
                }
            });

            @foreach ($news as $new)
                ClassicEditor.create(document.querySelector('#content-{{ $new->id }}'), {
                        ckfinder: {
                            uploadUrl: "{{ route('news.upload') }}?_token={{ csrf_token() }}",
                        },
                        mediaEmbed: {
                            previewsInData: true
                        }
                    })
                    .then(editor => {
                        console.log('Editor for plant {{ $new->id }} initialized', editor);
                    })
                    .catch(error => console.error(error));

                FilePond.create(document.querySelector('#new_images-{{ $new->id }}'), {
                    allowMultiple: true,
                    instantUpload: false,
                    storeAsFile: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg']
                });
            @endforeach
        });
    </script>
@endpush

@section('content')
    <!-- Modal Create -->
    <div class="modal fade" id="formAddNews" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Add News</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('news.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required />
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label><span class="text-danger">*</span>
                            <textarea name="content" class="form-control w-100 h-100 me-auto" id="content"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label><span class="text-danger">*(Put 1 file
                                minimum)</span>
                            <input type="file" class="filepond form-control" name="images[]" multiple required>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal view images --}}
    @foreach ($news as $new)
        @foreach ($new->images as $image)
            <div class="modal fade" id="imageModal-{{ $image['id'] }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <img src="{{ $image['image_path'] }}" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

    {{-- Modal View --}}
    @foreach ($news as $new)
        <div class="modal fade" id="detailNews{{ $new->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Detail News</h5>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Title:</strong>{{ $new->title }}</p>
                        <p><strong>Content:</strong>{!! $new->content !!}</p>
                        <p><strong>Images:</strong></p>
                        <div class="row d-flex gap-2">
                            @foreach ($new->images as $image)
                                <div class="col-md-3 text-center">
                                    <a href="{{ asset($image['image_path']) }}"
                                        data-lightbox="plant-gallery-{{ $new->id }}" data-title="Plant Image">
                                        <img src="{{ asset($image['image_path']) }}" class="img-fluid rounded border p-2"
                                            alt="Plant Image" style="width: 100%; height: 100%; cursor: pointer;" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <p><strong>Published At:</strong>{{ $new->published ?? ' -' }}</p>
                        <p><strong>Published At:</strong>{{ $new->created_by }}</p>
                        <p><strong>Published At:</strong>{{ $new->created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    @foreach ($news as $new)
        <div class="modal fade" id="formUpdateNews{{ $new->id }}" tabindex="1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Update News</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('new.edit', $new->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Kolom Kiri: Text -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title-{{ $new->id }}" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title-{{ $new->id }}"
                                            name="title" value="{{ $new->title }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="content-{{ $new->id }}" class="form-label">Content</label><span
                                            class="text-danger">*</span>
                                        <textarea name="content" class="form-control w-100" id="content-{{ $new->id }}" rows="5">{{ $new->content }}</textarea>
                                    </div>
                                </div>

                                <!-- Kolom Kanan: Images -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Current Images</label>
                                        <div class="row">
                                            @if (!empty($new->images))
                                                @foreach ($new->images as $image)
                                                    <div class="col-md-6 text-center mb-3">
                                                        <a href="{{ $image['image_path'] }}"
                                                            data-lightbox="new-gallery-{{ $new->id }}"
                                                            data-title="new Image">
                                                            <img src="{{ $image['image_path'] }}"
                                                                class="img-fluid rounded border p-2" alt="New Image"
                                                                style="width: 100%; height: auto; cursor: pointer;">
                                                        </a>
                                                        <div class="form-check d-flex align-items-center gap-1 mt-2">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="deleted_images[]" value="{{ $image['id'] }}"
                                                                id="deleteImage-{{ $new->id }}-{{ $image['id'] }}">
                                                            <label class="form-check-label text-danger"
                                                                for="deleteImage-{{ $new->id }}-{{ $image['id'] }}">
                                                                Remove
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted">No images uploaded</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_images-{{ $new->id }}" class="form-label">Add New
                                            Images</label>
                                        <input type="file" class="filepond" name="new_images[]"
                                            id="new_images-{{ $new->id }}" multiple>
                                        <small class="text-muted">You can select multiple images to add</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <button type="submit" class="btn btn-success mt-3 w-100">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Delete -->
    @foreach ($news as $new)
        <div class="modal fade" id="formDeleteNews{{ $new->id }}" tabindex="-1" aria-labelledby="modalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus News</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <form method="POST" action="{{ route('news.delete', ['id' => $new->id]) }}">
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
    <!-- Main Content -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="mb-0">News Data</h1>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#formAddNews">
                <i class="ph ph-plus me-1"></i>Add News
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="newsTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Created By</th>
                            <th>Published At</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $key => $new)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $new->title }}</td>
                                <td>{!! $new->content !!}</td>
                                <td>{{ $new->created_by }}</td>
                                <td>{{ $new->published_at ?? '-' }}</td>
                                <td>{{ $new->created_at }}</td>
                                <td>{{ $new->updated_at }}</td>
                                <td class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#detailNews{{ $new->id }}"><i class="ph-eye"></i></button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#formUpdateNews{{ $new->id }}"><i
                                            class="ph-pencil"></i></button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formDeleteNews{{ $new->id }}"><i
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
