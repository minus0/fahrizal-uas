<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    
    protected $DBGroup          = 'default';
    protected $table            = 'tb_petugas';
    protected $primaryKey       = 'id_petugas';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id_petugas','nama_petugas','jabatan'];
}