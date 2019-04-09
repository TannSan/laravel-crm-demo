<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $dynamic_rules = [
            'company_name' => 'required|string|min:1|max:255',
            'company_email' => 'nullable|email|max:400',
            'company_website' => 'nullable|url|max:200',
            'company_logo_upload' => 'nullable|image',
        ];

        if ($this->routeIs("*.update")) {
            return array_merge($dynamic_rules, [
                'company_name' => 'filled|string|min:1|max:255',
            ]);
        }

        return $dynamic_rules;
    }
}
