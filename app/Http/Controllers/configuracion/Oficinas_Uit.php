<?php

namespace App\Http\Controllers\configuracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Oficinas_Uit extends Controller {

    public function get_alluit() {
        return view('configuracion/vw_uit');
    }

    public function get_alloficinas() {
        return view('configuracion/vw_oficinas');
    }

    public function index() {
        header('Content-type: application/json');


        $totalg = DB::select('select count(pk_uit) as total from adm_tri.vw_uit');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];

        $total_pages = 0;
        if (!$sidx) {
            $sidx = 1;
        }
        $count = $totalg[0]->total;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $start = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
        if ($start < 0) {
            $start = 0;
        }

        $sql = DB::table('adm_tri.vw_uit')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;

        foreach ($sql as $Index => $Datos) {
            $Lista->rows[$Index]['id'] = $Datos->pk_uit;
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->pk_uit),
                trim($Datos->anio),
                trim($Datos->uit),
                trim($Datos->uit_alc),
                trim($Datos->tas_alc),
                trim($Datos->formatos),
                trim($Datos->porc_min_ivpp),
                trim($Datos->porc_ot_ins),
                trim($Datos->deoa15),
                trim($Datos->de15a60),
                trim($Datos->mas60),
            );
        }

        return response()->json($Lista);
//        echo json_encode($table);  
//        dd($table);
    }

    public function index1() {
        header('Content-type: application/json');


        $totalg = DB::select('select count(id_ofi) as total from adm_tri.oficinas');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];

        $total_pages = 0;
        if (!$sidx) {
            $sidx = 1;
        }
        $count = $totalg[0]->total;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $start = ($limit * $page) - $limit; // do not put $limit*($page - 1)  
        if ($start < 0) {
            $start = 0;
        }

        $sql = DB::table('adm_tri.oficinas')->orderBy($sidx, $sord)->limit($limit)->offset($start)->get();
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;

        foreach ($sql as $Index => $Datos) {
            $Lista->rows[$Index]['id'] = $Datos->id_ofi;
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->id_ofi),
                trim($Datos->nombre),
                trim($Datos->cod_oficina),
            );
        }

        return response()->json($Lista);
//        echo json_encode($table);  
//        dd($table);
    }

    public function insert(Request $request) {
        header('Content-type: application/json');

        $data = $request->all();


        if ($this->insert_2($request->all())) {
            return response()->json([
                        'msg' => 'si',
                            //'anio' => $data['anio'],
                            //'uit' => $data['uit']
            ]);
        }
    }

    public function insert_2(array $data) {
        $arr_uit = array('anio' => $data['anio'],
            'uit' => $data['uit'],
            'uit_alc' => $data['uit_alc'],
            'tas_alc' => $data['tas_alc'],
            'formatos' => $data['formatos'],
            'base_01' => $data['base_01'],
            'deoa15' => $data['deoa15'],
            'tram_01' => $data['tram_01'],
            'base_02' => $data['base_02'],
            'de15a60' => $data['de15a60'],
            'tram_02' => $data['tram_02'],
            'base_03' => $data['base_03'],
            'mas60' => $data['mas60'],
            'porc_min_ivpp' => $data['porc_min_ivpp'],
            'porc_ot_ins' => $data['porc_ot_ins']
        );
        // $uit=array('uit'=>$data['uit']); 
        //$insert = DB::table('uit')->insert($arr_uit)->where('id','=',$id);
        $insert = DB::table('adm_tri.uit')->insert($arr_uit);
        if ($insert)
            return true;
        else
            return false;
    }

    public function modif(Request $request) {
        header('Content-type: application/json');
        $data = $request->all();

        if ($this->modif_2($request->all())) {
            return response()->json([
                        'msg' => 'si'
            ]);
        }
    }

    public function modif_2(array $data) {
        $arr_uit = array('pk_uit' => $data['pk_uit'],
            'anio' => $data['anio'],
            'uit' => $data['uit'],
            'uit_alc' => $data['uit_alc'],
            'tas_alc' => $data['tas_alc'],
            'formatos' => $data['formatos'],
            'base_01' => $data['base_01'],
            'deoa15' => $data['deoa15'],
            'tram_01' => $data['tram_01'],
            'base_02' => $data['base_02'],
            'de15a60' => $data['de15a60'],
            'tram_02' => $data['tram_02'],
            'base_03' => $data['base_03'],
            'mas60' => $data['mas60'],
            'porc_min_ivpp' => $data['porc_min_ivpp'],
            'porc_ot_ins' => $data['porc_ot_ins']
        );
        // $uit=array('uit'=>$data['uit']); 

        $insert = DB::table('adm_tri.uit')->where('pk_uit', '=', $data['pk_uit'])->update($arr_uit);
        //$insert = DB::table('uit')->insert($arr_uit);
        if ($insert)
            return true;
        else
            return false;
    }

    public function eliminar(Request $request) {
        header('Content-type: application/json');
        $data = $request->all();

        if ($this->eliminar_2($request->all())) {
            return response()->json([
                        'msg' => 'si'
            ]);
        }
    }

    public function eliminar_2(array $data) {
        $arr_uit = array('pk_uit' => $data['pk_uit']);
        // $uit=array('uit'=>$data['uit']); 

        $insert = DB::table('adm_tri.uit')->where('pk_uit', '=', $data['pk_uit'])->delete();
        //$insert = DB::table('uit')->insert($arr_uit);
        if ($insert)
            return true;
        else
            return false;
    }

    public function modif_ofi(Request $request) {
        header('Content-type: application/json');
        $data = $request->all();

        if ($this->modif_ofi_2($request->all())) {
            return response()->json([
                        'msg' => 'si'
            ]);
        }
    }

    public function modif_ofi_2(array $data) {
        $arr_uit = array('id_ofi' => $data['id_ofi'],
            'nombre' => $data['nombre'],
            'cod_oficina' => $data['cod_oficina']
        );
        // $uit=array('uit'=>$data['uit']); 

        $insert = DB::table('adm_tri.oficinas')->where('id_ofi', '=', $data['id_ofi'])->update($arr_uit);
        //$insert = DB::table('uit')->insert($arr_uit);
        if ($insert)
            return true;
        else
            return false;
    }

}
