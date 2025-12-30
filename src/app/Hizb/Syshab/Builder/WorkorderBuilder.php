<?php

namespace App\Hizb\Syshab\Builder;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\UmmuHelper;

use App\Hizb\Syshab\Models\DivisiModel;
use App\Hizb\Syshab\Models\DepartemenModel;

class WorkorderBuilder
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new UmmuHelper();

        $this->mDivisi = new DivisiModel();
        $this->model = new DepartemenModel();
    }

    private function sjQuery()
    {
        // exec dbo.uSP_0304_SHB_0002_05 20250801,20250805,N'^All^,^ABR^,^AKP^,^AMA^,^AMI^,^AMO^,^BBN^,^BJM^,^BKA^,^BKL^,^BKN^,^BMI^,^BPM^,^BPN^,^BPR^,^BPU^,^CNI^,^GBA^,^GBU^,^GNS^,^HO^,^HSM^,^IBU^,^JBU^,^KEN^,^KIN^,^KTE^,^KVA^,^LNT^,^LOL^,^LUW^,^MAC^,^MLA^,^MND^,^NBL^,^NPB^,^PCA^,^PMT^,^PMU^,^PTC^,^PTP^,^PWD^,^REI^,^REM^,^SAH^,^SCM^,^SRE^,^SRO^,^SSA^,^SSC^,^STO^,^TCM^,^TCN^,^TER^,^TLS^,^TMA^,^TPN^,^VIC^,^WBN^',0

        // SELECT tr_machine_conditionh.trans_id,
        //     tr_machine_conditionh.trans_date,
        //     tr_machine_conditionh.unit_code,
        //     tr_machine_conditionh.region_code,
        //     tr_machine_conditionh.remark,
        //     tr_machine_conditionh.job_status,           
        //     tr_machine_conditionh.time_reading,
        //     tr_machine_conditionh.pm_id,
        //     tr_machine_conditionh.priority_code,    
        //     tr_machine_conditionh.tDown,
        //     ms_unit.model_no,
        //     ms_jobsite.region_name,
        //     PMMSOrderType.OrderName  AS OrderType,
        //     ms_wo_status.wo_desc AS trans_status,
        //     (SELECT UPPER(ms_priority.prio_desc) FROM ms_priority WHERE ms_priority.priority_code=tr_machine_conditionh.priority_code) AS priority,
        //     tr_machine_conditionh.down_type,
        //     compstdate,
        //     trans_down,
        //     compfndate,
        //     comp_down_time,
        //     (SELECT UPPER(ms_componenh.com_group_name) FROM ms_componenh WHERE  ms_componenh.com_group=tr_machine_conditionh.com_group) AS Comp_Group,
        //     (SELECT UPPER(ms_componend.com_name) FROM ms_componend WHERE ms_componend.com_code=tr_machine_conditionh.com_code) AS Comp_detail,
        //     (SELECT UPPER(ms_diagnosis.diag_remark) FROM ms_diagnosis WHERE ms_diagnosis.diag_code=tr_machine_conditionh.diag_code) AS Diagnosis,
        //     (SELECT UPPER(sym_name) FROM ms_symtom_problem WHERE ms_symtom_problem.sym_code=tr_machine_conditionh.sym_code) AS Symptom,
        //     CASE WHEN tdown=1 THEN 'X' ELSE NULL END AS tdown
        // FROM  tr_machine_conditionh INNER JOIN ms_jobsite ON ms_jobsite.region_code = tr_machine_conditionh.region_code
        //     INNER JOIN ms_unit ON ms_unit.unit_code=tr_machine_conditionh.unit_code
        //     INNER JOIN ms_wo_status ON ms_wo_status.wo_status  =tr_machine_conditionh.trans_status
        //     INNER JOIN PMMSOrderType ON PMMSOrderType.OrderType=tr_machine_conditionh.OrderType
        // WHERE (tr_machine_conditionh.void <> '4') 
        // AND (tr_machine_conditionh.region_code IN (SELECT data FROM dbo.MyArray(@ls_project))) 
        // AND (tr_machine_conditionh.trans_status <> '02')

        $subquery = $this->db->table('tr_machine_conditionh a')
            ->select('
                a.trans_date,
                a.unit_code,
                a.region_code,
                a.remark,
                a.job_status,           
                a.time_reading,
                a.pm_id,
                a.priority_code,    
                a.tDown,
                a.down_type,
                ms_unit.model_no,
                ms_jobsite.region_name,
                PMMSOrderType.OrderName  AS OrderType,
                ms_wo_status.wo_desc AS trans_status,
                (SELECT UPPER(ms_priority.prio_desc) FROM ms_priority WHERE ms_priority.priority_code=a.priority_code) AS priority,
                compstdate,
                trans_down,
                compfndate,
                comp_down_time,
            ')
            // ->join($this->mDivisi->table . ' b', 'b.KdDivisi = a.KdDivisi', 'left')
            ->where('a.void <> 4');

        return $this->db->newQuery()->fromSubquery($subquery, 't');
    }

    public function show($id = null)
    {
        if ($this->qHelp->is_jsonVar() == true) {
            $KdDivisi = $this->request->getJsonVar('KdDivisi');
        } else {
            $KdDivisi = $this->request->getVar('KdDivisi');
        }

        $allowedFields = $this->model->allowedFields;

        $builder = $this->sjQuery();

        if ($KdDivisi) {
            $builder->where('KdDivisi', $KdDivisi);
        }

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["KdDepar", "NmDepar"],
            "company_id" => null
        ];

        $builder = $this->bHelp->conditions0($params);
        $allowedFields = array_merge($allowedFields, ["NmDivisi"]);
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }

    public function show_by_kode($kode = null)
    {
        $builder = $this->db->table($this->model->table)
            ->where('KdDepar', $kode)
            ->where('DeleteBy IS NULL');

        return $builder;
    }
}