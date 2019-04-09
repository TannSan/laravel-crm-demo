@extends('layouts.authenticated')
@section('page_title') {!! isset($employee) ? __('crm.editing', ['Name' => $employee->name]) : __('crm.creating', ['Name' => 'Employee']) !!}
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
            <form role="form" form method="POST" action="{{ isset($employee) ? route('employee.update', $employee->id) : route('employee.store') }}{{ $querystring }}" enctype="multipart/form-data">
                @if(isset($employee))
                @method('PUT')
                @else
                @method('POST')
                @endif
                @csrf @if ($errors->any())
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
                        <label for="employee_firstname">{{ __('crm.firstname') }}*</label>
                        <input type="text" class="form-control{{ $errors->has('employee_firstname') ? ' bg-danger border-danger' : '' }}" id="employee_firstname" name="employee_firstname" placeholder="Enter {{ __('crm.firstname') }}" value="{{ old('employee_firstname', isset($employee) ? $employee->firstname : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="employee_lastname">{{ __('crm.lastname') }}*</label>
                        <input type="text" class="form-control{{ $errors->has('employee_lastname') ? ' bg-danger border-danger' : '' }}" id="employee_lastname" name="employee_lastname" placeholder="Enter {{ __('crm.lastname') }}" value="{{ old('employee_lastname', isset($employee) ? $employee->lastname : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="employee_email">{{ __('crm.email') }}</label>
                        <input type="text" class="form-control{{ $errors->has('employee_email') ? ' bg-danger border-danger' : '' }}" id="employee_email" name="employee_email" placeholder="Enter {{ __('crm.email') }}" value="{{ old('employee_email', isset($employee) ? $employee->email : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="employee_phone">{{ __('crm.phone') }}</label>
                        <input type="text" class="form-control{{ $errors->has('employee_phone') ? ' bg-danger border-danger' : '' }}" id="employee_phone" name="employee_phone" placeholder="Enter {{ __('crm.phone') }}" value="{{ old('employee_phone', isset($employee) ? $employee->phone : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="employee_company_id">{{ __('crm.company') }}</label>
                        <select class="custom-select form-control{{ $errors->has('employee_company_id') ? ' bg-danger border-danger' : '' }}" id="employee_company_id" name="employee_company_id" >
                            @php($selected_company_id = old('employee_company_id', isset($employee) ? $employee->company_id : null))
                            <option value=""{{ is_null($selected_company_id) ? ' selected' : '' }}>{{ __('crm.none') }}</option>
                            @foreach ($companies as $company_id => $company_name)
                                <option value="{{ $company_id }}"{!! $selected_company_id == $company_id ? 'selected="selected"' : '' !!}>{{ $company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">{{ __('crm.save') }}</button>
                    <a href="{!! route('employee.index') . $querystring !!}" class="btn btn-secondary">{{ __('crm.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection