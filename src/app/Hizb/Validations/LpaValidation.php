<?php

namespace App\Hizb\Validations;

use Sparkhizb\Helpers\IdentityHelper;

use App\Hizb\Models\Safety\LpahModel;
use App\Hizb\Models\Safety\LpadOrangModel;
use App\Hizb\Models\Safety\LpadFotoModel;
use App\Hizb\Models\Safety\LpadKerusakanModel;
use App\Hizb\Models\Safety\LpaAppvMatrixModel;

class LpaValidation 
{
	public function __construct()
    {
        $this->iescm = \Config\Database::connect('iescm');
        $this->validation = \Config\Services::validation();
        $this->request = \Config\Services::request();
        $this->identity = new IdentityHelper();

        $this->model = new LpahModel();
        $this->mOrang = new LpadOrangModel();
        $this->mFoto = new LpadFotoModel();
        $this->mKerusakan = new LpadKerusakanModel();
        $this->mAppvMtx = new LpaAppvMatrixModel();
    }

    private function cekID($id)
    {
        $builder = $this->iescm->table($this->model->table)
        ->select("id")
        ->where('id', $id)
        ->get()
        ->getRow();

        return $builder;
    }

    private function cekID_orangTerlibat($id, $lpa_id)
    {
        $builder = $this->iescm->table($this->mOrang->table)
        ->select("id")
        ->where("lpa_id", $lpa_id)
        ->where('id', $id)
        ->get()
        ->getRow();

        return $builder;
    }

    private function cekID_kerusakan($id, $lpa_id)
    {
        $builder = $this->iescm->table($this->mKerusakan->table)
        ->select("id")
        ->where('id', $id)
        ->where("lpa_id", $lpa_id)
        ->get()
        ->getRow();

        return $builder;
    }

    private function cekID_foto($id, $lpa_id)
    {
        $builder = $this->iescm->table($this->mFoto->table)
        ->select("id")
        ->where('id', $id)
        ->where("lpa_id", $lpa_id)
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

        if ($this->request->getVar('orang_terlibat')) {
            $orang_terlibat = $this->request->getVar('orang_terlibat');
            foreach ($orang_terlibat as $key => $value) {
                if (!$this->cekID_orangTerlibat($key, $id)) return ["orang_terlibat_id" => "ID ".$key." not found!"];
            }
        }

        if ($this->request->getVar('kerusakan')) {
            $kerusakan = $this->request->getVar('kerusakan');
            foreach ($kerusakan as $key => $value) {
                if (!$this->cekID_kerusakan($key, $id)) return ["kerusakan_id" => "ID ".$key." not found!"];
            }
        }

        if ($this->request->getVar('foto')) {
            $foto = $this->request->getVar('foto');
            foreach ($foto as $key => $value) {
                if (!$this->cekID_foto($key, $id)) return ["foto_id" => "ID ".$key." not found!"];
            }
        }

        // $is_pic                 = $this->request->getJsonVar('is_pic');

        // $site_project_id        = $this->request->getJsonVar('site_project_id');
        // $site_project_kode      = $this->request->getJsonVar('site_project_kode');

        // $po_number              = $this->request->getJsonVar('po_number');
        // $pic_code               = $this->request->getJsonVar('pic_code');
        // $pic                    = $this->request->getJsonVar('pic');
        // $vendor                 = $this->request->getJsonVar('vendor');
        // $reference              = $this->request->getJsonVar('reference');
        // $reference_number       = $this->request->getJsonVar('reference_number');

        // $item_code              = $this->request->getJsonVar('item_code');
        // $item_name              = $this->request->getJsonVar('item_name');
        // $qty                    = $this->request->getJsonVar('qty');
        // $uom                    = $this->request->getJsonVar('uom');
        // $item_category_id       = $this->request->getJsonVar('item_category_id');

        // $received_at            = $this->request->getJsonVar('received_at');
        // $installed_at           = $this->request->getJsonVar('installed_at');
        // $problem_category_id    = $this->request->getJsonVar('problem_category_id');
        // $fekb_number            = $this->request->getJsonVar('fekb_number');
        // $description            = $this->request->getJsonVar('description');
        // $report_by_name         = $this->request->getJsonVar('report_by_name');

        // $status_id              = $this->request->getJsonVar('status_id');
        // $remark                 = $this->request->getJsonVar('remark');
        // $action                 = $this->request->getJsonVar('action');

        // $filename               = $this->request->getJsonVar('filename');
        // $folder                 = $this->request->getJsonVar('folder');
        // $path                   = $this->request->getJsonVar('path');
        // $url                    = $this->request->getJsonVar('url');

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


    /**
     * DETAIL ORANG TERLIBAT
     * */
    public function insert_orangTerlibat()
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $status_karyawan = $this->request->getVar('status_karyawan');
        
        $rules = [
            "lpa_id" => 'required',
            "status_karyawan" => 'required',
            "nik" => 'required',
            "name" => 'required',
            "jk" => 'required',
            "jabatan" => 'required',
            // "atasan" => 'required',
            "umur" => 'required',
            "pengalaman_tahun" => 'required',
            "pengalaman_bulan" => 'required',
            "sebagai" => 'required',
            "hari_kerja_ke" => 'required'
        ];

        if ($status_karyawan == "Eksternal") {
            $rules["perusahaan"] = 'required';
        }

        $this->validation->setRules($rules);
        $this->validation->withRequest($this->request)->run();
        $errors = $this->validation->getErrors();
            if($errors) return $errors;

        $findLpaID = $this->model->select('id')->where('id', $lpa_id)->get()->getRow();
            if (!$findLpaID) return ["id" => "lpa_id not found!"];
    }

    public function update_orangTerlibat($id)
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $status_karyawan = $this->request->getVar('status_karyawan');
        
        $rules = [
            "lpa_id" => 'required',
            "status_karyawan" => 'required',
            "nik" => 'required',
            "name" => 'required',
            "jk" => 'required',
            "jabatan" => 'required',
            // "atasan" => 'required',
            "umur" => 'required',
            "pengalaman_tahun" => 'required',
            "pengalaman_bulan" => 'required',
            "sebagai" => 'required',
            "hari_kerja_ke" => 'required'
        ];

        if ($status_karyawan == "Eksternal") {
            $rules["perusahaan"] = 'required';
        }

        $this->validation->setRules($rules);
        $this->validation->withRequest($this->request)->run();
        $errors = $this->validation->getErrors();
            if($errors) return $errors;

        $show_id = $this->mOrang
        ->select('id')
        ->where('id', $id)
        ->get()
        ->getRow();
        if (!$show_id) return ["id" => "id not found!"];

        $show_lpaID = $this->mOrang
        ->select('id')
        ->where('id', $id)
        ->where('lpa_id', $lpa_id)
        ->get()
        ->getRow();
        if (!$show_lpaID) return ["lpa_id" => "lpa_id not found!"];
    }
    /**
     * END DETAIL ORANG TERLIBAT*/


    /**
     * DETAIL KERUSAKAN*/
    public function insert_kerusakan()
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $aset_perusahaan = $this->request->getVar('aset_perusahaan');
        
        $rules = [
            "lpa_id" => 'required',
            // "jenis_kerusakan" => 'required',
            // "name" => 'required',
            // "tipe" => 'required',
            // "serial_number" => 'required',
            // "tingkat_kerusakan" => 'required',
            // "detail_kerusakan_kerugian" => 'required',
            // "perkiraan_biaya" => 'required'
        ];

        // if (!$aset_perusahaan) {
        //     $rules['bukan_aset_perusahaan_text'] = 'required';
        // }

        $this->validation->setRules($rules);
        $this->validation->withRequest($this->request)->run();
        $errors = $this->validation->getErrors();
            if($errors) return $errors;

        $findLpaID = $this->model->select('id')->where('id', $lpa_id)->get()->getRow();
            if (!$findLpaID) return ["id" => "lpa_id not found!"];
    }

    public function update_kerusakan($id)
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $aset_perusahaan = $this->request->getVar('aset_perusahaan');
        
        $rules = [
            "lpa_id" => 'required',
            // "jenis_kerusakan" => 'required',
            // "name" => 'required',
            // "tipe" => 'required',
            // "serial_number" => 'required',
            // "tingkat_kerusakan" => 'required',
            // "detail_kerusakan_kerugian" => 'required',
            // "perkiraan_biaya" => 'required'
        ];

        // if (!$aset_perusahaan) {
        //     $rules['bukan_aset_perusahaan_text'] = 'required';
        // }

        $this->validation->setRules($rules);
        $this->validation->withRequest($this->request)->run();
        $errors = $this->validation->getErrors();
            if($errors) return $errors;

        $show_id = $this->mKerusakan
        ->select('id')
        ->where('id', $id)
        ->get()
        ->getRow();
        if (!$show_id) return ["id" => "id not found!"];

        $show_lpaID = $this->mKerusakan
        ->select('id')
        ->where('id', $id)
        ->where('lpa_id', $lpa_id)
        ->get()
        ->getRow();
        if (!$show_lpaID) return ["lpa_id" => "lpa_id not found!"];
    }

    /**
     * DETAIL APPROVAL MATRIX*/
    public function insert_approval_matrix($params)
    {
        $site = $params['site'];
        $sequence = $params['sequence'];
        $account_id = $params['account_id'];
        
        $rules = [
            "site_project_kode" => 'required',
            "sequence" => 'required',
            "account_id" => 'required',
        ];

        $this->validation->setRules($rules);
        $this->validation->withRequest($this->request)->run();
        $errors = $this->validation->getErrors();
            if($errors) return $errors;

        $cek = $this->mAppvMtx
        ->select('id')
        // ->where('sequence', $sequence)
        ->where('site', $site)
        ->where('account_id', $account_id)
        ->where('deleted_at IS NULL')
        ->get()->getRow();
            if ($cek) return ["id" => "User already exist in ".$site."!"];

        $cek2 = $this->mAppvMtx
        ->select('id')
        ->where('sequence', $sequence)
        ->where('site', $site)
        // ->where('account_id', $account_id)
        ->where('deleted_at IS NULL')
        ->get()->getRow();
            if ($cek2) return ["id" => "Sequence already exist in ".$site."!"];
    }

    public function update_approval_matrix($id, $params)
    {
        $site = $params['site'];
        $sequence = $params['sequence'];
        $account_id = $params['account_id'];
        
        $rules = [
            "site_project_kode" => 'required',
            "sequence" => 'required',
            "account_id" => 'required',
        ];

        $this->validation->setRules($rules);
        $this->validation->withRequest($this->request)->run();
        $errors = $this->validation->getErrors();
            if($errors) return $errors;

        $cek = $this->mAppvMtx
        ->select('id')
        // ->where('sequence', $sequence)
        ->where('site', $site)
        ->where('account_id', $account_id)
        ->where('id !='. $id)
        ->where('deleted_at IS NULL')
        ->get()->getRow();
            if ($cek) return ["id" => "User already exist in ".$site."!"];

        $cek2 = $this->mAppvMtx
        ->select('id')
        ->where('sequence', $sequence)
        ->where('site', $site)
        ->where('id !='. $id)
        // ->where('account_id', $account_id)
        ->where('deleted_at IS NULL')
        ->get()->getRow();
            if ($cek2) return ["id" => "Sequence already exist in ".$site."!"];
    }
}