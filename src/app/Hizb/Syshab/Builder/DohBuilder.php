<?php

namespace App\Hizb\Syshab\Builder;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\UmmuHelper;
use App\Hizb\Syshab\Models\UsersModel;
use App\Hizb\Syshab\Builder\EmployeeBuilder;

class DohBuilder
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new UmmuHelper();
        $this->mUser = new UsersModel();
        $this->qbEmployee = new EmployeeBuilder();
    }

    private function selects()
    {
        return '
            a.lbm_code as id,
            a.lbm_code as text,
            a.lbm_code,
            a.ref_code,
            a.lbm_date,
            b.prod_code
        ';
    }

    public function qbAlya()
    {
        // // SET @NomorRS = ISNULL((SELECT NoContr FROM dbo.tr_purchaseD WHERE po_code=@po_code AND Prod_code=@argProd_code),'')
        // // SELECT MAX(Tgl) AS tgl  FROM dbo.tr_doh INNER JOIN dbo.tr_dod ON tr_dod.do_code = tr_doh.do_code WHERE status_do<>'4' AND ref_code=@NomorRS AND prod_code=@argProd_code

        // $subquery = $this->db->table('tr_lbmh a')
        //     ->select($this->selects())
        //     ->join('tr_lbmd b', 'b.lbm_code = a.lbm_code', 'left');

        // return $this->db->newQuery()->fromSubquery($subquery, 't');
    }

    public function show($id = null)
    {
        // $po_number = $this->request->getJsonVar('po_number');
        // $part_number = $this->request->getJsonVar('part_number');

        // $builder = $this->qbAlya();

        // if ($po_number) {
        //     $builder->where('po_code', $po_number);
        // }

        // if ($part_number) {
        //     $builder->where('Prod_code', $part_number);
        // }

        // $params = [
        //     "builder" => $builder,
        //     "id" => $id,
        //     "search_params" => ["po_code", "Prod_code"],
        //     "company_id" => null
        // ];

        // $builder = $this->bHelp->conditions0($params);
        // // $allowedFields = array_merge($allowedFields,["gedung_name"]);
        // // $builder = $this->qHelp->orderBy($builder, $allowedFields);

        // return $builder;
    }

    public function show_tgl_gi($NoContr, $prod_code)
    {
        $subquery = $this->db->table('tr_doh a')
            ->select('
                a.do_code,
                a.ref_code,
                a.Tgl,
                b.Prod_code

            ')
            ->join('tr_dod b', 'b.do_code = a.do_code', 'left')
            ->where('a.ref_code', $NoContr)
            ->where('b.Prod_code', $prod_code)
            ->where('a.status_do != 4');

        return $this->db->newQuery()->fromSubquery($subquery, 't');
    }
}