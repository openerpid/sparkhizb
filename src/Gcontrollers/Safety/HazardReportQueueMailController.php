<?php

namespace App\Gcontrollers\Safety;

use CodeIgniter\RESTful\ResourceController;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\UmmuPhotos;
use Sparkhizb\UmmuUpload;

use App\Gbuilder\Safety\HazardReportBuilder;
use App\Gbuilder\Safety\HazardReportQueueMailBuilder;

class HazardReportQueueMailController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->qHelp = new UmmuHelper();
        $this->qBuilder = new HazardReportQueueMailBuilder();
        $this->qbHazard = new HazardReportBuilder();
        $this->umUpl = new UmmuUpload();
        $this->umPhot = new UmmuPhotos();
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
        $builder = $this->qBuilder->show();
        if ($builder) {
            $row = $builder[0];
            $document_id = $row['document_id'];

            $detail = $this->qbHazard->show($document_id);
            $response = $detail;
        } else {
            $response = [];
        }
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
        $document_id = $this->request->getJsonVar('document_id');

        $builder = $this->qBuilder->create($document_id);
        return $this->respond($builder, 200);
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
        $body = $this->request->getJsonVar();

        $builder = $this->qBuilder->update_queue_mail($id, $body);

        return $this->respond($builder, 200);
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
        $body = $this->request->getJsonVar();

        $payload = [
            "send_mail" => $this->request->getJsonVar('send_mail')
        ];

        $builder = $this->qBuilder->update_by_docID($document_id, $payload);
        return $this->respond($builder, 200);
    }
}
