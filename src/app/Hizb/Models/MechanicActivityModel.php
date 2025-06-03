<?php

namespace App\Hizb\Models;

use CodeIgniter\Model;

class MechanicActivityModel extends Model
{
    protected $DBGroup = 'openerpid';
    protected $table = 'mechanic_activity';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        // "id",
        "company_id",
        "msdb_id",
        "plant_id",
        "site_project_id",

        "activity_type",
        "workorder_id",
        "jobtype",
        "job_type_id",
        "tech_iden_no",
        "operation_id",
        "operation_kode",
        "operation_name",
        "unit_id",
        "reason_id",
        "mechanic_id",
        "workstart",
        "workend",
        "description",
        "nik",
        "nikaryawan",
        "testing",
        "hm",
        "workstart_date",
        "workstart_time",
        "workend_date",
        "workend_time",
        "actual_work",
        "duration",
        "duration_text",
        "actual_duration",
        "activity_description",
        "mechanic_name",

        "wo_number_sap",
        "operation",
        "operation_short_text",
        "AUFNR_order",
        "WERKS_plant",
        "TIDNR_techIdentNo",
        "VORNR_operation",
        "system_status",
        "is_sap",
        "is_integration",
        "remark",
        "site",
        "workorder",
        "user",

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
        $this->DBGroup = (getenv('DBGroup')) ? getenv('DBGroup') : 'default';
    }
}