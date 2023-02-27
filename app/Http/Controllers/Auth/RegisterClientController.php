<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Models\Client;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class RegisterClientController extends Controller
{
    use RegistersUsers;
  

   
    public function __construct()
    {
        $this->middleware('guest:clients');
    }

    public function showClientRegisterForm()
    {
        return view('site.auth.register');
    }

public $message=[
    'email.required' => 'O campo e-mail é de preenchimento obrigatório',
    'email.email' => 'Informe um e-mail válido',
    'email.exists' => 'Informe seu e-mnail',
    'name.required' => 'O campo Nome da Mãe é de preenchimento obrigatório',
    'name.max' => 'O campo Nome da Mãe permite no máximo 255 caracteres',
    'nameBaby.required' => 'O campo Nome do Bebê é de preenchimento obrigatório',
    'birthBaby.required' => 'O campo Nascimento do Bebê é de preenchimento obrigatório',
    'birthBaby.date_format' => 'O campo Nascimento do Bebê deve ser preenchido com uma data válida no formato dd/mm/yyyy',
    'sexBaby.required' => 'O campo Sexo do Bebê é de preenchimento obrigatório',
    'password.required' => 'O campo Senha é de preenchimento obrigatório',
    'password.min' => 'O campo Senha deve ter no mínimo 6 caracteres',
    'password.confirmed' => 'As senhas não estão iguais',
    
    




];
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'nameBaby' => 'required|string|max:255',
            'birthBaby' => 'required|date_format:d/m/Y',
            'sexBaby' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|exists:clients',
            'password' => 'required|string|min:6|confirmed',
        ],$this->message);
    }

    

    protected function createClient(Request $request)
    {
       
        
        $this->validator($request->all())->validate();
       
        $client=Client::where('email',$request->email)->first();
        $expira = Carbon::createFromFormat('Y-m-d', $client->expireAt);
        
        if($client->active=="1" && $expira->isFuture()){
            
        $client->update([
            'name' => $request->name,
            'email' => $request->email,
            'nameBaby' => $request->nameBaby,
            'birthBaby' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->birthBaby)->format('Y-m-d') ,
            'sexBaby' => $request->sexBaby,
            
            'password' => Hash::make($request->password),
        ]);
        return redirect()->intended('/login');
    }else{
        return redirect()->intended('/cadastro')->
        withInput($request->only('email', 'nameBaby', 'birthBaby', 'sexBaby'
     ));
    }

    }

}
