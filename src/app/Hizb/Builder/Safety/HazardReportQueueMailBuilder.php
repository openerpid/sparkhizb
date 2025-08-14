<?php

namespace App\Hizb\Builder\Safety;

use Sparkhizb\UmmuHelper;
use Sparkhizb\UmmuHazardReport;
use App\Hizb\Models\Safety\HazardReportQueueMailModel;

class HazardReportQueueMailBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->umHelp = new UmmuHelper();
        $this->ummu = new UmmuHazardReport();
        $this->model = new HazardReportQueueMailModel();
    }

    public function show()
    {
        $builder = $this->model
            ->where('send_mail IS NULL')
            ->find();

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