<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->is_admin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $required = '';

        // set reqruired for create request
        if (request()->routeIs('lessons.store')) $required = 'required|';

        return [
            'course_id'     => empty($required) ? '' : 'required|exists:courses,id', // ignore if not required
            'title'         => $required . 'string|max:255',
            'description'   => $required . 'string|min:10',
        ];
    }
}
