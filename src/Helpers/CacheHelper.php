<?php

namespace Sparkhizb\Helpers;

/**
 * =============================================
 * Author: Ummu
 * Website: https://ummukhairiyahyusna.com/
 * App: DORBITT LIB
 * Description: 
 * =============================================
 */

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Helpers\IdentityHelper;
use Sparkhizb\Helpers\RequestHelper;

class CacheHelper
{
    protected $cache;
    protected $identity;
    protected $reqH;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->cache = \Config\Services::cache();
        $this->identity = new IdentityHelper();
        $this->reqH = new RequestHelper();

        $this->cacheKey = $this->reqH->moduleKode() . '_company_' . $this->identity->company_id();
    }

    public function getData_byModule()
    {
        $data = $this->cache->get($this->cacheKey);

        return json_decode($data, true);
    }

    public function saveData_byModule($data)
    {
        $this->cache->save($this->cacheKey, json_encode($data), 3600);
    }
}
