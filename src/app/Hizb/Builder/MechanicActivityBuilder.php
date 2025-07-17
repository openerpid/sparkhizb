<?php

namespace App\Hizb\Builder;

use Sparkhizb\Helpers\IdentityHelper;
use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\Helpers\UmmuHelper;
use App\Hizb\Models\MechanicActivityModel;
use App\Hizb\Models\MechanicActivityAppvtrxModel;
use App\Hizb\Models\UserAccessModel;

class MechanicActivityBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->iescm = \Config\Database::connect('iescm');
        $this->request = \Config\Services::request();
        $this->identity = new IdentityHelper();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new QueryHelper();
        $this->umHelp = new UmmuHelper();
        $this->model = new MechanicActivityModel();
        $this->mAppvtrx = new MechanicActivityAppvtrxModel();
        $this->mUsracc = new UserAccessModel;
    }

    public function qbAlya()
    {
        $table = $this->model->table;
        // $selects = $this->model->selects;
        // $allowedFields = $this->model->allowedFields;

        $subquery = $this->iescm->table($table . ' a');

        if ($this->request->getJsonVar('almi') == true) {
            $subquery->select($this->model->almi);
        }
        // ->select($selects)

        // ->join($this->mUsracc->database . '.' . $this->mUsracc->table . ' b', 'b.id = a.created_by', 'left')
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
        $subquery->where('a.deleted_at IS NULL');

        return $this->iescm->newQuery()->fromSubquery($subquery, 't');
    }

    public function cekStatus($id)
    {
        $builder = $this->model
        ->select("appr_status_id")
        ->where("id", $id)
        ->get()
        ->getRow();

        return $builder;
    }

    public function show($id = null, $builder = null)
    {
        $allowedFields = $this->model->allowedFields;

        if ($builder == null) {
            $builder = $this->qbAlya();
        }

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["mechanic_name","unit","jobtype_text","tech_iden_no","site","operation","operation_short_text","workorder"],
            "company_id" => null,
            "account_id" => null
        ];

        $builder = $this->bHelp->conditions($params);        
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }

    public function insert($payload)
    {
        // $payload = $this->identity->insert($payload);
        $builder = $this->model->insert($payload);

        return $builder;
    }


    /**
     * UPDATE
     */
    public function update($id, $payload)
    {
        $builder = $this->model
            ->where('id', $id)
            ->set($payload)
            ->update();

        return $builder;
    }

    /**
     * DELETE
     *  */
    public function delete($id)
    {
        if ($this->identity->vendor() == "syshab") {
            $builder = $this->bHelp->delete2($id, $this->model);
        }else{
            $builder = $this->bHelp->delete($id, $this->model);
        }

        return $builder;
    }

    public function insert_appvtrx($payload)
    {
        // $payload = $this->identity->insert($payload);
        $builder = $this->mAppvtrx->insert($payload);

        return $builder;
    }

    public function show_appvtrx_by_activityID($id)
    {
        $builder = $this->mAppvtrx
        ->where("activity_id", $id);

        $table = $this->mAppvtrx->table;
        // $selects = $this->model->selects;
        $selects = "a.*,b.access";
        // $allowedFields = $this->model->allowedFields;

        $subquery = $this->iescm->table($table . ' a')
        ->select($selects)
        ->join($this->mUsracc->database . '.' . $this->mUsracc->table . ' b', 'b.user = a.created_by_text', 'left')
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
        // ->where("a.module", "pm_mechanic_activity")
        ->where('a.activity_id', $id)
        ->where('a.deleted_at IS NULL');

        return $this->iescm->newQuery()->fromSubquery($subquery, 't');
    }

    public function show_last_trx_byaccess($activity_id, $access)
    {
        $builder = $this->mAppvtrx
        ->where("activity_id", $activity_id);

        $table = $this->mAppvtrx->table;
        // $selects = $this->model->selects;
        $selects = "a.*,b.access";
        // $allowedFields = $this->model->allowedFields;

        $subquery = $this->iescm->table($table . ' a')
        ->select($selects)
        ->join($this->mUsracc->database . '.' . $this->mUsracc->table . ' b', 'b.user = a.created_by_text', 'left')
        ->where('a.activity_id', $activity_id)
        ->where('b.access', $access)
        ->where('a.deleted_at IS NULL');

        return $this->iescm->newQuery()->fromSubquery($subquery, 't');
    }

    public function history_deleted()
    {
        $table = $this->model->table;

        $subquery = $this->iescm->table($table);

        if ($this->request->getJsonVar('almi') == true) {
            $subquery->select($this->model->almi);
        }

        $subquery->where("deleted_at IS NOT NULL")
        ->where("user", $this->identity->username());

        return $subquery;
    }
}