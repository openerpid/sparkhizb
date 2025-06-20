<?php

namespace App\Hizb\Controllers\Safety;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
use Sparkhizb\Helpers\QueryHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\IdentityHelper;
use Sparkhizb\UmmuPhotos;
use Sparkhizb\UmmuUpload;

use App\Hizb\Builder\Safety\LpaBuilder;
use App\Hizb\Validations\LpaValidation;

class LpaController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->qHelp = new QueryHelper();
        $this->identity = new IdentityHelper();
        $this->umUpl = new UmmuUpload();
        $this->umPhot = new UmmuPhotos();

        $this->qBuilder = new LpaBuilder();
        $this->qVal = new LpaValidation();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        // 
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $show_detail_orang_terlibat = $this->request->getJsonVar('show_detail_orang_terlibat');
        $show_detail_foto = $this->request->getJsonVar('show_detail_foto');
        $show_detail_kerusakan = $this->request->getJsonVar('show_detail_kerusakan');
        $show_detail_unit = $this->request->getJsonVar('show_detail_unit');
        $show_detail_divisiTerkait = $this->request->getJsonVar('show_detail_divisiTerkait');
        $join_syshab = $this->request->getJsonVar('join_syshab');

        $builder = $this->qBuilder->show($id);
        $total = $this->qHelp->_total($builder);
        $rows = $this->qHelp->_rowsBui($builder);
        $count = count($rows);
        $rows = $this->qBuilder->joinData($rows);

        if ($rows) {
            foreach ($rows as $key => $value) {
                if ($show_detail_orang_terlibat) {
                    $orang = $this->qBuilder->show_d_orang($value->id);
                    $orang = $this->qBuilder->joinEmployee($orang);
                    $rows[$key]->orang_terlibat = $orang;
                }

                if ($show_detail_foto) {
                    $foto = $this->qBuilder->show_d_foto($value->id);
                    if ($foto) {
                        foreach ($foto as $key2 => $value2) {
                            $foto[$key2]->file_url = base_url() . $value2->filepath;
                        }
                    }
                    $rows[$key]->foto = $foto;
                }

                if ($show_detail_kerusakan) {
                    $kerusakan = $this->qBuilder->show_d_kerusakan($value->id);
                    $rows[$key]->kerusakan = $kerusakan;
                }

                if ($show_detail_unit) {
                    $unit = $this->qBuilder->show_d_unit($value->id);
                    $rows[$key]->unit = $unit;
                }

                if ($show_detail_divisiTerkait) {

                    $divisi = $this->qBuilder->show_d_divisi($value->id);

                    $divisi_name = '';
                    $depar_name = '';
                    $section_name = '';
                    if ($join_syshab) {
                        foreach ($divisi as $key2 => $value2) {
                            if (in_array("divisi", $join_syshab)) {
                                $qbDivisi = new \App\Hizb\Syshab\Builder\DivisiBuilder;

                                $herp_divisi = $qbDivisi->show_by_kode($value2->divisi_kode)->get()->getRow();
                                if ($herp_divisi) {
                                    $divisi_name = $herp_divisi->NmDivisi;
                                }

                                $divisi[$key2]->divisi_name = $divisi_name;
                            }

                            if (in_array("departemen", $join_syshab)) {
                                $qbDepar = new \App\Hizb\Syshab\Builder\DepartementBuilder;

                                $show_depar = $qbDepar->show_by_kode($value2->departemen_kode)->get()->getRow();
                                if ($show_depar) {
                                    $depar_name = $show_depar->NmDepar;
                                }

                                $divisi[$key2]->depar_name = $depar_name;

                            }

                            if (in_array("section", $join_syshab)) {
                                $qbSeksi = new \App\Hizb\Syshab\Builder\SeksiBuilder;

                                $builder = $qbSeksi->show_by_kode($value2->section_kode)->get()->getRow();
                                if ($builder) {
                                    $section_name = $builder->NmSec;
                                }

                                $divisi[$key2]->section_name = $section_name;

                            }
                        }
                    }
                    $rows[$key]->divisi_terkait = $divisi;
                }
            }
        }

        $response = $this->qHelp->respon($rows, $count, $total);
        return $this->respond($response, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $show_number_unused = $this->qBuilder->show_number_unused()->get()->getFirstRow();
        if ($show_number_unused) { /* jika ada nomor dokumen yang belum digunakan pada bulan dan tahun yang sama dengan sekarang */
            $row = $show_number_unused;
            $number = $row->number;
        } else {
            $getLastRow = $this->qBuilder->getLastRow();
            if ($getLastRow) {
                $seq = $getLastRow->seq;
                $seq = $seq + 1;
            } else {
                $seq = 1;
            }

            $n = sprintf('%06d', $seq);
            $number = 'INCIDENT' . date('Ym') . $n;

            $payload = [
                "docat_id" => 2,
                "seq" => $seq,
                "number" => $number,
                "created_by" => $this->identity->account_id()
            ];
            $insert_number = $this->qBuilder->insert_number($payload);
        }

        // $response = ["nomor_dokument" => $number];
        $response = [$number];

        return $this->respond($response, 200);
    }

    public function used_number($number)
    {
        $builder = $this->qBuilder->used_number($number);
        return $this->respond($builder, 200);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        // $body = (array) $this->request->getVar();
        // $foto_temuan = $this->request->getFile("foto_temuan");
        // $foto_perbaikan = $this->request->getFile("foto_perbaikan");
        // $foto_temuan_id = null;
        // $foto_perbaikan_id = null;

        // if (isset($foto_temuan)) {
        //     $ci_foto_temuan = new \CodeIgniter\Files\File($foto_temuan);
        //     if ($ci_foto_temuan->getBasename()) {
        //         $foto_temuan_upload = $this->umUpl->create2($foto_temuan);
        //         if ($foto_temuan_upload['status'] == true) {
        //             $payload = [
        //                 "filename" => $foto_temuan_upload["name"],
        //                 "folder" => $foto_temuan_upload["folder"],
        //                 "paht" => null,
        //                 "url" => $foto_temuan_upload["url"]
        //             ];
        //             $params = [
        //                 "payload" => $payload,
        //                 "token" => $this->qHelp->token()
        //             ];
        //             $photos_create = $this->umPhot->create($params);
        //             if ($photos_create->status == true) {
        //                 $foto_temuan_id = $photos_create->data->id;
        //             }
        //         }
        //     }
        // }

        // if (isset($foto_perbaikan)) {
        //     $ci_foto_perbaikan = new \CodeIgniter\Files\File($foto_perbaikan);
        //     if ($ci_foto_perbaikan->getBasename()) {
        //         $foto_perbaikan_upload = $this->umUpl->create2($foto_perbaikan);
        //         if ($foto_perbaikan_upload['status'] == true) {
        //             $payload = [
        //                 "filename" => $foto_perbaikan_upload["name"],
        //                 "folder" => $foto_perbaikan_upload["folder"],
        //                 "paht" => null,
        //                 "url" => $foto_perbaikan_upload["url"]
        //             ];
        //             $params = [
        //                 "payload" => $payload,
        //                 "token" => $this->qHelp->token()
        //             ];
        //             $photos_create = $this->umPhot->create($params);
        //             if ($photos_create->status == true) {
        //                 $foto_perbaikan_id = $photos_create->data->id;
        //             }
        //         }
        //     }
        // }

        // $payload = array_merge(
        //     $body,
        //     ["foto_temuan_id" => $foto_temuan_id],
        //     ["foto_perbaikan_id" => $foto_perbaikan_id]
        // );
        // $builder = $this->qBuilder->insert($payload);
        $nomor_dokumen = $this->request->getVar('nomor_dokumen');
        $insident_classification = $this->request->getVar('insident_classification');
        $site = $this->request->getVar('site');
        // $divisi = $this->request->getVar('divisi');
        // $departemen = $this->request->getVar('departemen');
        // $section = $this->request->getVar('section');
        $hari_kejadian = $this->request->getVar('hari_kejadian');
        $tanggal_kejadian = $this->request->getVar('tanggal_kejadian');
        $waktu_kejadian = $this->request->getVar('waktu_kejadian');
        $tanggal_pelaporan = $this->request->getVar('tanggal_pelaporan');
        $waktu_pelaporan = $this->request->getVar('waktu_pelaporan');

        $shift_kerja = $this->request->getVar('shift_kerja');
        $mulai_shift = $this->request->getVar('mulai_shift');
        $selesai_shift = $this->request->getVar('selesai_shift');
        $hari_kerja_ke = $this->request->getVar('hari_kerja_ke');

        $lokasi_insiden = $this->request->getVar('lokasi_insiden');
        $detail_lokasi_insiden = $this->request->getVar('detail_lokasi_insiden');
        $cidera = $this->request->getVar('cidera');
        $detail_cidera_lainnya = $this->request->getVar('detail_cidera_lainnya');
        $kronologi = $this->request->getVar('kronologi');

        $instansi_pemerintah = $this->request->getVar('instansi_pemerintah');
        $nama_pejabat = $this->request->getVar('nama_pejabat');
        $pemerintah_disampaikan_oleh = $this->request->getVar('pemerintah_disampaikan_oleh');
        $pemerintah_tanggal = $this->request->getVar('pemerintah_tanggal');

        $asuransi = $this->request->getVar('asuransi');
        $nama_perusahaan = $this->request->getVar('nama_perusahaan');
        $asuransi_disampaikan_oleh = $this->request->getVar('asuransi_disampaikan_oleh');
        $asuransi_tanggal = $this->request->getVar('asuransi_tanggal');

        $pihak_tiga = $this->request->getVar('pihak_tiga');
        $nama_pihak_ketiga = $this->request->getVar('nama_pihak_ketiga');
        $pihak_tiga_disampaikan_oleh = $this->request->getVar('pihak_tiga_disampaikan_oleh');
        $pihak_tiga_tanggal = $this->request->getVar('pihak_tiga_tanggal');

        $tipe_insiden = $this->request->getVar('tipe_insiden');
        $penjelasan_insiden = $this->request->getVar('penjelasan_insiden');
        $zona_waktu = $this->request->getVar('zona_waktu');

        $payload = [
            "nomor_dokumen" => $nomor_dokumen,
            "insident_classification" => $insident_classification,
            "site" => $site,
            // "divisi" => $divisi,
            // "departemen" => $departemen,
            // "section" => $section,
            "tanggal_kejadian" => $tanggal_kejadian,
            "tanggal_pelaporan" => $tanggal_pelaporan,
            "waktu_pelaporan" => $waktu_pelaporan,
            "shift_kerja" => $shift_kerja,
            "mulai_shift" => $mulai_shift,
            "selesai_shift" => $selesai_shift,
            "hari_kerja_ke" => $hari_kerja_ke,
            "waktu_kejadian" => $waktu_kejadian,
            "lokasi_insiden" => $lokasi_insiden,
            "detail_lokasi_insiden" => $detail_lokasi_insiden,
            "cidera" => $cidera,
            "detail_cidera_lainnya" => $detail_cidera_lainnya,
            "kronologi" => $kronologi,
            "instansi_pemerintah" => $instansi_pemerintah,
            "nama_pejabat" => $nama_pejabat,
            "pemerintah_disampaikan_oleh" => $pemerintah_disampaikan_oleh,
            "pemerintah_tanggal" => $pemerintah_tanggal,
            "asuransi" => $asuransi,
            "nama_perusahaan" => $nama_perusahaan,
            "asuransi_disampaikan_oleh" => $asuransi_disampaikan_oleh,
            "asuransi_tanggal" => $asuransi_tanggal,
            "pihak_tiga" => $pihak_tiga,
            "nama_pihak_ketiga" => $nama_pihak_ketiga,
            "pihak_tiga_disampaikan_oleh" => $pihak_tiga_disampaikan_oleh,
            "pihak_tiga_tanggal" => $pihak_tiga_tanggal,
            "tipe_insiden" => $tipe_insiden,
            "penjelasan_insiden" => $penjelasan_insiden,
            "zona_waktu" => $zona_waktu,
            // "kerusakan_arr" => $kerusakan_arr,
            // "unit_arr" => $unit_arr
        ];

        $show_by_number = $this->qBuilder->show_by_number($nomor_dokumen)->get()->getFirstRow();
        if ($show_by_number) {
            // $validation = $this->qVal->insert();
            // if ($validation)
            $response = [
                "status" => false,
                "message" => 'Nomor dokumen already exists.',
            ];
        } else {
            $isValid_number = $this->qBuilder->show_number_isValid($nomor_dokumen)->get()->getFirstRow();
            if ($isValid_number) {
                $insert = $this->qBuilder->insert($payload);
                $used_number = $this->qBuilder->used_number($nomor_dokumen);

                // ############## Divisi terkait #################
                $divisi = $this->request->getVar('divisi');
                foreach ($divisi as $key => $value) {
                    $divisi_kode = (isset($value['divisi_kode']) ? $value['divisi_kode'] : null);
                    $departemen_kode = (isset($value['departemen_kode']) ? $value['departemen_kode'] : null);
                    $section = (isset($value['section']) ? $value['section'] : null);
                    $section_kode = (isset($value['section_kode']) ? $value['section_kode'] : null);

                    $divisi_terkait = [
                        "lpa_id" => $insert,
                        "divisi_kode" => $divisi_kode,
                        "departemen_kode" => $departemen_kode,
                        "section_kode" => $section_kode,
                        "section" => $section
                    ];
                    $insert_divisi_terkait = $this->qBuilder->insert_divisiTerkait($divisi_terkait);
                }

                // ############## ORANG TERLIBAT #################
                $orang_terlibat = $this->request->getVar('orang_terlibat');
                foreach ($orang_terlibat as $key => $value) {
                    $status_karyawan = (isset($value['status_karyawan']) ? $value['status_karyawan'] : null);
                    $nik = (isset($value['nik']) ? $value['nik'] : null);
                    $name = (isset($value['name']) ? $value['name'] : null);
                    $jk = (isset($value['jk']) ? $value['jk'] : null);
                    $jabatan = (isset($value['jabatan']) ? $value['jabatan'] : null);
                    $atasan = (isset($value['atasan']) ? $value['atasan'] : null);
                    $umur = (isset($value['umur']) ? $value['umur'] : null);
                    $pengalaman_tahun = (isset($value['pengalaman_tahun']) ? $value['pengalaman_tahun'] : null);
                    $pengalaman_bulan = (isset($value['pengalaman_bulan']) ? $value['pengalaman_bulan'] : null);
                    $sebagai = (isset($value['sebagai']) ? $value['sebagai'] : null);
                    $perusahaan = (isset($value['perusahaan']) ? $value['perusahaan'] : null);
                    $hari_kerja_ke = (isset($value['hari_kerja_ke']) and $value['hari_kerja_ke']) ? $value['hari_kerja_ke'] : null;

                    $orang_terlibat_payload = [
                        "lpa_id" => $insert,
                        "status_karyawan" => $status_karyawan,
                        "nik" => $nik,
                        "name" => $name,
                        "jk" => $jk,
                        "jabatan" => $jabatan,
                        "atasan" => $atasan,
                        "umur" => $umur,
                        "pengalaman_tahun" => $pengalaman_tahun,
                        "pengalaman_bulan" => $pengalaman_bulan,
                        "sebagai" => $sebagai,
                        "perusahaan" => $perusahaan,
                        "hari_kerja_ke" => $hari_kerja_ke
                    ];
                    $insert_orangTerlibat = $this->qBuilder->insert_orangTerlibat($orang_terlibat_payload);
                }

                //############## KERUSAKAN #################
                $kerusakan = $this->request->getVar('kerusakan');
                foreach ($kerusakan as $key => $value) {
                    // $tipe_komponen = (isset($value['tipe_komponen']) ? $value['tipe_komponen'] : null);
                    $jenis_kerusakan = (isset($value['jenis_kerusakan']) ? $value['jenis_kerusakan'] : null);
                    $name = (isset($value['name']) ? $value['name'] : null);
                    $tipe = (isset($value['tipe']) ? $value['tipe'] : null);
                    $aset_perusahaan = (isset($value['aset_perusahaan']) and $value['aset_perusahaan']) ? $value['aset_perusahaan'] : null;
                    $bukan_aset_perusahaan_text = (isset($value['bukan_aset_perusahaan_text']) and $value['bukan_aset_perusahaan_text']) ? $value['bukan_aset_perusahaan_text'] : null;
                    $serial_number = (isset($value['serial_number']) ? $value['serial_number'] : null);
                    $tingkat_kerusakan = (isset($value['tingkat_kerusakan']) ? $value['tingkat_kerusakan'] : null);
                    $kerusakan_keparahan = (isset($value['kerusakan_keparahan']) ? $value['kerusakan_keparahan'] : null);
                    $detail_kerusakan_kerugian = (isset($value['detail_kerusakan_kerugian']) ? $value['detail_kerusakan_kerugian'] : null);
                    $perkiraan_biaya = (isset($value['perkiraan_biaya']) ? $value['perkiraan_biaya'] : null);

                    $kerusakan_payload = [
                        "lpa_id" => $insert,
                        "jenis_kerusakan" => $jenis_kerusakan,
                        "name" => $name,
                        "tipe" => $tipe,
                        // "tipe_komponen" => $tipe_komponen,
                        "aset_perusahaan" => $aset_perusahaan,
                        "bukan_aset_perusahaan_text" => $bukan_aset_perusahaan_text,
                        "serial_number" => $serial_number,
                        "tingkat_kerusakan" => $tingkat_kerusakan,
                        "kerusakan_keparahan" => $kerusakan_keparahan,
                        "detail_kerusakan_kerugian" => $detail_kerusakan_kerugian,
                        "perkiraan_biaya" => $perkiraan_biaya
                    ];

                    $insert_kerusakan = $this->qBuilder->insert_kerusakan($kerusakan_payload);
                }

                //############## UNIT #################
                if ($this->request->getVar('unit')) {
                    $unit = $this->request->getVar('unit');
                    foreach ($unit as $key => $value) {
                        $tipe_equipment_kendaraan = (isset($value['tipe_equipment_kendaraan']) ? $value['tipe_equipment_kendaraan'] : null);
                        $model_serial = (isset($value['model_serial']) ? $value['model_serial'] : null);
                        $aset_perusahaan = (isset($value['aset_perusahaan']) ? $value['aset_perusahaan'] : null);
                        $keterangan_bukan_aset = (isset($value['keterangan_bukan_aset']) ? $value['keterangan_bukan_aset'] : null);

                        $unit_payload = [
                            "lpa_id" => $insert,
                            "tipe_equipment_kendaraan" => $tipe_equipment_kendaraan,
                            "model_serial" => $model_serial,
                            "aset_perusahaan" => $aset_perusahaan,
                            "keterangan_bukan_aset" => $keterangan_bukan_aset
                        ];

                        $insert_unit = $this->qBuilder->insert_unit($unit_payload);
                    }
                }

                //############## FOTO #################
                $foto = $this->request->getVar('foto');
                foreach ($foto as $key => $value) {
                    $file = $this->request->getFile('foto.' . $key . '.file');
                    if ($file != NULL) {
                        $isFile = $file->isValid();
                        $group_category = $value['group_category'];
                        $category = $value['category'];
                        if ($isFile) {
                            $newName = $file->getRandomName();
                            // $filename = $file->getName();
                            // $real_path = $file->getRealPath();
                            $filename = $newName;
                            // $real_path = date('Ymd') . '/upploads/' . $newName;
                            // $file->move(WRITEPATH . 'uploads', $newName);
                            if (!$file->hasMoved()) {
                                // $filepath = WRITEPATH . 'uploads/' . $file->store();
                                // $filepath = 'uploads/' . $file->store();
                                // $real_path = new File($filepath);
                                $real_path = 'uploads/' . $file->store();
                            }

                            $foto_payload = [
                                "lpa_id" => $insert,
                                "group_category" => $group_category,
                                "category" => $category,
                                "filepath" => $real_path
                            ];

                            $insert_foto = $this->qBuilder->insert_foto($foto_payload);
                        }
                    }
                }

                $response = [
                    "status" => true,
                    "message" => 'Insert data success.',
                ];
            } else {
                $response = [
                    "status" => false,
                    "message" => 'Invalid document number!',
                ];
            }
        }

        return $this->respond($response, 200);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $validation = $this->qVal->update($id);
        if($validation) return $this->respond($validation, 200);

        $payload = [];

        $insident_classification = $this->request->getVar('insident_classification');
        $site = $this->request->getVar('site');
        // $divisi = $this->request->getVar('divisi');
        // $departemen = $this->request->getVar('departemen');
        // $section = $this->request->getVar('section');

        $hari_kejadian = $this->request->getVar('hari_kejadian');
        $tanggal_kejadian = $this->request->getVar('tanggal_kejadian');
        $waktu_kejadian = $this->request->getVar('waktu_kejadian');
        $tanggal_pelaporan = $this->request->getVar('tanggal_pelaporan');
        $waktu_pelaporan = $this->request->getVar('waktu_pelaporan');

        $shift_kerja = $this->request->getVar('shift_kerja');
        $mulai_shift = $this->request->getVar('mulai_shift');
        $selesai_shift = $this->request->getVar('selesai_shift');
        $hari_kerja_ke = $this->request->getVar('hari_kerja_ke');

        $lokasi_insiden_id = $this->request->getVar('lokasi_insiden_id');
        $lokasi_insiden = $this->request->getVar('lokasi_insiden');
        $detail_lokasi_insiden = $this->request->getVar('detail_lokasi_insiden');

        $cidera_id = $this->request->getVar('cidera_id');
        $cidera = $this->request->getVar('cidera');
        $detail_cidera_lainnya = $this->request->getVar('detail_cidera_lainnya');
        $kronologi = $this->request->getVar('kronologi');

        $instansi_pemerintah = $this->request->getVar('instansi_pemerintah');
        $nama_pejabat = $this->request->getVar('nama_pejabat');
        $pemerintah_disampaikan_oleh = $this->request->getVar('pemerintah_disampaikan_oleh');
        $pemerintah_tanggal = $this->request->getVar('pemerintah_tanggal');

        $asuransi = $this->request->getVar('asuransi');
        $nama_perusahaan = $this->request->getVar('nama_perusahaan');
        $asuransi_disampaikan_oleh = $this->request->getVar('asuransi_disampaikan_oleh');
        $asuransi_tanggal = $this->request->getVar('asuransi_tanggal');

        $pihak_tiga = $this->request->getVar('pihak_tiga');
        $nama_pihak_ketiga = $this->request->getVar('nama_pihak_ketiga');
        $pihak_tiga_disampaikan_oleh = $this->request->getVar('pihak_tiga_disampaikan_oleh');
        $pihak_tiga_tanggal = $this->request->getVar('pihak_tiga_tanggal');

        $tipe_insiden_id = $this->request->getVar('tipe_insiden_id');
        $tipe_insiden = $this->request->getVar('tipe_insiden');
        $penjelasan_insiden = $this->request->getVar('penjelasan_insiden');

        /*set to payload*/
        if(isset($insident_classification)) $payload["insident_classification"] = $insident_classification;
        if(isset($site)) $payload["site"] = $site;
        // if(isset($divisi)) $payload["divisi"] = $divisi;
        // if(isset($departemen)) $payload["departemen"] = $departemen;
        // if(isset($section)) $payload["section"] = $section;

        if(isset($hari_kejadian)) $payload["hari_kejadian"] = $hari_kejadian;
        if(isset($tanggal_kejadian)) $payload["tanggal_kejadian"] = $tanggal_kejadian;
        if(isset($waktu_kejadian)) $payload["waktu_kejadian"] = $waktu_kejadian;
        if(isset($tanggal_pelaporan)) $payload["tanggal_pelaporan"] = $tanggal_pelaporan;
        if(isset($waktu_pelaporan)) $payload["waktu_pelaporan"] = $waktu_pelaporan;

        if(isset($shift_kerja)) $payload["shift_kerja"] = $shift_kerja;
        if(isset($mulai_shift)) $payload["mulai_shift"] = $mulai_shift;
        if(isset($selesai_shift)) $payload["selesai_shift"] = $selesai_shift;
        if(isset($hari_kerja_ke)) $payload["hari_kerja_ke"] = $hari_kerja_ke;

        if(isset($lokasi_insiden_id)) $payload["lokasi_insiden_id"] = (isset($lokasi_insiden_id) and $lokasi_insiden_id != "") ? $lokasi_insiden_id : null;
        if(isset($lokasi_insiden)) $payload["lokasi_insiden"] = $lokasi_insiden;
        if(isset($detail_lokasi_insiden)) $payload["detail_lokasi_insiden"] = $detail_lokasi_insiden;

        if(isset($cidera_id)) $payload["cidera_id"] = (isset($cidera_id) and $cidera_id != "") ? $cidera_id : null;
        if(isset($cidera)) $payload["cidera"] = $cidera;
        if(isset($detail_cidera_lainnya)) $payload["detail_cidera_lainnya"] = $detail_cidera_lainnya;
        if(isset($kronologi)) $payload["kronologi"] = $kronologi;

        if(isset($instansi_pemerintah)) $payload["instansi_pemerintah"] = (isset($instansi_pemerintah) and $instansi_pemerintah != "") ? $instansi_pemerintah : null;
        if(isset($nama_pejabat)) $payload["nama_pejabat"] = (isset($nama_pejabat) and $nama_pejabat != "" and $instansi_pemerintah != "") ? $nama_pejabat : null;
        if(isset($pemerintah_disampaikan_oleh)) $payload["pemerintah_disampaikan_oleh"] = (isset($pemerintah_disampaikan_oleh) and $pemerintah_disampaikan_oleh != "" and $instansi_pemerintah != "") ? $pemerintah_disampaikan_oleh : null;;
        if(isset($pemerintah_tanggal)) $payload["pemerintah_tanggal"] = (isset($pemerintah_tanggal) and $pemerintah_tanggal != "" and $instansi_pemerintah != "") ? $pemerintah_tanggal : null;;

        if(isset($asuransi)) $payload["asuransi"] = (isset($asuransi) and $asuransi != "") ? $asuransi : null;
        if(isset($nama_perusahaan)) $payload["nama_perusahaan"] = (isset($nama_perusahaan) and $nama_perusahaan != "" and $asuransi != "") ? $nama_perusahaan : null;
        if(isset($asuransi_disampaikan_oleh)) $payload["asuransi_disampaikan_oleh"] = (isset($asuransi_disampaikan_oleh) and $asuransi_disampaikan_oleh != "" and $asuransi != "") ? $asuransi_disampaikan_oleh : null;
        if(isset($asuransi_tanggal)) $payload["asuransi_tanggal"] = (isset($asuransi_tanggal) and $asuransi_tanggal != "" and $asuransi != "") ? $asuransi_tanggal : null;

        if(isset($pihak_tiga)) $payload["pihak_tiga"] = (isset($pihak_tiga) and $pihak_tiga != "") ? $pihak_tiga : null;
        if(isset($nama_pihak_ketiga)) $payload["nama_pihak_ketiga"] = (isset($nama_pihak_ketiga) and $nama_pihak_ketiga != "" and $pihak_tiga != "") ? $nama_pihak_ketiga : null;
        if(isset($pihak_tiga_disampaikan_oleh)) $payload["pihak_tiga_disampaikan_oleh"] = (isset($pihak_tiga_disampaikan_oleh) and $pihak_tiga_disampaikan_oleh != "" and $pihak_tiga != "") ? $pihak_tiga_disampaikan_oleh : null;
        if(isset($pihak_tiga_tanggal)) $payload["pihak_tiga_tanggal"] = (isset($pihak_tiga_tanggal) and $pihak_tiga_tanggal != "" and $pihak_tiga != "") ? $pihak_tiga_tanggal : null;

        if(isset($tipe_insiden_id)) $payload["tipe_insiden_id"] = (isset($tipe_insiden_id) and $tipe_insiden_id != "") ? $tipe_insiden_id : null;
        if(isset($tipe_insiden)) $payload["tipe_insiden"] = (isset($tipe_insiden) and $tipe_insiden != "") ? $tipe_insiden : null;
        if(isset($penjelasan_insiden)) $payload["penjelasan_insiden"] = (isset($penjelasan_insiden) and $penjelasan_insiden != "") ? $penjelasan_insiden : null;
        
        $builder = $this->qBuilder->update($id, $payload);

        $payload['orang_terlibat'] = $this->update_orangTerlibat($id);        
        $payload['kerusakan_payload'] = $this->update_kerusakan($id);

        /*if(isset($item_category_id)) $payload["item_category_id"] = $item_category_id;
        if(isset($received_at)) $payload["received_at"] = $received_at;
        if(isset($installed_at)) $payload["installed_at"] = $installed_at;
        if(isset($problem_category_id)) $payload["problem_category_id"] = $problem_category_id;
        if(isset($fekb_number)) $payload["fekb_number"] = $fekb_number;
        if(isset($description)) $payload["description"] = $description;
        if(isset($report_by_name)) $payload["report_by_name"] = $report_by_name;
        if(isset($remark)) $payload["remark"] = $remark;
        if(isset($action)) $payload["action"] = $action;
        if(isset($status_id)) $payload["status_id"] = $status_id;*/

        // $payload2["goodseval_id"] = $id;
        // if(isset($remark)) $payload2["remark"] = $remark;
        // if(isset($action)) $payload2["action"] = $action;
        // if(isset($status_id)) $payload2["status_id"] = $status_id;


        /*$validation = $this->qVal->update($id);
        if ($validation)
            return $this->respond([
                "status"    => false,
                "message"   => 'Validation error!',
                "errors"    => $validation,
                "rows"      => [],
            ],200);*/


        if ($builder) {
            $response = array(
                "status"    => true,
                "message"   => "Updaate data success.",
                "response"  => $builder,
                "errors"    => null
            );
        }else{
            $response = array(
                "status"    => false,
                "message"   => "Updaate data failed.",
                "response"  => $builder,
                "errors"    => null
            );
        }

        return $this->respond($response, 200);
    }

    private function update_orangTerlibat($lpi_id)
    {
        $orang_terlibat = $this->request->getVar('orang_terlibat');
        $payload_arr = [];
        $builder = [];
        if ($orang_terlibat) {
            foreach ($orang_terlibat as $key => $value) {
                $status_karyawan = (isset($value['status_karyawan']) ? $value['status_karyawan'] : null);
                $nik = (isset($value['nik']) ? $value['nik'] : null);
                $name = (isset($value['name']) ? $value['name'] : null);
                $jk = (isset($value['jk']) ? $value['jk'] : null);
                $jabatan = (isset($value['jabatan']) ? $value['jabatan'] : null);
                $atasan = (isset($value['atasan']) ? $value['atasan'] : null);
                $umur = (isset($value['umur']) ? $value['umur'] : null);
                $pengalaman_tahun = (isset($value['pengalaman_tahun']) ? $value['pengalaman_tahun'] : null);
                $pengalaman_bulan = (isset($value['pengalaman_bulan']) ? $value['pengalaman_bulan'] : null);
                $sebagai = (isset($value['sebagai']) ? $value['sebagai'] : null);
                $perusahaan = (isset($value['perusahaan']) ? $value['perusahaan'] : null);
                $hari_kerja_ke = (isset($value['hari_kerja_ke']) ? $value['hari_kerja_ke'] : null);

                $payload = [];

                if(isset($status_karyawan)) $payload["status_karyawan"] = $status_karyawan;
                if(isset($nik)) $payload["nik"] = $nik;
                if(isset($name)) $payload["name"] = $name;
                if(isset($jk)) $payload["jk"] = $jk;
                if(isset($jabatan)) $payload["jabatan"] = $jabatan;
                if(isset($atasan)) $payload["atasan"] = $atasan;
                if(isset($umur)) $payload["umur"] = ($umur) ? $umur : null;
                if(isset($pengalaman_tahun)) $payload["pengalaman_tahun"] = ($pengalaman_tahun) ? $pengalaman_tahun : null;
                if(isset($pengalaman_bulan)) $payload["pengalaman_bulan"] = ($pengalaman_bulan) ? $pengalaman_bulan : null;
                if(isset($sebagai)) $payload["sebagai"] = $sebagai;
                if(isset($perusahaan)) $payload["perusahaan"] = $perusahaan;
                if(isset($hari_kerja_ke)) $payload["hari_kerja_ke"] = ($hari_kerja_ke) ? $hari_kerja_ke : null;

                $payload_arr[] = $payload;

                $builder = $this->qBuilder->update_orangTerlibat($lpi_id, $key, $payload);
            }
        }

        return $builder;
    }

    /*public function update_kerusakan($lpi_id)
    {
        $kerusakan = $this->request->getVar('kerusakan');
        $payload_arr = [];
        $builder = [];
        if ($kerusakan) {
            foreach ($kerusakan as $key => $value) {
                $jenis_kerusakan = (isset($value['jenis_kerusakan']) ? $value['jenis_kerusakan'] : null);
                $name = (isset($value['name']) ? $value['name'] : null);
                $tipe = (isset($value['tipe']) ? $value['tipe'] : null);
                $aset_perusahaan = (isset($value['aset_perusahaan']) ? $value['aset_perusahaan'] : null);
                $serial_number = (isset($value['serial_number']) ? $value['serial_number'] : null);
                $tingkat_kerusakan = (isset($value['tingkat_kerusakan']) ? $value['tingkat_kerusakan'] : null);
                $kerusakan_keparahan = (isset($value['kerusakan_keparahan']) ? $value['kerusakan_keparahan'] : null);
                $detail_kerusakan_kerugian = (isset($value['detail_kerusakan_kerugian']) ? $value['detail_kerusakan_kerugian'] : null);
                $perkiraan_biaya = (isset($value['perkiraan_biaya']) ? $value['perkiraan_biaya'] : null);

                $payload = [];

                if(isset($jenis_kerusakan)) $payload["jenis_kerusakan"] = $jenis_kerusakan;
                if(isset($name)) $payload["name"] = $name;
                if(isset($tipe)) $payload["tipe"] = $tipe;
                if(isset($aset_perusahaan)) $payload["aset_perusahaan"] = $aset_perusahaan;
                if(isset($serial_number)) $payload["serial_number"] = $serial_number;
                if(isset($tingkat_kerusakan)) $payload["tingkat_kerusakan"] = $tingkat_kerusakan;
                if(isset($kerusakan_keparahan)) $payload["kerusakan_keparahan"] = $kerusakan_keparahan;
                if(isset($detail_kerusakan_kerugian)) $payload["detail_kerusakan_kerugian"] = $detail_kerusakan_kerugian;
                if(isset($perkiraan_biaya)) $payload["perkiraan_biaya"] = $perkiraan_biaya;

                $payload_arr[] = $payload;

                $builder = $this->qBuilder->update_kerusakan($key, $kerusakan_payload);
            }
        }

        return $builder;
    }*/

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $builder = $this->qBuilder->delete($id);
        if ($builder) {
            $response = [
                "status" => true,
                "message" => "Delete success.",
            ];
            $rescod = 200;
        } else {
            $response = [
                "status" => false,
                "message" => "Delete error.",
            ];
            $rescod = 200;
        }

        return $this->respond($response, $rescod);
    }



    /**
     * Detail ORANG TERLIBAT
     * */
    public function create_orang_terlibat()
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $status_karyawan = $this->request->getVar('status_karyawan');
        $nik = $this->request->getVar('nik');
        $name = $this->request->getVar('name');
        $jk = $this->request->getVar('jk');
        $jabatan = $this->request->getVar('jabatan');
        $atasan = $this->request->getVar('atasan');
        $umur = $this->request->getVar('umur');
        $pengalaman_bulan = $this->request->getVar('pengalaman_bulan');
        $pengalaman_tahun = $this->request->getVar('pengalaman_tahun');
        $sebagai = $this->request->getVar('sebagai');
        $perusahaan = $this->request->getVar('perusahaan');
        $hari_kerja_ke = $this->request->getVar('hari_kerja_ke');

        $validation = $this->qVal->insert_orangTerlibat();
        if($validation) return $this->respond($validation, 200);

        $payload = [
            "lpa_id" => $lpa_id,
            "status_karyawan" => $status_karyawan,
            "nik" => $nik,
            "name" => $name,
            "jk" => $jk,
            "jabatan" => $jabatan,
            "atasan" => $atasan,
            "umur" => $umur,
            "pengalaman_tahun" => $pengalaman_tahun,
            "pengalaman_bulan" => $pengalaman_bulan,
            "sebagai" => $sebagai,
            "perusahaan" => $perusahaan,
            "hari_kerja_ke" => $hari_kerja_ke
        ];
        $builder = $this->qBuilder->insert_orangTerlibat($payload);

        if ($builder) {
            $response = [
                "status" => true,
                "message" => 'Insert data success.',
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Insert data failed!',
            ];
        }

        return $this->respond($response, 200);
    }

    public function update_orang_terlibat($id)
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $status_karyawan = $this->request->getVar('status_karyawan');
        $nik = $this->request->getVar('nik');
        $name = $this->request->getVar('name');
        $jk = $this->request->getVar('jk');
        $jabatan = $this->request->getVar('jabatan');
        $atasan = $this->request->getVar('atasan');
        $umur = $this->request->getVar('umur');
        $pengalaman_bulan = $this->request->getVar('pengalaman_bulan');
        $pengalaman_tahun = $this->request->getVar('pengalaman_tahun');
        $sebagai = $this->request->getVar('sebagai');
        $perusahaan = $this->request->getVar('perusahaan');
        $hari_kerja_ke = $this->request->getVar('hari_kerja_ke');

        $validation = $this->qVal->update_orangTerlibat($id);
        if($validation) return $this->respond($validation, 200);

        $payload = [
            "status_karyawan" => $status_karyawan,
            "nik" => $nik,
            "name" => $name,
            "jk" => $jk,
            "jabatan" => $jabatan,
            "atasan" => $atasan,
            "umur" => $umur,
            "pengalaman_tahun" => $pengalaman_tahun,
            "pengalaman_bulan" => $pengalaman_bulan,
            "sebagai" => $sebagai,
            "perusahaan" => $perusahaan,
            "hari_kerja_ke" => $hari_kerja_ke
        ];

        $builder = $this->qBuilder->update_orangTerlibat($id, $payload);

        if ($builder) {
            $response = [
                "status" => true,
                "message" => 'Update data success.',
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Update data failed!',
            ];
        }

        return $this->respond($response, 200);
    }

    public function delete_orang_terlibat($id)
    {
        $builder = $this->qBuilder->delete_orang_terlibat($id);
        if ($builder) {
            $response = [
                "status" => true,
                "message" => "Delete success.",
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "Delete error.",
            ];
        }

        return $this->respond($response, 200);
    }
    /**
     * END Detail ORANG TERLIBAT*/



    /**
     * Detail KERUSAKAN
     * */
    public function create_kerusakan()
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $jenis_kerusakan = $this->request->getVar('jenis_kerusakan');
        $name = $this->request->getVar('name');
        $tipe = $this->request->getVar('tipe');
        $serial_number = $this->request->getVar('serial_number');
        $aset_perusahaan = $this->request->getVar('aset_perusahaan');
        $bukan_aset_perusahaan_text = $this->request->getVar('bukan_aset_perusahaan_text');
        $tingkat_kerusakan = $this->request->getVar('tingkat_kerusakan');
        $detail_kerusakan_kerugian = $this->request->getVar('detail_kerusakan_kerugian');
        $perkiraan_biaya = $this->request->getVar('perkiraan_biaya');

        $validation = $this->qVal->insert_kerusakan();
        if($validation) return $this->respond($validation, 200);

        $payload = [
            "lpa_id" => $lpa_id,
            "jenis_kerusakan" => $jenis_kerusakan,
            "name" => $name,
            "tipe" => $tipe,
            "serial_number" => $serial_number,
            "aset_perusahaan" => (isset($aset_perusahaan) and $aset_perusahaan != "") ? $aset_perusahaan : null,
            "bukan_aset_perusahaan_text" => (!$aset_perusahaan) ? $bukan_aset_perusahaan_text : null,
            "tingkat_kerusakan" => $tingkat_kerusakan,
            "detail_kerusakan_kerugian" => $detail_kerusakan_kerugian,
            "perkiraan_biaya" => $perkiraan_biaya
        ];

        $builder = $this->qBuilder->insert_kerusakan($payload);

        if ($builder) {
            $response = [
                "status" => true,
                "message" => 'Insert data success.',
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Insert data failed!',
            ];
        }

        return $this->respond($response, 200);
    }

    public function update_kerusakan($id)
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $jenis_kerusakan = $this->request->getVar('jenis_kerusakan');
        $name = $this->request->getVar('name');
        $tipe = $this->request->getVar('tipe');
        $serial_number = $this->request->getVar('serial_number');
        $aset_perusahaan = $this->request->getVar('aset_perusahaan');
        $bukan_aset_perusahaan_text = $this->request->getVar('bukan_aset_perusahaan_text');
        $tingkat_kerusakan = $this->request->getVar('tingkat_kerusakan');
        $detail_kerusakan_kerugian = $this->request->getVar('detail_kerusakan_kerugian');
        $perkiraan_biaya = $this->request->getVar('perkiraan_biaya');

        $validation = $this->qVal->update_kerusakan($id);
        if($validation) return $this->respond($validation, 200);

        $payload = [
            // "lpa_id" => $lpa_id,
            "jenis_kerusakan" => $jenis_kerusakan,
            "name" => $name,
            "tipe" => $tipe,
            "serial_number" => $serial_number,
            "aset_perusahaan" => (isset($aset_perusahaan) and $aset_perusahaan != "") ? $aset_perusahaan : null,
            "bukan_aset_perusahaan_text" => (!$aset_perusahaan) ? $bukan_aset_perusahaan_text : null,
            "tingkat_kerusakan" => $tingkat_kerusakan,
            "detail_kerusakan_kerugian" => $detail_kerusakan_kerugian,
            "perkiraan_biaya" => $perkiraan_biaya
        ];

        $builder = $this->qBuilder->update_kerusakan($id, $payload);

        if ($builder) {
            $response = [
                "status" => true,
                "message" => 'Update data success.',
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Update data failed!',
            ];
        }

        return $this->respond($response, 200);
    }

    public function delete_kerusakan($id)
    {
        $builder = $this->qBuilder->delete_kerusakan($id);
        if ($builder) {
            $response = [
                "status" => true,
                "message" => "Delete success.",
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "Delete error.",
            ];
        }

        return $this->respond($response, 200);
    }
    /**
     * END Detail KERUSAKAN*/



    /**
     * Detail DIVISI TERKAIT
     * */
    public function create_divisi_terkait()
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $divisi_kode = $this->request->getVar('divisi_kode');
        $departemen_kode = $this->request->getVar('departemen_kode');
        $section_kode = $this->request->getVar('section_kode');
        $section = $this->request->getVar('section');

        // $validation = $this->qVal->insert_divisi_terkait();
        // if($validation) return $this->respond($validation, 200);

        $payload = [
            "lpa_id" => $lpa_id,
            "divisi_kode" => $divisi_kode,
            "departemen_kode" => $departemen_kode,
            "section_kode" => $section_kode,
            "section" => $section
        ];

        $builder = $this->qBuilder->insert_divisi_terkait($payload);

        if ($builder) {
            $response = [
                "status" => true,
                "message" => 'Insert data success.',
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Insert data failed!',
            ];
        }

        return $this->respond($response, 200);
    }

    public function update_divisi_terkait($id)
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $divisi_kode = $this->request->getVar('divisi_kode');
        $departemen_kode = $this->request->getVar('departemen_kode');
        $section_kode = $this->request->getVar('section_kode');
        $section = $this->request->getVar('section');

        // $validation = $this->qVal->update_divisi_terkait($id);
        // if($validation) return $this->respond($validation, 200);

        $payload = [
            // "lpa_id" => $lpa_id,
            "divisi_kode" => $divisi_kode,
            "departemen_kode" => $departemen_kode,
            "section_kode" => $section_kode,
            "section" => $section
        ];

        $builder = $this->qBuilder->update_divisi_terkait($id, $payload);

        if ($builder) {
            $response = [
                "status" => true,
                "message" => 'Update data success.',
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Update data failed!',
            ];
        }

        return $this->respond($response, 200);
    }

    public function delete_divisi_terkait($id)
    {
        $builder = $this->qBuilder->delete_divisi_terkait($id);
        if ($builder) {
            $response = [
                "status" => true,
                "message" => "Delete success.",
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "Delete error.",
            ];
        }

        return $this->respond($response, 200);
    }
    /**
     * END Detail DIVISI TERKAIT*/



    /**
     * Detail FOTO
     * */
    public function create_d_foto()
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $group_category = $this->request->getVar('group_category');
        $category = $this->request->getVar('category');
        $getFiles = $this->request->getFiles();

        /*// Testing
        $name = [];
        if ($getFiles) {
            foreach ($getFiles['file'] as $img) {
                // if ($img->isValid() && ! $img->hasMoved()) {
                //     $newName = $img->getRandomName();
                //     $img->move(WRITEPATH . 'uploads', $newName);
                // }
                $name[] = $img->getName();
            }
        }*/

        // $validation = $this->qVal->insert_divisi_terkait();
        // if($validation) return $this->respond($validation, 200);

        $builder = [];
        $responseb = [];
        /*if ($file != NULL) {
            $isFile = $file->isValid();
            if ($isFile) {
                $newName = $file->getRandomName();
                if (!$file->hasMoved()) {
                    $real_path = 'uploads/' . $file->store();
                }

                $foto_payload = [
                    "lpa_id" => $lpa_id,
                    "group_category" => $group_category,
                    "category" => $category,
                    "filepath" => $real_path
                ];

                $builder = $this->qBuilder->insert_d_foto($foto_payload);
            }
        }*/

        if ($getFiles) {
            foreach ($getFiles['file'] as $file) {
                $isFile = $file->isValid();
                if ($isFile) {
                    $newName = $file->getRandomName();
                    if (!$file->hasMoved()) {
                        $real_path = 'uploads/' . $file->store();
                    }

                    $foto_payload = [
                        "lpa_id" => $lpa_id,
                        "group_category" => $group_category,
                        "category" => $category,
                        "filepath" => $real_path
                    ];

                    $builder = $this->qBuilder->insert_d_foto($foto_payload);

                    $responseb[] = [
                        "id" => $builder,
                        // "lpa_id" => $lpa_id,
                        // "group_category" => $group_category,
                        // "category" => $category,
                        "filepath" => $real_path,
                        "file_url" => base_url($real_path)
                    ];

                    // $builder[] = $builder;
                }
            }
        }

        if ($responseb) {
            $response = [
                "status" => true,
                "message" => 'Insert data success.',
                "response" => $responseb
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Insert data failed!',
                "response" => $responseb
            ];
        }

        return $this->respond($response, 200);
    }

    public function update_d_foto($id = null)
    {
        $lpa_id = $this->request->getVar('lpa_id');
        $group_category = $this->request->getVar('group_category');
        $category = $this->request->getVar('category');
        $file = $this->request->getFile('file');
        $getFiles = $this->request->getFiles();

        // $validation = $this->qVal->update_d_foto();
        // if($validation) return $this->respond($validation, 200);

        $builder = [];
        if ($id) {
            if ($file != NULL) {
                $isFile = $file->isValid();
                if ($isFile) {
                    $newName = $file->getRandomName();
                    if (!$file->hasMoved()) {
                        $real_path = 'uploads/' . $file->store();
                    }

                    $foto_payload = [
                        "group_category" => $group_category,
                        "category" => $category,
                        "filepath" => $real_path
                    ];

                    $builder = $this->qBuilder->update_d_foto($id, $foto_payload);
                }
            }
        }else{
            if ($getFiles) {
                foreach ($getFiles['file'] as $key => $file) {
                    $isFile = $file->isValid();
                    if ($isFile) {
                        $newName = $file->getRandomName();
                        if (!$file->hasMoved()) {
                            $real_path = 'uploads/' . $file->store();
                        }

                        $foto_payload = [
                            "group_category" => $group_category,
                            "category" => $category,
                            "filepath" => $real_path
                        ];

                        $builder[] = $this->qBuilder->update_d_foto($key, $foto_payload);
                    }
                }
            }
        }

        if ($builder) {
            $response = [
                "status" => true,
                "message" => 'Update data success.',
                "response" => $builder
            ];
        } else {
            $response = [
                "status" => false,
                "message" => 'Update data failed!',
                "response" => $builder
            ];
        }

        return $this->respond($response, 200);
    }

    public function delete_d_foto($id = null)
    {
        if ($id == null) {
            $id = $this->request->getJsonVar('id');
        }

        $builder = $this->qBuilder->delete_d_foto($id);
        if ($builder) {
            $response = [
                "status" => true,
                "message" => "Delete success.",
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "Delete error.",
            ];
        }

        return $this->respond($response, 200);
    }
    /**
     * END Detail FOTO*/
}
