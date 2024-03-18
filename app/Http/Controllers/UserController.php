<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home.index');
        }
    }

    /**
     * .
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $erro = 0;
        $messagem = 'Account created successfully, email sent!!';

        $validator =  Validator::make(
            $request->all(),
            [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]
        );

        if ($validator->errors()->count() > 0) {
            if ($request->ajax()) {
                return ['error' => 1, 'message' => implode("\n", $validator->errors()->all())];
            }
            return $validator->validate();
        }


        $email = $request->input('email');
        $name = $request->input('name');

        $user = new User();
        $password = $user->generatePassword(8, true, true, true, true);
        $user->email = $email;
        $user->name = $name;
        $user->password = Hash::make($password);

        if (!$user->save()) {
            $erro = 1;
            $messagem = 'An error occurred while saving, please try again later!';
        }

        $data = ['email' => $email, 'password' => $password, 'name' => $name];
        try {
            Mail::send(
                'email.register',
                $data,
                function ($message) use ($user) {
                    $message
                        ->to($user->email, $user->name)
                        ->subject('Registration completed on holiday, here are your passwords!');
                }
            );
        } catch (\Throwable $th) {
            //throw $th;
        }

        if ($request->ajax()) {
            return ['error' => $erro, 'message' => $messagem];
        }

        session()->flash($erro ? 'error' : 'success', $messagem);

        return view('auth.login');
    }


    /**
     *
     * @param  Request $request
     */
    public function contato(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_name'            => "required|regex:/^[a-zà-ź]+(([',. -][a-zà-ź ])?[a-zà-ź]*)*$/i",
                'from_email'           => 'required|email',
                //'subject'              => 'required',
                'the_message'          => 'required',
                'g-recaptcha-response' => 'required|captcha',
            ],
            [
                'from_name.required'            => 'Preencha o seu nome!',
                'from_name.regex'               => 'Insira seu nome completo!',
                'from_phone.required'           => 'Informe o seu telefone!',
                'from_phone.regex'              => 'Informe um telefone válido!',
                'from_email.required'           => 'Informe seu e-mail!',
                'from_email.regex'              => 'Informe um e-mail válido!',
                'subject.required'              => 'Informe o assunto!',
                'the_message.required'          => 'Preencha a mensagem!',
                'g-recaptcha-response.required' => 'Faça a validação do captcha!',
                'g-recaptcha-response.captcha'  => 'Faça a validação do captcha!',
            ]
        );

        $validator->validate();

        if ($validator->errors()->count() == 0) {
            $data = array(
                'mail_from_name'  => env('MAIL_FROM_NAME', 'Loji'),
                'mail_from_email' => env('MAIL_FROM_ADDRESS', 'oi@mail.loji.com.br'),
                'to_name'         => env('MAIL_TO_NAME', 'Loji'),
                'to_email'        => env('MAIL_TO_ADDRESS', 'oi@mail.loji.com.br'),
                'from_name'       => $request->input('from_name', ''),
                'from_email'      => $request->input('from_email', ''),
                'from_phone'      => $request->input('from_phone', ''),
                'subject'         => (
                    config('app.name', 'Loji') .
                    " - Solicitação de contato - " .
                    $request->input('from_name', '')
                ),
                'the_message'     => $request->input('the_message', ''),
            );

            try {
                Mail::send(
                    'emails.contato',
                    $data,
                    function ($message) use ($data) {
                        $message
                            ->replyTo($data['from_email'], $data['from_name'])
                            ->to($data['to_email'], $data['to_name'])
                            ->subject($data['subject']);
                    }
                );

                session()->flash('success', 'Solicitação de contato enviada!');
            } catch (\Exception $ex) {
                $errors = implode('<br>', $validator->errors()->all());

                if (!$errors) {
                    $errors = $ex->getMessage();
                }

                session()->flash('error', 'Falha ao enviar solicitação de contato:<br>' . $errors);
            }
        }

        return redirect()->back();
    }
}
