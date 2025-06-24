<?php

namespace App\Hizb\Builder;

use Sparkhizb\Helpers\IdentityHelper;
use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\Helpers\UmmuHelper;
use App\Hizb\Models\MechanicActivityModel;

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
        $builder = $this->model
            ->delete($id);

        if ($builder) {
            $this->model
                ->where('id', $id)
                ->set('deleted_by', $this->identity->account_id())
                ->update();
        }

        return $builder;
    }
}