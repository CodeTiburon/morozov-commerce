<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

    protected $redirectTo = '/admin';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

    public function postRegister(Request $request)
    {
        $json = array();
        $validator = $this->registrar->validator($request->all());

        if ($validator->fails())
        {
            $json['errors'] = $validator->messages();
//			$this->throwValidationException(
//				$request, $validator
//			);
        } else {
            $this->auth->login($this->registrar->create($request->all()));
            $json['success'] = true;
            $json['redirect_url'] = $this->redirectPath();
        }

        return response()->json($json);

        //return redirect($this->redirectPath());
    }


    public function postLogin(Request $request)
    {
        $json = array();
//		$this->validate($request, [
//			'email' => 'required|email', 'password' => 'required',
//		]);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
            $json['success'] = true;
            $json['redirect_url'] = redirect()->intended($this->redirectPath());
            //return redirect()->intended($this->redirectPath());
        }

        /*		return redirect($this->loginPath())
                            ->withInput($request->only('email', 'remember'))
                            ->withErrors([
                                'email' => $this->getFailedLoginMessage(),
                            ]);*/
        $json['errors'] = array('email' => $this->getFailedLoginMessage());
        return response()->json($json);
    }

}
