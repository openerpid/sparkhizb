<?php

namespace App\Hizb\Models\Safety;

use CodeIgniter\Model;

class LpadKerusakanModel extends Model
{
    protected $DBGroup = 'openerpid';
    protected $table = 'lpa_d_kerusakan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        "id",
        "company_id",
        
        "lpa_id",
        "jenis_kerusakan_id",
        "jenis_kerusakan",
        "name",
        "tipe",
        "tipe_komponen",
        "aset_perusahaan",
        "bukan_aset_perusahaan_text",
        "serial_number",
        "tingkat_kerusakan_id",
        "tingkat_kerusakan",
        "kerusakan_keparahan",
        "detail_kerusakan_kerugian",
        "perkiraan_biaya",
        "nomor_lambung",
        "is_external",

        "created_at",
        "updated_at",
        "deleted_at",

        "created_by",
        "updated_by",
        "deleted_by"
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function __construct()
    {
        $this->DBGroup = (getenv('DBGroup')) ? getenv('DBGroup') : 'dorbitt_she';
    }
}