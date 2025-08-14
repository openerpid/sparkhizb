<?php

namespace App\Hizb\Syshab\Builder;

use Sparkhizb\UmmuEncryption;
use Sparkhizb\Auth;
use Sparkhizb\Helpers\JwtHelper;
use Dorbitt\Auth as Openapi2Auth;

use App\Helpers\SyshabEncrypterHelper;
use App\Hizb\Syshab\Builder\EmployeeBuilder;
use App\Hizb\Syshab\Models\UsersModel;

class LoginBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->auth = new Auth();
        $this->oa2auth = new Openapi2Auth();
        // $this->username = $this->request->getJsonVar('username');
        // $this->password = $this->request->getJsonVar('password');
        $this->jwt = new JwtHelper();
        $this->syshabEncrypter = new SyshabEncrypterHelper();
        $this->mUser = new UsersModel();
        $this->encryption = new UmmuEncryption();
        $this->qbEmployee = new EmployeeBuilder();
    }

    public function show_username($username)
    {
        $builder = $this->db->table($this->mUser->table)
            // ->select('kdUser,nmUser,pswd1,lvl,level_akses_android,tDelMaster,tLock,tResetPass')
            // ->select('*')
            ->where("kdUser", $username)
            ->where("stEdit !=", 4)
            ->get()->getResult();

        if ($builder)
            return $builder[0];
    }

    public function username($username)
    {
        $query = $this->db->table($this->mUser->table . ' a')
            ->select('a.kdUser,a.nmUser,a.pswd1,a.lvl,a.level_akses_android,a.tDelMaster,a.tLock,a.tResetPass,b.Nik,a.scan_pajak')
            ->join('H_A101 b', 'b.Nama = a.nmUser', 'left')
            ->where("a.kdUser", $username)
            ->where("a.stEdit !=", 4)
            ->get()->getResult();

        if ($query)
            return $query[0];
    }

    public function password($password)
    {
        // 
    }

    public function project_area($userid)
    {
        $qu = "EXEC uSP_secure_jobsite " . $userid;
        $query = $this->db->query($qu);
        $query->getResultArray();
        $query = $query->resultArray;

        return $query;
    }

    public function role($userid)
    {
        $qu = "EXEC uSP_secure_jobsite " . $userid;
        $query = $this->db->query($qu);
        $query->getResultArray();
        $query = $query->resultArray;

        return $query;
    }

    public function scope($userid)
    {
        $qu = "EXEC usp_0101_SHB_0011 " . $userid;
        $query = $this->db->query($qu);
        $query->getResultArray();
        $query = $query->resultArray;

        return $query;
    }

    public function departement($userid)
    {
        $query = $this->db->table('ms_users_dept a')
            ->select('a.dept_code,a.status_default_dept,b.dept_name')
            ->join('ms_department b', 'b.dept_code = a.dept_code', 'left')
            ->where("a.kduser", $userid)
            ->where("b.stEdit != ", 4)
            ->where('a.status_default_dept', 1)
            ->get()->getResult();

        return $query;
    }

    public function access_module($userid)
    {
        $qu = "EXEC uSP_secure_datastore " . $userid;
        $query = $this->db->query($qu);
        $query->getResultArray();
        $query = $query->resultArray;

        return $query;
    }

    public function update($id = null, $payload)
    {
        $username = $this->request->getJsonVar('username');

        $builder = $this->db->table($this->mUser->table)
            ->set($payload)
            ->where('KdUser', $username)
            ->update();

        return $builder;
    }

    public function dorbitt_auth()
    {
        $payload = [
            "username" => getenv('dorbitt.username'),
            "password" => getenv('dorbitt.password')
        ];

        $builder = $this->auth->login($payload);

        return $builder;
    }

    public function herp_username($username)
    {
        $query = $this->db->table($this->mUser->table)
            ->select('kdUser')
            // ->join('H_A101 b', 'b.Nama = a.nmUser','left')
            ->where("a.kdUser", $username)
            ->where("a.stEdit !=", 4)
            ->get()->getResult();

        if ($query)
            return $query[0];
    }

    public function integration_username($username)
    {
        $payload = [
            "username" => $username
        ];
        return $this->auth->username($payload);
    }

    public function partisipan($username, $password)
    {
        $payload = [
            "username" => $username,
            "password" => $password
        ];
        return $this->auth->partisipan($payload);
    }

    public function create_next($payload)
    {
        return $this->auth->create_next($payload);
    }

    public function username_nik($username)
    {
        $query = $this->db->table('H_A101')
            // ->select('')
            // ->join('H_A101 b', 'b.Nama = a.nmUser','left')
            ->where("nik", $username)
            // ->where("a.stEdit !=", 4)
            ->get()->getResult();

        if ($query)
            return $query[0];
    }

    public function username_integration($username)
    {

    }

    public function create_otp_sms($phone_number)
    {
        $payload = [
            "phone_number" => $phone_number
        ];

        return $this->auth->get_otp_sms($payload);
    }

    public function show_msdb($token = null)
    {
        $payload = [
            "limit" => 0,
            "offset" => 0,
            "sort" => "id",
            "order" => "desc",
            "search" => "",
            "token" => $token,
            "status" => 1
        ];

        $params = [
            "payload" => $payload,
            "token" => getenv('company_token')
        ];
        $builder = $this->oa2auth->show_msdb($params);

        return $builder;
    }
}