@extends('layouts.authenticated')

@section('page_title') {{ __('crm.dashboard')}}
@endsection

@section('navbar')
    @include('partials.navbar')
@endsection

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-building"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a href="{{ route('company.index') }}">{{ __('crm.companies')}}</a></span>
                <span class="info-box-number">{{ $company_count }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a href="{{ route('employee.index') }}">{{ __('crm.employees')}}</a></span>
                <span class="info-box-number">{{ $employee_count }}</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title">Employee Comparison</h3>
            </div>
            <div class="card-body d-none d-md-block">
                <div class="chart">
                    <canvas id="barChart" style="height: 382px; width: 764px;" width="764" height="382"></canvas>
                </div>
            </div>
            <div class="card-body d-block d-md-none">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-primary">
                                <th>{{ __('crm.companies') }}</th>
                                <th class="text-center">{{ __('crm.employees') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($chart_data[ 'labels']); $i++)
                                <tr>
                                    <td>{{ $chart_data['labels'][$i] }}</td>
                                    <td class="text-center">{{ $chart_data['datasets'][$i] }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.chartData = {
        labels: ["{!! implode('","', $chart_data['labels']) !!}"],
        datasets: [
            {
                label: 'Employees',
                borderWidth: 1,
                backgroundColor: '#2c8abe',
                borderColor: '#006892',
                hoverBackgroundColor: '#51beed',
                hoverBorderColor: '#006892',
                data: ["{!! implode('","', $chart_data['datasets']) !!}"]
            }
        ]
    };

</script>
@endsection