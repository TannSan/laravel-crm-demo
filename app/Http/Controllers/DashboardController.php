<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Create chart data
        $employees_vs_companies = DB::table('employees')
            ->select('company_id', DB::raw('count(*) as total, companies.name as name'))
            ->groupBy('company_id', 'name')
            ->orderBy('name')
            ->join('companies', 'companies.id', '=', 'employees.company_id')
            ->pluck('total', 'name');

        $chart_data = [
            'labels' => array_keys($employees_vs_companies->toArray()),
            'datasets' => array_values($employees_vs_companies->toArray()),
        ];

        return view('dashboard', ['company_count' => \App\Company::count(), 'employee_count' => \App\Employee::count(), 'chart_data' => $chart_data]);
    }
}
