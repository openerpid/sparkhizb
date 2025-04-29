<?php

namespace App\Hizb\Syshab\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Sparkhizb\Helpers\QueryHelper;

use App\Hizb\Syshab\Builder\SiteProjectBuilder;

class SiteProjectController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->qBuilder = new SiteProjectBuilder();
        $this->qHelp = new QueryHelper();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        // 
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $builder = $this->qBuilder->show($id);

        $total = $this->qHelp->_total($builder);
        $rows = $this->qHelp->_rowsBui($builder);
        if ($rows) {
            foreach ($rows as $key => $value) {
                if ($value->cc_email) {
                    $rows[$key]->cc_email_arr = explode(";", $value->cc_email);
                } else {
                    $rows[$key]->cc_email_arr = [];
                }
            }
        }
        $count = count($rows);

        $response = $this->qHelp->restrue($rows, $count, $total);
        // $response = array_merge($response,["response" => $rows]);

        return $this->respond($response, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        // 
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $cc_email = $this->request->getJsonVar('cc_email');
        $cc_email = str_replace("\r\n", "", $cc_email);

        $payload = [
            "cc_email" => $cc_email
        ];

        $builder = $this->qBuilder->update($id, $payload);

        $response = array(
            "status" => true,
            "message" => "Update data success.",
            "errors" => $builder,
        );

        return $this->respond($response, 200);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        // 
    }

    public function usp_0202_SHB_0004($user = null)
    {
        $builder = $this->qBuilder->usp_0202_SHB_0004($user);
        $builder->getResultArray();

        $query = $builder->resultArray;

        $response = [
            "status" => true,
            "message" => 'Get data success',
            "rows" => $query,
            "count" => count($query),
            "total" => count($query),
            "recordsTotal" => count($query),
            "recordsFiltered" => count($query)
        ];

        return $this->respond($response, 200);
    }

    public function show_from_openintegrasi($id = null)
    {
        $params = [
            "id" => $id,
            "payload" => [
                "limit" => $this->request->getJsonVar('limit'),
                "offset" => $this->request->getJsonVar('offset'),
                "sort" => $this->request->getJsonVar('sort'),
                "order" => $this->request->getJsonVar('order'),
                "search" => $this->request->getJsonVar('search'),
                "selects" => $this->request->getJsonVar('selects')
            ]
        ];
        $builder = $this->qBuilder->show_from_openintegrasi($params);

        return $this->respond($builder, 200);
    }
}
