<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MahasiswaController extends Controller
{
    public function getDataMahasiswa(Request $request)
    {
        if (!$request->cari) {
            $data = DB::table('mahasiswa')->paginate(5);
        } else {
            $data = DB::table('mahasiswa')->where('nama', 'LIKE', '%'.$request->cari.'%')->paginate(5);
        }
    	
    	return response()->json($data);

    }

    public function storeDataMahasiswa(Request $request)
    {
    	$this->validate($request, [
    		'nim' => 'required|numeric|unique:mahasiswa',
    		'nama' => 'required',
    		'tempat_lahir' => 'required'
    	]);

    	$data = DB::table('mahasiswa')->insert([
    		'nim' => $request->nim,
    		'nama' => $request->nama,
    		'tempat_lahir' => $request->tempat_lahir
    	]);

    	return response()->json($data);

    }
}
