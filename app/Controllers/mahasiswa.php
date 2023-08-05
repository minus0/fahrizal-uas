<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\models\mahasiswaModel;

class mahasiswa extends BaseController
{
    protected $pm;
    private $menu;
    private $rules;
    public function __construct()
    {
        $this->pm = new mahasiswaModel();

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
                'aktif' => '',
            ],
            'Semester' => [
                'title' => 'Semester',
                'link' => base_url() . '/semester',
                'icon' => 'fa-solid fa-list',
                'aktif' => '',
            ],
            'mahasiswa' => [
                'title' => 'mahasiswa',
                'link' => base_url() . '/mahasiswa',
                'icon' => 'fa-solid fa-user',
                'aktif' => 'active',
            ],
            'skor' => [
                'title' => 'skor',
                'link' => base_url() . '/skor',
                'icon' => 'fa-solid fa-ranking-star',
                'aktif' => '',
            ],
        ];

        $this->rules = [			
            'id_mahasiswa' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'ID mahasiswa tidak boleh kosong',
                ]
            ],
            'nim' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'nim tidak boleh kosong',
                ]
            ],
            'nama_mahasiswa' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Nama mahasiswa tidak boleh kosong',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'alamat tidak boleh kosong',
                ]
            ],
            'asrama' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'asrama tidak boleh kosong',
                ]
            ],
            'tahun_mondok' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Tahun Mondok tidak boleh kosong',
                ]
            ],
        ];
    }

    public function index()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">mahasiswa</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item active">mahasiswa</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "data mahasiswa";

        $query = $this->pm->Find();
        $data['data_mahasiswa'] = $query;
        return view('mahasiswa/content', $data);
    }

    public function tambah()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">mahasiswa</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="' . base_url() . '/mahasiswa">mahasiswa</a></li>
                                <li class="breadcrumb-item active">Tambah mahasiswa</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Tambah mahasiswa';
        $data['action'] = base_url() . '/mahasiswa/simpan';
        return view('mahasiswa/input', $data);
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
            return redirect()->to('mahasiswa')->with('success', 'data berhasil disimpan');

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
            return redirect()->to('mahasiswa')->with('success', 'data mahasiswa dengan kode'.$id.'berhasil dihapus');
        } catch (\codeIgniter\Database\Exceptions\DatabaseException $e){
            return redirect()->to('mahasiswa')->with('error',$e->getmessage());
        }
    }

    public function edit($id){
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">samahasiswantri</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="' . base_url() . '/hasiswa">mahasiswa</a></li>
                                <li class="breadcrumb-item active">Edit mahasiswa</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Edit mahasiswa';
        $data['action'] = base_url() . '/mahasiswa/update';

        $data['edit_data'] = $this->pm->find($id);
        return view('mahasiswa/input', $data);
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
            return redirect()->to('mahasiswa')->with('success','Data Berhasil Diupdate');
        } catch (\codeIgniter\Database\Exceptions\DatabaseException $e) {
            session()->setFlashdata('error',$e->getmessage());
            return redirect()->back()->withInput();
        }

    }
}
