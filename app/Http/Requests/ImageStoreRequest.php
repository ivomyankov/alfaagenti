<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'photo' => 'required|image',
            'imot_id' => 'required|numeric|min:0',
            'position' => 'required|numeric|min:0',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'photo.required' => 'Няма изображение!',
            'photo.image' => 'Този файл не е изображение!',
            'imot_id.numeric' => 'Имот № трябва да е число0',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            //'email' => 'trim|lowercase',
            //'name' => 'trim|capitalize|escape'
        ];
    }
}