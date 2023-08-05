<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\models\PetugasModel;

class Petugas extends BaseController
{
    protected $pm;
    private $menu;
    private $rules;
    public function __construct()
    {
        $this->pm = new PetugasModel();

        $this->menu = [
            'Beranda' => [
                'title' => 'Beranda',
                'link' => base_url(),
                'icon' => 'fa-solid fa-house',
                'aktif' => '',
            ],
            'Petugas' => [
                'title' => 'Petugas',
                'link' => base_url() . '/petugas',
                'icon' => 'fa-solid fa-users',
                'aktif' => 'active',
            ],
            'Semester' => [
                'title' => 'Semester',
                'link' => base_url() . '/semester',
                'icon' => 'fa-solid fa-list',
                'aktif' => '',
            ],
            'Mahasiswa' => [
                'title' => 'Mahasiswa',
                'link' => base_url() . '/Mahasiswa',
                'icon' => 'fa-solid fa-user',
                'aktif' => '',
            ],
            'skor' => [
                'title' => 'skor',
                'link' => base_url() . '/skor',
                'icon' => 'fa-solid fa-ranking-star',
                'aktif' => '',
            ],
        ];

        $this->rules = [			
            'id_petugas' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'ID Petugas tidak boleh kosong',
                ]
            ],
            'nama_petugas' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Nama Petugas tidak boleh kosong',
                ]
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Jabatan Petugas tidak boleh kosong',
                ]
            ],
        ];
    }

    public function index()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">Petugas</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item active">Petugas</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "data petugas";

        $query = $this->pm->Find();
        $data['data_petugas'] = $query;
        return view('petugas/content', $data);
    }

    public function tambah()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">Petugas</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="' . base_url() . '/petugas">Petugas</a></li>
                                <li class="breadcrumb-item active">Tambah Petugas</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Tambah Petugas';
        $data['action'] = base_url() . '/petugas/simpan';
        return view('petugas/input', $data);
    }

    public function simpan()
    {
        
        if (strtolower($this->request->getmethod()) !== 'post') {

            return redirect()->back()->withInput();
        }
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput();
        }
 
        $dt = $this->request->getPost();
        try{
            $simpan = $this->pm->insert($dt);        
            return redirect()->to('petugas')->with('success', 'data berhasil disimpan');

        } catch(\codeIgniter\Database\Exceptions\DatabaseException $e){

            session()->setflashdata('error', $e->getmessage());
            return redirect()->back()->withinput();
        }
    }

    public function hapus($id){
        if(empty($id)){
            return redirect()->back()->with('error', 'hapus data gagal dilakukan');
        }

        try{
            $this->pm->delete($id);
            return redirect()->to('petugas')->with('success', 'data petugas dengan kode'.$id.'berhasil dihapus');
        } catch (\codeIgniter\Database\Exceptions\DatabaseException $e){
            return redirect()->to('petugas')->with('error',$e->getmessage());
        }
    }

    public function edit($id){
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">Petugas</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="' . base_url() . '/petugas">Petugas</a></li>
                                <li class="breadcrumb-item active">Edit Petugas</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Edit Petugas';
        $data['action'] = base_url() . '/petugas/update';

        $data['edit_data'] = $this->pm->find($id);
        return view('petugas/input', $data);
    }

    public function update(){
        $dtEdit = $this->request->getPost();
        $param = $dtEdit['param'];
        unset($dtEdit['param']);

        if (strtolower($this->request->getmethod()) !== 'post') {

            return redirect()->back()->withInput();
        }
        try {
            $this->pm->update($param, $dtEdit);
            return redirect()->to('petugas')->with('success','Data Berhasil Diupdate');
        } catch (\codeIgniter\Database\Exceptions\DatabaseException $e) {
            session()->setFlashdata('error',$e->getmessage());
            return redirect()->back()->withInput();
        }

    }
}
