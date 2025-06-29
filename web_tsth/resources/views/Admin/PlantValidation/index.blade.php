@extends('Component.main')
@section('menu', 'Home')
@section('title', 'Plant Validation')
@section('icon')
    <i class="ph-flower"></i>
@endsection
@push('resource')
    <style>
        .date-filter-container {
            flex: 1;
            /* Allow the filter container to take available space */
        }

        .date-filter-container .d-flex {
            gap: 0.5rem;
            /* Consistent spacing between elements */
        }

        .date-filter-container .form-label {
            font-size: 0.9rem;
            /* Slightly smaller label for mobile */
            white-space: nowrap;
            /* Prevent label wrapping */
        }

        .date-filter-container .form-control {
            max-width: 150px;
            /* Limit input width for better mobile display */
            font-size: 0.9rem;
            /* Adjust font size for readability */
        }

        .date-filter-container .btn {
            padding: 0.375rem 0.75rem;
            /* Consistent button padding */
            font-size: 0.9rem;
            /* Slightly smaller button text */
        }

        @media (max-width: 767.98px) {
            .date-filter-container .form-control {
                max-width: 100%;
                /* Full width inputs on mobile */
            }

            .date-filter-container .d-flex {
                flex-direction: column;
                /* Stack elements vertically on mobile */
                align-items: stretch;
                /* Stretch elements to full width */
                gap: 0.75rem;
                /* More vertical spacing */
            }

            .date-filter-container .d-flex>div {
                width: 100%;
                /* Ensure input containers take full width */
            }

            .date-filter-container .btn {
                width: 100%;
                /* Full-width buttons on mobile */
            }

            #exportExcel {
                width: 100%;
                /* Full-width export button on mobile */
                margin-top: 0.75rem;
                /* Space above export button */
            }
        }

        @media (min-width: 768px) {
            .date-filter-container .d-flex {
                flex-direction: row;
                /* Horizontal layout on larger screens */
                align-items: center;
            }
        }
    </style>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#tableValidation').DataTable({
                responsive: true,
                autoWidth: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                dom: '<"top"f>rt<"bottom"lip><"clear">'
            });

            function updateExportUrl() {
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                var url = "{{ route('validation.excel') }}";

                // Append query parameters if filters are applied
                if (fromDate || toDate) {
                    url += "?fromDate=" + (fromDate || '') + "&toDate=" + (toDate || '');
                }

                $('#exportExcel').attr('href', url);
            }

            // Apply date range filter
            $('#filterBtn').click(function() {
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();

                if (fromDate || toDate) {
                    // Custom filtering function for date range
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var createdAt = new Date(data[5]); // Created At column
                            var updatedAt = new Date(data[6]); // Updated At column

                            if (!fromDate && !toDate) return true;

                            if (fromDate && !toDate) {
                                var minDate = new Date(fromDate);
                                return (createdAt >= minDate) || (updatedAt >= minDate);
                            }

                            if (!fromDate && toDate) {
                                var maxDate = new Date(toDate);
                                maxDate.setDate(maxDate.getDate() + 1); // Include the entire day
                                return (createdAt <= maxDate) || (updatedAt <= maxDate);
                            }

                            var minDate = new Date(fromDate);
                            var maxDate = new Date(toDate);
                            maxDate.setDate(maxDate.getDate() + 1); // Include the entire day

                            return (
                                (createdAt >= minDate && createdAt <= maxDate) ||
                                (updatedAt >= minDate && updatedAt <= maxDate)
                            );
                        }
                    );

                    table.draw();
                    $.fn.dataTable.ext.search.pop(); // Remove the filter
                } else {
                    table.draw();
                }

                updateExportUrl(); // Update export URL after filtering
            });

            // Reset date filter
            $('#resetDateFilter').click(function() {
                $('#fromDate').val('');
                $('#toDate').val('');
                table.draw();
                updateExportUrl(); // Update export URL after reset
            });

            // Initial update of export URL
            updateExportUrl();
        });
    </script>
@endpush
@section('content')
    {{-- Modal View --}}
    @foreach ($plant_validations as $plant_validation)
        <div class="modal fade" id="detailValidation{{ $plant_validation->id }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $plant_validation->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Land</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Plant Name:</strong> {{ $plant_validation->plant['name'] }}</p>
                        <p><strong>Validator:</strong> {{ $plant_validation->validator['full_name'] }}</p>
                        <p><strong>Date Validation:</strong> {{ $plant_validation->date_validation }} </p>
                        <p><strong>Condition:</strong> {{ $plant_validation->condition }} </p>
                        <p><strong>Validation Image:</strong></p>
                        <div class="row g-2">
                            @foreach ($plant_validation->images as $image)
                                <div class="col-md-3 text-center">
                                    <a href="{{ asset($image['image_path']) }}"
                                        data-lightbox="plant-gallery-{{ $image['id'] }}" data-title="Validation Image">
                                        <img src="{{ asset($image['image_path']) }}" class="img-fluid rounded border p-2"
                                            alt="Validation Image" style="width: 100%; height: 150px; cursor: pointer;" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <p><strong>Created At:</strong> {{ $plant_validation->created_at }}</p>
                        <p><strong>Updated At:</strong> {{ $plant_validation->updated_at }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-center">
            <h1>Data Plant Validation</h1>
        </div>
        <div class="card-body">
            <div
                class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                <div class="date-filter-container">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <div class="d-flex align-items-center gap-1">
                            <label for="fromDate" class="form-label mb-0">From:</label>
                            <input type="date" id="fromDate" class="form-control">
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <label for="toDate" class="form-label mb-0">To:</label>
                            <input type="date" id="toDate" class="form-control">
                        </div>
                        <button id="filterBtn" class="btn btn-primary btn-sm">
                            <i class="ph ph-funnel"></i> Filter
                        </button>
                        <button id="resetDateFilter" class="btn btn-secondary btn-sm">
                            <i class="ph ph-arrows-counter-clockwise"></i> Reset
                        </button>
                    </div>
                </div>
                <a href="#" id="exportExcel" class="btn btn-success btn-sm mb-3">
                    <i class="ph ph-download-simple"></i> Export to Excel
                </a>
            </div>
            <div class="table-responsive">
                <table id="tableValidation" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Plant</th>
                            <th>Validator</th>
                            <th>Date Validation</th>
                            <th>Condition</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plant_validations as $key => $plant_validation)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $plant_validation->plant['name'] }}</td>
                                <td>{{ $plant_validation->validator['full_name'] }}</td>
                                <td>{{ $plant_validation->date_validation }}</td>
                                <td>{{ $plant_validation->condition }}</td>
                                <td>{{ $plant_validation->created_at }}</td>
                                <td>{{ $plant_validation->updated_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success"><i class="ph-eye"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailValidation{{ $plant_validation->id }}"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
