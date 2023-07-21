@extends('layouts.app')

@section('title', __('Employee'))

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
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"></i>
                </div>
                <div>{{ __(isset($employee) ? 'edit_employee' : 'create_employee') }}</div>
            </div>
            <div class="page-title-actions">
                <div class="d-inline-block dropdown">
                    <a href="{{ route('employees.index') }}" class="btn-shadow btn btn-danger">
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
            <form role="form" id="employeeForm"
                action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @isset($employee)
                    @method('PUT')
                @endisset

                <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="first_name">{{ __('first_name') }} <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ old('first_name') ?? ($employee->first_name ?? '') }}"
                                            name="first_name" id="first_name" placeholder="{{ __('first_name') }}"
                                            type="text"
                                            class="form-control rounded @error('first_name') is-invalid @enderror">
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="last_name">{{ __('last_name') }} <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ old('last_name') ?? ($employee->last_name ?? '') }}"
                                            name="last_name" id="last_name" placeholder="{{ __('last_name') }}"
                                            type="text"
                                            class="form-control rounded @error('last_name') is-invalid @enderror">
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_id">{{ __('company') }}</label>
                                <select name="company_id" id="company_id"
                                    class="form-control rounded @error('company_id') is-invalid @enderror">
                                    <option value="">-- {{ __('select_company') }} --</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ (old('company_id') ?? ($employee->company_id ?? '')) == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="email">{{ __('email') }}</label>
                                        <input value="{{ old('email') ?? ($employee->email ?? '') }}" name="email"
                                            id="email" placeholder="{{ __('email') }}" type="email"
                                            class="form-control rounded @error('email') is-invalid @enderror">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="phone">{{ __('phone') }}</label>
                                        <input value="{{ old('phone') ?? ($employee->phone ?? '') }}" name="phone"
                                            id="phone" placeholder="{{ __('phone') }}" type="text"
                                            class="form-control rounded @error('phone') is-invalid @enderror">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn-shadow btn btn-danger" onclick="resetForm('employeeForm')">
                                <i class="fas fa-redo"></i>
                                {{ __('reset') }}
                            </button>

                            @isset($employee)
                                <button type="submit" class="btn-shadow btn btn-primary">
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

        $('.dropify').dropify();
    </script>
@endpush
