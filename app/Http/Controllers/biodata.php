<?php

namespace App\Http\Controllers;

use App\Models\Biodata as ModelsBiodata;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class biodata extends Controller
{
    public function showAll(){
        $data = ModelsBiodata::all();
        if(count($data)){
            $res['jumlah'] = count($data);
            $res['data'] = $data;
        }else{
            $res['jumlah'] = count($data);
            $res['data'] = null;
        }
        return response($res);
    }

    public function showOne($id){
        $data = ModelsBiodata::find($id);
        if($data){
            $res['status'] = 'oke';
            $res['data'] = $data;
        }else{
            $res['status'] = 'tidak ada';
            $res['data'] = null;
        }
        return response($res);
    }

    public function insertData(Request $request){
        $path = null;
        //check if there file input
        if($request->file('foto')->isValid()){
            $dateNow = Carbon::now()->isoFormat('DD-MM-YYYY');
            $extension = $request->file('foto')->extension();
            //make name of image
            $nameImage = 'gambar-'.$dateNow.'-'.Str::random(5).'.'.$extension;
            //upload image to storage of servers
            $path = $request->file('foto')->storeAs('public/image',$nameImage);
        }
        $req['nama'] = $request->input('nama');
        $req['no_hp'] = $request->input('no_hp');
        $req['alamat'] = $request->input('alamat');
        $req['hobi'] = $request->input('hobi');
        $req['foto'] = $nameImage;

        $data = ModelsBiodata::create($req);
        if($data){
            $res['status'] = 'berhasil di input';
            $res['data'] = $data;
        }else{
            $res['status'] = 'Gagal di Input';
            $res['data'] = $data;
        }
        return response($res);
    }

    public function updateData(Request $request,$id){
        $previousData = ModelsBiodata::find($id);
        $req['nama'] = $request->input('nama');
        $req['no_hp'] = $request->input('no_hp');
        $req['alamat'] = $request->input('alamat');
        $req['hobi'] = $request->input('hobi');
        if($previousData){
            if($request->file('foto')->isValid()){
                $req['foto'] = $previousData['foto'];
                // update image in storage from exist data
                $path = $request->file('foto')->storeAs('public/image',$req['foto']);
            }
            $data = ModelsBiodata::where('id',$id)->update($req);
            if($data){
                $res['status'] = 'Update Data Berhasil';
                $res['data'] = $data;
            }
        }else{
            $res['status'] = 'data tidak ditemukan';
            $res['data'] = null;
        }
        return response($res);
    }

    public function deleteData($id){
        $data = ModelsBiodata::find($id);
        if($data['foto']){
            //delete image from server's storage
            Storage::delete('public/image/'.$data['foto']);
        }
        $deleteData = ModelsBiodata::destroy($id);
        if($deleteData){
            $res['status'] = 'Berhasil hapus Data';
            $res['data'] = $deleteData;
        }else{
            $res['status'] = 'Gagal hapus Data';
            $res['data'] = $deleteData;
        }
        return response($res);
    }
}
