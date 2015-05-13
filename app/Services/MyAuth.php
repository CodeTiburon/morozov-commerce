<?php namespace App\Services;

use App\User;
use Illuminate\Contracts\Auth\Registrar;
use Validator;

class MyAuth {

    public function isAdmin()
    {
        if(\Auth::check() && \Auth::user()->user_role_id === '3') {
            return true;
        } else {
            return false;
        }
    }

    public function checkCategoryField($field)
    {
        $messages = [
            'required' => 'The category name field is required.',
        ];
        $rules = ['name' => ['required', 'min:5', 'unique:categories', 'string']];
        $validator = Validator::make(
            ['name' => $field],
            $rules,
            $messages
        );
        return $validator;
    }

    public function checkProductField($fields)
    {
        $rules = array(
            'file' => 'mimes:png,gif,jpeg',
            'name' => 'required|min:5'
        ); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
        $validator = Validator::make(
            array(
                'file'=> $fields['file'],
                'name'=> $fields['name']
            ), $rules
        );
        return $validator;
    }

    public function tokenEncrypt()
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return $encrypted_token;
    }


}
