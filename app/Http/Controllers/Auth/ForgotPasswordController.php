<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function recuperar_password(Request $request){

        return view('auth.passwords.recuperar_password');
    }

    public function comprobar_email_usuario(Request $request){
        return $request;
    }

    public function recuperar_password_enviar_mail(Request $request){

        $usuario = User::where('email',$request->email_password_reset)->first();

        if ($usuario) {
            $mensaje = 'existe';
        }else{
            $mensaje = 'no existe';
        }

        $tipo = 'error';

        return redirect()->route('recuperar_password_enviar_mail')->with($tipo, $mensaje);
    }

}
