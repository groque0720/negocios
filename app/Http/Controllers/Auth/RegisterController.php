<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Negocio;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/redirigir';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => 'required|max:255|unique:negocios',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        // ]);

        $this->validator($data);

        $usuario = new User;
        $usuario->name = $data['name'];
        $usuario->email = $data['email'];
        $usuario->password = bcrypt($data['password']);
        $usuario->remember_token = md5(microtime());
        $usuario->perfil_id = 2;
        $usuario->save();

        $negocio = new Negocio;
        $negocio->user_id = $usuario->id;
        $negocio->nombre =  $data['nombre'];
        $negocio->codigo = md5(microtime());
        $negocio->url = $this->url_nombre_negocio($data['nombre']);
        $negocio->activo = true;
        $negocio->save();

        mkdir("storage/".$negocio->url, 0755);

        return $usuario;
    }

    public function url_nombre_negocio($string){
        //$string = 'la [casá    de los  sueños  ';
        $string = trim($string);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array('¨', 'º', '-', '~', '@',
                 '#', '@', '|', '!',
                 '·', '$', '%', '&', '/',
                 '(', ')', '?', '¡',
                 '¿', '[', '^', '<code>', ']',
                 '+', '}', '{', '¨', '´',
                 '>', '< ', ';', ',', ':',
                 '.'),
            '',
            $string
        );

        $url_negocio = '';
        $cant = 0;

        $palabras = str_word_count(strtolower($string), 1);

        foreach ($palabras as $palabra) {
            $cant ++;
            if ($cant > 1) {
                $url_negocio .=$palabra;
            }else{
                $url_negocio .=$palabra;
            }
        }

        return $url_negocio;
    }
}
