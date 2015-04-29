<?php namespace App\Services;

use App\User;
use Illuminate\Contracts\Auth\Registrar;
use Validator;

class MyAuth {

    public function isAdmin(){
        if(\Auth::check() && \Auth::user()->user_role_id === '3') {
            return true;
        } else {
            return false;
        }
    }

    public function checkCategoryField($field){
        $messages = [
            'required' => 'The category name field is required.',
        ];
        $validator = Validator::make(
            ['name' => $field],
            ['name' => ['required', 'min:5', 'unique:categories', 'string']],
            $messages
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
