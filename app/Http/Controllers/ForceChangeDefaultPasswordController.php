<?php

namespace App\Http\Controllers;

use Str;
use Auth;
use Mail;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Providers\RouteServiceProvider;
use App\Mail\CambiarContraseñaMailable;

class ForceChangeDefaultPasswordController extends Controller
{
    private $r_t; //resend time
    private $c_l; //code length
    private $e_t; //expiry time

    public function __construct()
    {
        $this->r_t = config('session.resend_t')??5;
        $this->c_l = config('session.code_len')??6;
        $this->e_t = config('session.expiry_t')??60;
    }

    public function ResendCode(Request $request){
        $dateR = Session::get('resent_date');
        if($dateR){
            if(Carbon::now() > $dateR){
                try {
                    Mail::to(Auth::user()->email)->send(new CambiarContraseñaMailable(Session::get('code'), Session::get('expiry_date')->format('d/m/Y, h:i:s A'), Auth::user()->datos->nombre));
                    Session::put('resent_date', Carbon::now()->addMinutes($this->r_t));
                    $data = ['type' => 'success', 'message' => 'El codigo ha sido reenviado.', 'timer' => 1500];
                } catch (\Exception $e) {
                    $data = ['type' => 'warning', 'message' => 'Error al enviar el correo, '.$e->getMessage(), 'timer' => 3000];
                }
            }else{
                $data = ['type' => 'warning', 'message' => 'Aun no puede realizar esta accion, favor de esperar.', 'timer' => 3000];
            }
        }else{
            $data = ['type' => 'error', 'message' => 'Su cuenta no tiene un código vinculado.', 'timer' => 2500];
        }
        return json_encode($data);
    }

    public function Check(Request $request){
        $validated = $request->validate([
            "code_1" => "required|size:1",
            "code_2" => "required|size:1",
            "code_3" => "required|size:1",
            "code_4" => "required|size:1",
            "code_5" => "required|size:1",
            'code_6' => 'required|size:1'
        ]);
        $code = Session::get('code');
        $dateE = Session::get('expiry_date');
        if($code && $dateE){
            $code_req = $request['code_1'].$request['code_2'].$request['code_3'].$request['code_4'].$request['code_5'].$request['code_6'];
            if($code == $code_req){
                if(Carbon::now() < $dateE){
                    Session::put('code', true);
                    return view('auth.change-password');
                }
                return back()->with('warning','El código de verificación ya ha expirado.');
            }
            return back()->with('warning','El código es incorrecto.');
        }
        else
            return back()->with('error','Su cuenta no tiene un código vinculado');
    }

    private function NewCode(){
        $ms = $this->r_t*60*1000;
        $code = Str::random($this->c_l);
        Session::put('code', $code);
        $expiration = Carbon::now()->addMinutes($this->e_t);
        Session::put('expiry_date', $expiration);
        try {
            Mail::to(Auth::user()->email)->send(new CambiarContraseñaMailable($code, $expiration->format('d/m/Y, h:i:s A'), Auth::user()->datos->nombre));
            Session::put('resent_date', Carbon::now()->addMinutes($this->r_t));
            session()->flash('success', 'El correo ha sido enviado correctamente');
        } catch (\Exception $e) {
            $ms = 0;
            session()->flash('warning', 'Error al enviar el correo, '.$e->getMessage());
        }
        return $ms;
    }

    public function index()
    {
        if(!Hash::check('password', Auth::user()->password)) return redirect(RouteServiceProvider::HOME);
        $email = Auth::user()->email;
        $mail_segments = explode("@", $email);
        $len_email = strlen($mail_segments[0])/2;
        $mail_segments[0] = substr($email,0,$len_email).str_repeat("*", (strlen($mail_segments[0])%2) == 0 ? $len_email : $len_email+1);
        $code = Session::get('code');
        $dateE = Session::get('expiry_date');
        $dateR = Session::get('resent_date');
        if($code && $dateE && $dateR){
            if($code === true){
                return view('auth.change-password');
            }else if(Carbon::now() < $dateE){
                $ms = (int)($dateR->valueOf()-Carbon::now()->valueOf());
            }else{
                $ms = $this->NewCode();
                session()->flash('info', 'Se genero un nuevo código');
            }
        }else{
            $ms = $this->NewCode();
        }
        return view('auth.default-password', ['email' => implode("@", $mail_segments), 'ms' => $ms]);
    }

    public function ChangePassword(Request $request){
        $validated = $request->validate([
            'password' => [
                'required',
                'max:50',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
            "password_confirmation" => "required|min:8|max:50|same:password",
        ]);
        if($request->password == $request->password_confirmation){
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect(RouteServiceProvider::HOME);
        }
        return back()->with('error','Las contraseñas no coinciden');
    }
}
