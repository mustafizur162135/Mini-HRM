@extends('layouts.app')

@section('title', 'employee')

@push('css')
@endpush

@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-check icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>{{ __('all_employees') }}</div>

            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('employees.create') }}" class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-plus-circle fa-w-20"></i>
                        </span>
                        {{ __('create_employee') }}
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="table-responsive">
                    <table id="dataTable" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('first_name') }}</th>
                                <th>{{ __('last_name') }}</th>
                                <th>{{ __('email') }}</th>
                                <th>{{ __('phone') }}</th>
                                <th>{{ __('company') }}</th>
                                <th>{{ __('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": true,
                "stateSave": true,
                "paging": true,
                "iDisplayLength": 20,
                "ajax": {
                    "url": "{{ route('employees.index') }}",
                    "data": function(data) {
                        // Additional data to be sent with the request
                        // Example: data.status = $("#status").val();
                    },

                },
                "columns": [{
                        "data": "DT_RowIndex",
                        "name": "DT_RowIndex",
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "data": "first_name",
                        "name": "first_name"
                    },
                    {
                        "data": "last_name",
                        "name": "last_name"
                    },
                    {
                        "data": "email",
                        "name": "email"
                    },
                    {
                        "data": "phone",
                        "name": "phone"
                    },
                    {
                        "data": "company.name", // Use the correct data path for company name
                        "name": "company.name",
                        "render": function(data, type, row) {
                            return row.company.name ? row.company.name : '';
                        }
                    },
                    {
                        "data": "action",
                        "name": "action",
                        "orderable": true,
                        "searchable": true
                    }
                ],
                "rowCallback": function(row, data, index) {
                    $("td:eq(0)", row).html(index +
                        1); // Assign the index value to the first column (DT_RowIndex)
                }
            });
        });
    </script>





    <script>
        function deleteEmployee(event) {
            event.preventDefault(); // Prevent form submission

            // Display confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                // If user confirms the deletion
                if (result.isConfirmed) {
                    event.target.submit(); // Proceed with form submission
                }
            });
        }
    </script>
@endpush
