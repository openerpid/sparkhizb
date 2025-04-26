<?php

namespace App\Gbuilder\Safety;

use Sparkhizb\Helpers\IdentityHelper;
use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\UmmuHelper;
use Sparkhizb\UmmuHazardReport;

use App\Gmodels\Safety\LpahModel;
use App\Gmodels\Safety\LpadUnitModel;
use App\Gmodels\Safety\LpadOrangModel;
use App\Gmodels\Safety\LpadFotoModel;
use App\Gmodels\Safety\LpadKerusakanModel;

// use App\Models\Safety\HazardReportQueueMailModel;
// use App\Models\Safety\HazardReportNumberModel;

class LpaBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->iescm = \Config\Database::connect('iescm');
        $this->request = \Config\Services::request();
        $this->identify = new IdentityHelper();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new QueryHelper();
        $this->umHelp = new UmmuHelper();
        $this->ummu = new UmmuHazardReport();

        // $this->model = new HazardReportQueueMailModel();
        // $this->mNum = new HazardReportNumberModel();
        $this->model = new LpahModel();
        $this->mOrang = new LpadOrangModel();
        $this->mFoto = new LpadFotoModel();
        $this->mKerusakan = new LpadKerusakanModel();
        $this->mUnit = new LpadUnitModel();

        // $this->db->defaultGroup = 'iescm';
    }

    private function qbAlya()
    {
        // $release = $this->request->getJsonVar('release');
        // if ($release) {
        //     $release2 = [];
        //     foreach ($release as $key => $value) {
        //         $release2[] = (string)$value;
        //     }
        // }else{
        //     $release2 = ["0","1"];
        // }

        $table = $this->model->table;
        // $selects = $this->model->selects;
        // $allowedFields = $this->model->allowedFields;

        $subquery = $this->iescm->table($table . ' a')
            // ->select($selects)

            // ->join($this->mAcnt->database . '.' . $this->mAcnt->table . ' b', 'b.id = a.created_by', 'left')
            // ->join($this->mIdnt->database . '.' . $this->mIdnt->table . ' c', 'c.id = b.identity_id', 'left')

            // ->join($this->mEmpl->database . '.' . $this->mEmpl->table . ' j', 'j.identity_id = c.id', 'left')
            // ->join('Sparkhizb_she.lokasi_temuan d', 'd.id = a.lokasi_temuan_id', 'left')
            // ->join('Sparkhizb_she.jenis_bahaya e', 'e.id = a.jenis_temuan_id', 'left')
            // ->join('Sparkhizb_she.kode_bahaya f', 'f.id = a.kode_bahaya_id', 'left')
            // ->join('Sparkhizb.document_kode g', 'g.document_id = 5', 'left')
            // ->join('Sparkhizb_gallery.photos h', 'h.id = a.foto_temuan_id', 'left')
            // ->join('Sparkhizb_gallery.photos i', 'i.id = a.foto_perbaikan_id', 'left')

            // ->join($this->mAcnt->database . '.' . $this->mAcnt->table . ' ll', 'll.id = a.approved_by', 'left')
            // ->join($this->mIdnt->database . '.' . $this->mIdnt->table . ' l', 'l.id = ll.identity_id', 'left')

            // ->join($this->mAcnt->database . '.' . $this->mAcnt->table . ' kk', 'kk.id = a.rejected_by', 'left')
            // ->join($this->mIdnt->database . '.' . $this->mIdnt->table . ' k', 'k.id = kk.identity_id', 'left')
            // // ->whereIn('a.is_release', $release2)
            ->where('a.deleted_at IS NULL');

        return $this->iescm->newQuery()->fromSubquery($subquery, 't');
    }

    public function show($id = null)
    {
        $builder = $this->qbAlya();

        // /**
        //  * 0 = Not Release
        //  * 1 = Release
        //  * 2 = Approve
        //  * 3 = Reject
        //  * 
        //  * is_release 1 dan 2 tidak dapat lakukan (edit dan release), tapi dapat dilakukan approve dan reject oleh admin.
        //  * Admin hanya dapat melihat semua data yang is_release = 1 dan 2.
        //  * */

        // $release = $this->request->getJsonVar('release');
        // $nomor_dokumen = $this->request->getJsonVar('nomor_dokumen');

        // $allowedFields = $this->model->allowedFields;
        // $account_id = $this->identity->account_id();
        // $crud = $this->identity->crud();
        // $identity_id = null;
        // // $crud = [1,0,0,0];
        // // $crud = [];

        // if ($release) {
        //     $release = $release;
        // } else {
        //     $release = [0, 1, 2, 3];
        // }

        // if ($nomor_dokumen) {
        //     $builder->where('nomor_dokumen', $nomor_dokumen);
        // } else {
        //     if (isset($crud[1]) and $crud[1] == 1) { // jika Read All
        //         // if ($release == 0 OR $release == 3) { // jika get data dengan status (not release atau reject)
        //         if ($release == 0) { // jika get data dengan status (not release)
        //             $identity_id = $this->identity->account_id();
        //         }
        //     } else {
        //         $identity_id = $this->identity->account_id();
        //     }


        //     if (is_array($release)) {
        //         $builder->whereIn('is_release', $release);
        //     } else {
        //         $builder->where('is_release', $release);
        //     }

        // }

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => [],
            "company_id" => null,
            "account_id" => null
        ];

        $builder = $this->bHelp->conditions($params);
        // $builder = $this->qHelp->orderBy($builder, $allowedFields);
        return $builder;
    }

    public function show_d_orang($h_id)
    {
        return $this->mOrang->where('lpa_id', $h_id)->get()->getResult();
    }

    public function show_d_foto($h_id)
    {
        return $this->mFoto->where('lpa_id', $h_id)->get()->getResult();
    }

    public function show_d_kerusakan($h_id)
    {
        return $this->mKerusakan->where('lpa_id', $h_id)->get()->getResult();
    }

    public function show_d_unit($h_id)
    {
        return $this->mUnit->where('lpa_id', $h_id)->get()->getResult();
    }





    public function show_new($nik, $site)
    {
        $builder = $this->mNum
            ->where('nik', $nik)
            ->where('site', $site)
            ->where('number IS NULL')
            ->where('used_at IS NULL')
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'))
            ->first();

        return $builder;
    }

    public function show_number_unused($nik, $site)
    {
        $builder = $this->mNum
            ->where('nik', $nik)
            ->where('site', $site)
            ->where('used_at IS NULL')
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'))
            ->first();

        return $builder;
    }

    public function getLastRow()
    {
        $builder = $this->iescm->table($this->mNum->table)
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'))
            ->get()
            ->getLastRow();

        return $builder;
    }

    public function update_new($id, $payload)
    {
        $builder = $this->mNum
            ->where('id', $id)
            ->set($payload)
            ->update();

        return $builder;
    }

    public function create_id($payload)
    {
        return $this->mNum->insert($payload);
    }

    public function insert_number($payload)
    {
        return $this->mNum->insert($payload);
    }

    function used_number($number)
    {
        return $this->mNum
            ->where('number', $number)
            ->set('used_at', date('Y-m-d H:i:s'))
            ->update();
    }

    public function insert($payload)
    {
        $params = [
            "id" => null,
            "payload" => $payload,
            "token" => $this->umHelp->token()
        ];

        $builder = $this->ummu->insert($params);
        return $builder;
    }

    // public function show_queue_mail()
    // {
    //     $builder = $this->model
    //         ->where('send_mail IS NULL')
    //         ->find();

    //     return $builder;
    // }

    // public function show_queue_mail_detail($id)
    // {
    //     $payload = [
    //         "limit" => 10,
    //         "offset" => 0,
    //         "sort" => "id",
    //         "order" => "desc",
    //         "search" => "",
    //         "selects" => "*"
    //     ];

    //     $params = [
    //         "id" => $id,
    //         "payload" => $payload,
    //         "token" => getenv('OPEN_INTEGRASI_TOKEN_SAFETY')
    //     ];

    //     $builder = $this->ummu->show($params);
    //     return $builder;
    // }

    // public function create_queue_mail($document_id)
    // {
    //     $builder = $this->model->insert(["document_id" => $document_id]);
    //     return $builder;
    // }

    // public function update_queue_mail($id, $body)
    // {
    //     $builder = $this->model->update($id, $body);
    //     return $builder;
    // }
}