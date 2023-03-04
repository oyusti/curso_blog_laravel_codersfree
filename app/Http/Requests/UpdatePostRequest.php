<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'         =>  'required|string|max:255', //solo se permite string maximo 255 caracteres
            'slug'          =>  'required|string|max:255|unique:posts,slug,' .$this->route('post')->id,//esto se coloca para que sepa de donde encontrar estos datos
            'category_id'   =>  'required|integer|exists:categories,id', //solo se permite entero y que exista la variable categories_id
            'summary'       =>  $this->request->get('is_published') ? 'required|string' : 'nullable',//si is_published es true se aplica la validacion, en cambio si es false me deja enviar y no se aplica la validacion
            'content'       =>  $this->request->get('is_published') ? 'required|string' : 'nullable',//si is_published es true se aplica la validacion, en cambio si es false me deja enviar y no se aplica la validacion
            'is_published'  =>  'required|boolean'
        ];
    }
}
