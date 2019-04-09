<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyFormRequest;
use \App\Company;

class CompanyController extends QueryAwareController
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
            $paginated_company = Company::where('name', 'LIKE', '%' . \Request::input('search') . '%')
                ->orWhere('website', 'LIKE', '%' . \Request::input('search') . '%')
                ->orWhere('email', 'LIKE', '%' . \Request::input('search') . '%')
                ->orderBy('name')
                ->paginate(10);
            $page_number = 0;
            $paginated_company->appends(['search' => \Request::input('search')]);
        } else {
            $paginated_company = Company::orderBy('name')->paginate(10);
        }
        if ($page_number) {
            $paginated_company->setCurrentPage($page_number);
        }
        return view('company.index', ['companies' => $paginated_company, 'querystring' => $this->createQuerystring($page_number)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.edit', ['querystring' => $this->createQuerystring()]);
    }

    /**
     * Show the form for the specified resource.
     *
     * @param  int  $id Company ID
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit', ['company' => $company, 'querystring' => $this->createQuerystring($this->getCompanyPageNumber($company))]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RequestCompanyFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyFormRequest $request)
    {
        $company = Company::create([
            'name' => $request->company_name,
            'website' => $request->company_website,
            'email' => $request->company_email,
            'logo' => $request->company_logo,
        ]);

        $this->handleImageUpload($request, $company);

        return redirect()->action('CompanyController@index', $this->createQueryvars($this->getCompanyPageNumber($company, true), true));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id Company ID
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit', ['company' => $company, 'employees' => \App\Employee::where('company_id', $id)->orderBy('firstname')->orderBy('lastname')->get(), 'querystring' => $this->createQuerystring($this->pageQuerystringExists() ? \Request::input('page') : $this->getCompanyPageNumber($company))]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RequestCompanyFormRequest   $request
     * @param  int  $id Company ID
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyFormRequest $request, int $id)
    {
        $company = Company::findOrFail($id);
        $original_page_number = $this->getCompanyPageNumber($company);
        $company->name = $request->company_name;
        $company->website = $request->company_website;
        $company->email = $request->company_email;
        $company->save();
        $new_page_number = $this->getCompanyPageNumber($company);

        $this->handleImageUpload($request, $company);

        return redirect()->action('CompanyController@index', $this->createQueryvars($this->getCompanyPageNumber($company, $original_page_number != $new_page_number), $original_page_number != $new_page_number));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id Company ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $company = Company::findOrFail($id);
        $page_number = $this->getCompanyPageNumber($company);
        if (!empty($company->logo)) {
            \File::delete(public_path('storage/' . $company->logo));
        }
        $company->delete();

        // Check to make sure we haven't deleted one at the end and now there is one less page
        $total_pages = ceil(Company::count() / 10);

        return redirect()->action('CompanyController@index', $this->createQueryvars($page_number > $total_pages ? $total_pages : $page_number));
    }

    /**
     * Handles uploading the images to the server and setting the company's logo path.
     *
     * @param  \Illuminate\Http\RequestCompanyFormRequest   $request
     * @param  \App\Company   $company  The company this image is being uploaded for.
     * @return \Illuminate\Http\Response
     */
    private function handleImageUpload(CompanyFormRequest $request, Company $company)
    {
        if ($request->hasFile('company_logo_upload')) {
            $image = $request->company_logo_upload;
            $image_name = 'company_' . $company->id . '.' . $image->extension();
            $image = \Image::make($image);
            $image->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image_path = public_path('storage/' . $image_name);
            $image->save($image_path);
            $company->logo = $image_name;
            $company->save();
        }
    }

    /**
     * Get the pagination page number that the specified company would appear on.  This can optionaly include the current search term.
     *
     * @param  \App\Company  $company    The company to get the page number for
     * @param  bool  $skip_search    When true the 'search' querystring value is ignored
     * @return integer   Pagination page number for the specified company
     */
    private function getCompanyPageNumber(Company $company, bool $skip_search = null)
    {
        if (!$skip_search && \Request::exists('search') && !empty(\Request::input('search'))) {
            return ceil(Company::where('name', '<=', $company->name)
                    ->where(function ($query) {
                        $query->where('name', 'LIKE', '%' . \Request::input('search') . '%')
                            ->orWhere('website', 'LIKE', '%' . \Request::input('search') . '%')
                            ->orWhere('email', 'LIKE', '%' . \Request::input('search') . '%');
                    })
                    ->count() / 10);
        }

        return ceil(Company::where('name', '<=', $company->name)->count() / 10);
    }
}
