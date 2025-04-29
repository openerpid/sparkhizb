<?php

namespace App\Hizb\Syshab\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'H_A150';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "KdJabat",
        "NmJabat",
        "KdRef",
        "KdJob",
        "KdPos",
        "KdLok",
        "KdLevel",
        "Jobdes",
        "KdDivisi",
        "KdDepar",
        "KdSec",
        "UsiaMax",
        "UsiaMin",
        "Gender",
        "LvlStudy",
        "MinExp",
        "CreatedBy",
        "CreatedIn",
        "CreatedTime",
        "ModifiedBy",
        "ModifiedIn",
        "ModifiedTime",
        "StEdit",
        "DeleteBy",
        "DeleteTime",
        "costcode",
        "Functcode"
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
}