<?php

namespace App\Hizb\Builder;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\QueryHelper;
use App\Hizb\Models\UsersModel;

class UsersBuilder 
{
	public function __construct()
    {
        $this->request 	= \Config\Services::request();
        $this->db      	= \Config\Database::connect('iescm');
        $this->bHelp    = new BuilderHelper();
        $this->qHelp    = new QueryHelper();
        $this->model    = new UsersModel();
    }

    private function sjQuery()
    {
        $table = $this->model->table;
        $selects = $this->model->selects;
        
        $subquery = $this->db->table($table . ' a')
        ->select($selects);
        // ->join('workorder b', 'b.id = a.wo_id', 'left')
        // ->join('operation_maintenance c', 'c.id = a.operation_id', 'left')
        // ->join('reason d', 'd.id = a.reason_id', 'left')
        // ->join('mechanic e', 'e.id = a.mechanic_id','left')
        // ->join('dorbitt.accounts f','f.id = e.account_id', 'left')
        // ->join('dorbitt.identities g','g.id = f.identity_id', 'left')
        // ->join('dorbitt.site_project h', 'h.id = a.site_project_id', 'left');

        $builder  = $this->db->newQuery()->fromSubquery($subquery, 't');

        return $builder;
    }

    public function show($id = null)
    {
        $allowedFields = $this->model->allowedFields;

        $builder = $this->sjQuery();
        
        $params = [
            "builder"       => $builder,
            "id"            => null,
            "search_params" => ["nik","name"],
            "company_id"    => null
        ];

        $builder = $this->bHelp->conditions($params);
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }
}