<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_mahasiswa';
    protected $primaryKey       = 'id_mahasiswa';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_mahasiswa','nim','nama_mahasiswa', 'alamat', 'asrama', 'tahun_mondok'];
}