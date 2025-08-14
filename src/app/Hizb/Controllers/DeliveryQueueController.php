<?php

namespace App\Hizb\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Sparkhizb\Helpers\UmmuHelper;

use App\Hizb\Builder\DeliveryQueueBuilder;
// use App\Builder\GoodsevalBuilder;

class DeliveryQueueController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->qHelp = new UmmuHelper();
        $this->qBuilder = new DeliveryQueueBuilder();
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
        $response = [];

        $builder = $this->qBuilder->show();
        // if ($builder) {
        //     $row = $builder[0];
        //     $document_id = $row['document_id'];

        //     $detail = $this->qbGev->show($document_id);
        //     $response = $detail;
        // }
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
        // $document_id = $this->request->getJsonVar('document_id');

        // $builder = $this->qBuilder->create($document_id);
        // return $this->respond($builder, 200);
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
        // $body = $this->request->getJsonVar();

        // $builder = $this->qBuilder->update_queue_mail($id, $body);

        // return $this->respond($builder, 200);
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

    public function update_by_docID($document_id)
    {
        $payload = [
            "send_mail" => $this->request->getJsonVar('send_mail')
        ];

        $builder = $this->qBuilder->update_by_docID($document_id, $payload);
        return $this->respond($builder, 200);
    }
}
