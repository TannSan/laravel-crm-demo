@extends('layouts.authenticated')

@section('page_title') {{ __('crm.companies')}} <a href="/company/create{{ $querystring }}" title="{{ __('crm.create_company') }}"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
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
            <span class="info-box-icon bg-success"><i class="fa fa-building"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{ __('crm.total', ['total' => $companies->total()]) }}</span>
                <span class="info-box-number">{{ __('crm.pagination', ['current' => $companies->currentPage(), 'last' => $companies->lastPage()]) }}</span>
            </div>
            <div class="d-flex d-lg-none float-right">{{ $companies->links('vendor.pagination.simple-bootstrap-4') }}</div>
            <div class="d-none d-lg-flex float-right">{{ $companies->links('vendor.pagination.bootstrap-4') }}</div>
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
                            <th class="d-none d-sm-table-cell">{{ __('crm.logo') }}</th>
                            <th>{{ __('crm.name') }}</th>
                            <th class="d-none d-xl-table-cell">{{ __('crm.website') }}</th>
                            <th class="d-none d-xl-table-cell">{{ __('crm.email') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($companies as $company)
                        <tr>
                            <td class="d-none d-sm-table-cell"><img src="{{ $company->logo_url }}" alt=" " title="{{ $company->name . ' ' . __('crm.logo') }}" /></td>
                            <td class="align-middle"><a href="/company/{{ $company->id }}/edit{{ $querystring }}" title="{{ __('crm.edit', ['Name' => $company->name]) }}">{{ $company->name }}</a></td>
                            <td class="align-middle d-none d-xl-table-cell">{!! empty($company->website) ? '' : '<a href="'.$company->website .'" title="'. __('crm.visit', ['Name' => $company->name]) .'">'.$company->website .'</a>' !!}</td>
                            <td class="align-middle d-none d-xl-table-cell">{!! empty($company->email) ? '' : '<a href="mailto:'.$company->email .'" title="'. __('crm.send_email', ['Name' => $company->name]) .'">'.$company->email .'</a>' !!}</td>
                            <td class="align-middle text-right">
                                <form action="/company/{{ $company->id . $querystring }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-warning" role="button" href="/company/{{ $company->id }}/edit{{ $querystring }}" title="{{ __('crm.edit', ['Name' => $company->name]) }}"><i class="fa fa-pencil"></i></a>
                                        <button type="submit" class="btn btn-danger" role="button" title="{{ __('crm.confirm_deletion', ['Name' => $company->name]) }}" data-content="{{ __('crm.delete_company_warning') }}" data-toggle="confirmation"><i class='fa fa-trash'></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger font-weight-bold">{{ __('crm.no_companies') . (\Request::exists('search') && !empty(\Request::input('search')) ? __('crm.none_with_search') : '') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@if($companies->hasMorePages())
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex d-sm-none float-right">{{ $companies->links('vendor.pagination.simple-bootstrap-4') }}</div>
                <div class="d-none d-sm-flex float-right">{{ $companies->links('vendor.pagination.bootstrap-4') }}</div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection