<?php

namespace Sparkhizb\Models\Syshab;

use CodeIgniter\Model;
// use \Config\DorbitT;

class UsersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ms_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "KdUser",
        "NmUser",
        "Pswd1",
        "Pswd2",
        "Lvl",
        "OpenSalesLimit",
        "OpenSalesDue",
        "lastupdate",
        "userid",
        "stEdit",
        "tDelMaster",
        "tResetPass",
        "tLock",
        "emailadd",
        "nik",
        "Pswd_web1",
        "Pswd_web2",
        "kduser_dele",
        "FullName_dele",
        "from_date",
        "until_date",
        "tDelegate",
        "noref",
        "token",
        "profile",
        "level_akses_android",
        "token_notif",
        "supplier_code",
        "scan_pajak"
    ];

    protected $selects = "
        a.KdUser,
        a.NmUser,
        a.Pswd1,
        a.Pswd2,
        a.Lvl,
        a.OpenSalesLimit,
        a.OpenSalesDue,
        a.lastupdate,
        a.userid,
        a.stEdit,
        a.tDelMaster,
        a.tResetPass,
        a.tLock,
        a.emailadd,
        a.nik,
        a.Pswd_web1,
        a.Pswd_web2,
        a.kduser_dele,
        a.FullName_dele,
        a.from_date,
        a.until_date,
        a.tDelegate,
        a.noref,
        a.token,
        a.profile,
        a.level_akses_android,
        a.token_notif,
        a.supplier_code,
        a.scan_pajak
    ";

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}