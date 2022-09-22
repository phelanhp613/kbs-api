<?php

namespace App\Http\Requests;

class UserSignupRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'form_id' => 'required|numeric',
            'email' => 'required'
        ];
        $formIdValid = false;
        if (!empty($this->form_id)) {
            $signupConfigRepository = app(\App\Repositories\SignupConfigRepository::class);
            $listFieldRequired = $signupConfigRepository->detail($this->form_id);
            if ($listFieldRequired) {
                $formIdValid = true;
                $formFiledList = config('form-signup.list-field');
                foreach ($listFieldRequired->fields as $field) {
                    if (empty($formFiledList[$field]['validate_default'])) {
                        $rules[$field] = 'required';
                    } else {
                        $rules[$field] = 'required|' . $formFiledList[$field]['validate_default'];
                    }
                }
            }
        }
        if (!$formIdValid) {
            $rules['form_id'] = [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $fail('The ' . $attribute . ' is invalid.');
                },
            ];
        }

        return $rules;
    }
}
