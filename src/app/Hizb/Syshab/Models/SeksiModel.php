<?php

namespace App\Hizb\Syshab\Models;

use CodeIgniter\Model;

class SeksiModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'H_A209';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "KdSec",
        "NmSec",
        "KdDepar",
        "CreatedBy",
        "CreatedIn",
        "CreatedTime",
        "ModifiedBy",
        "ModifiedIn",
        "ModifiedTime",
        "StEdit",
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