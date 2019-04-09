@extends('layouts.authenticated')

@section('page_title') {!! isset($company) ? __('crm.editing', ['Name' => $company->name]) : __('crm.creating', ['Name' => 'Company']) !!}
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <form role="form" form method="POST" action="{{ isset($company) ? route('company.update', $company->id) : route('company.store') }}{{ $querystring }}" enctype="multipart/form-data">
                @if(isset($company))
                @method('PUT')
                @else
                @method('POST')
                @endif
                @csrf
                @if ($errors->any())
                <div class="card-header alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    <div class="form-group">
                        <label for="company_name">{{ __('crm.name') }}*</label>
                        <input type="text" class="form-control{{ $errors->has('company_name') ? ' bg-danger border-danger' : '' }}" id="company_name" name="company_name" placeholder="Enter {{ __('crm.name') }}" value="{{ old('company_name', isset($company) ? $company->name : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="company_website">{{ __('crm.website') }}</label>
                        <input type="text" class="form-control{{ $errors->has('company_website') ? ' bg-danger border-danger' : '' }}" id="company_website" name="company_website" placeholder="Enter {{ __('crm.website') }}" value="{{ old('company_website', isset($company) ? $company->website : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="company_email">{{ __('crm.email') }}</label>
                        <input type="text" class="form-control{{ $errors->has('company_email') ? ' bg-danger border-danger' : '' }}" id="company_email" name="company_email" placeholder="Enter {{ __('crm.email') }}" value="{{ old('company_email', isset($company) ? $company->email : '') }}">
                    </div>
                    @if (isset($company->logo))
                    <div class="form-group">
                        <label for="company_logo_image">{{ __('crm.logo') }}</label>
                        <div><img src="{{ $company->logo_url }}" alt=" " id="company_logo_image" title="{{ $company->name . ' ' . __('crm.logo') }}" /></div>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="company_logo_upload">{{ __('crm.upload_new_logo') }}</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="company_logo_upload" name="company_logo_upload">
                            <label class="custom-file-label" for="company_logo_upload">{{ __('crm.choose_file') }}</label>
                        </div>
                    </div>
                    @if(isset($company) && isset($employees))
                    <div class="form-group">
                        <label for="company_employees">{{ __('crm.employees') }}: {{ count($employees) }}</label>
                        <select class="custom-select" id="company_employees" name="company_employees" size="5" disabled>
                            @foreach ($employees as $employee)
                                <option>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">{{ __('crm.save') }}</button>
                    <a href="{!! route('company.index') . $querystring !!}" class="btn btn-secondary">{{ __('crm.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection