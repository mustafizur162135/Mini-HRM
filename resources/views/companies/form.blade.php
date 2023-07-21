@extends('layouts.app')

@section('title', 'Company')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }
    </style>
@endpush
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-bookmarks icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>{{ __(isset($company) ? 'edit_company' : 'create_company') }}</div>

            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('companies.index') }}" class="btn-shadow btn btn-danger">
                        <span class="btn-icon-wrapper pr-2 opacity-7">
                            <i class="fas fa-arrow-circle-left fa-w-20"></i>
                        </span>
                        {{ __('back_to_list') }}
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <form role="form" id="companyFrom" method="POST"
                action="{{ isset($company) ? route('companies.update', $company->id) : route('companies.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($company))
                    @method('PUT')
                @endif

                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="company">{{ __('company_name') }} <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ old('name') ?? ($company->name ?? '') }}" name="name"
                                            id="name" placeholder="{{ __('company_name') }}" type="text"
                                            class="form-control rounded @error('name') is-invalid @enderror">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="email">{{ __('company_email') }}</label>
                                        <input value="{{ old('email') ?? ($company->email ?? '') }}" name="email"
                                            id="email" placeholder="{{ __('company_email') }}" type="email"
                                            class="form-control rounded @error('email') is-invalid @enderror">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="logo">{{ __('company_logo') }}</label>
                                <input type="file" name="logo" id="logo"
                                    class="dropify form-control-file @error('logo') is-invalid @enderror"
                                    data-default-file="{{ isset($company) ? Storage::url($company->logo) : '' }}"
                                    data-max-file-size="2M">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Add a small note for maximum size -->
                                <small class="form-text text-muted">{{ __('maximum_logo_size') }}</small>
                            </div>





                            <button type="button" class="btn-shadow btn btn-danger" onclick="resetForm('companyFrom')">
                                <i class="fas fa-redo"></i>
                                {{ __('reset') }}
                            </button>

                            @isset($company)
                                <button type="submit" class="btn-shadow btn btn-primary ">
                                    <i class="fas fa-arrow-circle-up opacity-7"></i>
                                    {{ __('update') }}
                                </button>
                            @else
                                <button type="submit" class="btn-shadow btn btn-success">
                                    <i class="fas fa-plus-circle"></i>
                                    {{ __('create') }}
                                </button>
                            @endisset
                        </div>
                    </div>
                </div>
            </form>


        </div>


    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function resetForm(formId) {
            document.getElementById(formId).reset();
        }

        $('.dropify').dropify({


            // Set the maximum image width and height
            maxImageWidth: 100,
            maxImageHeight: 100,
        });
    </script>
@endpush
