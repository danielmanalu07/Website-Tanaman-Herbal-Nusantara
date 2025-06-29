@extends('Component.main')

@section('menu', 'Home')
@section('title', 'News')
@section('icon')
    <i class="ph ph-newspaper"></i>
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

            // const {
            //     ClassicEditor,
            //     Essentials,
            //     Bold,
            //     Italic,
            //     Paragraph,
            //     Font,
            //     FontColor,
            //     FontBackgroundColor,
            //     FontSize,
            //     FontFamily,
            //     Alignment,
            //     Image,
            //     ImageToolbar,
            //     ImageCaption,
            //     ImageStyle,
            //     ImageResize,
            //     ImageUpload,
            //     MediaEmbed,
            //     Table,
            //     TableToolbar,
            //     Link,
            //     BlockQuote,
            //     Heading,
            //     List,
            //     SimpleUploadAdapter,
            // } = CKEDITOR;

            // ClassicEditor.create(document.querySelector('#content'), {
            //         licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzYyOTc1OTksImp0aSI6IjcwNDMzMDI4LTljZGItNGE0NS04MmJhLTgxNmEyYWQzMzUyNSIsImxpY2Vuc2VkSG9zdHMiOlsiMTI3LjAuMC4xIiwibG9jYWxob3N0IiwiMTkyLjE2OC4qLioiLCIxMC4qLiouKiIsIjE3Mi4qLiouKiIsIioudGVzdCIsIioubG9jYWxob3N0IiwiKi5sb2NhbCJdLCJ1c2FnZUVuZHBvaW50IjoiaHR0cHM6Ly9wcm94eS1ldmVudC5ja2VkaXRvci5jb20iLCJkaXN0cmlidXRpb25DaGFubmVsIjpbImNsb3VkIiwiZHJ1cGFsIl0sImxpY2Vuc2VUeXBlIjoiZGV2ZWxvcG1lbnQiLCJmZWF0dXJlcyI6WyJEUlVQIl0sInZjIjoiOTc3NzVhYzAifQ.liBinbB_5Fjq0nGgi8D1gdLS91Fcrsv-N7flqCTstGR2p12jpAzyXc_Fs_Bci9Ywv3AHow__HcyEE08yWqmizg',
            //         simpleUpload: {
            //             uploadUrl: "{{ route('news.upload') }}?_token={{ csrf_token() }}"
            //         },
            //         mediaEmbed: {
            //             previewsInData: true
            //         },
            //         plugins: [
            //             Essentials, Bold, Italic, Font, FontColor, FontBackgroundColor, FontSize,
            //             FontFamily,
            //             Paragraph, Alignment,
            //             Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, ImageUpload,
            //             MediaEmbed, Table, TableToolbar, Link, BlockQuote, Heading, List,
            //             SimpleUploadAdapter,
            //         ],
            //         toolbar: [
            //             'heading', '|',
            //             'bold', 'italic', 'blockQuote', '|',
            //             'link', 'imageUpload', 'mediaEmbed', 'insertTable', '|',
            //             'alignment', 'numberedList', 'bulletedList', '|',
            //             'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
            //             'undo', 'redo'
            //         ],
            //         image: {
            //             toolbar: [
            //                 'imageTextAlternative',
            //                 'imageStyle:alignLeft',
            //                 'imageStyle:full',
            //                 'imageStyle:alignRight'
            //             ],
            //             styles: [
            //                 'full',
            //                 'alignLeft',
            //                 'alignRight'
            //             ]
            //         },
            //         table: {
            //             contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            //         }
            //     })
            //     .then(editor => {
            //         console.log('Editor was initialized', editor);
            //     })
            //     .catch(error => console.error(error));


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
                // ClassicEditor.create(document.querySelector('#content-{{ $new->id }}'), {
                //         licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NzYyOTc1OTksImp0aSI6IjcwNDMzMDI4LTljZGItNGE0NS04MmJhLTgxNmEyYWQzMzUyNSIsImxpY2Vuc2VkSG9zdHMiOlsiMTI3LjAuMC4xIiwibG9jYWxob3N0IiwiMTkyLjE2OC4qLioiLCIxMC4qLiouKiIsIjE3Mi4qLiouKiIsIioudGVzdCIsIioubG9jYWxob3N0IiwiKi5sb2NhbCJdLCJ1c2FnZUVuZHBvaW50IjoiaHR0cHM6Ly9wcm94eS1ldmVudC5ja2VkaXRvci5jb20iLCJkaXN0cmlidXRpb25DaGFubmVsIjpbImNsb3VkIiwiZHJ1cGFsIl0sImxpY2Vuc2VUeXBlIjoiZGV2ZWxvcG1lbnQiLCJmZWF0dXJlcyI6WyJEUlVQIl0sInZjIjoiOTc3NzVhYzAifQ.liBinbB_5Fjq0nGgi8D1gdLS91Fcrsv-N7flqCTstGR2p12jpAzyXc_Fs_Bci9Ywv3AHow__HcyEE08yWqmizg',
                //         simpleUpload: {
                //             uploadUrl: "{{ route('news.upload') }}?_token={{ csrf_token() }}"
                //         },
                //         mediaEmbed: {
                //             previewsInData: true
                //         },
                //         plugins: [
                //             Essentials, Bold, Italic, Font, FontColor, FontBackgroundColor, FontSize,
                //             FontFamily,
                //             Paragraph, Alignment,
                //             Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, ImageUpload,
                //             MediaEmbed, Table, TableToolbar, Link, BlockQuote, Heading, List,
                //             SimpleUploadAdapter,
                //         ],
                //         toolbar: [
                //             'heading', '|',
                //             'bold', 'italic', 'blockQuote', '|',
                //             'link', 'imageUpload', 'mediaEmbed', 'insertTable', '|',
                //             'alignment', 'numberedList', 'bulletedList', '|',
                //             'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                //             'undo', 'redo'
                //         ],
                //         image: {
                //             toolbar: [
                //                 'imageTextAlternative',
                //                 'imageStyle:alignLeft',
                //                 'imageStyle:full',
                //                 'imageStyle:alignRight'
                //             ],
                //             styles: [
                //                 'full',
                //                 'alignLeft',
                //                 'alignRight'
                //             ]
                //         },
                //         table: {
                //             contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                //         }
                //     })
                //     .then(editor => {
                //         console.log('Editor was initialized', editor);
                //     })
                //     .catch(error => console.error(error));

                ClassicEditor.create(document.querySelector('#content-{{ $new->id }}'), {
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
                FilePond.create(document.querySelector('#new_images-{{ $new->id }}'), {
                    allowMultiple: true,
                    instantUpload: false,
                    storeAsFile: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg']
                });
            @endforeach
        });

        let selectedElement = null;
        let previousValue = null;

        function showConfirmModal(id, newValue, oldValue, element) {
            newValue = parseInt(newValue);
            oldValue = parseInt(oldValue);

            if (newValue === oldValue) return;

            selectedElement = element;
            previousValue = oldValue;

            const form = document.getElementById('statusForm');
            form.action = `/admin/news/${id}/update-status`;
            document.getElementById('statusValue').value = newValue;

            const modal = new bootstrap.Modal(document.getElementById('confirmStatusModal'));
            modal.show();

            document.getElementById('confirmStatusModal').addEventListener('hidden.bs.modal', function() {
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

    <!-- Modal Confirmation Status -->
    <div class="modal fade" id="confirmStatusModal" tabindex="-1" aria-labelledby="confirmStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStatusModalLabel">Update News Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to update this data?
                </div>
                <div class="modal-footer">
                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" id="statusValue">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="resetDropdown()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                            <th>Status</th>
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
                                <td>
                                    <select
                                        class="form-select form-select-sm custom-select {{ $new->status ? 'bg-success text-white' : 'bg-danger text-white' }}"
                                        onchange="showConfirmModal({{ $new->id }}, this.value, {{ $new->status ? 1 : 0 }}, this)">
                                        <option value="1" {{ $new->status ? 'selected' : '' }}
                                            class="bg-white text-dark">Published</option>
                                        <option value="0" {{ !$new->status ? 'selected' : '' }}
                                            class="bg-white text-dark">Draft</option>
                                    </select>
                                </td>
                                <td>{{ $new->created_by }}</td>
                                <td>{{ $new->published ?? '-' }}</td>
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
