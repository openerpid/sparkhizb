<?php

namespace App\Hizb\Syshab\Builder;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\UmmuHelper;
use App\Hizb\Syshab\Builder\EmployeeBuilder;
use App\Hizb\Syshab\Models\PurchaseOrderModel;
use App\Hizb\Syshab\Models\UsersModel;

class PurchaseOrderBuilder
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new UmmuHelper();
        $this->mUser = new UsersModel();
        $this->model = new PurchaseOrderModel();
        $this->qbEmployee = new EmployeeBuilder();
    }

    private function selects()
    {
        // a.po_code,
        // a.vendor_code,   
        // a.vendor_name,   
        // a.KoExp,   
        // a.cur_code,          
        // a.Po_date,   
        // a.no_ref,   
        // a.remark,   
        // a.AppBy,   
        // a.etd,   
        // a.OrdBy,   
        // a.FreBy,   
        // a.JPPN,   
        // a.tot_amount,  
        // a.deliv_address, 
        // a.Net,   
        // a.PDisc,   
        // a.etaWh as etaWh_H,  
        // a.ShipModeEtaWh,   
        // a.Freight,   
        // a.DP,   
        // a.JTempo,   
        // a.pay_code,   
        // a.ppn,   
        // a.OTax,   
        // a.JOTax,   
        // a.Jpph,  
        // a.plantcode, 
        // a.priority_code,   
        // a.ShipModeEtd, 
        // a.tsendEmail,
        // a.LastAppvDate,




        // return "
        // 	a.*,
        // 	b.Prod_code,
        // 	b.spec,
        // 	b.Prod_code as item_id,
        // 	b.spec as item_name,
        //     b.nomer,   
        //     b.qty,   
        //     b.harga,   
        //     b.Disc as Disc_b,   
        //     b.delDate,   
        //     b.jumlah,   
        //     b.jumlah2,   
        //     b.SatQty,   
        //     b.etaWh as etaWh_b,
        // 	b.NoContr,
        // 	c.nmUser as owner_name,
        // 	c.emailadd,
        //     CASE b.twarranty WHEN '1' THEN 'Warranty' ELSE '' END as twarranty
        // 	";


        return "
			a.*,
			b.nmUser as owner_name,
			b.emailadd,
			b.Prod_code
		";




        // (select wh_name from ms_warehouse where wh_code=a.wh_code) as wh_name,
        // ms_company.company_name,   
        // ms_company.address1,   
        // (DATEDIFF(day, a.Po_date, b.etaWh)) AS TdayEtaWh,
        // IsNull(ms_product.koref,b.Prod_code)  as Prod_code,
        // IsNull(ms_product.spec,ms_product.spec)  as spec,   
        // IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
        // FROM MS_TAX WHERE MS_TAX.TAX_CODE =a.ppn),'') as PPN_Name,    
        // IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
        // FROM MS_TAX WHERE MS_TAX.TAX_CODE =a.OTAX),'') as PPH_Name,
        // IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
        // FROM MS_TAX WHERE MS_TAX.TAX_CODE =a.pph),'') as otax2_Name,   
        // isnull(a.attname,'') as attname ,
        // IsNull(ms_supplier.address1,'') as suppaddress,   
        // IsNull(ms_supplier.cityName,'') as cityName,   
        // IsNull(ms_supplier.contact1,'') as contact1,   
        // IsNull(ms_supplier.phone,'') as phone,   
        // IsNull(ms_supplier.fax,'') as fax,
        // IsNull(ms_supplier.contact2,'') as contact2,
        // IsNull(ms_supplier.hp1,'') as hp1,
        // IsNull(ms_supplier.hp2,'') as hp2,
        // IsNull(ms_supplier.email,'') as email,
        // appby_jab AS appby_txt,
        // ordby_jab AS ordby_txt,
        // freby_jab AS freby_txt,
    }

    public function findAll()
    {
        $subquery = $this->db->table('tr_purchaseH a')
            ->select($this->selects())
            ->join($this->mUser->table . ' c', 'c.kdUser = a.Owner', 'left');

        return $this->db->newQuery()->fromSubquery($subquery, 't');
    }

    public function qbAlya()
    {
        $table = $this->model->getTable;
        $selects = $this->model->selects;

        $subquery = $this->db->table('tr_purchaseH a')
            ->select($selects)
            ->join($this->mUser->table . ' b', 'b.kdUser = a.Owner', 'left');
        // ->join('tr_purchaseD b', 'b.po_code = a.po_code', 'left')
        // ->where('a.deleted_at IS NULL');

        return $this->db->newQuery()->fromSubquery($subquery, 't');
    }

    public function show_detail($po_code)
    {
        $subquery = $this->db->table('tr_purchaseD a')
            ->select("
            a.*,
            a.Prod_code as id,
            CONCAT(a.Prod_code,' | ', a.Spec) as text,
        ")
            ->where('a.po_code', $po_code);

        return $subquery;
    }

    public function show($id = null)
    {
        $is_json = $this->request->is('json');
        if ($is_json == true) {
            $po_number = $this->request->getJsonVar('po_number');
            $part_number = $this->request->getJsonVar('part_number');
        } else {
            $po_number = $this->request->getVar('po_number');
            $part_number = $this->request->getVar('part_number');
        }

        $builder = $this->qbAlya();

        if ($po_number) {
            $builder->where('po_code', $po_number);
        }

        if ($part_number) {
            // $builder->where('Prod_code', $part_number);
        }

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["po_code"],
            "company_id" => null
        ];

        $builder = $this->bHelp->conditions0($params);
        // $allowedFields = array_merge($allowedFields,["gedung_name"]);
        // $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }

    public function showBy_poNumber($po_number, $selects = null)
    {
        $builder = $this->qbAlya();
        if ($selects) {
            $builder->select($selects);
        }
        $builder->where('po_code', $po_number);

        $params = [
            "builder" => $builder,
            "id" => null,
            "search_params" => ["po_code"],
            "company_id" => null
        ];

        $builder = $this->bHelp->conditions0($params);

        return $builder;
    }

    public function selectDetail_by_poNumber_prodCode($po_code, $prod_code, $selects)
    {
        $subquery = $this->db->table('tr_purchaseD a')
            ->select($selects)
            ->where('a.po_code', $po_code)
            ->where("Prod_code", $prod_code);

        return $subquery;
    }

    public function show2($id = null)
    {
        $po_number = $this->request->getJsonVar('po_number');
        $part_number = $this->request->getJsonVar('part_number');

        // $where = " tr_purchaseH.po_code = '" . $po_number . "'";
        $where = " tr_purchaseH.po_code = '" . $po_number . "' AND tr_purchaseD.Prod_code = '" . $part_number . "'";

        $qum = "
        SELECT tr_purchaseH.po_code,
            tr_purchaseH.vendor_code,   
            tr_purchaseH.vendor_name,   
            tr_purchaseH.KoExp,   
            tr_purchaseD.nomer,   
            tr_purchaseD.qty,   
            tr_purchaseD.harga,   
            tr_purchaseD.Disc,   
            tr_purchaseD.delDate,   
            tr_purchaseD.jumlah,   
            tr_purchaseD.jumlah2,   
            tr_purchaseH.cur_code,          
            tr_purchaseH.Po_date,   
            tr_purchaseH.no_ref,   
            tr_purchaseD.SatQty,   
            tr_purchaseH.remark,   
            tr_purchaseH.AppBy,   
            tr_purchaseH.etd,   
            tr_purchaseH.OrdBy,   
            tr_purchaseH.FreBy,   
            tr_purchaseH.JPPN,   
            tr_purchaseH.tot_amount,  
            tr_purchaseH.deliv_address, 
            tr_purchaseH.Net,   
            tr_purchaseH.PDisc,   
            (select wh_name from ms_warehouse where wh_code=tr_purchaseH.wh_code) as wh_name,
            ms_company.company_name,   
            ms_company.address1,   
            tr_purchaseH.etaWh as etaWh_H,  
            tr_purchaseD.etaWh,
            tr_purchaseH.ShipModeEtaWh,   
            tr_purchaseH.Freight,   
            tr_purchaseH.DP,   
            tr_purchaseH.JTempo,   
            tr_purchaseH.pay_code,   
            tr_purchaseH.ppn,   
            tr_purchaseH.OTax,   
            tr_purchaseH.JOTax,   
            tr_purchaseH.Jpph,  
            tr_purchaseH.plantcode, 
            tr_purchaseH.priority_code,   
            tr_purchaseH.ShipModeEtd, 
            tr_purchaseH.tsendEmail,
            tr_purchaseH.LastAppvDate,
			(DATEDIFF(day, tr_purchaseH.Po_date, tr_purchaseD.etaWh)) AS TdayEtaWh,
            IsNull(ms_product.koref,tr_purchaseD.Prod_code)  as Prod_code,
            IsNull(ms_product.spec,ms_product.spec)  as spec,   
            IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
            FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.ppn),'') as PPN_Name,    
            IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
            FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.OTAX),'') as PPH_Name,
            IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
            FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.pph),'') as otax2_Name,   
            isnull(tr_purchaseH.attname,'') as attname ,
            IsNull(ms_supplier.address1,'') as suppaddress,   
            IsNull(ms_supplier.cityName,'') as cityName,   
            IsNull(ms_supplier.contact1,'') as contact1,   
            IsNull(ms_supplier.phone,'') as phone,   
            IsNull(ms_supplier.fax,'') as fax,
            IsNull(ms_supplier.contact2,'') as contact2,
            IsNull(ms_supplier.hp1,'') as hp1,
            IsNull(ms_supplier.hp2,'') as hp2,
            IsNull(ms_supplier.email,'') as email,
            appby_jab AS appby_txt,
            ordby_jab AS ordby_txt,
            freby_jab AS freby_txt,
            CASE tr_purchaseD.twarranty WHEN '1' THEN 'Warranty' ELSE '' END as twarranty
        FROM tr_purchaseD,   
            tr_purchaseH,   
            ms_supplier,   
            ms_company,   
            ms_product  
        WHERE tr_purchaseH.po_code = tr_purchaseD.po_code and  
            tr_purchaseH.vendor_code = ms_supplier.supplier_code  and  
            tr_purchaseD.Prod_code = ms_product.prod_code  and  
            --tr_purchaseD.po_code = :arg_pur_code AND
            tr_purchaseD.tapproved <> 2 AND " .
            $where . "
        ORDER BY tr_purchaseD.nomer ASC";

        $builder = $this->db->query($qum);
        return $builder;
    }

    public function check_po_type($po_number)
    {
        $select = "
			a.po_code,
            a.no_ref,
            a.doc_type,
            a.Printed,
            b.unit_code
		";
        $builder = $this->db->table('tr_purchaseH a')
            ->select($select)
            ->join('tr_purchase_reqH b', 'b.pr_code = a.no_ref', 'left')
            ->where('a.po_code', $po_number);

        return $builder;
    }

    public function show_po_asset_with_appv($po_number, $printed)
    {
        /* $qu = "EXEC uSP_0302_SHB_068D " . $po_number . "," . $printed; */

        $qu2 = "
        SELECT tr_purchaseH.po_code,   
			tr_purchaseH.vendor_code,   
			tr_purchaseH.vendor_name,   
			tr_purchaseH.KoExp,   
			tr_purchaseD.nomer,   
			tr_purchaseD.qty,   
			tr_purchaseD.harga2,   
			tr_purchaseD.Disc,   
			tr_purchaseD.delDate,   
			tr_purchaseD.jumlah,   
			tr_purchaseD.jumlah2,   
			tr_purchaseH.cur_code,          
			tr_purchaseH.Po_date,   
			tr_purchaseH.no_ref,   
			tr_purchaseD.SatQty,   
			tr_purchaseH.remark,   
			tr_purchaseH.AppBy,   
			tr_purchaseH.etd,   
			tr_purchaseH.OrdBy,   
			tr_purchaseH.FreBy,   
			tr_purchaseH.JPPN,   
			tr_purchaseH.tot_amount,  
			tr_purchaseH.deliv_address, 
			tr_purchaseH.Net,   
			tr_purchaseH.PDisc,   
			(select wh_name from ms_warehouse where wh_code=tr_purchaseH.wh_code) as wh_name,
			ms_company.company_name,   
			ms_company.address1,   
			tr_purchaseH.etaWh as etaWh_H,   
			tr_purchaseD.etaWh,
			tr_purchaseH.ShipModeEtaWh,   
			tr_purchaseH.Freight,   
			tr_purchaseH.DP,   
			tr_purchaseH.JTempo,   
			tr_purchaseH.pay_code,   
			tr_purchaseH.ppn,   
			tr_purchaseH.OTax,   
			tr_purchaseH.JOTax,   
			tr_purchaseH.Jpph,  
			tr_purchaseH.plantcode, 
			tr_purchaseH.priority_code,   
			tr_purchaseH.ShipModeEtd,
			tr_purchaseH.LastAppvDate,
			(DATEDIFF(day, tr_purchaseH.Po_date, tr_purchaseD.etaWh)) AS TdayEtaWh,
			IsNull(ms_product.koref,tr_purchaseD.Prod_code)  as Prod_code,
			IsNull(ms_product.NmRef,tr_purchaseD.spec)  as spec,	 	
			IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'') FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.ppn),'') as PPN_Name,    
			IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'') FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.OTAX),'') as PPH_Name,
			IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'') FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.pph),'') as otax2_Name,			
			isnull(tr_purchaseH.attname,'') as attname ,
			IsNull(ms_supplier.address1,'') as suppaddress,   
			IsNull(ms_supplier.cityName,'') as cityName,   
			IsNull(ms_supplier.contact1,'') as contact1,   
			IsNull(ms_supplier.phone,'') as phone,   
			IsNull(ms_supplier.fax,'') as fax,
			IsNull(ms_supplier.contact2,'') as contact2,
			IsNull(ms_supplier.hp1,'') as hp1,
			IsNull(ms_supplier.hp2,'') as hp2,
			IsNull(ms_supplier.email,'') as email," .
            ((int) $printed + 1) . " AS printed,
			appby_jab AS appby_txt,
			ordby_jab AS ordby_txt,
			freby_jab AS freby_txt,
			CASE tr_purchaseD.twarranty WHEN '1' THEN 'Warranty' ELSE '' END as twarranty,
			tr_purchaseh.asset_id
        FROM tr_purchaseD,   
			tr_purchaseH,   
			ms_supplier,   
			ms_company,   
			ms_product  
        WHERE tr_purchaseH.po_code = tr_purchaseD.po_code 
        AND tr_purchaseH.vendor_code = ms_supplier.supplier_code
        AND tr_purchaseD.Prod_code = ms_product.prod_code 
        AND tr_purchaseD.po_code = '" . $po_number . "'
        AND tr_purchaseD.tapproved <> 2";

        $builder = $this->db->query($qu2);
        return $builder;
    }

    public function show_po_001($po_number, $printed)
    {
        /* $qu = "EXEC qSP_MAI_0001 " . $po_code . "," . $printed;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $query = $this->herp->query($qu);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $query->getResultArray();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $query = $query->resultArray;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                return $query; */

        $qum = "
        SELECT tr_purchaseH.po_code,
            tr_purchaseH.vendor_code,   
            tr_purchaseH.vendor_name,   
            tr_purchaseH.KoExp,   
            tr_purchaseD.nomer,   
            tr_purchaseD.qty,   
            tr_purchaseD.harga,   
            tr_purchaseD.Disc,   
            tr_purchaseD.delDate,   
            tr_purchaseD.jumlah,   
            tr_purchaseD.jumlah2,   
            tr_purchaseH.cur_code,          
            tr_purchaseH.Po_date,   
            tr_purchaseH.no_ref,   
            tr_purchaseD.SatQty,   
            tr_purchaseH.remark,   
            tr_purchaseH.AppBy,   
            tr_purchaseH.etd,   
            tr_purchaseH.OrdBy,   
            tr_purchaseH.FreBy,   
            tr_purchaseH.JPPN,   
            tr_purchaseH.tot_amount,  
            tr_purchaseH.deliv_address, 
            tr_purchaseH.Net,   
            tr_purchaseH.PDisc,   
            (select wh_name from ms_warehouse where wh_code=tr_purchaseH.wh_code) as wh_name,
            ms_company.company_name,   
            ms_company.address1,   
            tr_purchaseH.etaWh as etaWh_H,  
            tr_purchaseD.etaWh,
            tr_purchaseH.ShipModeEtaWh,   
            tr_purchaseH.Freight,   
            tr_purchaseH.DP,   
            tr_purchaseH.JTempo,   
            tr_purchaseH.pay_code,   
            tr_purchaseH.ppn,   
            tr_purchaseH.OTax,   
            tr_purchaseH.JOTax,   
            tr_purchaseH.Jpph,  
            tr_purchaseH.plantcode, 
            tr_purchaseH.priority_code,   
            tr_purchaseH.ShipModeEtd, 
            tr_purchaseH.tsendEmail,
            tr_purchaseH.LastAppvDate,
			(DATEDIFF(day, tr_purchaseH.Po_date, tr_purchaseD.etaWh)) AS TdayEtaWh,
            IsNull(ms_product.koref,tr_purchaseD.Prod_code)  as Prod_code,
            IsNull(ms_product.spec,ms_product.spec)  as spec,   
            IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
            FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.ppn),'') as PPN_Name,    
            IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
            FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.OTAX),'') as PPH_Name,
            IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
            FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.pph),'') as otax2_Name,   
            isnull(tr_purchaseH.attname,'') as attname ,
            IsNull(ms_supplier.address1,'') as suppaddress,   
            IsNull(ms_supplier.cityName,'') as cityName,   
            IsNull(ms_supplier.contact1,'') as contact1,   
            IsNull(ms_supplier.phone,'') as phone,   
            IsNull(ms_supplier.fax,'') as fax,
            IsNull(ms_supplier.contact2,'') as contact2,
            IsNull(ms_supplier.hp1,'') as hp1,
            IsNull(ms_supplier.hp2,'') as hp2,
            IsNull(ms_supplier.email,'') as email," .
            ((int) $printed + 1) . " AS printed,
            appby_jab AS appby_txt,
            ordby_jab AS ordby_txt,
            freby_jab AS freby_txt,
            CASE tr_purchaseD.twarranty WHEN '1' THEN 'Warranty' ELSE '' END as twarranty
        FROM tr_purchaseD,   
            tr_purchaseH,   
            ms_supplier,   
            ms_company,   
            ms_product  
        WHERE tr_purchaseH.po_code = tr_purchaseD.po_code and  
            tr_purchaseH.vendor_code = ms_supplier.supplier_code  and  
            tr_purchaseD.Prod_code = ms_product.prod_code  and  
            --tr_purchaseD.po_code = :arg_pur_code AND
            tr_purchaseD.tapproved <> 2 AND
            tr_purchaseH.po_code = '" . $po_number . "'
        ORDER BY tr_purchaseD.nomer ASC";

        $builder = $this->db->query($qum);
        return $builder;
    }

    public function show_po_002($po_number, $printed)
    {
        $qum = "
		SELECT tr_purchaseH.po_code,  
			tr_purchaseH.vendor_code,   
			tr_purchaseH.vendor_name,   
			tr_purchaseH.KoExp,   
			tr_purchaseD.nomer,   
			tr_purchaseD.qty,   
			tr_purchaseD.harga,   
			tr_purchaseD.Disc,   
			tr_purchaseD.jumlah,   
			tr_purchaseD.jumlah2,   
			tr_purchaseH.cur_code,          
			tr_purchaseH.Po_date,   
			tr_purchaseH.no_ref,   
			tr_purchaseD.SatQty,  
			tr_purchaseD.delDate,   
			tr_purchaseH.remark,   
			tr_purchaseH.AppBy,   
			tr_purchaseH.etd,   
			tr_purchaseH.OrdBy,   
			tr_purchaseH.FreBy,   
			tr_purchaseH.JPPN,   
			tr_purchaseH.tot_amount,   
			tr_purchaseH.Net,   
			tr_purchaseH.PDisc,   
			ms_company.company_name,   
			ms_company.address1,   
			tr_purchaseH.etaWh as etaWh_H,  
			tr_purchaseD.etaWh,  
			tr_purchaseH.ShipModeEtaWh,   
			tr_purchaseH.deliv_address,   
			tr_purchaseH.Freight,   
			tr_purchaseH.DP,   
			tr_purchaseH.JTempo,   
			tr_purchaseH.pay_code,   
			tr_purchaseH.ppn,   
			tr_purchaseH.OTax,   
			tr_purchaseH.JOTax,   
			tr_purchaseH.Jpph,  
			tr_purchaseH.plantcode, 
			tr_purchaseH.priority_code, 
			tr_purchaseH.woordertype, 			  
			tr_purchaseH.ShipModeEtd,
			tr_purchaseH.LastAppvDate,
			(DATEDIFF(day, tr_purchaseH.Po_date, tr_purchaseD.etaWh)) AS TdayEtaWh,			
			IsNull(ms_product.koref,tr_purchaseD.Prod_code)  as Prod_code,
			IsNull(ms_product.NmRef,ms_product.spec)  as spec,	  
			IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
			FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.ppn),'') as PPN_Name,    
			IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
			FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.OTAX),'') as PPH_Name,
			IsNull((SELECT IsNull(MS_TAX.TAX_NAME  ,'')
			FROM MS_TAX WHERE MS_TAX.TAX_CODE =tr_purchaseH.pph),'') as otax2_Name,
			(SELECT tr_purchase_reqH.unit_code FROM  tr_purchase_reqH WHERE tr_purchase_reqH.pr_code =  tr_purchaseH.no_ref) as unit_code,
			(SELECT  tr_purchase_reqH.model_no FROM  tr_purchase_reqH WHERE tr_purchase_reqH.pr_code =  tr_purchaseH.no_ref) as model_no,
			(SELECT  tr_purchase_reqH.time_reading FROM  tr_purchase_reqH WHERE tr_purchase_reqH.pr_code =  tr_purchaseH.no_ref) as time_reading,
			(SELECT key_no FROM ms_unit where unit_code =(SELECT tr_purchase_reqH.unit_code FROM  tr_purchase_reqH WHERE tr_purchase_reqH.pr_code =  tr_purchaseH.no_ref) ) as key_no,
			(SELECT engine_no FROM ms_unit where unit_code =(SELECT tr_purchase_reqH.unit_code FROM  tr_purchase_reqH WHERE tr_purchase_reqH.pr_code =  tr_purchaseH.no_ref) ) as engine_no,
			isnull(tr_purchaseH.attname,'') as attname ,
			IsNull(ms_supplier.address1,'') as suppaddress,   
			IsNull(ms_supplier.cityName,'') as cityName,   
			IsNull(ms_supplier.contact1,'') as contact1,   
			IsNull(ms_supplier.phone,'') as phone,   
			IsNull(ms_supplier.fax,'') as fax,
			IsNull(ms_supplier.contact2,'') as contact2,
			IsNull(ms_supplier.hp1,'') as hp1,
			IsNull(ms_supplier.hp2,'') as hp2,
			IsNull(ms_supplier.email,'') as email," .
            ((int) $printed + 1) . " AS printed,			
			appby_jab AS appby_txt,
			ordby_jab AS ordby_txt,
			freby_jab AS freby_txt,
			CASE tr_purchaseD.twarranty WHEN '1' THEN 'Warranty' ELSE '' END as twarranty,
			(select wh_name from ms_warehouse where wh_code=tr_purchaseH.wh_code) as wh_name,
			(SELECT brand_name FROM ms_brand where  brand_code=ms_product.brand_code) as brand_name
		FROM tr_purchaseD,   
			tr_purchaseH,   
			ms_supplier,   
			ms_company,   
			ms_product  
		WHERE tr_purchaseH.po_code = tr_purchaseD.po_code and  
			tr_purchaseH.vendor_code = ms_supplier.supplier_code  and  
			tr_purchaseD.Prod_code = ms_product.prod_code  and  
			--tr_purchaseD.po_code = :arg_pur_code AND
			tr_purchaseD.tapproved <> 2 AND
			tr_purchaseH.po_code = '" . $po_number . "'
		ORDER BY tr_purchaseD.nomer ASC";

        $builder = $this->db->query($qum);
        return $builder;
    }

    public function get_po_ready_for_exec_pomailer($po_number)
    {
        $builder = $this->db->table('tr_purchaseH a')
            ->select('
            a.po_code,
			a.po_date,
			a.etaWh,
            a.no_ref,
            a.doc_type,
            a.vendor_code,
            a.tsendEmail,
            a.Printed,
            a.Tprint,
            a.wh_code,
            a.LastAppvDate,
            a.plantcode,
            b.email,
            b.email2,
            c.unit_code,
            d.lastupdate,
            e.email AS email_supplier_site,
            CONVERT(DATE, d.lastupdate) AS lastupdate_date,
			(DATEDIFF(day, a.po_date, a.etaWh)) AS TdayEtaWh
        ');

        $builder->join('ms_supplier b', 'b.supplier_code = a.vendor_code', 'left')
            ->join('tr_purchase_reqH c', 'c.pr_code = a.no_ref', 'left')
            ->join('tr_purchaseE d', 'd.po_code = a.po_code', 'left')
            ->join('ms_supplier_email e', 'e.supplier_code = a.vendor_code AND e.region_code = a.plantcode', 'left');

        $builder->where('a.TotAppv > 0')
            ->where('a.TotAppv = a.LastAppv')
            ->where('a.status_pur != 4')
            ->where('a.TstAppv != 2')
            ->where('a.Net != 0')
            ->where('b.tEmail', 1)
            ->where('b.email IS NOT NULL')
            ->where('(SELECT SUM(jumlah2) FROM tr_purchased e WHERE e.po_code = a.po_code) > 0');

        if ($po_number) {
            $builder->where('a.po_code', $po_number);
        } else {
            $builder->where('a.Printed', 0)
                ->where('a.Tprint', 0)
                ->where('a.status_pur != 3')
                ->where('a.tsendEmail', 1)
                ->where('CONVERT(DATE, a.LastAppvDate)', date('Y-m-d'));
        }

        return $builder;
    }

    public function get_po_ready_for_exec_inBackdate($date)
    {
        $now = date('Y-m-d');

        $builder = $this->db->table('tr_purchaseH a')
            ->select('
            a.po_code,
            a.no_ref,
            a.doc_type,
            a.vendor_code,
            a.tsendEmail,
            a.Printed,
            a.Tprint,
            a.wh_code,
            a.LastAppvDate,
            a.plantcode,
            b.email,
            b.email2,
            c.unit_code,
            d.lastupdate,
            e.email AS email_supplier_site,
            CONVERT(DATE, d.lastupdate) AS lastupdate_date
        ');

        $builder->join('ms_supplier b', 'b.supplier_code = a.vendor_code', 'left')
            ->join('tr_purchase_reqH c', 'c.pr_code = a.no_ref', 'left')
            ->join('tr_purchaseE d', 'd.po_code = a.po_code', 'left')
            ->join('ms_supplier_email e', 'e.supplier_code = a.vendor_code AND e.region_code = a.plantcode', 'left');

        $builder->where('a.TotAppv > 0')
            ->where('a.TotAppv = a.LastAppv')
            ->where('a.TstAppv != 2')
            ->where('a.Printed', 0)
            ->where('a.Tprint', 0)
            ->where('a.tsendEmail', 1)
            ->where('a.Net != 0')
            ->where('b.tEmail', 1)
            ->where('b.email IS NOT NULL')
            ->where('CONVERT(DATE, a.LastAppvDate) >= ', $date)
            ->where('CONVERT(DATE, a.LastAppvDate) < ', $now)
            ->where('(SELECT SUM(jumlah2) FROM tr_purchased e WHERE e.po_code = a.po_code) > 0');

        return $builder;
    }

    public function get_po_ready_for_exec_inBackdate_by_po($po_number)
    {
        $builder = $this->db->table('tr_purchaseH a')
            ->select('
            a.po_code,
            a.no_ref,
            a.doc_type,
            a.vendor_code,
            a.tsendEmail,
            a.Printed,
            a.Tprint,
            a.wh_code,
            a.LastAppvDate,
            a.plantcode,
            b.email,
            b.email2,
            c.unit_code,
            d.lastupdate,
            e.email AS email_supplier_site,
            CONVERT(DATE, d.lastupdate) AS lastupdate_date
        ');

        $builder->join('ms_supplier b', 'b.supplier_code = a.vendor_code', 'left')
            ->join('tr_purchase_reqH c', 'c.pr_code = a.no_ref', 'left')
            ->join('tr_purchaseE d', 'd.po_code = a.po_code', 'left')
            ->join('ms_supplier_email e', 'e.supplier_code = a.vendor_code AND e.region_code = a.plantcode', 'left');

        // $builder->where('a.TotAppv > 0')
        // 	->where('a.TotAppv = a.LastAppv')
        // 	->where('a.TstAppv != 2')
        // 	->where('a.Printed', 0)
        // 	->where('a.Tprint', 0)
        // 	->where('a.tsendEmail', 1)
        // 	->where('a.Net != 0')
        // 	->where('b.tEmail', 1)
        // 	->where('b.email IS NOT NULL')
        // 	->where('CONVERT(DATE, a.LastAppvDate) >= ', $date)
        // 	->where('CONVERT(DATE, a.LastAppvDate) < ', $now)
        // 	->where('(SELECT SUM(jumlah2) FROM tr_purchased e WHERE e.po_code = a.po_code) > 0');

        $builder->where('a.TotAppv > 0')
            ->where('a.TotAppv = a.LastAppv')
            ->where('a.status_pur != 4')
            ->where('a.TstAppv != 2')
            ->where('a.Net != 0')
            ->where('b.tEmail', 1)
            ->where('b.email IS NOT NULL')
            ->where('(SELECT SUM(jumlah2) FROM tr_purchased e WHERE e.po_code = a.po_code) > 0')
            ->where('a.tsendEmail >= 1')
            ->where('a.po_code', $po_number);

        return $builder;
    }

    public function update_tsendEmail($po_number, $payload)
    {
        $query = $this->db
            ->table('tr_purchaseH')
            ->where('po_code', $po_number)
            ->update($payload);

        return $query;
    }

    public function update_po_printed($po_number, $payload)
    {
        $query = $this->db
            ->table('tr_purchaseH')
            ->where('po_code', $po_number)
            ->update($payload);

        return $query;
    }
}