<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\models\SemesterModel;

class Semester extends BaseController
{
    protected $pm;
    private $menu;
    private $rules;
    public function __construct()
    {
        $this->pm = new SemesterModel();

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
                'aktif' => 'active',
            ],
            'mahasiswa' => [
                'title' => 'mahasiswa',
                'link' => base_url() . '/mahasiswa',
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
            'id_mahasiswa' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'nama mahasiswar tidak boleh kosong',
                ]
            ],
            'nama_mahasiswa' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'nama mahasiswar tidak boleh kosong',
                ]
            ],
            'prodi' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'prodi tidak boleh kosong',
                ]
            ],
            'semester' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'semester tidak boleh kosong',
                ]
            ],
            'skor' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'skor tidak boleh kosong',
                ]
            ],
        ];
    }

    public function index()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">semester</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item active">semester</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "data semester";

        $query = $this->pm->Find();
        $data['data_semester'] = $query;
        return view('semester/content', $data);
    }

    public function tambah()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">semester</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="' . base_url() . '/semester">semester</a></li>
                                <li class="breadcrumb-item active">Tambah semester</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Tambah semester';
        $data['action'] = base_url() . '/semester/simpan';
        return view('semester/input', $data);
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
            return redirect()->to('semester')->with('success', 'data berhasil disimpan');

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
            return redirect()->to('semester')->with('success', 'data semester dengan kode'.$id.'berhasil dihapus');
        } catch (\codeIgniter\Database\Exceptions\DatabaseException $e){
            return redirect()->to('semester')->with('error',$e->getmessage());
        }
    }

    public function edit($id){
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">semester</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="' . base_url() . '/semester">semester</a></li>
                                <li class="breadcrumb-item active">Edit semester</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Edit semester';
        $data['action'] = base_url() . '/semester/update';

        $data['edit_data'] = $this->pm->find($id);
        return view('semester/input', $data);
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
            return redirect()->to('semester')->with('success','Data Berhasil Diupdate');
        } catch (\codeIgniter\Database\Exceptions\DatabaseException $e) {
            session()->setFlashdata('error',$e->getmessage());
            return redirect()->back()->withInput();
        }

    }
}
