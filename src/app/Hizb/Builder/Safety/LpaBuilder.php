<?php

namespace App\Hizb\Builder\Safety;

use Sparkhizb\Helpers\IdentityHelper;
use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\UmmuHazardReport;
use Sparkhizb\UmmuInvestigation;

use App\Hizb\Models\Safety\LpahModel;
use App\Hizb\Models\Safety\LpadUnitModel;
use App\Hizb\Models\Safety\LpadOrangModel;
use App\Hizb\Models\Safety\LpadFotoModel;
use App\Hizb\Models\Safety\LpadKerusakanModel;
use App\Hizb\Models\Safety\LpadDivisiModel;
use App\Hizb\Models\Safety\LpaIcdMsModel;
use App\Hizb\Models\Safety\LpaAppvModel;
use App\Hizb\Models\Safety\LpaAppvTrxModel;
use App\Hizb\Models\Safety\LpaAppvMatrixModel;

use App\Hizb\Models\DocumentNumbersModel;
use App\Hizb\Models\UsersModel;
use App\Hizb\Syshab\Builder\EmployeeBuilder;


class LpaBuilder
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
        $this->ummu = new UmmuInvestigation();
        $this->reqH = new RequestHelper();

        $this->model = new LpahModel();
        $this->mOrang = new LpadOrangModel();
        $this->mFoto = new LpadFotoModel();
        $this->mKerusakan = new LpadKerusakanModel();
        $this->mUnit = new LpadUnitModel();
        $this->mDoc = new DocumentNumbersModel();
        $this->mDivisi = new LpadDivisiModel();
        $this->mIcdms = new LpaIcdMsModel();

        $this->mAppv = new LpaAppvModel();
        $this->mAppvtrx = new LpaAppvTrxModel();
        $this->mAppvmatrix = new LpaAppvMatrixModel();

        $this->mUser = new UsersModel();
        $this->qbEmpl = new EmployeeBuilder();
    }

    public function sjQuery()
    {
        $database = (getenv('DBGroup')) ? getenv('DBGroup') : $this->mUser->database;
        $table = $this->model->table;
        $tbUser = $this->mUser->table;
        $tbAppv = $this->mAppv->table;

        $selects = $this->model->selects;
        $allowedFields = $this->model->allowedFields;

        $sjQuery = $this->iescm->table($database . '.' . $table . ' a')
            ->select($selects)
            ->join($database . '.' . $tbUser . ' b', 'b.account_id = a.created_by', 'left')
            ->join($database . '.' . $tbAppv . ' c', 'c.lpa_id = a.id', 'left')

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

        return $this->iescm->newQuery()->fromSubquery($sjQuery, 't');
    }

    public function show($id = null)
    {

        $allowedFields = $this->model->allowedFields;
        $where = $this->request->getJsonVar('where');

        $builder = $this->sjQuery();

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["nomor_dokumen", "site", "hari_kejadian"],
            "company_id" => null,
            "account_id" => null
        ];

        $builder = $this->bHelp->conditions($params);
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }

    public function show_for_approval($id = null, $builder, $sequence)
    {
        $allowedFields = $this->model->allowedFields;

        $builder->where("next_appv_sequence <= total_appv");
        $builder->whereIn("next_appv_sequence", array_unique($sequence));

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => [],
            "company_id" => null,
            "account_id" => null
        ];

        $builder = $this->bHelp->conditions($params);
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }

    public function show_by_number($number)
    {

        $builder = $this->sjQuery();
        $builder->where('nomor_dokumen', $number);

        // $params = [
        //     "builder" => $builder,
        //     "id" => null,
        //     "search_params" => [],
        //     "company_id" => null,
        //     "account_id" => null
        // ];

        // $builder = $this->bHelp->conditions($params);
        // // $builder = $this->qHelp->orderBy($builder, $allowedFields);
        return $builder;
    }

    public function show_d_orang($h_id)
    {
        return $this->mOrang
            ->where('lpa_id', $h_id)
            ->where('deleted_at IS NULL')
            ->get()->getResult();
    }

    public function show_d_foto($h_id)
    {
        return $this->mFoto
            ->where('lpa_id', $h_id)
            ->where('deleted_at IS NULL')
            ->get()->getResult();
    }

    public function show_d_kerusakan($h_id)
    {
        return $this->mKerusakan
            ->where('lpa_id', $h_id)
            ->where('deleted_at IS NULL')
            ->get()->getResult();
    }

    public function show_d_unit($h_id)
    {
        return $this->mUnit
            ->where('lpa_id', $h_id)
            ->where('deleted_at IS NULL')
            ->get()->getResult();
    }

    public function show_d_divisi($h_id)
    {
        return $this->mDivisi
            ->where('lpa_id', $h_id)
            ->where('deleted_at IS NULL')
            ->get()->getResult();
    }

    public function show_new($nik, $site)
    {
        $builder = $this->mDoc
            ->where('created_by', $this->identity->id)
            ->where('number IS NULL')
            ->where('used_at IS NULL')
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'))
            ->first();

        return $builder;
    }

    public function show_number_unused()
    {
        $builder = $this->mDoc
            ->where('created_by', $this->identity->account_id())
            ->where('used_at IS NULL')
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'));
        // ->first();
        // ->get()
        // ->getFirstRow();

        return $builder;
    }

    public function getLastRow()
    {
        $builder = $this->iescm->table($this->mDoc->table)
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'))
            ->get()
            ->getLastRow();

        return $builder;
    }

    public function show_number_isValid($number)
    {
        $builder = $this->mDoc
            ->where('docat_id', 2)
            ->where('number', $number)
            ->where('created_by', $this->identity->account_id())
            ->where('used_at IS NULL')
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'));

        return $builder;
    }



    /**
     * INSERT
     */
    public function create_id($payload)
    {
        return $this->mDoc->insert($payload);
    }

    public function insert_number($payload)
    {
        return $this->mDoc->insert($payload);
    }

    public function insert($payload)
    {
        $payload = $this->identity->insert($payload);
        $builder = $this->model->insert($payload);

        return $builder;
    }

    public function insert_unit($payload)
    {
        $payload = $this->identity->insert($payload);
        $builder = $this->mUnit->insert($payload);

        return $builder;
    }

    public function insert_foto($payload)
    {
        $payload = $this->identity->insert($payload);
        $builder = $this->mFoto->insert($payload);

        return $builder;
    }

    public function insert_divisiTerkait($payload)
    {
        $payload = $this->identity->insert($payload);
        $builder = $this->mDivisi->insert($payload);

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

    public function used_number($number)
    {
        return $this->mDoc
            ->where('number', $number)
            ->where('created_by', $this->identity->account_id())
            ->set('used_at', date('Y-m-d H:i:s'))
            ->update();
    }

    public function joinData($rows)
    {
        if ($rows) {
            if ($this->identity->company_id() == 4) {
                $mSite = new \App\Hizb\Syshab\Models\SiteProjectModel();
                $sites = $mSite->findAll();
                if ($sites) {
                    foreach ($rows as $key => $value) {
                        $kode = $value->site;
                        $region_name = '';
                        foreach ($sites as $key2 => $value2) {
                            if ($value2['region_code'] == $kode) {
                                $region_name = $value2['region_name'];
                            }
                        }
                        $rows[$key]->site_name = $region_name;
                    }
                }

                // $mDivisi = new \App\Hizb\Syshab\Models\DivisiModel();
                // $divisi = $mDivisi->findAll();
                // if ($divisi) {
                //     foreach ($rows as $key => $value) {
                //         $kode = $value->divisi;
                //         $NmDivisi = '';
                //         foreach ($divisi as $key2 => $value2) {
                //             if ($value2['KdDivisi'] == $kode) {
                //                 $NmDivisi = $value2['NmDivisi'];
                //             }
                //         }
                //         $rows[$key]->divisi_name = $NmDivisi;
                //     }
                // }

                // $mDepartemen = new \App\Hizb\Syshab\Models\DepartemenModel();
                // $departemen = $mDepartemen->findAll();
                // if ($divisi) {
                //     foreach ($rows as $key => $value) {
                //         $kode = $value->departemen;
                //         $NmDepar = '';
                //         foreach ($departemen as $key2 => $value2) {
                //             if ($value2['KdDepar'] == $kode) {
                //                 $NmDepar = $value2['NmDepar'];
                //             }
                //         }
                //         $rows[$key]->departemen_name = $NmDepar;
                //     }
                // }

                // $mSeksi = new \App\Hizb\Syshab\Models\SeksiModel();
                // $seksi = $mSeksi->findAll();
                // if ($divisi) {
                //     foreach ($rows as $key => $value) {
                //         $kode = $value->section;
                //         $NmSec = '';
                //         foreach ($seksi as $key2 => $value2) {
                //             if ($value2['KdSec'] == $kode) {
                //                 $NmSec = $value2['NmSec'];
                //             }
                //         }
                //         $rows[$key]->section_name = $NmSec;
                //     }
                // }
            }
        }

        return $rows;
    }

    public function joinEmployee($rows)
    {
        $join_syshab = $this->request->getJsonVar('join_syshab');
        if ($rows) {
            if ($this->identity->company_id() == 4) {
                $nik = [];
                foreach ($rows as $key => $value) {
                    $nik[] = $value->nik;
                }
                if (in_array("employee", $join_syshab)) {
                    $builder = new \App\Hizb\Syshab\Models\EmployeeModel();
                    $table = $builder->getTable();
                    $query = $this->db->table($table . ' a')
                        ->select("a.Nik,c.NmSec,f.NmDepar")
                        ->join('H_A150 d', 'd.Kdjabat = a.Kdjabatan', 'left')
                        ->join('H_A209 c', 'c.KdSec = d.KdSec', 'left')
                        ->join('H_A130 f', 'f.KdDepar = a.KdDepar', 'left')
                        ->whereIn('Nik', $nik)->get()->getResult();
                    if ($query) {
                        foreach ($rows as $key => $value) {
                            $nik = $value->nik;
                            foreach ($query as $key2 => $value2) {
                                if ($value2->Nik == $nik) {
                                    $NmSec = $value2->NmSec;
                                    $NmDepar = $value2->NmDepar;
                                }
                            }
                            $rows[$key]->NmSec = $NmSec;
                            $rows[$key]->NmDepar = $NmDepar;
                        }
                    }
                }
            }
        }

        return $rows;
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


    /**
     * Detail ORANG TERLIBAT*/
    public function insert_orangTerlibat($payload)
    {
        $payload = $this->identity->insert($payload);
        $builder = $this->mOrang->insert($payload);

        return $builder;
    }

    public function update_orangTerlibat($id, $payload)
    {
        return $this->bUpdate_detail($id, $payload, $this->mOrang);
    }

    public function delete_orang_terlibat($id)
    {
        return $this->bHelp->delete($id, $this->mOrang);
    }
    /**
     * End Detail ORANG TERLIBAT*/



    /**
     * Detail KERUSAKAN*/
    public function insert_kerusakan($payload)
    {
        $payload = $this->identity->insert($payload);
        $builder = $this->mKerusakan->insert($payload);

        return $builder;
    }

    public function update_kerusakan($id, $payload)
    {
        return $this->bUpdate_detail($id, $payload, $this->mKerusakan);
    }

    public function delete_kerusakan($id)
    {
        return $this->bHelp->delete($id, $this->mKerusakan);
    }
    /**
     * End Detail KERUSAKAN*/



    /**
     * Detail DIVISI TERKAIT*/
    public function insert_divisi_terkait($payload)
    {
        $payload = $this->identity->insert($payload);
        $builder = $this->mDivisi->insert($payload);

        return $builder;
    }

    public function update_divisi_terkait($id, $payload)
    {
        return $this->bUpdate_detail($id, $payload, $this->mDivisi);
    }

    public function delete_divisi_terkait($id)
    {
        return $this->bHelp->delete($id, $this->mDivisi);
    }
    /**
     * End Detail DIVISI TERKAIT*/



    /**
     * Detail DIVISI TERKAIT*/
    public function insert_d_foto($payload)
    {
        $payload = $this->identity->insert($payload);
        $builder = $this->mFoto->insert($payload);

        return $builder;
    }

    public function update_d_foto($id, $payload)
    {
        return $this->bUpdate_detail($id, $payload, $this->mFoto);
    }

    public function delete_d_foto($id)
    {
        return $this->bHelp->delete($id, $this->mFoto);
    }
    /**
     * End Detail DIVISI TERKAIT*/




    private function bUpdate_detail($id, $payload, $builder)
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $payload = $this->identity->update($payload);

        return $builder->where('lpa_id', $lpa_id)
            ->where('id', $id)
            ->set($payload)
            ->update();
    }


    public function show_icdms($id_arr)
    {
        $builder = $this->mIcdms
            ->whereIn('id', $id_arr);

        return $builder;
    }

    public function show_created_by_name($id)
    {
        $payload = [
            // "limit" => 10,
            // "offset" => 0,
            // "sort" => "id",
            // "order" => "desc",
            // "search" => "",
            // "selects" => "*"
        ];

        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->reqH->myToken()
        ];

        $builder = $this->ummu->show_created_by_name($params);

        return $builder;
    }

    public function insert_approve_trx($lpa_id, $site)
    {
        $show_matrix_appv = $this->mAppvmatrix
            ->where('site', $site)
            ->orderBy('sequence', 'ASC')
            ->get()->getResult();

        if ($show_matrix_appv) {
            $insert = [];
            foreach ($show_matrix_appv as $key => $value) {
                $payload = [
                    "sequence" => $value->sequence,
                    "lpa_id" => $lpa_id,
                    "account_id" => $value->account_id,
                ];
                $insert[] = $this->mAppvtrx->insert($payload);
            }
        }


        return $insert;
    }

    public function insert_approval_doc_queue($lpa_id, $site)
    {
        $show_matrix_appv = $this->mAppvmatrix
            ->where('site', $site)
            ->orderBy('sequence', 'ASC')
            ->get()->getResult();

        if ($show_matrix_appv) {
            $insert = [];
            foreach ($show_matrix_appv as $key => $value) {
                $payload = [
                    "sequence" => $value->sequence,
                    "lpa_id" => $lpa_id,
                    "account_id" => $value->account_id,
                ];
                $insert[] = $this->mAppvtrx->insert($payload);
            }
        }


        return $insert;
    }

    public function show_matrix_appv($site)
    {
        $builder = $this->mAppvmatrix
            ->where('site', $site)
            ->orderBy('sequence', 'ASC')
            ->get()->getResult();

        return $builder;
    }

    public function insert_approve($lpa_id, $site)
    {
        $show_matrix_appv = $this->mAppvmatrix
            ->where('site', $site)
            ->get()
            ->getResultArray();

        $count = count($show_matrix_appv);

        $payload = [
            "lpa_id" => $lpa_id,
            "total_appv" => $count
        ];

        $insert = $this->mAppv->insert($payload);

        return $insert;
    }

    public function approval_queue($doc_id)
    {
        $payload = [
            "limit" => 0,
            "offset" => 0,
            "search" => "",
            "sort" => "sequence",
            "order" => "asc",
            "doc_id" => $doc_id,
            "selects" => "*"
        ];

        $params = [
            "id" => null,
            "payload" => $payload,
            "token" => $this->reqH->myToken()
        ];

        $response = $this->ummu->approval_show_doc_queue($params);

        return $response;
    }

    public function approve($lpa_id, $payload)
    {
        $builder = $this->mAppv
            ->set($payload)
            ->where("lpa_id", $lpa_id)
            ->update();

        return $builder;
    }

    public function last_appv_sequence($lpa_id)
    {
        $builder = $this->mAppv
            ->select("last_appv_sequence")
            ->where("lpa_id", $lpa_id)
            ->get()->getRow();

        if ($builder) {
            return $builder->last_appv_sequence;
        } else {
            return null;
        }
    }

    public function show_approval_matrix($id)
    {
        $table = $this->mAppvmatrix->table;
        $subquery = $this->iescm->table($table . ' a')
            ->select("a.*,b.name")
            ->join($this->mUser->database . '.' . $this->mUser->table . ' b', 'b.account_id = a.account_id', 'left')
            ->where('a.deleted_at IS NULL');

        $builder = $this->iescm->newQuery()->fromSubquery($subquery, 't');

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["site"],
            "company_id" => null,
            "account_id" => null
        ];

        $builder = $this->bHelp->conditions($params);
        $builder->orderBy('site', 'asc')->orderBy('sequence', 'asc');
        // $builder = $this->qHelp->orderBy($builder, $allowedFields);
        return $builder;
    }

    public function approval_matrix_insert($payload)
    {
        // $payload = $this->identity->insert($payload);
        $builder = $this->mAppvmatrix->insert($payload);

        return $builder;
    }

    public function approval_matrix_delete($id)
    {
        $payload = [
            "deleted_at" => date("Y-m-d H:i:s"),
            "deleted_by" => $this->identity->account_id()
        ];
        $builder = $this->mAppvmatrix
            ->set($payload)
            ->whereIn("id", $id)
            ->update();

        return $builder;
    }

    public function update_approval_matrix($id, $payload)
    {
        $builder = $this->mAppvmatrix
            ->where('id', $id)
            ->set($payload)
            ->update();

        return $builder;
    }
}