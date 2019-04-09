<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $dynamic_rules = [
            'employee_company_id' => 'sometimes|nullable|integer',
            'employee_firstname' => 'required|string|max:255',
            'employee_lastname' => 'required|string|max:255',
            'employee_email' => 'nullable|email|max:255',
            'employee_phone' => 'nullable|string|max:255',
        ];

        if ($this->routeIs("*.update")) {
            return array_merge($dynamic_rules, [
                'employee_firstname' => 'filled|string|max:255',
                'employee_lastname' => 'filled|string|max:255',
            ]);
        }

        return $dynamic_rules;
    }
}
