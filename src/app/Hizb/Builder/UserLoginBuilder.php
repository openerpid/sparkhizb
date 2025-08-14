<?php

namespace App\Hizb\Builder;

use Sparkhizb\Helpers\Curl;
use Sparkhizb\Helpers\CurlHelper;
use Sparkhizb\Helpers\RequestHelper;
use App\Hizb\Models\UserLoginModel;

class UserLoginBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->curl = new Curl();
        $this->curlH = new CurlHelper();
        $this->reqH = new RequestHelper();
        $this->model = new UserLoginModel();
    }

    public function show($id = null)
    {
        // 
    }

    public function insert($payload)
    {
        $builder = $this->model->insert($payload);

        return $builder;
    }

    public function update_by_username($username,$payload)
    {
        $builder = $this->model
        ->set($payload)
        ->where('username', $username)
        ->update();

        return $builder;
    }

    public function show_by_username($username)
    {
        $builder = $this->model->where('username', $username)->get()->getRow();

        return $builder;
    }
}