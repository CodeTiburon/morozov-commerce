<?php
namespace App\AuthCustom;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomUserProvider implements UserProvider {

    protected $model;

    public function __construct(UserContract $model)
    {
        $this->model = $model;
    }
    public function retrieveById($identifier)
    {
    }
    public function retrieveByToken($identifier, $token)
    {
    }
    public function updateRememberToken(UserContract $user, $token)
    {
    }
    public function retrieveByCredentials(array $credentials)
    {
        $user =  $this->dummyUser();
        $this->user = $user;
        return $user;
    }
    public function validateCredentials(UserContract $user, array $credentials)
    {
        return true;
    }

    protected function dummyUser()
    {
        $attributes = array(
            'id' => 123,
            'remember_token' => "",
            'username' => 'chuckles',
            'password' => \Hash::make('SuperSecret'),
            'name' => 'Dummy User',
        );
        return new GenericUser($attributes);
    }
}