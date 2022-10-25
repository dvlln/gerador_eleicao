<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Eleicao, User};
use App\Http\Requests\Admin\eleicaoRequest;
use Illuminate\Support\Facades\DB;
use App\Services\EleicaoService;


// use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;

class eleicaoController extends Controller
{

    public function index(Request $request)
    {
        $eleicoes = Eleicao::query();

        if (isset($request->search) && $request->search !== ''){
            $eleicoes->where('name', 'like', '%'.$request->search.'%');
        }

        return view('admin.eleicao.index', [
            'eleicoes' => $eleicoes->paginate(3),
            'search' => isset($request->search) ? $request->search : ''
        ]);
    }

    public function create()
    {
        return view('admin.eleicao.create');
    }

    public function store(eleicaoRequest $request)
    {
        $data = $request->validated();


        $data['start_date_eleicao'] .= ' '.$data['start_time_eleicao']; //JUNTANDO DATA E HORA INICIAL DA ELEICAO
        $data['end_date_eleicao'] .= ' '.$data['end_time_eleicao']; //JUNTANDO DATA E HORA FINAL DA ELEICAO

        $data['start_date_inscricao'] .= ' '.$data['start_time_inscricao']; //JUNTANDO DATA E HORA INICIAL
        $data['end_date_inscricao'] .= ' '.$data['end_time_inscricao']; //JUNTANDO DATA E HORA FINAL

        unset($data['start_time_eleicao']); // REMOVE HORA INICIAL
        unset($data['end_time_eleicao']); // REMOVE HORA FINAL

        unset($data['start_time_inscricao']); // REMOVE HORA INICIAL
        unset($data['end_time_inscricao']); // REMOVE HORA FINAL

        Eleicao::create($data);

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição cadastrada com sucesso');
    }

    public function show(Eleicao $eleicao)
    {

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
            'eleicaoStartDateHasPassed' => EleicaoService::eleicaoStartDateHasPassed($eleicao),
            'eleicaoEndDateHasPassed' => EleicaoService::eleicaoEndDateHasPassed($eleicao),
            'inscricaoStartDateHasPassed' => EleicaoService::inscricaoStartDateHasPassed($eleicao),
            'inscricaoEndDateHasPassed' => EleicaoService::inscricaoEndDateHasPassed($eleicao),
            'total' => $total,
            'vencedor' => $vencedor
        ]);
    }

    public function edit(Eleicao $eleicao)
    {
        $start_time_eleicao = date('H:i', strtotime($eleicao->start_date_eleicao));
        $end_time_eleicao = date('H:i', strtotime($eleicao->end_date_eleicao));
        $start_time_inscricao = date('H:i', strtotime($eleicao->start_date_inscricao));
        $end_time_inscricao = date('H:i', strtotime($eleicao->end_date_inscricao));

        return view('admin.eleicao.edit', [
            'eleicoes' => $eleicao,
            'start_time_eleicao' => $start_time_eleicao,
            'end_time_eleicao' => $end_time_eleicao,
            'start_time_inscricao' => $start_time_inscricao,
            'end_time_inscricao' => $end_time_inscricao
        ]);
    }

    public function update(Eleicao $eleicao, eleicaoRequest $request)
    {
        $data = $request->validated();

        $data['start_date_eleicao'] .= ' '.$data['start_time_eleicao']; //JUNTANDO DATA E HORA INICIAL DA ELEICAO
        $data['end_date_eleicao'] .= ' '.$data['end_time_eleicao']; //JUNTANDO DATA E HORA FINAL DA ELEICAO

        $data['start_date_inscricao'] .= ' '.$data['start_time_inscricao']; //JUNTANDO DATA E HORA INICIAL
        $data['end_date_inscricao'] .= ' '.$data['end_time_inscricao']; //JUNTANDO DATA E HORA FINAL

        unset($data['start_time_eleicao']); // REMOVE HORA INICIAL
        unset($data['end_time_eleicao']); // REMOVE HORA FINAL

        unset($data['start_time_inscricao']); // REMOVE HORA INICIAL
        unset($data['end_time_inscricao']); // REMOVE HORA FINAL

        $eleicao->update($data);

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição atualizada com sucesso');
    }

    public function destroy(Eleicao $eleicao)
    {
        $eleicao->delete();

        return redirect()->route('admin.eleicao.index')->with('success', 'Eleição removida com sucesso');
    }

    public function import(Eleicao $eleicao, Request $request)
    {
        $file = $request->all();

        if ($file) {
            $filename = $file['import']->getClientOriginalName();
            $extension = $file['import']->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file['import']->getRealPath();
            $fileSize = $file['import']->getSize(); //Get size of uploaded file in bytes

            //Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);

            //Where uploaded file will be stored on the server
            $location = 'storage/imports'; //Created an "uploads" folder for that

            // Upload file
            $file['import']->move($location, $filename);

            // In case the uploaded file path is to be stored in the database
            $filepath = public_path($location . "/" . $filename);

            // Reading file
            $file['import'] = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;

            $delimiter = $this->getCSVDelimiter($filepath);

            //Read the contents of the uploaded file
            while (($filedata = (fgetcsv($file['import'], 1000, $delimiter))) !== FALSE) {
                $num = count($filedata);

                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }

                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }

                $i++;
            }

            fclose($file['import']); //Close after reading

            foreach ($importData_arr as $importData) {
                // CRIAÇÃO dOS USUÁRIOS
                try {
                    DB::beginTransaction();
                    User::create([
                        'name' => $importData[0],
                        'email' => $importData[1],
                        'cpf' => $importData[2],
                        'password' => $importData[3],
                        'role' => $importData[4],
                        'foto' => $importData[5]
                    ]);

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }

                // INCLUSÃO DOS USUÁRIOS NA ELEIÇÃO
                $user_id = User::where('name', $importData[0])->value('id');

                $eleicao->users()->attach([
                    $user_id => [
                        'categoria' => $importData[6],
                    ]
                ]);
            }


            return back()->with('success', 'Importação concluida');
        } else {
            return back()->with('warning', 'Nenhum arquivo foi inserido');
        }
    }


    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                return redirect()->route('admin.eleicao.show')->with('warning', 'Nenhum arquivo foi inserido');
            }
        } else {
            return redirect()->route('admin.eleicao.show')->with('warning', 'Extensão invalida');
        }
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
