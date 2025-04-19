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
    <!-- Styles -->
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

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            $('#plantTable').DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true
            });

            ClassicEditor.create(document.querySelector('#advantage'), {
                    ckfinder: {
                        uploadUrl: "{{ route('plant.upload') }}?_token={{ csrf_token() }}",
                    },
                    mediaEmbed: {
                        previewsInData: true
                    }
                })
                .then(editor => {
                    console.log('Editor was initialized', editor);
                })
                .catch(error => console.error(error));


            @foreach ($plants as $plant)
                ClassicEditor.create(document.querySelector('#advantage-edit-{{ $plant->id }}'), {
                        ckfinder: {
                            uploadUrl: "{{ route('plant.upload') }}?_token={{ csrf_token() }}",
                        },
                        mediaEmbed: {
                            previewsInData: true
                        }
                    })
                    .then(editor => {
                        console.log('Editor for plant {{ $plant->id }} initialized', editor);
                    })
                    .catch(error => console.error(error));

                FilePond.create(document.querySelector('#new_images-{{ $plant->id }}'), {
                    allowMultiple: true,
                    instantUpload: false,
                    storeAsFile: true,
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg']
                });
            @endforeach

            FilePond.create(document.querySelector('.filepond'), {
                allowMultiple: true,
                instantUpload: false,
                storeAsFile: true,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg']
            });
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
            form.action = `/admin/plant/${id}/update-status`;
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
    {{-- Modal Create --}}
    <div class="modal fade" id="formAddPlant" tabindex="1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Form Add Plant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('plant.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Plant Name</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="latin_name" class="form-label">Latin Name</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="latin_name" id="latin_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="advantage" class="form-label">Advantage</label><span class="text-danger">*</span>
                            <textarea name="advantage" class="form-control w-100 h-100 me-auto" id="advantage"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="ecology" class="form-label">Ecology</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="ecology" id="ecology" required>
                        </div>
                        <div class="mb-3">
                            <label for="endemic_information" class="form-label">endemic_information</label><span
                                class="text-danger">*</span>
                            <input type="text" class="form-control" name="endemic_information" id="endemic_information"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="habitus_id" class="form-label">Plant Habitus</label><span
                                class="text-danger">*</span>
                            <select name="habitus_id" id="habitus_id" class="form-control" required>
                                <option value="-">--- Choose Habitus ---</option>
                                @foreach ($habitus as $habitus_item)
                                    <option value="{{ $habitus_item->id }}">{{ $habitus_item->name }}</option>
                                @endforeach
                            </select>
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
                        <p><strong>Habitus: </strong> {{ $plant->habitus['name'] ?? null }}</p>
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

    {{-- Modal view images --}}
    {{-- @foreach ($plants as $plant)
        @foreach ($plant->images as $image)
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
    @endforeach --}}

    {{-- Modal Edit --}}
    @foreach ($plants as $plant)
        <div class="modal fade" id="updatePlant{{ $plant->id }}" tabindex="-1"
            aria-labelledby="modalTitle{{ $plant->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle{{ $plant->id }}">Form Update Plant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('plant.update', $plant->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name-{{ $plant->id }}" class="form-label">Plant Name</label>
                                        <input type="text" class="form-control" name="name"
                                            id="name-{{ $plant->id }}" value="{{ $plant->name }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="latin_name-{{ $plant->id }}" class="form-label">Latin Name</label>
                                        <input type="text" class="form-control" name="latin_name"
                                            id="latin_name-{{ $plant->id }}" value="{{ $plant->latin_name }}"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="advantage-{{ $plant->id }}" class="form-label">Advantage</label>
                                        <textarea name="advantage" class="form-control w-100 h-100 me-auto" id="advantage-edit-{{ $plant->id }}">{{ $plant->advantage }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ecology-{{ $plant->id }}" class="form-label">Ecology</label>
                                        <input type="text" class="form-control" name="ecology"
                                            id="ecology-{{ $plant->id }}" value="{{ $plant->ecology }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="endemic_information-{{ $plant->id }}" class="form-label">Endemic
                                            Information</label>
                                        <input type="text" class="form-control" name="endemic_information"
                                            id="endemic_information-{{ $plant->id }}"
                                            value="{{ $plant->endemic_information }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="habitus_id-{{ $plant->id }}" class="form-label">Plant
                                            Habitus</label>
                                        <select name="habitus_id" id="habitus_id-{{ $plant->id }}"
                                            class="form-control" required>
                                            <option value="">-- Select Habitus --</option>
                                            @foreach ($habitus as $habitus_item)
                                                <option value="{{ $habitus_item->id }}"
                                                    {{ $plant->habitus && $plant->habitus['id'] == $habitus_item->id ? 'selected' : '' }}>
                                                    {{ $habitus_item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current Images</label>
                                <div class="row">
                                    @if (!empty($plant->images))
                                        @foreach ($plant->images as $image)
                                            <div class="col-md-3 text-center">
                                                <!-- Gambar dengan link untuk Lightbox -->
                                                <a href="{{ $image['image_path'] }}"
                                                    data-lightbox="plant-gallery-{{ $plant->id }}"
                                                    data-title="Plant Image">
                                                    <img src="{{ $image['image_path'] }}"
                                                        class="img-fluid rounded border p-2" alt="Plant Image"
                                                        style="width: 300px; height: 200px; cursor: pointer;">
                                                </a>

                                                <div class="form-check d-flex align-items-center gap-1 mt-2">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="deleted_images[]" value="{{ $image['id'] }}"
                                                        id="deleteImage-{{ $plant->id }}-{{ $image['id'] }}">
                                                    <label class="form-check-label text-danger"
                                                        for="deleteImage-{{ $plant->id }}-{{ $image['id'] }}">
                                                        Remove Image
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
                                <label for="new_images-{{ $plant->id }}" class="form-label">Add New Images</label>
                                <input type="file" class="filepond form-control" name="new_images[]"
                                    id="new_images-{{ $plant->id }}" multiple>
                                <small class="text-muted">You can select multiple images to add</small>
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
                        <h5 class="modal-title" id="modalTitle">Delete Staff</h5>
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

    <!-- Modal Confirmation Status -->
    <div class="modal fade" id="confirmStatusModal" tabindex="-1" aria-labelledby="confirmStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStatusModalLabel">Update Plant Status</h5>
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
                                <td>{!! Str::limit(
                                    strip_tags(preg_replace('/<(img|iframe|video)[^>]*>/i', '', $plant->advantage), '<b><strong><i><em><u><span>'),
                                    100,
                                    '...',
                                ) !!}</td>
                                <td>{{ $plant->ecology }}</td>
                                <td>{{ $plant->endemic_information }}</td>
                                <td>
                                    <select
                                        class="form-select form-select-sm custom-select {{ $plant->status ? 'bg-success text-white' : 'bg-danger text-white' }}"
                                        onchange="showConfirmModal({{ $plant->id }}, this.value, {{ $plant->status ? 1 : 0 }}, this)">
                                        <option value="1" {{ $plant->status ? 'selected' : '' }}
                                            class="bg-white text-dark">Published</option>
                                        <option value="0" {{ !$plant->status ? 'selected' : '' }}
                                            class="bg-white text-dark">Draft</option>
                                    </select>
                                </td>
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
