<?php

namespace App\Hizb\Syshab\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\Helpers\DateTimeHelper;

use App\Hizb\Syshab\Builder\EmployeeBuilder;

class EmployeeController extends ResourceController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->qHelp = new QueryHelper();
        $this->dtHelp = new DateTimeHelper();

        $this->qBuilder = new EmployeeBuilder();
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
        // $qu = "EXEC contoh_join_database";
        // $builder = $this->db->query($qu);
        // $builder->getResultArray();

        // $query = $builder->resultArray;

        $builder = $this->qBuilder->show($id);
        $total = $this->qHelp->_total($builder);
        $rows = $this->qHelp->_rowsBui($builder);
        $count = count($rows);

        $umur = [];
        $pengalaman = [];

        if ($rows) {
            foreach ($rows as $key => $value) {
                if (isset($value->TglLahir)) {
                    $umur = $this->dtHelp->calc_age($value->TglLahir);
                    $rows[$key]->umur = $umur;
                }

                if (isset($value->tglEfektif)) {
                    $pengalaman = $this->dtHelp->calc_age($value->tglEfektif);
                    $rows[$key]->pengalaman = $pengalaman;
                }
            }
        }

        $response = $this->qHelp->respon($rows, $count, $total);

        return $this->respond($response, $response['scode']);
    }

    public function show_from_sap()
    {
        $plant = $this->request->getJsonVar('plant');

        $builder = $this->qBuilder->show_from_sap();

        if ($plant) {
            $builder = $this->qHelp->array_where($builder, 'PLANT', $plant);
        }

        $params = [
            "PLANT",
            "NIK",
            "NAMA"
        ];

        $builder = $this->qHelp->array_search($builder, $params);
        $query = $this->qHelp->array_paging($builder);

        $count = $query['count'];
        $total = $query['total'];
        $rows = $query['rows'];

        $response = $this->qHelp->restrue($rows, $count, $total);

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
        // 
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
}
