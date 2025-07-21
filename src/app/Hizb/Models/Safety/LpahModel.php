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
        "divisi",
        "departemen",
        "section_kode",
        "section",

        "hari_kejadian",
        "tanggal_kejadian","waktu_kejadian",
        "tanggal_pelaporan","waktu_pelaporan",

        "shift_kerja",
        "mulai_shift",
        "selesai_shift",
        "hari_kerja_ke",

        "lokasi_insiden_id",
        "lokasi_insiden",
        "detail_lokasi_insiden",

        "cidera_id",
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

        "tipe_insiden_id",
        "tipe_insiden",
        "penjelasan_insiden",
        "zona_waktu",

        "rs_klinik_rujukan",
        "dokter_menangani",
        "perkiraan_hari_hilang",
        "perkiraan_biaya_perawatan",

        "created_at",
        "updated_at",
        "deleted_at",

        "created_by",
        "updated_by",
        "deleted_by"
    ];

    protected $selects = "a.*"
        .",b.nik"
        .",b.name as created_by_name"
        .",c.total_appv"
        .",c.last_appv_sequence"
        .",
            CASE
                WHEN c.last_appv_sequence IS NULL THEN 1
                ELSE (c.last_appv_sequence + 1) 
            END as next_appv_sequence
        "
        // .",(c.last_appv_sequence + 1) as next_appv_sequence"
        .",c.last_appv_by"
    ;

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