@extends('layouts.authenticated')

@section('page_title') {{ __('crm.employees')}} <a href="/employee/create{{ $querystring }}" title="{{ __('crm.create_employee') }}"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
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
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('crm.total', ['total' => $employees->total()]) }}</span>
                <span class="info-box-number">{{ __('crm.pagination', ['current' => $employees->currentPage(), 'last' => $employees->lastPage()]) }}</span>
            </div>
            <div class="d-flex d-lg-none float-right">{{ $employees->links('vendor.pagination.simple-bootstrap-4') }}</div>
            <div class="d-none d-lg-flex float-right">{{ $employees->links('vendor.pagination.bootstrap-4') }}</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr class="bg-light">
                            <th>{{ __('crm.name') }}</th>
                            <th class="d-none d-sm-table-cell">{{ __('crm.phone') }}</th>
                            <th class="d-none d-xl-table-cell">{{ __('crm.email') }}</th>
                            <th class="d-none d-md-table-cell">{{ __('crm.company') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                        <tr>
                            <td class="align-middle"><a href="/employee/{{ $employee->id }}/edit{{ $querystring }}" title="{{ __('crm.edit', ['Name' => $employee->name]) }}">{{ $employee->name }}</a></td>
                            <td class="align-middle d-none d-sm-table-cell">{!! empty($employee->phone) ? '' : '<a href="tel:'.$employee->phone .'" title="'. __('crm.call', ['Name' => $employee->name]) .'">'.$employee->phone .'</a>' !!}</td>
                            <td class="align-middle d-none d-xl-table-cell">{!! empty($employee->email) ? '' : '<a href="mailto:'.$employee->email .'" title="'. __('crm.send_email', ['Name' => $employee->name]) .'">'.$employee->email .'</a>' !!}</td>
                            <td class="align-middle d-none d-md-table-cell">{!! empty($employee->company_id) ? '' : '<a href="/company/'.$employee->company_id .'" title="'. __('crm.edit', ['Name' => $employee->company_name]) .'">'.$employee->company_name .'</a>' !!}</td>
                            <td class="align-middle text-right">
                                <form action="/employee/{{ $employee->id . $querystring }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-warning" role="button" href="/employee/{{ $employee->id }}/edit{{ $querystring }}" title="{{ __('crm.edit', ['Name' => $employee->name]) }}"><i class="fa fa-pencil"></i></a>
                                        <button type="submit" class="btn btn-danger" role="button" title="{{ __('crm.confirm_deletion', ['Name' => $employee->name]) }}" data-toggle="confirmation"><i class='fa fa-trash'></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger font-weight-bold">{{ __('crm.no_employees') . (\Request::exists('search') && !empty(\Request::input('search')) ? __('crm.none_with_search') : '') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@if($employees->hasMorePages())
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex d-sm-none float-right">{{ $employees->links('vendor.pagination.simple-bootstrap-4') }}</div>
                <div class="d-none d-sm-flex float-right">{{ $employees->links('vendor.pagination.bootstrap-4') }}</div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection