<?php

namespace App\Hizb\Syshab\Builder;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\UmmuHelper;

use App\Hizb\Syshab\Models\EmployeeModel;

class EmployeeBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new UmmuHelper();
        $this->model = new EmployeeModel();
    }

    private function qbAlya()
    {
        $table = $this->model->getTable();
        // $allowedFields = $this->model->allowedFields;
        $selectFields2 = $this->model->selectFields2;

        $subquery = $this->db->table($table . ' a')
            ->select($selectFields2)
            ->join('H_A150 d', 'd.Kdjabat = a.Kdjabatan', 'left')
            ->join('ms_jobsite b', 'b.region_code = a.KdSite', 'left')
            ->join('H_A209 c', 'c.KdSec = d.KdSec', 'left')
            ->join('H_A160 e', 'e.KdLevel = a.kdlevel', 'left')
            ->join('H_A130 f', 'f.KdDepar = a.KdDepar', 'left')
            ->where('TglResign IS NULL');

        return $this->db->newQuery()->fromSubquery($subquery, 't');
    }

    public function show($id)
    {
        if ($this->qHelp->is_jsonVar() == true) {
            $Active = $this->request->getJsonVar('Active');
            $nik = $this->request->getJsonVar('nik');
            $site = $this->request->getJsonVar('site');
            $KdJabatan = $this->request->getJsonVar('KdJabatan');
            $where_by = $this->request->getJsonVar('where_by');
        } else {
            $Active = $this->request->getVar('Active');
            $nik = explode(",", $this->request->getVar('nik'));
            $site = explode(",", $this->request->getVar('site'));
            $KdJabatan = explode(",", $this->request->getVar('KdJabatan'));
            $where_by = explode(",", $this->request->getVar('where_by'));
        }

        $table = $this->model->getTable();
        $selectFields = $this->model->selectFields;
        $allowedFields = $this->model->allowedFields;

        // $builder = $this->db->table($table)
        //     ->select($selectFields);
        $builder = $this->qbAlya();
        // $builder = $this->db->newQuery()->fromSubquery($subquery, 't');
        // $builder->select('Nik,Nama');

        if ($where_by) {
            if (in_array('nik', $where_by)) {
                if (is_array($nik)) {
                    $builder->whereIn('Nik', $nik);
                } else {
                    $builder->where('Nik', $nik);
                }
            }

            if (in_array('site', $where_by)) {
                if (is_array($site)) {
                    $builder->whereIn('KdSite', $site);
                } else {
                    $builder->where('KdSite', $site);
                }
            }

            if (in_array('KdJabatan', $where_by)) {
                $builder->whereIn('KdJabatan', $KdJabatan);
            }
        } else {
            if ($nik) {
                if (is_array($nik)) {
                    $builder->whereIn('Nik', $nik);
                } else {
                    $builder->where('Nik', $nik);
                }
            }
        }

        if ($Active) {
            $builder->where('Active', 1);
        }

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["Nik", "Nama", "KdSite"],
            "company_id" => null
        ];

        $builder = $this->bHelp->conditions0($params);
        // $allowedFields = array_merge($allowedFields,["gedung_name"]);
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }

    public function show_by_nik($nik)
    {
        // $table = $this->model->getTable();
        // $selectFields2 = $this->model->selectFields2;
        // // $allowedFields = $this->model->allowedFields;

        // $builder = $this->db->table($table . ' a')
        //     ->select($selectFields2)
        //     ->join('H_A150 d', 'd.Kdjabat = a.Kdjabatan', 'left')
        //     ->join('ms_jobsite b', 'b.region_code = a.KdSite', 'left')
        //     ->join('H_A209 c', 'c.KdSec = d.KdSec', 'left')
        //     ->join('H_A160 e', 'e.KdLevel = a.kdlevel', 'left')
        //     ->join('H_A130 f', 'f.KdDepar = a.KdDepar', 'left')
        //     ->where('a.nik', $nik);

        // // INNER JOIN H_A130 ON H_A101.KdDepar = H_A130.KdDepar
        // // UPPER(H_A150.nmJabat) AS jabatanxx,
        // // INNER JOIN H_A160 ON H_A160.KdLevel=H_A101.kdlevel
        // // INNER JOIN H_A150 ON H_A150.Kdjabat = H_A101.Kdjabatan
        // // INNER JOIN H_A209 ON H_A209.KdSec = H_A150.KdSec	
        // // $params = [
        // //     "builder" => $builder,
        // //     "id" => $id,
        // //     "search_params" => ["Nik", "Nama"],
        // //     "company_id" => null
        // // ];

        // // $builder = $this->bHelp->conditions0($params);

        // // // $allowedFields = array_merge($allowedFields,["gedung_name"]);
        // // $builder = $this->qHelp->orderBy($builder, $allowedFields);

        $subquery = $this->qbAlya();
        $builder = $this->db->newQuery()->fromSubquery($subquery, 't')
            ->where('nik', $nik);

        return $builder;
    }

    public function show_from_sap()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://vhplnds4ap01.sap.hjs.com:8000/sap/dorbitt/karyawan?sap-client=210',
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic SENfQWxpOkluaXRpYWwxMjMhQCNIaWwwMDA5OTg4Nzc=',
                'Cookie: SAP_SESSIONID_DS4_110=F7ggppDfGUr6vhej1K-BZ9Q0SK1zrRHug5_lgCTyMco%3d; sap-usercontext=sap-client=110'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }

    public function show2()
    {
        // exec dbo.usp_0206_SHB_0001C N'All,AKP,ABR,AMO,AMA,BKN,BPM,BPU,BMI,BKA,GBA,GBU,GNS,HSM,HO,IBU,JBU,KTE,KVA,KIN,CNI,LNT,AMI,LOL,LUW,MAC,MLA,NBL,SRE,NPB,TCM,PCA,PTP,BPN,BJM,BKL,BBN,KEN,MND,PMT,TER,PWD,REI,PMU,SAH,SSA,SSC,STO,SCM,SRO,REM,TLS,TPN,TMA,PTC,TCN,VIC,WBN',N'1',N'0',N''

        // SELECT 
        //     H_A101.Nik,   
        //     UPPER(H_A101.Nama) AS Nama,   
        //     CASE H_A101.Gender
        //     WHEN 'P' THEN 'PEREMPUAN'
        //     WHEN 'L' THEN 'LAKI - LAKI' END AS Gender,   
        //     UPPER(H_A101.TmpLahir) AS TmpLahir,   
        //     H_A101.TglLahir, 	
        //     H_A101.NoHP,   	
        //     CASE H_A101.Agama WHEN '1' THEN 'ISLAM' 
        //     WHEN '2'THEN 'KATOLIK'
        //     WHEN '3'THEN 'PROTESTAN'
        //     WHEN '4'THEN 'HINDU'
        //     WHEN '5' THEN 'BUDDHA' END AS Agama,    
        //     CASE H_A101.StSipil WHEN 'A' THEN 'SINGLE'
        //     WHEN 'B' THEN 'KAWIN'
        //     WHEN 'C' THEN 'DUDA'
        //     WHEN 'D' THEN 'JANDA' 
        //     END AS StSipil,   
        //     H_A101.StMarital,   
        //     H_A101.GolDarah,   
        //     H_A101.NoKTP,   	
        //     H_A101.AlamatID,	         
        //     H_A160.NmLevel,   
        //     H_A101.KdSubLevel,   
        //     H_A101.TglMasuk,   
        //     H_A101.tglEfektif, 	
        //     CASE H_A101.EmpType
        //     WHEN '1' THEN 'PERMANEN'
        //     WHEN '2' THEN 'KONTRAK'
        //     WHEN '3' THEN 'PERCOBAAN'
        //     WHEN '4' THEN 'TRAINEE' END AS EmpType ,   		   
        //     H_A101.KotaID,   
        //     H_A101.PropinsiID,   		    
        //     UPPER(H_A140.NmDivisi) AS NmDivisi,   
        //     UPPER(ms_jobsite.region_name) AS region_name,   
        //     UPPER(H_A110.NmCompany) AS NmCompany,
        //     UPPER(H_A130.NmDepar) AS NmDepar,
        //     UPPER(H_A150.nmJabat) AS jabatanxx,		
        //     CASE H_A160.tSatus WHEN 'ST' THEN 'STAFF' ELSE 'NON STAFF' END group_karyawanxx,
        //     UPPER(H_A352.NmLokasi) AS NmLokasi,		
        //     UPPER(contactperson) AS contactperson,
        //     UPPER(hubperson) AS hubperson,
        //     telpperson,
        //     UPPER (H_A190.NmPOH)  AS  NmPOH,
        //     tglawalkontrak,
        //     tglawaltetap,
        //     tglakhirkontrak,
        //     DATEDIFF(MONTH,TglLahir,GETDATE()) AS umur,
        //     DATEDIFF(MONTH,TglMasuk,GETDATE()) AS masa_kerja,
        //     H_A103.NPWP,
        //     H_A103.TglNPWP,
        //     (SELECT H_A106.NmBank FROM H_A106 WHERE KdBank=H_A103.KdBank) AS NmBank,		
        //     cabbank,
        //     norekening,
        //     UPPER(nmrekening) AS nmrekening,
        //     UPPER(H_A209.NmSec) AS NmSec,
        //     (SELECT  UPPER(LvlName)
        //     FROM H_A161 WHERE H_A161.LvlStudy=(SELECT MAX(LvlStudy) FROM H_A105 WHERE H_A105.Nik=H_A101.Nik)) AS LvlStudy,
        //     H_A101.KdSite
        // FROM H_A101 
        //     INNER JOIN H_A130 ON H_A101.KdDepar = H_A130.KdDepar
        //     INNER JOIN H_A150 ON H_A150.Kdjabat = H_A101.Kdjabatan
        //     INNER JOIN H_A140 ON H_A140.KdDivisi = H_A150.KdDivisi
        //     INNER JOIN ms_jobsite ON H_A101.KdSite = ms_jobsite.region_code
        //     INNER JOIN H_A110 ON H_A110.KdCompany = H_A101.KdCompany
        //     INNER JOIN H_A160 ON H_A160.KdLevel=H_A101.kdlevel
        //     INNER JOIN H_A352 ON H_A352.KdLok=H_A101.kdlok
        //     INNER JOIN H_A190 ON H_A190.KdPOH=H_A101.pointhire
        //     INNER JOIN H_A103 ON H_A103.Nik=H_A101.Nik	
        //     INNER JOIN H_A209 ON H_A209.KdSec = H_A150.KdSec	
        // WHERE H_A101.StEdit <> '2' AND H_A101.KdSite IN (SELECT data FROM dbo.MyArray(@argUser)) AND
        //     (( H_A101.active =@arg_active1 ) OR ( H_A101.active =@arg_active2 ))
    }
}