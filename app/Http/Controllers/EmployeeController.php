<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFormRequest;
use \App\Employee;

class EmployeeController extends QueryAwareController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $page_number = null)
    {
        // Process the page and search querystring filters
        if ($this->searchQuerystringExists()) {
            $paginated_employee = Employee::where('firstname', 'LIKE', '%' . \Request::input('search') . '%')
                ->orWhere('lastname', 'LIKE', '%' . \Request::input('search') . '%')
                ->orWhere('phone', 'LIKE', '%' . \Request::input('search') . '%')
                ->orWhere('email', 'LIKE', '%' . \Request::input('search') . '%')
                ->orderBy('firstname')
                ->orderBy('lastname')
                ->paginate(10);
            $page_number = 0;
            $paginated_employee->appends(['search' => \Request::input('search')]);
        } else {
            $paginated_employee = Employee::orderBy('firstname')->orderBy('lastname')->paginate(10);
        }
        if ($page_number) {
            $paginated_employee->setCurrentPage($page_number);
        }
        return view('employee.index', ['employees' => $paginated_employee, 'querystring' => $this->createQuerystring($page_number)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.edit', ['companies' => \App\Company::list(), 'querystring' => $this->createQuerystring()]);
    }

    /**
     * Show the form for the specified resource.
     *
     * @param  int  $id Employee ID
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.edit', ['employee' => $employee, 'companies' => \App\Company::list(), 'querystring' => $this->createQuerystring($this->getEmployeePageNumber($employee))]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RequestEmployeeFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeFormRequest $request)
    {
        $employee = Employee::create([
            'company_id' => $request->employee_company_id,
            'firstname' => $request->employee_firstname,
            'lastname' => $request->employee_lastname,
            'phone' => $request->employee_phone,
            'email' => $request->employee_email,
        ]);

        return redirect()->action('EmployeeController@index', $this->createQueryvars($this->getEmployeePageNumber($employee, true), true));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id Employee ID
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.edit', ['employee' => $employee, 'companies' => \App\Company::list(), 'querystring' => $this->createQuerystring($this->pageQuerystringExists() ? \Request::input('page') : $this->getEmployeePageNumber($employee))]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RequestEmployeeFormRequest   $request
     * @param  int  $id Employee ID
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeFormRequest $request, int $id)
    {
        $employee = Employee::findOrFail($id);
        $original_page_number = $this->getEmployeePageNumber($employee);
        $employee->company_id = $request->employee_company_id;
        $employee->firstname = $request->employee_firstname;
        $employee->lastname = $request->employee_lastname;
        $employee->phone = $request->employee_phone;
        $employee->email = $request->employee_email;
        $employee->save();
        $new_page_number = $this->getEmployeePageNumber($employee);

        return redirect()->action('EmployeeController@index', $this->createQueryvars($this->getEmployeePageNumber($employee, $original_page_number != $new_page_number), $original_page_number != $new_page_number));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id Employee ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $employee = Employee::findOrFail($id);
        $page_number = $this->getEmployeePageNumber($employee);
        $employee->delete();

        // Check to make sure we haven't deleted one at the end and now there is one less page
        $total_pages = ceil(Employee::count() / 10);

        return redirect()->action('EmployeeController@index', $this->createQueryvars($page_number > $total_pages ? $total_pages : $page_number));
    }

    /**
     * Get the pagination page number that the specified employee would appear on.  This can optionaly include the current search term.
     *
     * @param  \App\Employee  $employee    The employee to get the page number for
     * @param  bool  $skip_search    When true the 'search' querystring value is ignored
     * @return integer   Pagination page number for the specified employee
     */
    private function getEmployeePageNumber(Employee $employee, bool $skip_search = null)
    {
        if (!$skip_search && \Request::exists('search') && !empty(\Request::input('search'))) {
            return ceil(Employee::whereRaw('CONCAT_WS(" ", firstname, lastname) <= "' . $employee->name . '"')
                    ->where(function ($query) {
                        $query->where('firstname', 'LIKE', '%' . \Request::input('search') . '%')
                            ->orWhere('lastname', 'LIKE', '%' . \Request::input('search') . '%')
                            ->orWhere('phone', 'LIKE', '%' . \Request::input('search') . '%')
                            ->orWhere('email', 'LIKE', '%' . \Request::input('search') . '%');
                    })
                    ->count() / 10);
        }

        return ceil(Employee::whereRaw('CONCAT_WS(" ", firstname, lastname) <= "' . $employee->name . '"')->count() / 10);
    }
}
