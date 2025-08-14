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
        "id",
        "company_id",
        "msdb_id",
        "plant_id",
        "site_project_id",

        "activity_type",
        "workorder_id",
        "job_type_id",
        "jobtype",
        "jobtype_text",
        "unit_id",
        "unit",
        "reason_id",
        "mechanic_id",

        "tech_iden_no",
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

        "component_group",
        "component_group_text",
        "dayofftype_id",
        "dayofftype_text",

        "remark",
        "jobdesc",
        "site",
        "workorder",
        "user",
        "appr_status_id",
        
        "approved_by_text",
        "approved_at","approved_by",

        "created_at","updated_at","deleted_at",
        "created_by","updated_by","deleted_by",
        "deleted_by_text"
    ];

    protected $selects = "
        id,
        company_id,
        activity_type,
        workorder_id,
        jobtype,
        job_type_id,
        tech_iden_no,
        unit_id,
        workstart,
        workend,
        workstart_date,
        workstart_time,
        workend_date,
        workend_time,
        duration,
        actual_duration,
        mechanic_name,
        operation,
        operation_short_text,
        remark,
        jobdesc,
        site,
        workorder,
        user,
        appr_status_id,
        approved_at,
        approved_by_text,
        created_at,
        updated_at,
        created_by,
        updated_by,
    ";

    protected $almi = "
        id,
        activity_type,
        jobtype,
        jobtype_text,
        tech_iden_no,
        unit,
        site,
        mechanic_name,

        workstart,
        workend,
        duration,
        actual_duration,

        operation,
        operation_short_text,

        remark,
        jobdesc,
        workorder as workorder_id,
        workorder,

        component_group,
        component_group_text,

        dayofftype_id,
        dayofftype_text,
        
        appr_status_id,
        approved_at,
        approved_by_text,

        user,
        created_at,updated_at,deleted_at,
        created_by,updated_by,deleted_by
    ";

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