<?php

namespace App\Hizb\Models\Safety;

use CodeIgniter\Model;

class LpahModel extends Model
{
    protected $DBGroup = 'openerpid';
    protected $table = 'lpa_h';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        "id",
        "company_id",
        "nomor_dokumen",
        "insident_classification",
        "site",
        "devisi",
        "departemen",
        "section",
        "tanggal_kejadian",
        "tanggal_pelaporan",
        "waktu_pelaporan",
        "shift_kerja",
        "mulai_shift",
        "selesai_shift",
        "waktu_kejadian",
        "lokasi_insiden",
        "detail_lokasi_insiden",
        "cidera",
        "detail_cidera_lainnya",
        "kronologi",
        "instansi_pemerintah",
        "nama_pejabat",
        "pemerintah_disampaikan_oleh",
        "pemerintah_tanggal",
        "asuransi",
        "nama_perusahaan",
        "asuransi_disampaikan_oleh",
        "asuransi_tanggal",
        "pihak_tiga",
        "nama_pihak_ketiga",
        "pihak_tiga_disampaikan_oleh",
        "pihak_tiga_tanggal",
        "tipe_insiden",
        "penjelasan_insiden",
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