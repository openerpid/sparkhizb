<?php

namespace App\Hizb\Validations;

use Sparkhizb\Helpers\IdentityHelper;

use App\Hizb\Models\Safety\LpahModel;
use App\Hizb\Models\Safety\LpadOrangModel;
use App\Hizb\Models\Safety\LpadFotoModel;
use App\Hizb\Models\Safety\LpadKerusakanModel;
use App\Hizb\Models\MechanicActivityModel;

class MechanicActivityValidation 
{
	public function __construct()
    {
        $this->iescm = \Config\Database::connect('iescm');
        $this->validation = \Config\Services::validation();
        $this->request = \Config\Services::request();
        $this->identity = new IdentityHelper();

        $this->model = new MechanicActivityModel();
    }

    private function cekID($id)
    {
        $builder = $this->model
        ->select("id")
        ->where('id', $id)
        ->get()
        ->getRow();

        return $builder;
    }

    private function cek_status_id($id)
    {
        $builder = $this->model
        ->select("appr_status_id")
        ->where('id', $id)
        ->get()
        ->getRow();

        return $builder;
    }

    public function new()
    {
        // $rules = [
        //     'site_project_kode' => 'required',
        //     'kode' => 'required',
        //     'uom_id' => 'required',
        // ];

        // $this->validation->setRules($rules);
        // $this->validation->withRequest($this->request)->run();
        // $errors = $this->validation->getErrors();
        //     if($errors) return $errors;
    }

    public function insert()
    {
        $site_project_id        = $this->request->getJsonVar('site_project_id');
        $site_project_kode      = $this->request->getJsonVar('site_project_kode');

        $po_number              = $this->request->getJsonVar('po_number');
        $pic_code               = $this->request->getJsonVar('pic_code');
        $pic                    = $this->request->getJsonVar('pic');
        $vendor                 = $this->request->getJsonVar('vendor');
        $reference              = $this->request->getJsonVar('reference');
        $reference_number       = $this->request->getJsonVar('reference_number');

        $item_code              = $this->request->getJsonVar('item_code');
        $item_name              = $this->request->getJsonVar('item_name');
        $qty                    = $this->request->getJsonVar('qty');
        $uom                    = $this->request->getJsonVar('uom');
        $item_category_id       = $this->request->getJsonVar('item_category_id');

        $received_at            = $this->request->getJsonVar('received_at');
        $installed_at           = $this->request->getJsonVar('installed_at');
        $problem_category_id    = $this->request->getJsonVar('problem_category_id');
        $fekb_number            = $this->request->getJsonVar('fekb_number');
        $description            = $this->request->getJsonVar('description');
        $report_by_name         = $this->request->getJsonVar('report_by_name');

        $remark                 = $this->request->getJsonVar('remark');
        $action                 = $this->request->getJsonVar('action');
        $filename               = $this->request->getJsonVar('filename');
        $folder                 = $this->request->getJsonVar('folder');
        $url                    = $this->request->getJsonVar('url');
        $status_id              = $this->request->getJsonVar('status_id');

        $rules = [
            "po_number" => 'required',
            "pic_code" => 'required',
            "pic" => 'required',
            "vendor" => 'required',

            "item_code" => 'required',
            "item_name" => 'required',
            "qty" => 'required',
            "uom" => 'required',
            "item_category_id" => 'required',

            "received_at" => 'required',
            // "installed_at" => 'required',
            "problem_category_id" => 'required',
            "fekb_number" => 'required',
            "description" => 'required',
            "report_by_name" => 'required',

            "url" => 'required',
            "status_id" => 'required'
        ];

        $this->validation->setRules($rules);
        $this->validation->withRequest($this->request)->run();
        $errors = $this->validation->getErrors();
            if($errors) return $errors;

        $findByFekb = $this->model->where('fekb_number', $fekb_number)->first();
            if ($findByFekb) return ["fekb_number" => "FEKB Number already exist."];
    }

    public function update($id)
    {
        if (!$this->cekID($id)) return ["id" => "ID ".$id." not found!"];

        $show_statusID = $this->cek_status_id($id);
        $status_id = $show_statusID->appr_status_id;

        if ($status_id == 1) return ["status" => "Dokumen sudah di-approve. Tidak bisa di-update."];

        // if ($is_pic == 1) {
        //     $rules = [
        //         "status_id" => 'required',
        //         "remark" => 'required',
        //         "action" => 'required'
        //     ];
        // }else{
        //     $rules = [
        //         "po_number" => 'required',
        //         "pic_code" => 'required',
        //         "pic" => 'required',
        //         "vendor" => 'required',

        //         "item_code" => 'required',
        //         "item_name" => 'required',
        //         "qty" => 'required',
        //         "uom" => 'required',
        //         "item_category_id" => 'required',

        //         "received_at" => 'required',
        //         "installed_at" => 'required',
        //         "problem_category_id" => 'required',
        //         "fekb_number" => 'required',
        //         "description" => 'required',
        //         "report_by_name" => 'required',

        //         "status_id" => 'required'
        //     ];

        //     if(isset($filename)) $rules["filename"] = 'required';
        //     if(isset($folder)) $rules["folder"] = 'required';
        //     if(isset($path)) $rules["path"] = 'required';
        //     if(isset($url)) $rules["url"] = 'required';
        // }

        // $this->validation->setRules($rules);
        // $this->validation->withRequest($this->request)->run();
        // $errors = $this->validation->getErrors();
        //     if($errors) return $errors;

        // // $findByFekb = $this->model->where('fekb_number', $fekb_number)->first();
        // //     if ($findByFekb) return ["fekb_number" => "FEKB Number already exist."];
        
        // // $qUsername = $this->model->like('username', $username)->where('id != ', $id)->first();
        // //     if ($qUsername) return ["username" => "Username has already on this system"];

        /*$table = $this->model->table;
        $subquery = $this->iescm->table($table)
        ->select("id")
        ->where('id', $id)
        ->get()
        // ->getResultArray();
        ->getRow();

        return $subquery;*/
    }

    public function approve($id)
    {
        $show_statusID = $this->cek_status_id($id);
        $status_id = $show_statusID->appr_status_id;

        if ($status_id == 1) return ["status" => "Dokumen sudah di-approve. Tidak bisa di-approve lagi."];

        if ($status_id == 2) return ["status" => "Dokumen sedang di-revisi. Tidak bisa di-approve."];
    }
}