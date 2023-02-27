<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Challenge;
use App\Notifications\ChallengeTelegramNotification;
use App\Notifications\ChatTelegramNotification;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Message;
use App\Models\Module;
use App\Models\Submodule;
use App\Models\Doubt;


class ChallengeController extends Controller
{

    public function __construct(Challenge $challenge)
    {

        $this->repository = $challenge;
        $this->middleware('auth.client:clients');
    }

    public function index()
    {
        $challenges = Auth::guard('clients')->user()->challenges()->get();

        $latest_challenge = Auth::guard('clients')->user()->challenges()->latest()->first();

        return view('site.desafio.index', compact('challenges', 'latest_challenge'));
    }

    public function chat()
    {


        return view('site.desafio.chat');
    }

    public function store(Request $request)
    {
        $client = Auth::guard('clients')->user();
        $challenge = $client->challenges()->create([
            'status' => 'INICIADO',
          
        ]);
        return redirect()->route('desafio.show', $challenge->id);
    }

    public function show($id)
    {
        if (!$challenge = $this->repository->find($id)) {
            return redirect()->back();
        }
        if ($this->repository->find($id)->client_id != Auth::guard('clients')->user()->id) {
            return redirect()->back();
        }

        // dd(Auth::guard('clients')->user()->id);
        $challenge = $this->repository->find($id);

        $analyzes = $challenge->analyzes()->get();

        if($challenge->tipo==1){

        return view('site.desafio.show2', compact('analyzes', 'challenge'));
        }else{
            return view('site.desafio.show', compact('analyzes', 'challenge'));

        }

    }

    public function analyzeCreate($id, $day)
    {
        if ($day < 1 || $day > 7) {
            return redirect()->back();
        }
        if (!$challenge = $this->repository->find($id)) {
            return redirect()->back();
        }

        if (!$this->repository->find($id)->client_id == Auth::guard('clients')->user()->id) {
            return redirect()->back();
        }



        $challenge = $this->repository->find($id);
        if (isset($this->repository->find($id)->analyzes()->where('day', $day)->first()->day)) {
            return redirect()->back();
        }

        if ($day > 1) {
            if ($this->repository->find($id)->client->liberado == 1) {
                if (
                    !isset($this->repository->find($id)->analyzes()->where('day', $day - 1)->first()->day)


                ) {
                    return redirect()->back();
                }
            } else
            if (
                !isset($this->repository->find($id)->analyzes()->where('day', $day - 1)->first()->day)
                || !(date_format(now(), 'Y-m-d') >= date_format($challenge->analyzes()->where('day', $day - 1)->first()->created_at->addDays(1), 'Y-m-d'))

            ) {
                return redirect()->back();
            }
        }






        $challenge = $this->repository->find($id);
        return view('site.desafio.create', compact('challenge', 'day'));
    }
    public function analyzeCreateForm($id)
    {
        if (!$challenge = $this->repository->find($id)) {
            return redirect()->back();
        }

        if (!$this->repository->find($id)->client_id == Auth::guard('clients')->user()->id) {
            return redirect()->back();
        }



        if (isset($this->repository->find($id)->form()->first()->id)) {
            return redirect()->back();
        }
        $challenge = $this->repository->find($id);

        if ($this->repository->find($id)->client->liberado == 1) {
            if (
                !isset($this->repository->find($id)->analyzes()->where('day', '7')->first()->day)
            ) {
                return redirect()->back();
            }
        } else
        if (
            !isset($this->repository->find($id)->analyzes()->where('day', '7')->first()->day)
            || !(date_format(now(), 'Y-m-d') >= date_format($challenge->analyzes()->where('day', '7')->first()->created_at->addDays(1), 'Y-m-d'))
        ) {
            return redirect()->back();
        }




        return view('site.desafio.form', compact('challenge'));
    }

    public function analyzeEditForm($id)
    {
        if (!$challenge = $this->repository->find($id)) {
            return redirect()->back();
        }

        if (!$this->repository->find($id)->client_id == Auth::guard('clients')->user()->id) {
            return redirect()->back();
        }

        $challenge = $this->repository->find($id);
        if (!$form = $challenge->form) {
            return redirect()->back();
        }
        //dd($form);
        return view('site.desafio.form-edit', compact('challenge', 'form'));
    }

    public function desafioUpdate($id)
    {
        if (!$challenge = $this->repository->find($id)
            || !$this->repository->find($id)->client_id == Auth::guard('clients')->user()->id) {

            return redirect()->back();
        }
        $challenge = $this->repository->find($id);
        $challenge->update([
            'status' => 'ENVIADO', 'sended_at' => now(),
        ]);
        //   $challenge->notify(new ChallengeTelegramNotification());

        return redirect()->route('desafio.show', $challenge->id)->with('sucesso', 'Desafio Enviado!');
    }

    public $message = [
        'date.required' => 'O campo Data da Avaliação é de preenchimento obrigatório',
        'date.date_format' => 'O campo Data da Avaliação deve ser preenchido no formato dd/mm/aaaa',

        'timeWokeUp.required' => 'O campo Horário que Acordou é de preenchimento obrigatório',
        'timeWokeUp.date_format' => 'O campo Horário que Acordou deve ser preenchido no formato HH:mm ',

        'comments.max' => 'O campo de Observações deve ter no máximo 200 caracteres',

        'soneca1_ss.after_or_equal' => 'O campo Horário que sentiu sono da Soneca 1 deve ser um horário após o Horário que Acordou',
        'soneca1_ss.date_format' => 'O campo Horário que sentiu sono da Soneca 1 deve ser preenchido no formato HH:mm ',

        'soneca1_hd.after_or_equal' => 'O campo Horário que dormiu  da Soneca 1 deve ser um horário após o Horário que sentiu sono da Soneca 1',
        'soneca1_hd.date_format' => 'O campo Horário que dormiu  da Soneca 1 deve ser preenchido no formato HH:mm ',
        'soneca1_hd.required_unless' => 'Preencha os dados completos da Soneca 1',

        'soneca1_ha.after_or_equal' => 'O campo Horário que acordou  da Soneca 1 deve ser um horário após o Horário que dormiu da Soneca 1',
        'soneca1_ha.date_format' => 'O campo Horário que acordou  da Soneca 1 deve ser preenchido no formato HH:mm ',
        'soneca1_ha.required_unless' => 'Preencha os dados completos da Soneca 1',

        'soneca2_ss.after_or_equal' => 'O campo Horário que sentiu sono da Soneca 2 deve ser um horário após o Horário que Acordou da Soneca 1',
        'soneca2_ss.date_format' => 'O campo Horário que sentiu sono da Soneca 2 deve ser preenchido no formato HH:mm ',

        'soneca2_hd.after_or_equal' => 'O campo Horário que dormiu  da Soneca 2 deve ser um horário após o Horário que sentiu sono da Soneca 2',
        'soneca2_hd.date_format' => 'O campo Horário que dormiu  da Soneca 2 deve ser preenchido no formato HH:mm ',
        'soneca2_hd.required_unless' => 'Preencha os dados completos da Soneca 2',

        'soneca2_ha.after_or_equal' => 'O campo Horário que acordou  da Soneca 2 deve ser um horário após o Horário que dormiu da Soneca 2',
        'soneca2_ha.date_format' => 'O campo Horário que acordou  da Soneca 2 deve ser preenchido no formato HH:mm ',
        'soneca2_ha.required_unless' => 'Preencha os dados completos da Soneca 2',

        'soneca3_ss.after_or_equal' => 'O campo Horário que sentiu sono da Soneca 3 deve ser um horário após o Horário que Acordou da Soneca 2',
        'soneca3_ss.date_format' => 'O campo Horário que sentiu sono da Soneca 3 deve ser preenchido no formato HH:mm ',

        'soneca3_hd.after_or_equal' => 'O campo Horário que dormiu  da Soneca 3 deve ser um horário após o Horário que sentiu sono da Soneca 3',
        'soneca3_hd.date_format' => 'O campo Horário que dormiu  da Soneca 3 deve ser preenchido no formato HH:mm ',
        'soneca3_hd.required_unless' => 'Preencha os dados completos da Soneca 3',

        'soneca3_ha.after_or_equal' => 'O campo Horário que acordou  da Soneca 3 deve ser um horário após o Horário que dormiu da Soneca 3',
        'soneca3_ha.date_format' => 'O campo Horário que acordou  da Soneca 3 deve ser preenchido no formato HH:mm ',
        'soneca3_ha.required_unless' => 'Preencha os dados completos da Soneca 3',

        'soneca4_ss.after_or_equal' => 'O campo Horário que sentiu sono da Soneca 4 deve ser um horário após o Horário que Acordou da Soneca 3',
        'soneca4_ss.date_format' => 'O campo Horário que sentiu sono da Soneca 4 deve ser preenchido no formato HH:mm ',

        'soneca4_hd.after_or_equal' => 'O campo Horário que dormiu  da Soneca 4 deve ser um horário após o Horário que sentiu sono da Soneca 4',
        'soneca4_hd.date_format' => 'O campo Horário que dormiu  da Soneca 4 deve ser preenchido no formato HH:mm ',
        'soneca4_hd.required_unless' => 'Preencha os dados completos da Soneca 4',

        'soneca4_ha.after_or_equal' => 'O campo Horário que acordou  da Soneca 4 deve ser um horário após o Horário que dormiu da Soneca 4',
        'soneca4_ha.date_format' => 'O campo Horário que acordou  da Soneca 4 deve ser preenchido no formato HH:mm ',
        'soneca4_ha.required_unless' => 'Preencha os dados completos da Soneca 4',

        'soneca5_ss.after_or_equal' => 'O campo Horário que sentiu sono da Soneca 5 deve ser um horário após o Horário que Acordou da Soneca 4',
        'soneca5_ss.date_format' => 'O campo Horário que sentiu sono da Soneca 5 deve ser preenchido no formato HH:mm ',

        'soneca5_hd.after_or_equal' => 'O campo Horário que dormiu  da Soneca 5 deve ser um horário após o Horário que sentiu sono da Soneca 5',
        'soneca5_hd.date_format' => 'O campo Horário que dormiu  da Soneca 5 deve ser preenchido no formato HH:mm ',
        'soneca5_hd.required_unless' => 'Preencha os dados completos da Soneca 5',

        'soneca5_ha.after_or_equal' => 'O campo Horário que acordou  da Soneca 5 deve ser um horário após o Horário que dormiu da Soneca 5',
        'soneca5_ha.date_format' => 'O campo Horário que acordou  da Soneca 5 deve ser preenchido no formato HH:mm ',
        'soneca5_ha.required_unless' => 'Preencha os dados completos da Soneca 5',

        'soneca6_ss.after_or_equal' => 'O campo Horário que sentiu sono da Soneca 6 deve ser um horário após o Horário que Acordou da Soneca 5',
        'soneca6_ss.date_format' => 'O campo Horário que sentiu sono da Soneca 6 deve ser preenchido no formato HH:mm ',

        'soneca6_hd.after_or_equal' => 'O campo Horário que dormiu  da Soneca 6 deve ser um horário após o Horário que sentiu sono da Soneca 6',
        'soneca6_hd.date_format' => 'O campo Horário que dormiu  da Soneca 6 deve ser preenchido no formato HH:mm ',
        'soneca6_hd.required_unless' => 'Preencha os dados completos da Soneca 6',

        'soneca6_ha.after_or_equal' => 'O campo Horário que acordou  da Soneca 6 deve ser um horário após o Horário que dormiu da Soneca 6',
        'soneca6_ha.date_format' => 'O campo Horário que acordou  da Soneca 6 deve ser preenchido no formato HH:mm ',
        'soneca6_ha.required_unless' => 'Preencha os dados completos da Soneca 6',

        'ritual_ss.required' => 'O campo Horário que sentiu sono do Ritual Noturno é de preenchimento obrigatório',
        'ritual_ss.date_format' => 'O campo Horário que sentiu sono do Ritual Noturno deve ser preenchido no formato HH:mm',

        'ritual_in.required' => 'O campo Horário que iniciou Ritual Noturno é de preenchimento obrigatório',
        'ritual_in.date_format' => 'O campo Horário que iniciou Ritual Noturno deve ser preenchido no formato HH:mm',
        'ritual_in.after_or_equal' => 'O campo Horário que iniciou Ritual Noturno deve ser um horário após o Horário que sentiu sono do Ritual Noturno',

        'ritual_d.required' => 'O campo Horário que dormiu no Ritual Noturno é de preenchimento obrigatório',
        'ritual_d.date_format' => 'O campo Horário que dormiu no Ritual Noturno deve ser preenchido no formato HH:mm',
        'ritual_d.after_or_equal' => 'O campo Horário que dormiu no Ritual Noturno deve ser um horário após o Horário que iniciou o Ritual Noturno',

        'despertar1_a.date_format' => 'O campo Horário que acordou  do Despertar 1 deve ser preenchido no formato HH:mm ',
        'despertar1_a.required_unless' => 'Preencha os dados completos do Despertar 1',

        'despertar1_d.date_format' => 'O campo Horário que dormiu  da Despertar 1 deve ser preenchido no formato HH:mm ',
        'despertar1_d.required_unless' => 'Preencha os dados completos da Despertar 1',

        'despertar1_fd.required_unless' => 'Preencha o campo como dormiu do Despertar 1',

        'despertar2_a.date_format' => 'O campo Horário que acordou  do Despertar 2 deve ser preenchido no formato HH:mm ',
        'despertar2_a.required_unless' => 'Preencha os dados completos do Despertar 2',

        'despertar2_d.date_format' => 'O campo Horário que dormiu  da Despertar 2 deve ser preenchido no formato HH:mm ',
        'despertar2_d.required_unless' => 'Preencha os dados completos da Despertar 2',

        'despertar2_fd.required_unless' => 'Preencha o campo como dormiu do Despertar 2',

        'despertar3_a.date_format' => 'O campo Horário que acordou  do Despertar 3 deve ser preenchido no formato HH:mm ',
        'despertar3_a.required_unless' => 'Preencha os dados completos do Despertar 3',

        'despertar3_d.date_format' => 'O campo Horário que dormiu  da Despertar 3 deve ser preenchido no formato HH:mm ',
        'despertar3_d.required_unless' => 'Preencha os dados completos da Despertar 3',

        'despertar3_fd.required_unless' => 'Preencha o campo como dormiu do Despertar 3',

        'despertar4_a.date_format' => 'O campo Horário que acordou  do Despertar 4 deve ser preenchido no formato HH:mm ',
        'despertar4_a.required_unless' => 'Preencha os dados completos do Despertar 4',

        'despertar4_d.date_format' => 'O campo Horário que dormiu  da Despertar 4 deve ser preenchido no formato HH:mm ',
        'despertar4_d.required_unless' => 'Preencha os dados completos da Despertar 4',

        'despertar4_fd.required_unless' => 'Preencha o campo como dormiu do Despertar 4',

        'despertar5_a.date_format' => 'O campo Horário que acordou  do Despertar 5 deve ser preenchido no formato HH:mm ',
        'despertar5_a.required_unless' => 'Preencha os dados completos do Despertar 5',

        'despertar5_d.date_format' => 'O campo Horário que dormiu  da Despertar 5 deve ser preenchido no formato HH:mm ',
        'despertar5_d.required_unless' => 'Preencha os dados completos da Despertar 5',

        'despertar5_fd.required_unless' => 'Preencha o campo como dormiu do Despertar 5',

        'despertar6_a.date_format' => 'O campo Horário que acordou  do Despertar 6 deve ser preenchido no formato HH:mm ',
        'despertar6_a.required_unless' => 'Preencha os dados completos do Despertar 6',

        'despertar6_d.date_format' => 'O campo Horário que dormiu  da Despertar 6 deve ser preenchido no formato HH:mm ',
        'despertar6_d.required_unless' => 'Preencha os dados completos da Despertar 6',

        'despertar6_fd.required_unless' => 'Preencha o campo como dormiu do Despertar 6',


    ];

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'date' => 'required|date_format:d/m/Y',
            'timeWokeUp' => 'required|date_format:H:i',
            'volcanicEffect' => 'nullable|string',
            'comments' => 'nullable|string|max:200',
            'soneca1_ss' => 'nullable|after_or_equal:timeWokeUp|date_format:H:i',
            'soneca1_hd' => 'nullable|after_or_equal:soneca1_ss|date_format:H:i|required_unless:soneca1_ss,null',
            'soneca1_ha' => 'nullable|after_or_equal:soneca1_hd|date_format:H:i|required_unless:soneca1_ha,null',

            'soneca2_ss' => 'nullable|after_or_equal:soneca1_ha|date_format:H:i',
            'soneca2_hd' => 'nullable|after_or_equal:soneca2_ss|date_format:H:i|required_unless:soneca2_ss,null',
            'soneca2_ha' => 'nullable|after_or_equal:soneca2_hd|date_format:H:i|required_unless:soneca2_ha,null',

            'soneca3_ss' => 'nullable|after_or_equal:soneca2_ha|date_format:H:i',
            'soneca3_hd' => 'nullable|after_or_equal:soneca3_ss|date_format:H:i|required_unless:soneca3_ss,null',
            'soneca3_ha' => 'nullable|after_or_equal:soneca3_hd|date_format:H:i|required_unless:soneca3_ha,null',

            'soneca4_ss' => 'nullable|after_or_equal:soneca3_ha|date_format:H:i',
            'soneca4_hd' => 'nullable|after_or_equal:soneca4_ss|date_format:H:i|required_unless:soneca4_ss,null',
            'soneca4_ha' => 'nullable|after_or_equal:soneca4_hd|date_format:H:i|required_unless:soneca4_ha,null',

            'soneca5_ss' => 'nullable|after_or_equal:soneca4_ha|date_format:H:i',
            'soneca5_hd' => 'nullable|after_or_equal:soneca5_ss|date_format:H:i|required_unless:soneca5_ss,null',
            'soneca5_ha' => 'nullable|after_or_equal:soneca5_hd|date_format:H:i|required_unless:soneca5_ha,null',

            'soneca6_ss' => 'nullable|after_or_equal:soneca5_ha|date_format:H:i',
            'soneca6_hd' => 'nullable|after_or_equal:soneca6_ss|date_format:H:i|required_unless:soneca6_ss,null',
            'soneca6_ha' => 'nullable|after_or_equal:soneca6_hd|date_format:H:i|required_unless:soneca6_ha,null',

            'ritual_ss' => 'required|date_format:H:i',
            'ritual_in' => 'required|after_or_equal:ritual_ss|date_format:H:i',
            'ritual_d' => 'required|after_or_equal:ritual_in|date_format:H:i',

            'despertar1_a' => 'nullable|date_format:H:i',
            'despertar1_d' => 'nullable|date_format:H:i|required_unless:despertar1_a,null',
            'despertar1_fd' => 'nullable|required_unless:despertar1_a,null',

            'despertar2_a' => 'nullable|date_format:H:i',
            'despertar2_d' => 'nullable|date_format:H:i|required_unless:despertar2_a,null',
            'despertar2_fd' => 'nullable|required_unless:despertar2_a,null',

            'despertar3_a' => 'nullable|date_format:H:i',
            'despertar3_d' => 'nullable|date_format:H:i|required_unless:despertar3_a,null',
            'despertar3_fd' => 'nullable|required_unless:despertar3_a,null',

            'despertar4_a' => 'nullable|date_format:H:i',
            'despertar4_d' => 'nullable|date_format:H:i|required_unless:despertar4_a,null',
            'despertar4_fd' => 'nullable|required_unless:despertar4_a,null',

            'despertar5_a' => 'nullable|date_format:H:i',
            'despertar5_d' => 'nullable|date_format:H:i|required_unless:despertar5_a,null',
            'despertar5_fd' => 'nullable|required_unless:despertar5_a,null',

            'despertar6_a' => 'nullable|date_format:H:i',
            'despertar6_d' => 'nullable|date_format:H:i|required_unless:despertar6_a,null',
            'despertar6_fd' => 'nullable|required_unless:despertar6_a,null',


        ], $this->message);
    }

    public function analyzeStoreForm(Request $request, $id)
    {

        if (!$challenge = $this->repository->find($id)) {
            return redirect()->back();
        }

        if (!$this->repository->find($id)->client_id == Auth::guard('clients')->user()->id) {
            return redirect()->back();
        }
        $challenge = $this->repository->find($id);

        if ($request->ritual_luz == null) {
            $request->ritual_luz = "N";
        }
        if ($request->ritual_ruido == null) {
            $request->ritual_ruido = "N";
        }
        if ($request->ritual_estimulo == null) {
            $request->ritual_estimulo = "N";
        }
        if ($request->ritual_retira == null) {
            $request->ritual_retira = "N";
        }

        if ($request->soneca_acordado_berco == null) {
            $request->soneca_acordado_berco = "N";
        }
        if ($request->soneca_dorme_colo_berco == null) {
            $request->soneca_dorme_colo_berco = "N";
        }
        if ($request->soneca_dorme_colo == null) {
            $request->soneca_dorme_colo = "N";
        }
        if ($request->soneca_cama_compartilhada == null) {
            $request->soneca_cama_compartilhada = "N";
        }
        if ($request->soneca_cama_compartilhada == null) {
            $request->soneca_cama_compartilhada = "N";
        }
        if ($request->soneca_carrinho == null) {
            $request->soneca_carrinho = "N";
        }
        if ($request->soneca_rede == null) {
            $request->soneca_rede = "N";
        }
        if ($request->soneca_outro == null) {
            $request->soneca_outro = "N";
        }

        if ($request->soneca_outro == "S") {
            $request->soneca_outro = $request->soneca_outro_text;
        }

        if ($request->associacao_soneca_ruido_branco == null) {
            $request->associacao_soneca_ruido_branco = "N";
        }
        if ($request->associacao_soneca_naninha == null) {
            $request->associacao_soneca_naninha = "N";
        }
        if ($request->associacao_soneca_chupeta == null) {
            $request->associacao_soneca_chupeta = "N";
        }
        if ($request->associacao_soneca_chupar_dedo == null) {
            $request->associacao_soneca_chupar_dedo = "N";
        }
        if ($request->associacao_soneca_mamar == null) {
            $request->associacao_soneca_mamar = "N";
        }

        if ($request->associacao_soneca_cc == null) {
            $request->associacao_soneca_cc = "N";
        }

        if ($request->associacao_soneca_colo == null) {
            $request->associacao_soneca_colo = "N";
        }


        if ($request->associacao_soneca_outro == null) {
            $request->associacao_soneca_outro = "N";
        }

        if ($request->associacao_soneca_outro == "S") {
            $request->associacao_soneca_outro = $request->associacao_soneca_outro_text;
        }



        if ($request->associacao_noturno_ruido_branco == null) {
            $request->associacao_noturno_ruido_branco = "N";
        }
        if ($request->associacao_noturno_naninha == null) {
            $request->associacao_noturno_naninha = "N";
        }
        if ($request->associacao_noturno_chupeta == null) {
            $request->associacao_noturno_chupeta = "N";
        }
        if ($request->associacao_noturno_chupar_dedo == null) {
            $request->associacao_noturno_chupar_dedo = "N";
        }
        if ($request->associacao_noturno_mamar == null) {
            $request->associacao_noturno_mamar = "N";
        }

        if ($request->associacao_noturno_cc == null) {
            $request->associacao_noturno_cc = "N";
        }

        if ($request->associacao_noturno_colo == null) {
            $request->associacao_noturno_colo = "N";
        }

        if ($request->associacao_noturno_outro == null) {
            $request->associacao_noturno_outro = "N";
        }

        if ($request->associacao_noturno_outro == "S") {
            $request->associacao_noturno_outro = $request->associacao_noturno_outro_text;
        }


        if ($request->conclusao_imaturidade == null) {
            $request->conclusao_imaturidade = "N";
        }
        if ($request->conclusao_fome == null) {
            $request->conclusao_fome = "N";
        }
        if ($request->conclusao_dor == null) {
            $request->conclusao_dor = "N";
        }
        if ($request->conclusao_salto == null) {
            $request->conclusao_salto = "N";
        }
        if ($request->conclusao_angustia == null) {
            $request->conclusao_angustia = "N";
        }
        if ($request->conclusao_telas == null) {
            $request->conclusao_telas = "N";
        }
        if ($request->conclusao_estresse == null) {
            $request->conclusao_estresse = "N";
        }








        $form = $challenge->form()->create([

            'ritualGoodMorning' => $request->ritualBomDia,

            'ritualGoodMorningLight' => $request->ritual_luz,
            'ritualGoodMorningNoise' => $request->ritual_ruido,
            'ritualGoodMorningStimulus' => $request->ritual_estimulo,
            'ritualGoodMorningRemove' => $request->ritual_retira,
            'typeEatingRoutine' => $request->rotinaAlimentar,
            'routineDifficulties' => $request->dificuldadeRotinaAlimentar,
            'weightGain' => $request->ganhoPeso,

            'energyExpenditure' => $request->gastoEnergia,
            'noticeSigns' => $request->sinaisSono,
            'slowDown' => $request->desacelera,
            'ritualType' => $request->ritualSonecasChoro,
            'environmentNapsLights' => $request->soneca_luzes,
            'environmentNapsNoises' => $request->soneca_ruidos,
            'environmentNapsTemperature' => $request->soneca_temperatura,
            'whereSleepCrib' => $request->soneca_acordado_berco,
            'whereSleepLap' => $request->soneca_dorme_colo,
            'whereSleepLapCrib' => $request->soneca_dorme_colo_berco,
            'whereSleepSharedBed' => $request->soneca_cama_compartilhada,
            'whereSleepCar' => $request->soneca_carrinho,
            'whereSleepRede' => $request->soneca_rede,
            'whereSleepOther' => $request->soneca_outro,
            'environmentNapBother' => $request->soneca_local_incomoda,
            'napAssociationWhiteNoise' => $request->associacao_soneca_ruido_branco,
            'napAssociationCloth' => $request->associacao_soneca_naninha,
            'napAssociationPacifier' => $request->associacao_soneca_chupeta,
            'napAssociationSuckFinger' => $request->associacao_soneca_chupar_dedo,
            'napAssociationSuckle' => $request->associacao_soneca_mamar,
            'napAssociationCC' => $request->associacao_soneca_cc,
            'napAssociationLap' => $request->associacao_soneca_colo,
            'napAssociationOther' => $request->associacao_soneca_outro,
            'enoughNap' => $request->soneca_suficiente,
            'wakeUpNap' => $request->soneca_acorda,
            'nightRitual' => $request->ritaualNoturno,
            'environmentRitualLights' => $request->sn_luzes,
            'environmentRitualNoises' => $request->sn_ruidos,
            'environmentRitualTemperature' => $request->sn_temperatura,
            'ritualAssociationWhiteNoise' => $request->associacao_noturno_ruido_branco,
            'ritualAssociationCloth' => $request->associacao_noturno_naninha,
            'ritualAssociationPacifier' => $request->associacao_noturno_chupeta,
            'ritualAssociationSuckFinger' => $request->associacao_noturno_chupar_dedo,
            'ritualAssociationSuckle' => $request->associacao_noturno_mamar,
            'ritualAssociationCC' => $request->associacao_noturno_cc,
            'ritualAssociationLap' => $request->associacao_noturno_colo,
            'ritualAssociationOther' => $request->associacao_noturno_outro,
            'conclusionImmaturity' => $request->conclusao_imaturidade,
            'conclusionHungry' => $request->conclusao_fome,
            'conclusionAche' => $request->conclusao_dor,
            'conclusionJump' => $request->conclusao_salto,
            'conclusionAnguish' => $request->conclusao_angustia,
            'conclusionScreens' => $request->conclusao_telas,
            'conclusionStress' => $request->conclusao_estresse,
            'comments' => $request->observacoes,

        ]);
        return redirect()->route('desafio.show', $challenge->id)->with('sucesso', 'Formulário Final Concluído');
    }

    public function analyzeUpdateForm(Request $request, $id)
    {

        if (!$challenge = $this->repository->find($id)
            || !$this->repository->find($id)->client_id == Auth::guard('clients')->user()->id) {
            return redirect()->back();
        }
        $challenge = $this->repository->find($id);

        if ($request->ritual_luz == null) {
            $request->ritual_luz = "N";
        }
        if ($request->ritual_ruido == null) {
            $request->ritual_ruido = "N";
        }
        if ($request->ritual_estimulo == null) {
            $request->ritual_estimulo = "N";
        }
        if ($request->ritual_retira == null) {
            $request->ritual_retira = "N";
        }

        if ($request->soneca_acordado_berco == null) {
            $request->soneca_acordado_berco = "N";
        }
        if ($request->soneca_dorme_colo_berco == null) {
            $request->soneca_dorme_colo_berco = "N";
        }
        if ($request->soneca_dorme_colo == null) {
            $request->soneca_dorme_colo = "N";
        }
        if ($request->soneca_cama_compartilhada == null) {
            $request->soneca_cama_compartilhada = "N";
        }
        if ($request->soneca_cama_compartilhada == null) {
            $request->soneca_cama_compartilhada = "N";
        }
        if ($request->soneca_carrinho == null) {
            $request->soneca_carrinho = "N";
        }
        if ($request->soneca_rede == null) {
            $request->soneca_rede = "N";
        }
        if ($request->soneca_outro == null) {
            $request->soneca_outro = "N";
        }

        if ($request->soneca_outro == "S") {
            $request->soneca_outro = $request->soneca_outro_text;
        }

        if ($request->associacao_soneca_ruido_branco == null) {
            $request->associacao_soneca_ruido_branco = "N";
        }
        if ($request->associacao_soneca_naninha == null) {
            $request->associacao_soneca_naninha = "N";
        }
        if ($request->associacao_soneca_chupeta == null) {
            $request->associacao_soneca_chupeta = "N";
        }
        if ($request->associacao_soneca_chupar_dedo == null) {
            $request->associacao_soneca_chupar_dedo = "N";
        }
        if ($request->associacao_soneca_mamar == null) {
            $request->associacao_soneca_mamar = "N";
        }

        if ($request->associacao_soneca_cc == null) {
            $request->associacao_soneca_cc = "N";
        }

        if ($request->associacao_soneca_colo == null) {
            $request->associacao_soneca_colo = "N";
        }


        if ($request->associacao_soneca_outro == null) {
            $request->associacao_soneca_outro = "N";
        }

        if ($request->associacao_soneca_outro == "S") {
            $request->associacao_soneca_outro = $request->associacao_soneca_outro_text;
        }



        if ($request->associacao_noturno_ruido_branco == null) {
            $request->associacao_noturno_ruido_branco = "N";
        }
        if ($request->associacao_noturno_naninha == null) {
            $request->associacao_noturno_naninha = "N";
        }
        if ($request->associacao_noturno_chupeta == null) {
            $request->associacao_noturno_chupeta = "N";
        }
        if ($request->associacao_noturno_chupar_dedo == null) {
            $request->associacao_noturno_chupar_dedo = "N";
        }
        if ($request->associacao_noturno_mamar == null) {
            $request->associacao_noturno_mamar = "N";
        }

        if ($request->associacao_noturno_cc == null) {
            $request->associacao_noturno_cc = "N";
        }

        if ($request->associacao_noturno_colo == null) {
            $request->associacao_noturno_colo = "N";
        }

        if ($request->associacao_noturno_outro == null) {
            $request->associacao_noturno_outro = "N";
        }

        if ($request->associacao_noturno_outro == "S") {
            $request->associacao_noturno_outro = $request->associacao_noturno_outro_text;
        }


        if ($request->conclusao_imaturidade == null) {
            $request->conclusao_imaturidade = "N";
        }
        if ($request->conclusao_fome == null) {
            $request->conclusao_fome = "N";
        }
        if ($request->conclusao_dor == null) {
            $request->conclusao_dor = "N";
        }
        if ($request->conclusao_salto == null) {
            $request->conclusao_salto = "N";
        }
        if ($request->conclusao_angustia == null) {
            $request->conclusao_angustia = "N";
        }
        if ($request->conclusao_telas == null) {
            $request->conclusao_telas = "N";
        }
        if ($request->conclusao_estresse == null) {
            $request->conclusao_estresse = "N";
        }

        $form = $challenge->form();







        $form->update([

            'ritualGoodMorning' => $request->ritualBomDia,

            'ritualGoodMorningLight' => $request->ritual_luz,
            'ritualGoodMorningNoise' => $request->ritual_ruido,
            'ritualGoodMorningStimulus' => $request->ritual_estimulo,
            'ritualGoodMorningRemove' => $request->ritual_retira,
            'typeEatingRoutine' => $request->rotinaAlimentar,
            'routineDifficulties' => $request->dificuldadeRotinaAlimentar,
            'weightGain' => $request->ganhoPeso,

            'energyExpenditure' => $request->gastoEnergia,
            'noticeSigns' => $request->sinaisSono,
            'slowDown' => $request->desacelera,
            'ritualType' => $request->ritualSonecasChoro,
            'environmentNapsLights' => $request->soneca_luzes,
            'environmentNapsNoises' => $request->soneca_ruidos,
            'environmentNapsTemperature' => $request->soneca_temperatura,
            'whereSleepCrib' => $request->soneca_acordado_berco,
            'whereSleepLap' => $request->soneca_dorme_colo,
            'whereSleepLapCrib' => $request->soneca_dorme_colo_berco,
            'whereSleepSharedBed' => $request->soneca_cama_compartilhada,
            'whereSleepCar' => $request->soneca_carrinho,
            'whereSleepRede' => $request->soneca_rede,
            'whereSleepOther' => $request->soneca_outro,
            'environmentNapBother' => $request->soneca_local_incomoda,
            'napAssociationWhiteNoise' => $request->associacao_soneca_ruido_branco,
            'napAssociationCloth' => $request->associacao_soneca_naninha,
            'napAssociationPacifier' => $request->associacao_soneca_chupeta,
            'napAssociationSuckFinger' => $request->associacao_soneca_chupar_dedo,
            'napAssociationSuckle' => $request->associacao_soneca_mamar,
            'napAssociationCC' => $request->associacao_soneca_cc,
            'napAssociationLap' => $request->associacao_soneca_colo,
            'napAssociationOther' => $request->associacao_soneca_outro,
            'enoughNap' => $request->soneca_suficiente,
            'wakeUpNap' => $request->soneca_acorda,
            'nightRitual' => $request->ritaualNoturno,
            'environmentRitualLights' => $request->sn_luzes,
            'environmentRitualNoises' => $request->sn_ruidos,
            'environmentRitualTemperature' => $request->sn_temperatura,
            'ritualAssociationWhiteNoise' => $request->associacao_noturno_ruido_branco,
            'ritualAssociationCloth' => $request->associacao_noturno_naninha,
            'ritualAssociationPacifier' => $request->associacao_noturno_chupeta,
            'ritualAssociationSuckFinger' => $request->associacao_noturno_chupar_dedo,
            'ritualAssociationSuckle' => $request->associacao_noturno_mamar,
            'ritualAssociationCC' => $request->associacao_noturno_cc,
            'ritualAssociationLap' => $request->associacao_noturno_colo,
            'ritualAssociationOther' => $request->associacao_noturno_outro,
            'conclusionImmaturity' => $request->conclusao_imaturidade,
            'conclusionHungry' => $request->conclusao_fome,
            'conclusionAche' => $request->conclusao_dor,
            'conclusionJump' => $request->conclusao_salto,
            'conclusionAnguish' => $request->conclusao_angustia,
            'conclusionScreens' => $request->conclusao_telas,
            'conclusionStress' => $request->conclusao_estresse,
            'comments' => $request->observacoes,

        ]);
        return redirect()->route('desafio.show', $challenge->id)->with('sucesso', 'Formulário Final Concluído');
    }




    public function analyzeStore(Request $request, $id, $day)
    {
        //dd(\Carbon\Carbon::parse('00:25')->diffInMinutes(\Carbon\Carbon::parse('23:50'),true));
        $ritual_window = $request->timeWokeUp;
        if (!$challenge = $this->repository->find($id)
            || !$this->repository->find($id)->client_id == Auth::guard('clients')->user()->id) {
            return redirect()->back();
        }


        $this->validator($request->all())->validate();
        $challenge = $this->repository->find($id);

        if ($request->volcanicEffect == null) {
            $request->volcanicEffect = 'N';
        }

        if ($request->comments == null) {
            $request->comments = '';
        }

        $analyze = $challenge->analyzes()->create([
            'day' => $day,
            'date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d'),

            'timeWokeUp' => $request->timeWokeUp,
            'volcanicEffect' => $request->volcanicEffect,
            'comments' => $request->comments
        ]);

        if ($request->soneca1_ss != null) {
            $request->timeWokeUp = \Carbon\Carbon::parse($request->timeWokeUp);
            $request->soneca1_ss = \Carbon\Carbon::parse($request->soneca1_ss);
            $request->soneca1_hd = \Carbon\Carbon::parse($request->soneca1_hd);
            $request->soneca1_ha = \Carbon\Carbon::parse($request->soneca1_ha);
            $ritual_window = $request->soneca1_ha;
            $analyze->naps()->create([
                'number' => '1',
                'timeSlept' => $request->soneca1_hd,
                'timeWokeUp' => $request->soneca1_ha,
                'signalSlept' => $request->soneca1_ss,
                'window' => $request->soneca1_hd->diffInMinutes($request->timeWokeUp),
                'windowSignalSlept' => $request->soneca1_hd->diffInMinutes($request->soneca1_ss),
                'duration' => $request->soneca1_ha->diffInMinutes($request->soneca1_hd),
            ]);
        }

        if ($request->soneca2_ss != null) {
            $request->soneca2_ss = \Carbon\Carbon::parse($request->soneca2_ss);
            $request->soneca2_hd = \Carbon\Carbon::parse($request->soneca2_hd);
            $request->soneca2_ha = \Carbon\Carbon::parse($request->soneca2_ha);
            $ritual_window = $request->soneca2_ha;

            $analyze->naps()->create([
                'number' => '2',
                'timeSlept' => $request->soneca2_hd,
                'timeWokeUp' => $request->soneca2_ha,
                'signalSlept' => $request->soneca2_ss,
                'window' => $request->soneca2_hd->diffInMinutes($request->soneca1_ha),
                'windowSignalSlept' => $request->soneca2_hd->diffInMinutes($request->soneca2_ss),
                'duration' => $request->soneca2_ha->diffInMinutes($request->soneca2_hd),
            ]);
        }

        if ($request->soneca3_ss != null) {
            $request->soneca3_ss = \Carbon\Carbon::parse($request->soneca3_ss);
            $request->soneca3_hd = \Carbon\Carbon::parse($request->soneca3_hd);
            $request->soneca3_ha = \Carbon\Carbon::parse($request->soneca3_ha);
            $ritual_window = $request->soneca3_ha;

            $analyze->naps()->create([
                'number' => '3',
                'timeSlept' => $request->soneca3_hd,
                'timeWokeUp' => $request->soneca3_ha,
                'signalSlept' => $request->soneca3_ss,
                'window' => $request->soneca3_hd->diffInMinutes($request->soneca2_ha),
                'windowSignalSlept' => $request->soneca3_hd->diffInMinutes($request->soneca3_ss),
                'duration' => $request->soneca3_ha->diffInMinutes($request->soneca3_hd),
            ]);
        }

        if ($request->soneca4_ss != null) {
            $request->soneca3_ss = \Carbon\Carbon::parse($request->soneca4_ss);
            $request->soneca4_hd = \Carbon\Carbon::parse($request->soneca4_hd);
            $request->soneca4_ha = \Carbon\Carbon::parse($request->soneca4_ha);
            $ritual_window = $request->soneca4_ha;

            $analyze->naps()->create([
                'number' => '4',
                'timeSlept' => $request->soneca4_hd,
                'timeWokeUp' => $request->soneca4_ha,
                'signalSlept' => $request->soneca4_ss,
                'window' => $request->soneca4_hd->diffInMinutes($request->soneca3_ha),
                'windowSignalSlept' => $request->soneca4_hd->diffInMinutes($request->soneca4_ss),
                'duration' => $request->soneca4_ha->diffInMinutes($request->soneca4_hd),
            ]);
        }

        if ($request->soneca5_ss != null) {
            $request->soneca5_ss = \Carbon\Carbon::parse($request->soneca5_ss);
            $request->soneca5_hd = \Carbon\Carbon::parse($request->soneca5_hd);
            $request->soneca5_ha = \Carbon\Carbon::parse($request->soneca5_ha);
            $ritual_window = $request->soneca5_ha;

            $analyze->naps()->create([
                'number' => '5',
                'timeSlept' => $request->soneca5_hd,
                'timeWokeUp' => $request->soneca5_ha,
                'signalSlept' => $request->soneca5_ss,
                'window' => $request->soneca5_hd->diffInMinutes($request->soneca4_ha),
                'windowSignalSlept' => $request->soneca5_hd->diffInMinutes($request->soneca5_ss),
                'duration' => $request->soneca5_ha->diffInMinutes($request->soneca5_hd),
            ]);
        }

        if ($request->soneca6_ss != null) {
            $request->soneca5_ss = \Carbon\Carbon::parse($request->soneca6_ss);
            $request->soneca6_hd = \Carbon\Carbon::parse($request->soneca6_hd);
            $request->soneca6_ha = \Carbon\Carbon::parse($request->soneca6_ha);
            $ritual_window = $request->soneca6_ha;

            $analyze->naps()->create([
                'number' => '6',
                'timeSlept' => $request->soneca6_hd,
                'timeWokeUp' => $request->soneca6_ha,
                'signalSlept' => $request->soneca6_ss,
                'window' => $request->soneca6_hd->diffInMinutes($request->soneca5_ha),
                'windowSignalSlept' => $request->soneca6_hd->diffInMinutes($request->soneca6_ss),
                'duration' => $request->soneca6_ha->diffInMinutes($request->soneca6_hd),
            ]);
        }

        if ($request->ritual_ss != null) {
            $request->ritual_ss = \Carbon\Carbon::parse($request->ritual_ss);
            $request->ritual_in = \Carbon\Carbon::parse($request->ritual_in);
            $request->ritual_d = \Carbon\Carbon::parse($request->ritual_d);
            $analyze->rituals()->create([
                'signalSlept' => $request->ritual_ss,
                'start' => $request->ritual_in,
                'end' => $request->ritual_d,
                'duration' => $request->ritual_d->diffInMinutes($request->ritual_in),
                'window' => $request->ritual_in->diffInMinutes($ritual_window),
                'windowSignalSlept' => $request->ritual_in->diffInMinutes($request->ritual_ss)
            ]);
        }



        if ($request->despertar1_a != null) {
            $request->despertar1_a = \Carbon\Carbon::parse($request->despertar1_a);
            $request->despertar1_d = \Carbon\Carbon::parse($request->despertar1_d);

            if ($request->despertar1_a->format('H') >= 0 && $request->despertar1_a->format('H') < 7) {
                $request->despertar1_a->addDays(1);
            }

            if ($request->despertar1_d->format('H') >= 0 && $request->despertar1_d->format('H') < 7) {
                $request->despertar1_d->addDays(1);
            }
            if ($request->despertar1_fd == 4) {
                $request->despertar1_fd = $request->despertar1_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '1',
                'timeWokeUp' => $request->despertar1_a,
                'timeSlept' => $request->despertar1_d,
                'duration' => $request->despertar1_d->diffInMinutes($request->despertar1_a),
                'sleepingMode' => $request->despertar1_fd
            ]);
        }
        if ($request->despertar2_a != null) {
            $request->despertar2_a = \Carbon\Carbon::parse($request->despertar2_a);
            $request->despertar2_d = \Carbon\Carbon::parse($request->despertar2_d);

            if ($request->despertar2_a->format('H') >= 0 && $request->despertar2_a->format('H') < 7) {
                $request->despertar2_a->addDays(1);
            }

            if ($request->despertar2_d->format('H') >= 0 && $request->despertar2_d->format('H') < 7) {
                $request->despertar2_d->addDays(1);
            }
            if ($request->despertar2_fd == 4) {
                $request->despertar2_fd = $request->despertar2_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '2',
                'timeWokeUp' => $request->despertar2_a,
                'timeSlept' => $request->despertar2_d,
                'duration' => $request->despertar2_d->diffInMinutes($request->despertar2_a),
                'sleepingMode' => $request->despertar2_fd
            ]);
        }

        if ($request->despertar3_a != null) {
            $request->despertar3_a = \Carbon\Carbon::parse($request->despertar3_a);
            $request->despertar3_d = \Carbon\Carbon::parse($request->despertar3_d);

            if ($request->despertar3_a->format('H') >= 0 && $request->despertar3_a->format('H') < 7) {
                $request->despertar3_a->addDays(1);
            }

            if ($request->despertar3_d->format('H') >= 0 && $request->despertar3_d->format('H') < 7) {
                $request->despertar3_d->addDays(1);
            }
            if ($request->despertar3_fd == 4) {
                $request->despertar3_fd = $request->despertar3_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '3',
                'timeWokeUp' => $request->despertar3_a,
                'timeSlept' => $request->despertar3_d,
                'duration' => $request->despertar3_d->diffInMinutes($request->despertar3_a),
                'sleepingMode' => $request->despertar3_fd
            ]);
        }

        if ($request->despertar4_a != null) {
            $request->despertar4_a = \Carbon\Carbon::parse($request->despertar4_a);
            $request->despertar4_d = \Carbon\Carbon::parse($request->despertar4_d);

            if ($request->despertar4_a->format('H') >= 0 && $request->despertar4_a->format('H') < 7) {
                $request->despertar4_a->addDays(1);
            }

            if ($request->despertar4_d->format('H') >= 0 && $request->despertar4_d->format('H') < 7) {
                $request->despertar4_d->addDays(1);
            }
            if ($request->despertar4_fd == 4) {
                $request->despertar4_fd = $request->despertar4_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '4',
                'timeWokeUp' => $request->despertar4_a,
                'timeSlept' => $request->despertar4_d,
                'duration' => $request->despertar4_d->diffInMinutes($request->despertar4_a),
                'sleepingMode' => $request->despertar4_fd
            ]);
        }

        if ($request->despertar5_a != null) {
            $request->despertar5_a = \Carbon\Carbon::parse($request->despertar5_a);
            $request->despertar5_d = \Carbon\Carbon::parse($request->despertar5_d);

            if ($request->despertar5_a->format('H') >= 0 && $request->despertar5_a->format('H') < 7) {
                $request->despertar5_a->addDays(1);
            }

            if ($request->despertar5_d->format('H') >= 0 && $request->despertar5_d->format('H') < 7) {
                $request->despertar5_d->addDays(1);
            }
            if ($request->despertar5_fd == 4) {
                $request->despertar5_fd = $request->despertar5_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '5',
                'timeWokeUp' => $request->despertar5_a,
                'timeSlept' => $request->despertar5_d,
                'duration' => $request->despertar5_d->diffInMinutes($request->despertar5_a),
                'sleepingMode' => $request->despertar5_fd
            ]);
        }

        if ($request->despertar6_a != null) {
            $request->despertar6_a = \Carbon\Carbon::parse($request->despertar6_a);
            $request->despertar6_d = \Carbon\Carbon::parse($request->despertar6_d);

            if ($request->despertar6_a->format('H') >= 0 && $request->despertar6_a->format('H') < 7) {
                $request->despertar6_a->addDays(1);
            }

            if ($request->despertar6_d->format('H') >= 0 && $request->despertar6_d->format('H') < 7) {
                $request->despertar6_d->addDays(1);
            }
            if ($request->despertar6_fd == 4) {
                $request->despertar6_fd = $request->despertar6_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '6',
                'timeWokeUp' => $request->despertar6_a,
                'timeSlept' => $request->despertar6_d,
                'duration' => $request->despertar6_d->diffInMinutes($request->despertar6_a),
                'sleepingMode' => $request->despertar6_fd
            ]);
        }
        return redirect()->route('desafio.show', $challenge->id)->with('sucesso', 'Análise realizada');
    }

    public function analyzeEdit($id, $day)
    {
        $challenge = $this->repository->find($id);
        $analyze = $challenge->analyzes()->where('day', $day)->first();
        $ritual = $analyze->rituals()->first();
        $naps = $analyze->naps()->get();
        $wakes = $analyze->wakes()->get();
        return view('site.desafio.edit', compact('analyze', 'day', 'challenge', 'ritual', 'naps', 'wakes'));
    }

    public function analyzeUpdate($id, $day, Request $request)
    {
        $ritual_window = $request->timeWokeUp;
        if (!$challenge = $this->repository->find($id)
            || !$this->repository->find($id)->client_id == Auth::guard('clients')->user()->id) {
            return redirect()->back();
        }

        if ($request->volcanicEffect == null) {
            $request->volcanicEffect = 'N';
        }

        if ($request->comments == null) {
            $request->comments = '';
        }

        $this->validator($request->all())->validate();
        $challenge = $this->repository->find($id);

        $challenge->analyzes()->where('day', $day)->update([
            'day' => $day,
            'date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d'),

            'timeWokeUp' => $request->timeWokeUp,
            'volcanicEffect' => $request->volcanicEffect,

        ]);
        $analyze = $challenge->analyzes()->where('day', $day)->first();
        $analyze->naps()->delete();
        $analyze->wakes()->delete();

        if ($request->soneca1_ss != null) {
            $request->timeWokeUp = \Carbon\Carbon::parse($request->timeWokeUp);
            $request->soneca1_ss = \Carbon\Carbon::parse($request->soneca1_ss);
            $request->soneca1_hd = \Carbon\Carbon::parse($request->soneca1_hd);
            $request->soneca1_ha = \Carbon\Carbon::parse($request->soneca1_ha);
            $ritual_window = $request->soneca1_ha;
            $analyze->naps()->create([
                'number' => '1',
                'timeSlept' => $request->soneca1_hd,
                'timeWokeUp' => $request->soneca1_ha,
                'signalSlept' => $request->soneca1_ss,
                'window' => $request->soneca1_hd->diffInMinutes($request->timeWokeUp),
                'windowSignalSlept' => $request->soneca1_hd->diffInMinutes($request->soneca1_ss),
                'duration' => $request->soneca1_ha->diffInMinutes($request->soneca1_hd),
            ]);
        }

        if ($request->soneca2_ss != null) {
            $request->soneca2_ss = \Carbon\Carbon::parse($request->soneca2_ss);
            $request->soneca2_hd = \Carbon\Carbon::parse($request->soneca2_hd);
            $request->soneca2_ha = \Carbon\Carbon::parse($request->soneca2_ha);
            $ritual_window = $request->soneca2_ha;

            $analyze->naps()->create([
                'number' => '2',
                'timeSlept' => $request->soneca2_hd,
                'timeWokeUp' => $request->soneca2_ha,
                'signalSlept' => $request->soneca2_ss,
                'window' => $request->soneca2_hd->diffInMinutes($request->soneca1_ha),
                'windowSignalSlept' => $request->soneca2_hd->diffInMinutes($request->soneca2_ss),
                'duration' => $request->soneca2_ha->diffInMinutes($request->soneca2_hd),
            ]);
        }

        if ($request->soneca3_ss != null) {
            $request->soneca3_ss = \Carbon\Carbon::parse($request->soneca3_ss);
            $request->soneca3_hd = \Carbon\Carbon::parse($request->soneca3_hd);
            $request->soneca3_ha = \Carbon\Carbon::parse($request->soneca3_ha);
            $ritual_window = $request->soneca3_ha;

            $analyze->naps()->create([
                'number' => '3',
                'timeSlept' => $request->soneca3_hd,
                'timeWokeUp' => $request->soneca3_ha,
                'signalSlept' => $request->soneca3_ss,
                'window' => $request->soneca3_hd->diffInMinutes($request->soneca2_ha),
                'windowSignalSlept' => $request->soneca3_hd->diffInMinutes($request->soneca3_ss),
                'duration' => $request->soneca3_ha->diffInMinutes($request->soneca3_hd),
            ]);
        }

        if ($request->soneca4_ss != null) {
            $request->soneca3_ss = \Carbon\Carbon::parse($request->soneca4_ss);
            $request->soneca4_hd = \Carbon\Carbon::parse($request->soneca4_hd);
            $request->soneca4_ha = \Carbon\Carbon::parse($request->soneca4_ha);
            $ritual_window = $request->soneca4_ha;

            $analyze->naps()->create([
                'number' => '4',
                'timeSlept' => $request->soneca4_hd,
                'timeWokeUp' => $request->soneca4_ha,
                'signalSlept' => $request->soneca4_ss,
                'window' => $request->soneca4_hd->diffInMinutes($request->soneca3_ha),
                'windowSignalSlept' => $request->soneca4_hd->diffInMinutes($request->soneca4_ss),
                'duration' => $request->soneca4_ha->diffInMinutes($request->soneca4_hd),
            ]);
        }

        if ($request->soneca5_ss != null) {
            $request->soneca5_ss = \Carbon\Carbon::parse($request->soneca5_ss);
            $request->soneca5_hd = \Carbon\Carbon::parse($request->soneca5_hd);
            $request->soneca5_ha = \Carbon\Carbon::parse($request->soneca5_ha);
            $ritual_window = $request->soneca5_ha;

            $analyze->naps()->create([
                'number' => '5',
                'timeSlept' => $request->soneca5_hd,
                'timeWokeUp' => $request->soneca5_ha,
                'signalSlept' => $request->soneca5_ss,
                'window' => $request->soneca5_hd->diffInMinutes($request->soneca4_ha),
                'windowSignalSlept' => $request->soneca5_hd->diffInMinutes($request->soneca5_ss),
                'duration' => $request->soneca5_ha->diffInMinutes($request->soneca5_hd),
            ]);
        }

        if ($request->soneca6_ss != null) {
            $request->soneca5_ss = \Carbon\Carbon::parse($request->soneca6_ss);
            $request->soneca6_hd = \Carbon\Carbon::parse($request->soneca6_hd);
            $request->soneca6_ha = \Carbon\Carbon::parse($request->soneca6_ha);
            $ritual_window = $request->soneca6_ha;

            $analyze->naps()->create([
                'number' => '6',
                'timeSlept' => $request->soneca6_hd,
                'timeWokeUp' => $request->soneca6_ha,
                'signalSlept' => $request->soneca6_ss,
                'window' => $request->soneca6_hd->diffInMinutes($request->soneca5_ha),
                'windowSignalSlept' => $request->soneca6_hd->diffInMinutes($request->soneca6_ss),
                'duration' => $request->soneca6_ha->diffInMinutes($request->soneca6_hd),
            ]);
        }


        if ($request->ritual_ss != null) {
            $request->ritual_ss = \Carbon\Carbon::parse($request->ritual_ss);
            $request->ritual_in = \Carbon\Carbon::parse($request->ritual_in);
            $request->ritual_d = \Carbon\Carbon::parse($request->ritual_d);
            $analyze->rituals()->first()->update([
                'signalSlept' => $request->ritual_ss,
                'start' => $request->ritual_in,
                'end' => $request->ritual_d,
                'duration' => $request->ritual_d->diffInMinutes($request->ritual_in),
                'window' => $request->ritual_in->diffInMinutes($ritual_window),
                'windowSignalSlept' => $request->ritual_in->diffInMinutes($request->ritual_ss)
            ]);
        }
        if ($request->despertar1_a != null) {
            $request->despertar1_a = \Carbon\Carbon::parse($request->despertar1_a);
            $request->despertar1_d = \Carbon\Carbon::parse($request->despertar1_d);

            if ($request->despertar1_a->format('H') >= 0 && $request->despertar1_a->format('H') < 7) {
                $request->despertar1_a->addDays(1);
            }

            if ($request->despertar1_d->format('H') >= 0 && $request->despertar1_d->format('H') < 7) {
                $request->despertar1_d->addDays(1);
            }
            if ($request->despertar1_fd == 4) {
                $request->despertar1_fd = $request->despertar1_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '1',
                'timeWokeUp' => $request->despertar1_a,
                'timeSlept' => $request->despertar1_d,
                'duration' => $request->despertar1_d->diffInMinutes($request->despertar1_a),
                'sleepingMode' => $request->despertar1_fd
            ]);
        }
        if ($request->despertar2_a != null) {
            $request->despertar2_a = \Carbon\Carbon::parse($request->despertar2_a);
            $request->despertar2_d = \Carbon\Carbon::parse($request->despertar2_d);

            if ($request->despertar2_a->format('H') >= 0 && $request->despertar2_a->format('H') < 7) {
                $request->despertar2_a->addDays(1);
            }

            if ($request->despertar2_d->format('H') >= 0 && $request->despertar2_d->format('H') < 7) {
                $request->despertar2_d->addDays(1);
            }
            if ($request->despertar2_fd == 4) {
                $request->despertar2_fd = $request->despertar2_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '2',
                'timeWokeUp' => $request->despertar2_a,
                'timeSlept' => $request->despertar2_d,
                'duration' => $request->despertar2_d->diffInMinutes($request->despertar2_a),
                'sleepingMode' => $request->despertar2_fd
            ]);
        }

        if ($request->despertar3_a != null) {
            $request->despertar3_a = \Carbon\Carbon::parse($request->despertar3_a);
            $request->despertar3_d = \Carbon\Carbon::parse($request->despertar3_d);

            if ($request->despertar3_a->format('H') >= 0 && $request->despertar3_a->format('H') < 7) {
                $request->despertar3_a->addDays(1);
            }

            if ($request->despertar3_d->format('H') >= 0 && $request->despertar3_d->format('H') < 7) {
                $request->despertar3_d->addDays(1);
            }
            if ($request->despertar3_fd == 4) {
                $request->despertar3_fd = $request->despertar3_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '3',
                'timeWokeUp' => $request->despertar3_a,
                'timeSlept' => $request->despertar3_d,
                'duration' => $request->despertar3_d->diffInMinutes($request->despertar3_a),
                'sleepingMode' => $request->despertar3_fd
            ]);
        }

        if ($request->despertar4_a != null) {
            $request->despertar4_a = \Carbon\Carbon::parse($request->despertar4_a);
            $request->despertar4_d = \Carbon\Carbon::parse($request->despertar4_d);

            if ($request->despertar4_a->format('H') >= 0 && $request->despertar4_a->format('H') < 7) {
                $request->despertar4_a->addDays(1);
            }

            if ($request->despertar4_d->format('H') >= 0 && $request->despertar4_d->format('H') < 7) {
                $request->despertar4_d->addDays(1);
            }
            if ($request->despertar4_fd == 4) {
                $request->despertar4_fd = $request->despertar4_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '4',
                'timeWokeUp' => $request->despertar4_a,
                'timeSlept' => $request->despertar4_d,
                'duration' => $request->despertar4_d->diffInMinutes($request->despertar4_a),
                'sleepingMode' => $request->despertar4_fd
            ]);
        }

        if ($request->despertar5_a != null) {
            $request->despertar5_a = \Carbon\Carbon::parse($request->despertar5_a);
            $request->despertar5_d = \Carbon\Carbon::parse($request->despertar5_d);

            if ($request->despertar5_a->format('H') >= 0 && $request->despertar5_a->format('H') < 7) {
                $request->despertar5_a->addDays(1);
            }

            if ($request->despertar5_d->format('H') >= 0 && $request->despertar5_d->format('H') < 7) {
                $request->despertar5_d->addDays(1);
            }
            if ($request->despertar5_fd == 4) {
                $request->despertar5_fd = $request->despertar5_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '5',
                'timeWokeUp' => $request->despertar5_a,
                'timeSlept' => $request->despertar5_d,
                'duration' => $request->despertar5_d->diffInMinutes($request->despertar5_a),
                'sleepingMode' => $request->despertar5_fd
            ]);
        }

        if ($request->despertar6_a != null) {
            $request->despertar6_a = \Carbon\Carbon::parse($request->despertar6_a);
            $request->despertar6_d = \Carbon\Carbon::parse($request->despertar6_d);

            if ($request->despertar6_a->format('H') >= 0 && $request->despertar6_a->format('H') < 7) {
                $request->despertar6_a->addDays(1);
            }

            if ($request->despertar6_d->format('H') >= 0 && $request->despertar6_d->format('H') < 7) {
                $request->despertar6_d->addDays(1);
            }
            if ($request->despertar6_fd == 4) {
                $request->despertar6_fd = $request->despertar6_fd_outro;
            }
            $analyze->wakes()->create([
                'number' => '6',
                'timeWokeUp' => $request->despertar6_a,
                'timeSlept' => $request->despertar6_d,
                'duration' => $request->despertar6_d->diffInMinutes($request->despertar6_a),
                'sleepingMode' => $request->despertar6_fd
            ]);
        }
        return redirect()->route('desafio.show', $challenge->id)->with('sucesso', 'Análise atualizada');
    }

    public function chatStore(Request $request, $id)
    {
        if (!$challenge = $this->repository->find($id)) {
            return redirect()->back();
        }
        $challenge = $this->repository->find($id);
        if ($challenge->chat()->first() == null) {
            $chat = $challenge->chat()->create(['status' => 'mae']);
        } else {
            $chat = $challenge->chat()->first();
        }
        $chat->update(['status' => 'mae']);
        $chat->messages()->create(['content' => $request->message, 'type' => '1']);

        //  $chat->notify(new ChatTelegramNotification());

        return redirect()->route('desafio.show', $challenge->id);
    }

    public function clientEdit()
    {
        $client = Auth::guard('clients')->user();
        return view('site.desafio.profile-edit', compact('client'));
    }

    public function messageEdit($id)
    {
        $message = Message::find($id);
        return view('site.desafio.edit-message', compact('message'));
    }

    public function messageUpdate(Request $request, $id)
    {
        $message = Message::find($id);
        $message->update(['content' => $request->content]);

        $challenge = $message->chat->challenge()->first();


        return redirect()->route('desafio.show', $challenge->id);
    }

    public  $messageClient = [

        'name.required' => 'O campo Nome da Mãe é de preenchimento obrigatório',
        'name.max' => 'O campo Nome da Mãe permite no máximo 255 caracteres',
        'name.min' => 'O campo Nome da Mãe permite no mínimo 3 caracteres',
        'nameBaby.required' => 'O campo Nome do Bebê é de preenchimento obrigatório',
        'nameBaby.max' => 'O campo Nome da Mãe permite no máximo 255 caracteres',
        'nameBaby.min' => 'O campo Nome do Bebê permite no mínimo 3 caracteres',
        'birthBaby.required' => 'O campo Nascimento do Bebê é de preenchimento obrigatório',
        'birthBaby.date_format' => 'O campo Nascimento do Bebê deve ser preenchido com uma data válida no formato dd/mm/yyyy',
        'sexBaby.required' => 'O campo Sexo do Bebê é de preenchimento obrigatório',

    ];
    protected function validatorClient(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|min:3',
            'nameBaby' => 'required|string|max:255|min:3',
            'birthBaby' => 'required|date_format:d/m/Y',
            'sexBaby' => 'required|string|max:255',

        ], $this->messageClient);
    }

    public function clientUpdate(Request $request)
    {
        $client = Auth::guard('clients')->user();
        $this->validatorClient($request->all())->validate();

        $client->update([
            'name' => $request->name,
            'nameBaby' => $request->nameBaby,
            'birthBaby' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->birthBaby)->format('Y-m-d'),
            'sexBaby' => $request->sexBaby,
        ]);

        $challenge = $client->challenges->last();
        return redirect()->route('desafio.show', $challenge->id)->with('sucesso', 'Dados atualizados');
    }

    public function doubtCenter()
    {
        $modules = Module::all();
        return view('site.desafio.doubt-center', compact('modules'));
    }

    public function doubtCenterModule($id)
    {

        if (!$module = Module::find($id)) {
            return redirect()->back();
        }

        return view('site.desafio.doubt-center-show', compact('module'));
    }

    public function doubtCenterSubmodule($id)
    {

        if (!$submodule = Submodule::find($id)) {
            return redirect()->back();
        }

        return view('site.desafio.queries', compact('submodule'));
    }

    public function queryShow()
    {
        return view('site.desafio.query');
    }

    public function query(Request $request)
    {
        $client = Auth::guard('clients')->user();

        $doubt = $client->doubts()->create([
            'status' => 'ENVIADO',
            'sended_at' => now(),
            'query' => $request->pergunta
        ]);

        return redirect()->route('my.queries')->with('sucesso', 'Dúvida Enviada!');
    }

    public function myQueries()
    {
        $client = Auth::guard('clients')->user();

        $doubts = $client->doubts()->get();
        return view('site.desafio.my-queries', compact('doubts'));
    }


    public function doubtShow($id)
    {


        $doubt = Doubt::find($id);

        return view('site.desafio.myquery-show', compact('doubt'));
    }

    public function passo1($id, $day)
    {
        $client = Auth::guard('clients')->user();

        $challenge = $this->repository->find($id);
        $analyze = $challenge->analyzes()->where('day', $day)->first();
        $ritual = $analyze->rituals()->first();
        $naps = $analyze->naps()->get();
        $wakes = $analyze->wakes()->get();
        $janela = getJanela(getIdade($client->birthBaby));
        $babyAge = getIdade($client->birthBaby);
        $qtd_ritual_sonecas_longo = count($analyze->naps->where('windowSignalSlept', '>', 30));
        $qtd_ritual_inadequado = count($analyze->rituals->where('duration', '>', 30));
        $qtd_rituais_inadequados = $qtd_ritual_sonecas_longo + $qtd_ritual_inadequado;
        $qtd_sonecas_inadequadas = count($analyze->naps->where('duration', '<', 40));
        $qtd_sinais_sono_tardio = 0;
        $sinais_sono_resposta = "";
        foreach ($analyze->naps as $item) {
            if ($item->window - $item->windowSignalSlept > $janela->janelaIdealFim - 30) {
                $qtd_sinais_sono_tardio++;
            }
        }
        foreach ($analyze->rituals as $item) {
            if ($item->window - $item->windowSignalSlept > $janela->janelaIdealFim - 30) {
                $qtd_sinais_sono_tardio++;
            }
        }

        if ($qtd_sinais_sono_tardio == 0) {
            $sinais_sono_resposta = "Ótimo! Você consegue perceber os sinais de sono do seu bebê muito bem.
Vamos conferir os próximos pontos.
";
        }

        if ($qtd_sinais_sono_tardio > 0) {
            if ($babyAge < 60) {
                $sinal_sono_esperado = "30 a 50 minutos, até que sinta sono.";
            }
            if ($babyAge >= 60 && $babyAge < 120) {
                $sinal_sono_esperado = "45 a 50 minutos, até que sinta sono.";
            }
            if ($babyAge >= 120 && $babyAge < 180) {
                $sinal_sono_esperado = "70 a 90 minutos, até que sinta sono.";
            }
            if ($babyAge >= 180 && $babyAge < 210) {
                $sinal_sono_esperado = "90 a 120 minutos, até que sinta sono.";
            }
            if ($babyAge >= 210 && $babyAge < 365) {
                $sinal_sono_esperado = "2 a 3 horas, até que sinta sono.";
            }
            if ($babyAge >= 365 && $babyAge < 540) {
                $sinal_sono_esperado = "3 a 3 horas e meia, até que sinta sono.";
            }
            if ($babyAge > 540) {
                $sinal_sono_esperado = "5 a 6 horas até que sinta sono.";
            }
            $sinais_sono_resposta = "Como você pode ver, nessa pré-análise foi observado que o intervalo entre o despertar do bebê e ele sentir sono novamente foi muito longo para a idade.
Nessa idade, o esperado é:\n"
                . $sinal_sono_esperado .
                "\nOu seja, provavelmente seu bebê está emitindo sinais de sono que estão passando despercebidos. A sugestão inicial é que observe com um pouco mais de cuidado e veja se ele emitirá algum sinal de sono dentro desse horário esperado.

Para facilitar, vou deixar aqui uma lista de sinais de sono:

Sinais precoces: (bebê começou a sentir sono)
- Bocejar 
- Escondendo o rosto no peito de quem o segura no colo 
- Fazendo movimentos involuntários com braços e pernas 
- Esfregando os olhos 
- Puxando as orelhas/cabelos 
- Arranhando o próprio rosto/Batendo nas pessoas 
 
Intermediários: (bebê já está sentindo sono há alguns minutos)
- Olhar parado/fixo em algo 
- Ficando com os movimentos menos coordenados 
- Perdendo o interesse nos brinquedos 
 
Tardios: (bebê está sentindo sono há muito tempo)
-Irritabilidade 
-Virando/Arqueando o corpo para trás 
-Caindo muito ou esbarrando em coisas ou pessoas ";
        }

        if ($qtd_rituais_inadequados == 0) {
            $rituais_sono_resposta = "Que bom! Todos os rituais tiveram duração inferior a 30 minutos.
Isso é essencial para um sono reparador.";
        }

        if ($qtd_rituais_inadequados > 0) {
            $rituais_sono_resposta = "Estou vendo que houve alguns rituais com mais de 30 minutos.
Nesse primeiro passo, devo apenas te lembrar que o ideal de um ritual é que ele dure menos de 30 minutos e que seja sem choro.
Faça o seu melhor, mas caso tenha dificuldades com o ritual, conversaremos com mais detalhes no Passo 3. O principal, nesse primeiro momento, é mesmo conseguir perceber os sinais de sono do seu bebê.
";
        }

        if ($qtd_sonecas_inadequadas == 0) {
            $duracao_sonecas_resposta = "Vamos então para o 3º ponto a ser avaliado, a duração das sonecas.
E estou vendo que todas as sonecas tiveram duração superior a 40 minutos.
Isso é essencial para um sono reparador e para dormir a noite inteira.
Parabéns!
";
        }

        if ($qtd_sonecas_inadequadas > 0) {
            $duracao_sonecas_resposta = "Vamos então para o 3º ponto a ser avaliado, a duração das sonecas.
E estou vendo que houve algumas sonecas com duração menor que 40 minutos.
Nesse primeiro passo, devo apenas te lembrar que o ideal de uma soneca é que ela dure mais de 40 minutos e que seja sem choro.
Faça o seu melhor, mas caso tenha dificuldades com as sonecas, conversaremos com mais detalhes no Passo 3. O principal, nesse primeiro momento, é mesmo conseguir perceber os sinais de sono do seu bebê.
";
        }

        return view('site.desafio.passo1', compact('client', 'analyze', 'challenge', 'qtd_sinais_sono_tardio', 'sinais_sono_resposta', 'rituais_sono_resposta', 'duracao_sonecas_resposta'));
    }

    public function passo2($id)
    {
        $challenge = Challenge::find($id);
        $client = Auth::guard('clients')->user();
        $babyAge = getIdade($client->birthBaby);
        return view('site.desafio.passo2', compact('client', 'babyAge', 'challenge'));
    }

    public function passo3_despertar_analise($id)
    {
        $challenge = Challenge::find($id);
        $client = Auth::guard('clients')->user();
        $babyAge = getIdade($client->birthBaby);
        return view('site.desafio.passo3_despertar_analise', compact('client', 'babyAge', 'challenge'));
    }

    public function passo4_analise($id)
    {
        $challenge = Challenge::find($id);
        $client = Auth::guard('clients')->user();
        $babyAge = getIdade($client->birthBaby);
        return view('site.desafio.passo4_analise', compact('client', 'babyAge', 'challenge'));
    }
    public function conclusao($id)
    {
        $challenge = Challenge::find($id);
        $client = Auth::guard('clients')->user();
        $babyAge = getIdade($client->birthBaby);
        $qtd_dias_acordou_cedo = count($challenge->analyzes->where('timeWokeUp', '<', '06:00:00'));
        $qtd_dias_acordou_tarde = count($challenge->analyzes->where('timeWokeUp', '>', '08:00:00'));
        $qtd_sonecas_inadequadas = count($challenge->naps->where('duration', '<', 40));

        $janelas = [];

        foreach ($challenge->naps as $nap) {
            if ((($nap->window - $nap->windowSignalSlept) < getSinalSono(getIdade($client->birthBaby))->janelaIdealFim) && (($nap->window - $nap->windowSignalSlept) >= getSinalSono(getIdade($client->birthBaby))->janelaIdealInicio)) {
                array_push($janelas, $nap->window - $nap->windowSignalSlept);
            }
        }

        foreach ($challenge->rituals as $ritual) {
            if ($ritual->window < getSinalSono(getIdade($client->birthBaby))->janelaIdealFim && $ritual->window >= getSinalSono(getIdade($client->birthBaby))->janelaIdealInicio) {
                array_push($janelas, $ritual->window);
            }
        }

        if (count($janelas) > 0) {
            $media_janelas = array_sum($janelas) / count($janelas);
        } else {
            $media_janelas = 0;
        }




        return view('site.desafio.conclusao', compact('client', 'babyAge', 'challenge', 'janelas', 'media_janelas', 'qtd_sonecas_inadequadas', 'qtd_dias_acordou_cedo', 'qtd_dias_acordou_tarde', 'qtd_sonecas_inadequadas'));
    }
    public function passo3_rotina_sonecas_analise($id)
    {
        $challenge = Challenge::find($id);
        $client = Auth::guard('clients')->user();
        $babyAge = getIdade($client->birthBaby);
        return view('site.desafio.passo3_rotina_sonecas_analise', compact('client', 'babyAge', 'challenge'));
    }
    public function passo3_pilares_analise($id)
    {
        $challenge = Challenge::find($id);
        $client = Auth::guard('clients')->user();
        $babyAge = getIdade($client->birthBaby);
        return view('site.desafio.passo3_pilares_analise', compact('client', 'babyAge', 'challenge'));
    }

    public function passo2_analise($id)
    {
        $challenge = Challenge::find($id);
        $client = Auth::guard('clients')->user();
        $babyAge = getIdade($client->birthBaby);
        return view('site.desafio.passo2_analise', compact('client', 'babyAge', 'challenge'));
    }

    public function passo3_despertar($id)
    {
        $challenge = Challenge::find($id);
        $client = Challenge::find($id)->client;
        $qtd_dias_acordou_cedo = count($challenge->analyzes->where('timeWokeUp', '<', '06:00:00'));
        $qtd_dias_acordou_tarde = count($challenge->analyzes->where('timeWokeUp', '>', '08:00:00'));
        $orientação_acordou_cedo = "";
        $orientação_acordou_tarde = "";
        $orientação_acordou_bem = "";
        if ($qtd_dias_acordou_cedo > 0) {
            $orientação_acordou_cedo = "Despertar antes de 06:00.
	Se isso for incômodo para você, lembre que a principal causa para esse despertar tão cedo é a junção de baixos níveis de melatonina (normais para o horário) com um ambiente desajustado, ou seja, que há luz e/ou ruídos.
	Por isso a orientação inicial é para ajustar ao máximo o seu ambiente do sono.
	Quanto mais escuro e silencioso ele estiver, melhor.
	E caso não consiga que ele fique tão silencioso, o uso do ruído branco te ajudará!";
        }
        if ($qtd_dias_acordou_tarde > 0) {
            $orientação_acordou_tarde = "Despertar após às 08:00
	O ideal e o mais fisiológico para o organismo do ser humano, é que ele acorde até 08:00, tanto porque esse é o horário que o organismo já está liberando cortisol, que é um dos hormônios responsáveis pelo despertar, quanto porque o bebê que acorda tarde costuma dormir cada vez mais tarde.";
        }

        if (($qtd_dias_acordou_tarde == 0) && ($qtd_dias_acordou_cedo == 0)) {
            $orientação_acordou_bem = "Todos os despertares entre 06:00 e 08:00
	Vi que os horários dos despertares do seu bebê estão adequados, parabéns! Esses são os horários mais fisiológicos para o seu bebê.
	Gostaria apenas de lembrar que se você conseguir manter o intervalo entre o despertar mais cedo e o mais tarde em 1 hora, você certamente conseguirá muito mais previsibilidade para o seu dia e poderá se organizar melhor. Ou seja, esse ajuste mais refinado é muito mais para você do que para o seu bebê.
";
        }

        return view('site.desafio.passo3_despertar', compact('client', 'challenge', 'orientação_acordou_cedo', 'orientação_acordou_tarde', 'orientação_acordou_bem'));
    }

    public function passo3_rotina_sonecas($id)
    {
        $challenge = Challenge::find($id);
        $client = Challenge::find($id)->client;
        $qtd_sonecas_inadequadas = count($challenge->naps->where('duration', '<', 40));

        $janelas = [];

        foreach ($challenge->naps as $nap) {
            if ((($nap->window - $nap->windowSignalSlept) < getSinalSono(getIdade($client->birthBaby))->janelaIdealFim) && (($nap->window - $nap->windowSignalSlept) >= getSinalSono(getIdade($client->birthBaby))->janelaIdealInicio)) {
                array_push($janelas, $nap->window - $nap->windowSignalSlept);
            }
        }

        foreach ($challenge->rituals as $ritual) {
            if ($ritual->window < getSinalSono(getIdade($client->birthBaby))->janelaIdealFim && $ritual->window >= getSinalSono(getIdade($client->birthBaby))->janelaIdealInicio) {
                array_push($janelas, $ritual->window);
            }
        }
        if (count($janelas) > 0) {
            $media_janelas = array_sum($janelas) / count($janelas);
        } else {
            $media_janelas = 0;
        }


        return view('site.desafio.passo3_rotina_sonecas', compact('challenge', 'client', 'janelas', 'media_janelas', 'qtd_sonecas_inadequadas'));
    }
    public function passo3_rotina_sonecas2($id)
    {
        $challenge = Challenge::find($id);
        $client = Challenge::find($id)->client;
        $qtd_sonecas_inadequadas = count($challenge->naps->where('duration', '<', 40));

        $janelas = [];

        foreach ($challenge->naps as $nap) {
            if ((($nap->window - $nap->windowSignalSlept) < getSinalSono(getIdade($client->birthBaby))->janelaIdealFim) && (($nap->window - $nap->windowSignalSlept) >= getSinalSono(getIdade($client->birthBaby))->janelaIdealInicio)) {
                array_push($janelas, $nap->window - $nap->windowSignalSlept);
            }
        }

        foreach ($challenge->rituals as $ritual) {
            if ($ritual->window < getSinalSono(getIdade($client->birthBaby))->janelaIdealFim && $ritual->window >= getSinalSono(getIdade($client->birthBaby))->janelaIdealInicio) {
                array_push($janelas, $ritual->window);
            }
        }

        if (count($janelas) > 0) {
            $media_janelas = array_sum($janelas) / count($janelas);
        } else {
            $media_janelas = 0;
        }
dd($janelas);

      //  return view('site.desafio.passo3_rotina_sonecas', compact('challenge', 'client', 'janelas', 'media_janelas', 'qtd_sonecas_inadequadas'));
    }
    public function passo3_pilares($id)
    {
        $challenge = Challenge::find($id);
        $client = Challenge::find($id)->client;

        $qtd_despertares_inadequadas = count($challenge->wakes->where('duration', '>', 30));
        $qtd_rituais_inadequadas = count($challenge->analyzes->where('day', 3)->first()->naps->where('windowSignalSlept', '>', 30));



        $janelas = [];

        foreach ($challenge->analyzes->where('day', 3)->first()->naps as $nap) {
            if (($nap->window - $nap->windowSignalSlept) > getSinalSono(getIdade($client->birthBaby))->janelaIdealFim) {
                array_push($janelas, $nap->window - $nap->windowSignalSlept);
            }
        }

        foreach ($challenge->analyzes->where('day', 3)->first()->rituals as $ritual) {
            if ($ritual->window > getSinalSono(getIdade($client->birthBaby))->janelaIdealFim) {
                array_push($janelas, $ritual->window);
            }
        }


        if (count($janelas) > 0) {
            $media_janelas = array_sum($janelas) / count($janelas);
        } else {
            $media_janelas = 0;
        }



        return view('site.desafio.passo3_pilares', compact('challenge', 'client', 'janelas', 'media_janelas', 'qtd_despertares_inadequadas', 'qtd_rituais_inadequadas'));
    }
    public function passo4($id)
    {
        $challenge = Challenge::find($id);
        $client = Auth::guard('clients')->user();
        $babyAge = getIdade($client->birthBaby);
        return view('site.desafio.passo4', compact('client', 'babyAge', 'challenge'));
    }


    public function formulario_create($id, Request $request)
    {
        $challenge = Challenge::find($id);

        $challenge->formulario()->create(
            [
                'ajustes_fome' => $request->conclusao_fome,
                'ajustes_dor' => $request->conclusao_dor,
                'ajustes_dor_colica' => $request->conclusao_dor_colica,
                'ajustes_dor_refluxo' => $request->conclusao_dor_refluxo,
                'ajustes_dor_dentes' => $request->conclusao_dor_dente,
                'ajustes_salto' => $request->conclusao_salto,
                'ajustes_angustia' => $request->conclusao_angustia,
                'ajustes_telas' => $request->conclusao_telas,
                'telas' => $request->conclusao_telas,
                'angustia' => $request->angustia,
                'angustia_campo_visao' => $request->angustia_sim_campo,
                'angustia_pai_atende' => $request->angustia_sim_pai,
                'ajuste_exterogestacao' => $request->ajuste_exterogestacao,
                'fome_pediatra' => $request->ajuste_exterogestacao,
                'fome_peso_adequado' => $request->fome_peso_atual,
                'fome_peso_atual' => $request->fome_peso_atual,
                'fome_ganho_peso' => $request->fome_ganho_peso,
                'fome_urina' => $request->fome_fraldas,
                'fome_evacuacao' => $request->fome_evacuacoes,
                'fome_evacuacao' => $request->fome_evacuacoes,
                'salto' => $request->salto,
                'salto_marcos' => $request->salto_marcos,
                'passo2' => 'FEITO'

            ]
        );
        return redirect()->route('desafio.show', $challenge->id);
    }
    public function formulario_update($id, Request $request)
    {

        $challenge = Challenge::find($id);

        if ($request->passo3_despertar == "FEITO") {
            $challenge->formulario()->update(
                [
                    'ritual_bom_dia' => $request->rbd,
                    'ritual_bom_dia_outros' => $request->ritual_bom_dia_outros,
                    'ajustes_despertar' => $request->conclusao_despertar,
                    'ajustes_ritual_bom_dia' => $request->conclusao_rbd,
                    'passo3_despertar' => 'FEITO',

                ]
            );
        }

        if ($request->passo3_rotina == "FEITO") {
            $challenge->formulario()->update(
                [

                    'ajuste_rotina_sonecas' => $request->ajuste_rotina_sonecas,
                    'ajuste_duracao_sonecas' => $request->ajuste_duracao_sonecas,
                    'passo3_rotina' => 'FEITO',

                ]
            );
        }

        if ($request->passo3_pilares == "FEITO") {
            $challenge->formulario()->update(
                [


                    'desacelera' => $request->desacelera,
                    'ambiente_luz' => $request->ambiente_luz,
                    'ambiente_barulho' => $request->ambiente_som,
                    'ambiente_temperatura' => $request->ambiente_temperatura,
                    'ritual_choro' => $request->ritual_choro,
                    'ritual_momento' => $request->ritual_choro_sim_select,
                    'gasto_energia_ajuste' => $request->gasto_energia_ajuste,
                    'sinais_sono_ajuste' => $request->sinais_sono_ajuste,
                    'desacelerar_ajuste' => $request->desacelerar_ajuste,
                    'ambiente_luz_ajuste' => $request->ambiente_luz_ajuste,
                    'ambiente_som_ajuste' => $request->ambiente_som_ajuste,
                    'ambiente_temperatura_ajuste' => $request->ambiente_temperatura_ajuste,
                    'ritual_sono_ajuste' => $request->ritual_sono_ajuste,
                    'passo3_pilares' => 'FEITO',


                ]
            );
        }

        if ($request->conclusao == "FEITO") {
            $challenge->formulario()->update(
                [
                    'comentarios' => $request->comentarios,
                    'conclusao' =>'FEITO'
                ]
            );

            $challenge->update([
                'status' => 'ENVIADO', 'sended_at' => now(),
            ]);
        }
        if ($request->passo4 == "FEITO") {
            $challenge->formulario()->update(
                [
                    'associacao_soneca_mamar' => $request->associacao_soneca_mamar,
                    'associacao_soneca_cc' => $request->associacao_soneca_cc,
                    'associacao_soneca_rede' => $request->associacao_soneca_rede,
                    'associacao_soneca_chupar_dedo'  => $request->associacao_soneca_chupar_dedo,
                    'associacao_soneca_chupeta'                => $request->associacao_soneca_chupeta,
                    'associacao_soneca_ruido'                => $request->associacao_soneca_ruido,
                    'associacao_sono_colo' => $request->associacao_sono_colo,
                    'associacao_sono_mamar' => $request->associacao_sono_mamar,
                    'associacao_sono_cc' => $request->associacao_sono_cc,
                    'associacao_sono_rede' => $request->associacao_sono_rede,
                    'associacao_sono_chupar_dedo' => $request->associacao_sono_chupar_dedo,
                    'associacao_sono_naninha' => $request->associacao_sono_naninha,
                    'associacao_sono_chupeta' => $request->associacao_sono_chupeta,
                    'associacao_sono_ruido' => $request->associacao_sono_ruido,
                    'associacao_incomoda' => $request->associacao_incomoda,
                    'associacao_descricao' => $request->associacao_descricao,
                    'passo4' => 'FEITO'
                ]
            );
        }


        return redirect()->route('desafio.show', $challenge->id);
    }
}
