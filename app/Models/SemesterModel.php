<?php

namespace App\Models;

use CodeIgniter\Model;

class SemesterModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_semester';
    protected $primaryKey       = 'id_mahasiswa';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id_mahasiswa','nama_mahasiswa','prodi','semester','skor'];
}
