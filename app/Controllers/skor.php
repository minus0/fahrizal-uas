<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\models\skorModel;

class skor extends BaseController
{
    protected $pm;
    private $menu;
    private $rules;
    public function __construct()
    {
        $this->pm = new skorModel();

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
            'Mahasiswa' => [
                'title' => 'mahasiswa',
                'link' => base_url() . '/mahasiswa',
                'icon' => 'fa-solid fa-user',
                'aktif' => '',
            ],
            'skor' => [
                'title' => 'skor',
                'link' => base_url() . '/skor',
                'icon' => 'fa-solid fa-ranking-star',
                'aktif' => 'active',
            ],
        ];

        $this->rules = [			
            'id_mahasiswa' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'ID Mahasiswa tidak boleh kosong',
                ]
            ],
            'nim' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'NI tidak boleh kosong',
                ]
            ],
            'nama_mahasiswa' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'Nama Mahasiswa tidak boleh kosong',
                ]
            ],
            'jumlah_skor' => [
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
            'ketua_kamar' => [
                'rules' => 'required',
                'errors' =>[
                    'required' => 'ketua_kamar tidak boleh kosong',
                ]
            ],
        ];
    }

    public function index()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">skor</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item active">skor</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = "data skor";

        $query = $this->pm->Find();
        $data['data_skor'] = $query;
        return view('skor/content', $data);
    }

    public function tambah()
    {
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">skor</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="' . base_url() . '/skor">skor</a></li>
                                <li class="breadcrumb-item active">Tambah skor</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Tambah skor';
        $data['action'] = base_url() . '/skor/simpan';
        return view('skor/input', $data);
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
            return redirect()->to('skor')->with('success', 'data berhasil disimpan');

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
            return redirect()->to('skor')->with('success', 'data skor dengan kode'.$id.'berhasil dihapus');
        } catch (\codeIgniter\Database\Exceptions\DatabaseException $e){
            return redirect()->to('skor')->with('error',$e->getmessage());
        }
    }

    public function edit($id){
        $breadcrumb = '<div class="col-sm-6">
                            <h1 class="m-0">skor</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="' . base_url() . '">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="' . base_url() . '/skor">skor</a></li>
                                <li class="breadcrumb-item active">Edit skor</li>
                            </ol>
                        </div>';
        $data['menu'] = $this->menu;
        $data['breadcrumb'] = $breadcrumb;
        $data['title_card'] = 'Edit skor';
        $data['action'] = base_url() . '/skor/update';

        $data['edit_data'] = $this->pm->find($id);
        return view('skor/input', $data);
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
            return redirect()->to('skor')->with('success','Data Berhasil Diupdate');
        } catch (\codeIgniter\Database\Exceptions\DatabaseException $e) {
            session()->setFlashdata('error',$e->getmessage());
            return redirect()->back()->withInput();
        }

    }
}
