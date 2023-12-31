@extends('layouts.app')

@section('title', 'Company')

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
                <div>{{ __('all_companies') }}</div>

            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('companies.create') }}" class="btn-shadow btn btn-info">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-plus-circle fa-w-20"></i>
                        </span>
                        {{ __('create_company') }}
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
                                <th>{{ __('name') }}</th>
                                <th>{{ __('email') }}</th>
                                <th>{{ __('logo') }}</th>
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
                    "url": "{{ route('companies.index') }}",
                    "data": function(data) {
                        // Additional data to be sent with the request
                        // Example: data.status = $("#status").val();
                    }
                },
                "columns": [{
                        "data": "DT_RowIndex",
                        "name": "DT_RowIndex",
                        "orderable": false,
                        "searchable": false
                    },
                    {
                        "data": "name",
                        "name": "name"
                    },
                    {
                        "data": "email",
                        "name": "email"
                    },
                    {
                        "data": "logo",
                        "name": "logo",
                        "render": function(data, type, row) {
                            if (data) {
                                var imageUrl = '{{ asset('/storage') }}' + '/' + data;
                                return '<img src="' + imageUrl +
                                    '" alt="Company Logo" class="logo-image">';
                            } else {
                                var defaultImageUrl = '{{ asset('assets/images/no_img.jpg') }}';
                                return '<img src="' + defaultImageUrl +
                                    '" alt="Default Company Logo" class="logo-image">';
                            }
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
        function deleteCompany(event) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    </script>
@endpush
