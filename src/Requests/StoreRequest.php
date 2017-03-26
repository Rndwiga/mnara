<?php

namespace Tyondo\Mnara\Requests;

//use Tyondo\Mnara\Requests\Request; //no need since the request class is in the same namespace

class StoreRequest extends Request
{

    /**
     * 
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

        $name = $this->route()->getName();
        $tbl = ( str_contains($name, 'role') ) ? 'roles' : 'permissions';

       return [
            'name' => 'required|unique:'.$tbl.'|max:255|min:4',
            'slug' => 'required|unique:'.$tbl.'|max:255|min:4',
        ];

    }
}
