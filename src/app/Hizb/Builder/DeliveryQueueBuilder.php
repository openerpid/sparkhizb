<?php

namespace App\Hizb\Builder;

use Sparkhizb\Helpers\UmmuHelper;
// use Sparkhizb\UmmuHazardReport;
use App\Hizb\Models\DeliveryQueueModel;

class DeliveryQueueBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->umHelp = new UmmuHelper();
        // $this->ummu = new UmmuHazardReport();
        $this->model = new DeliveryQueueModel();
    }

    public function show()
    {
        // $builder = $this->db->table($this->model->table)
        $builder = $this->model
            // ->where('send_mail IS NULL')
            // ->findAll();
            ->get()->getResult();

        return $builder;
    }

    public function create($document_id)
    {
        $builder = $this->model->insert(["document_id" => $document_id]);
        return $builder;
    }

    public function update($id, $body)
    {
        $builder = $this->model->update($id, $body);
        return $builder;
    }

    public function update_by_docID($document_id, $payload)
    {
        $builder = $this->model
            ->where('document_id', $document_id)
            ->set($payload)
            ->update();

        return $builder;
    }
}