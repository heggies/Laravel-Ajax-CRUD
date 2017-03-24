<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kontak;

class MyController extends Controller
{
    public function get_to_index(Request $r)
    {
      $data = Kontak::orderBy('created_at', 'DESC')->get();
      $response['success'] = 1;
      $response['data'] = $data;

      return response()->json($response);
    }

    public function get()
    {
      return Kontak::orderBy('created_at', 'DESC')->get();
    }

    public function store(Request $r)
    {
      $response = [];

      $kontak = new Kontak;
      $kontak->nama = $r->input('nama');
      $kontak->nomor_handphone = $r->input('nomor_handphone');
      $kontak->save();

      $response['success'] = 1;
      $response['message'] = "Berhasil menambah data";
      $response['data'] = $this->get();
      return response()->json($response);
    }

    public function delete($id)
    {
      $response = [];

      $kontak = Kontak::find($id);
      if (count($kontak)==0) {
        $response['success'] = 0;
        $response['message'] = "Data tidak ditemukan";
      }
      else {
        $kontak->delete();

        $response['success'] = 1;
        $response['message'] = "Berhasil menghapus data";
      }

      return response()->json($response);
    }

    public function get_kontak_detail(Request $r)
    {
      $id = $r->input('id');
      $response = [];

      $kontak = Kontak::find($id);
      if (count($kontak)==0) {
        $response['success'] = 0;
        $response['message'] = "Data tidak ditemukan";
      }
      else {
        $response['success'] = 1;
        $response['data'] = $kontak;
      }

      return response()->json($response);
    }

    public function update(Request $r)
    {
      $response = [];

      $kontak = Kontak::find($r->input('id'));
      $kontak->nama = $r->input('nama');
      $kontak->nomor_handphone = $r->input('nomor_handphone');
      $kontak->save();

      $response['success'] = 1;
      $response['message'] = "Berhasil mengubah data";
      return response()->json($response);
    }
}
