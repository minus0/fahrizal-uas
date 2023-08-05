<?php

namespace App\Models;

use CodeIgniter\Model;

class skorModel extends Model
{
    
    protected $DBGroup          = 'default';
    protected $table            = 'tb_skor';
    protected $primaryKey       = 'id_mahasiswa';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id_skor','id_mahasiswa','jumlah_skor','asrama','ketua_kamar'];
}