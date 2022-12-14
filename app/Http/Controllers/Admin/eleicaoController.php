<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Eleicao, Secretaria, User};
use App\Http\Requests\Admin\{eleicaoRequest, importRequest};
use Illuminate\Support\Facades\DB;
use App\Services\EleicaoService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

// Validação
use Illuminate\Support\Facades\Validator;
use App\Rules\Cpf;
use Illuminate\Support\Str;

// MAIL
use App\Mail\importMail;
use Illuminate\Support\Facades\Mail;


// use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;

class eleicaoController extends Controller
{

    public function index(Request $request)
    {
        $eleicoes = Eleicao::query();
        $users = User::find(Auth::id());


        if (isset($request->search) && $request->search !== ''){
            $eleicoes->where('name', 'like', '%'.$request->search.'%');
        }

        return view('admin.eleicao.index', [
            'eleicoes' => $eleicoes->paginate(5),
            'search' => isset($request->search) ? $request->search : '',
            'users' => $users,
            'secretarias' => Secretaria::find(1),
        ]);
    }

    public function create()
    {
        $users = User::find(Auth::id());

        return view('admin.eleicao.create', [
            'users' => $users,
            'secretarias' => Secretaria::find(1)
        ]);
    }

    public function store(eleicaoRequest $request)
    {
        $data = $request->validated();

        // JUNTANDO DATA E HORA DA ELEIÇÃO E INSCRIÇÃO
        $data['start_date_inscricao'] .= ' '.$data['start_time_inscricao'];
        $data['end_date_inscricao'] .= ' '.$data['end_time_inscricao'];
        $data['start_date_homologacao'] .= ' '.$data['start_time_homologacao'];
        $data['end_date_homologacao'] .= ' '.$data['end_time_homologacao'];
        $data['start_date_eleicao'] .= ' '.$data['start_time_eleicao'];
        $data['end_date_eleicao'] .= ' '.$data['end_time_eleicao'];

        // VALIDANDO TEMPO DA INSCRICAO, homologacao E ELEICAO
        $validator = Validator::make(request()->all(), []);

        if($data['start_date_inscricao'] >= $data['end_date_inscricao']){
            $validator->errors()
                ->add('end_time_inscricao', 'Horario final deve ser maior que o inicial');
        }

        if($data['start_date_homologacao'] < $data['end_date_inscricao']){
            if($data['start_date_homologacao'] >= $data['end_date_homologacao']){
                $validator->errors()
                    ->add('start_time_homologacao', 'Horario inicial depuração deve ser maior que o final da inscrição')
                    ->add('end_time_homologacao', 'Horario final deve ser maior que o inicial');
            }else{
                $validator->errors()->add('start_time_homologacao', 'Horario inicial depuração deve ser maior que o final da inscrição');
            }
        }
        elseif($data['start_date_homologacao'] >= $data['end_date_homologacao']){
            $validator->errors()
                    ->add('end_time_homologacao', 'Horario final deve ser maior que o inicial');
        }

        if($data['start_date_eleicao'] < $data['end_date_homologacao']){
            if($data['start_date_eleicao'] >= $data['end_date_eleicao']){
                $validator->errors()
                    ->add('start_time_eleicao', 'Horario inicial eleição deve ser maior que o final da depuração')
                    ->add('end_time_eleicao', 'Horario final deve ser maior que o inicial');
            }else{
                $validator->errors()
                ->add('start_time_eleicao', 'Horario inicial eleição deve ser maior que o final da depuração');
            }
        }
        elseif($data['start_date_eleicao'] >= $data['end_date_eleicao']){
            $validator->errors()
                ->add('end_time_eleicao', 'Horario final deve ser maior que o inicial');
        }

        $errors = $validator->errors();

        if(sizeof($errors->messages()) != 0){
            return back()->withErrors($validator)->withInput();
        }


        // REMOVENDO HORA ELEIÇÃO E INSCRIÇÃO DA VARIAVEL
        unset($data['start_time_inscricao']);
        unset($data['end_time_inscricao']);
        unset($data['start_time_homologacao']);
        unset($data['end_time_homologacao']);
        unset($data['start_time_eleicao']);
        unset($data['end_time_eleicao']);

        // return response()->json($data);
        Eleicao::create($data);

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição cadastrada com sucesso');
    }

    public function show(Eleicao $eleicao)
    {
        $users = User::find(Auth::id());

        $empty = DB::table('eleicao_user')->count();

        $vencedor = DB::table('eleicao_user')
                      ->where('eleicao_id', '=', $eleicao->id)
                      ->where('voto', '=', DB::table('eleicao_user')->where('eleicao_id', '=', $eleicao->id)->max('voto'))
                      ->value('user_id');


        $total = DB::table('eleicao_user')
                   ->where('eleicao_id', '=', $eleicao->id)
                   ->where('categoria', '=', 'candidato')
                   ->sum('voto');

        return view('admin.eleicao.show', [
            'eleicoes' => $eleicao,
            'users' => $users,
            'secretarias' => Secretaria::find(1),
            'vazio', $empty,

            'beforeInscricao' => EleicaoService::beforeInscricao($eleicao),
            'duringInscricao' => EleicaoService::duringInscricao($eleicao),
            'afterInscricao' => EleicaoService::afterInscricao($eleicao),
            'beforeHomologacao' => EleicaoService::beforeHomologacao($eleicao),
            'duringHomologacao' => EleicaoService::duringHomologacao($eleicao),
            'afterHomologacao' => EleicaoService::afterHomologacao($eleicao),
            'beforeEleicao' => EleicaoService::beforeEleicao($eleicao),
            'duringEleicao' => EleicaoService::duringEleicao($eleicao),
            'afterEleicao' => EleicaoService::afterEleicao($eleicao),

            'total' => $total,
            'vencedor' => $vencedor
        ]);
    }

    public function edit(Eleicao $eleicao)
    {
        $users = User::find(Auth::id());

        $start_date_inscricao = Carbon::parse($eleicao->start_date_inscricao)->format('Y-m-d');
        $end_date_inscricao = Carbon::parse($eleicao->end_date_inscricao)->format('Y-m-d');
        $start_time_inscricao = Carbon::parse($eleicao->start_date_inscricao)->format('H:i');
        $end_time_inscricao = Carbon::parse($eleicao->end_date_inscricao)->format('H:i');

        $start_date_homologacao = Carbon::parse($eleicao->start_date_homologacao)->format('Y-m-d');
        $end_date_homologacao = Carbon::parse($eleicao->end_date_homologacao)->format('Y-m-d');
        $start_time_homologacao = Carbon::parse($eleicao->start_date_homologacao)->format('H:i');
        $end_time_homologacao = Carbon::parse($eleicao->end_date_homologacao)->format('H:i');

        $start_date_eleicao = Carbon::parse($eleicao->start_date_eleicao)->format('Y-m-d');
        $end_date_eleicao = Carbon::parse($eleicao->end_date_eleicao)->format('Y-m-d');
        $start_time_eleicao = Carbon::parse($eleicao->start_date_eleicao)->format('H:i');
        $end_time_eleicao = Carbon::parse($eleicao->end_date_eleicao)->format('H:i');

        return view('admin.eleicao.edit', [
            'eleicoes' => $eleicao,
            'users' => $users,
            'secretarias' => Secretaria::find(1),

            'start_date_inscricao' => $start_date_inscricao,
            'start_time_inscricao' => $start_time_inscricao,
            'end_date_inscricao' => $end_date_inscricao,
            'end_time_inscricao' => $end_time_inscricao,
            'start_date_homologacao' => $start_date_homologacao,
            'start_time_homologacao' => $start_time_homologacao,
            'end_date_homologacao' => $end_date_homologacao,
            'end_time_homologacao' => $end_time_homologacao,
            'start_date_eleicao' => $start_date_eleicao,
            'start_time_eleicao' => $start_time_eleicao,
            'end_date_eleicao' => $end_date_eleicao,
            'end_time_eleicao' => $end_time_eleicao
        ]);
    }

    public function update(Eleicao $eleicao, eleicaoRequest $request)
    {
        $data = $request->validated();

        // JUNTANDO DATA E HORA DA ELEIÇÃO E INSCRIÇÃO
        $data['start_date_inscricao'] .= ' '.$data['start_time_inscricao'];
        $data['end_date_inscricao'] .= ' '.$data['end_time_inscricao'];
        $data['start_date_homologacao'] .= ' '.$data['start_time_homologacao'];
        $data['end_date_homologacao'] .= ' '.$data['end_time_homologacao'];
        $data['start_date_eleicao'] .= ' '.$data['start_time_eleicao'];
        $data['end_date_eleicao'] .= ' '.$data['end_time_eleicao'];

        // VALIDANDO TEMPO DA INSCRICAO E ELEICAO
        // VALIDANDO TEMPO DA INSCRICAO, homologacao E ELEICAO
        $validator = Validator::make(request()->all(), []);

        if($data['start_date_inscricao'] >= $data['end_date_inscricao']){
            $validator->errors()
                ->add('end_time_inscricao', 'Horario final deve ser maior que o inicial');
        }

        if($data['start_date_homologacao'] < $data['end_date_inscricao']){
            if($data['start_date_homologacao'] >= $data['end_date_homologacao']){
                $validator->errors()
                    ->add('start_time_homologacao', 'Horario inicial depuração deve ser maior que o final da inscrição')
                    ->add('end_time_homologacao', 'Horario final deve ser maior que o inicial');
            }else{
                $validator->errors()->add('start_time_homologacao', 'Horario inicial depuração deve ser maior que o final da inscrição');
            }
        }
        elseif($data['start_date_homologacao'] >= $data['end_date_homologacao']){
            $validator->errors()
                    ->add('end_time_homologacao', 'Horario final deve ser maior que o inicial');
        }

        if($data['start_date_eleicao'] < $data['end_date_homologacao']){
            if($data['start_date_eleicao'] >= $data['end_date_eleicao']){
                $validator->errors()
                    ->add('start_time_eleicao', 'Horario inicial eleição deve ser maior que o final da depuração')
                    ->add('end_time_eleicao', 'Horario final deve ser maior que o inicial');
            }else{
                $validator->errors()
                ->add('start_time_eleicao', 'Horario inicial eleição deve ser maior que o final da depuração');
            }
        }
        elseif($data['start_date_eleicao'] >= $data['end_date_eleicao']){
            $validator->errors()
                ->add('end_time_eleicao', 'Horario final deve ser maior que o inicial');
        }

        $errors = $validator->errors();

        if(sizeof($errors->messages()) != 0){
            return back()->withErrors($validator)->withInput();
        }

        // REMOVENDO HORA ELEIÇÃO E INSCRIÇÃO DA VARIAVEL
        unset($data['start_time_inscricao']);
        unset($data['end_time_inscricao']);
        unset($data['start_time_homologacao']);
        unset($data['end_time_homologacao']);
        unset($data['start_time_eleicao']);
        unset($data['end_time_eleicao']);

        $eleicao->update($data);

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição atualizada com sucesso');
    }

    public function destroy(Eleicao $eleicao)
    {
        if(EleicaoService::duringEleicao($eleicao)){
            return back()->with('warning', 'Eleição em andamento, não pode excluir');
        }

        $eleicao->delete();

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição removida com sucesso');
    }

    public function import(Eleicao $eleicao, importRequest $request)
    {
        $file = $request->validated();

        // Validando foto
        $messages = ['required' => 'Campo obrigatorio'];
        $validator = Validator::make(request()->all(), [
            'import' => 'mimes:csv,txt|required'
        ], $messages);

        if($validator->fails()){
            return back()->with('modalOpen', '3')->withErrors($validator);
        }

        $filename = $file['import']->getClientOriginalName();

        // ARMAZENA O DOCUMENTO LOCALMENTE
        $location = 'storage/imports';
        $file['import']->move($location, $filename);
        $filepath = public_path($location . "/" . $filename);

        // ABRE O ARQUIVO E SALVA O CONTEUDO DO ARQUIVO EM UM ARRAY
        $file['import'] = fopen($filepath, "r");
        $importData_arr = array();

        // VERIFICA E ARMAZENA O DELIMITADOR DO CSV
        $delimiter = $this->getCSVDelimiter($filepath);

        // LÊ O CONTEUDO DO ARQUIVO E REORGANIZA O ARRAY
        $i=0;
        while (($filedata = (fgetcsv($file['import'], 1000, $delimiter))) !== FALSE) {
            $num = count($filedata);
            if ($i == 0) {
                $i++;
                continue;
            }
            for ($c = 0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata[$c];
            }
            $i++;
        }

        // FECHA O ARQUIVO
        fclose($file['import']);

        // CRIAÇÃO dOS USUÁRIOS
        DB::beginTransaction();
        try {
            foreach ($importData_arr as $importData) {
                $password = Str::random(8);
                User::create([
                    'name' => $importData[0],
                    'email' => $importData[1],
                    'cpf' => $importData[2],
                    'password' => $password,
                    'role' => 'user',
                ]);

                Mail::to($importData[1])->send(new importMail('admin.eleicao.import', $importData[1], $password, $eleicao->name));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        //INCLUSÃO DOS USUÁRIOS NA ELEIÇÃO
        try{
            foreach ($importData_arr as $importData) {
                $user_id = User::where('name', $importData[0])->value('id');
                $eleicao->users()->attach([
                    $user_id => [
                        'categoria' => $importData[3],
                        'ocupacao' => $importData[4],
                        'doc_user_status' => 'aprovado',
                    ]
                ]);
            }
        } catch(\Exception $e){
            return back()->with('warning', 'Erro na importação do usuário');
        }

        return back()->with('success', 'Importação concluida');
    }

    public function getCSVDelimiter($csvfile){
        $delimiters = array( ',' => 0, ';' => 0, "\t" => 0, '|' => 0, );
        $firstLine = '';
        $handle = fopen($csvfile, 'r');
        if ($handle){
            $firstLine = fgets($handle);
            fclose($handle);
        }
        if ($firstLine){
            foreach ($delimiters as $delimiter => &$count){
                $count = count(str_getcsv($firstLine, $delimiter));
            }
            return array_search(max($delimiters), $delimiters);
        } else{
            return key($delimiters);
        }
    }
}
