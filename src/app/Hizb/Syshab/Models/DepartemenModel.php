<?php

namespace App\Hizb\Syshab\Models;

use CodeIgniter\Model;

class DepartemenModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'H_A130';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "KdDepar",
        "NmDepar",
        "tStatus",
        "KdDivisi",
        "CreatedBy",
        "CreatedIn",
        "CreatedTime",
        "ModifiedBy",
        "ModifiedIn",
        "ModifiedTime",
        "StEdit",
        "VoidBy",
        "VoidIn",
        "DeleteBy",
        "DeleteTime"
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