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

        $builder = $this->qBuilder->show($id);
        $total = $this->qHelp->_total($builder);
        $rows = $this->qHelp->_rowsBui($builder);
        $count = count($rows);
        $rows = $this->qBuilder->joinData($rows);
        if ($rows) {
            foreach ($rows as $key => $value) {
                if ($show_detail_orang_terlibat) {
                    $orang = $this->qBuilder->show_d_orang($value->id);
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
        $divisi = $this->request->getVar('divisi');
        $departemen = $this->request->getVar('departemen');
        $section = $this->request->getVar('section');
        $tanggal_kejadian = $this->request->getVar('tanggal_kejadian');
        $tanggal_pelaporan = $this->request->getVar('tanggal_pelaporan');
        $waktu_pelaporan = $this->request->getVar('waktu_pelaporan');
        $shift_kerja = $this->request->getVar('shift_kerja');
        $mulai_shift = $this->request->getVar('mulai_shift');
        $selesai_shift = $this->request->getVar('selesai_shift');
        $waktu_kejadian = $this->request->getVar('waktu_kejadian');
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

        $payload = [
            "nomor_dokumen" => $nomor_dokumen,
            "insident_classification" => $insident_classification,
            "site" => $site,
            "divisi" => $divisi,
            "departemen" => $departemen,
            "section" => $section,
            "tanggal_kejadian" => $tanggal_kejadian,
            "tanggal_pelaporan" => $tanggal_pelaporan,
            "waktu_pelaporan" => $waktu_pelaporan,
            "shift_kerja" => $shift_kerja,
            "mulai_shift" => $mulai_shift,
            "selesai_shift" => $selesai_shift,
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
            // "orang_terlibat_arr" => $orang_terlibat_arr,
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
                        "perusahaan" => $perusahaan
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
                    $aset_perusahaan = (isset($value['aset_perusahaan']) ? $value['aset_perusahaan'] : null);
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
        $divisi = $this->request->getVar('divisi');
        $departemen = $this->request->getVar('departemen');
        $section = $this->request->getVar('section');
        $tanggal_kejadian = $this->request->getVar('tanggal_kejadian');
        $tanggal_pelaporan = $this->request->getVar('tanggal_pelaporan');
        $waktu_pelaporan = $this->request->getVar('waktu_pelaporan');
        $shift_kerja = $this->request->getVar('shift_kerja');
        $mulai_shift = $this->request->getVar('mulai_shift');
        $selesai_shift = $this->request->getVar('selesai_shift');
        $waktu_kejadian = $this->request->getVar('waktu_kejadian');
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

        /*set to payload*/
        if(isset($insident_classification)) $payload["insident_classification"] = $insident_classification;
        if(isset($site)) $payload["site"] = $site;
        if(isset($divisi)) $payload["divisi"] = $divisi;
        if(isset($departemen)) $payload["departemen"] = $departemen;
        if(isset($section)) $payload["section"] = $section;
        if(isset($tanggal_kejadian)) $payload["tanggal_kejadian"] = $tanggal_kejadian;
        if(isset($tanggal_pelaporan)) $payload["tanggal_pelaporan"] = $tanggal_pelaporan;
        if(isset($waktu_pelaporan)) $payload["waktu_pelaporan"] = $waktu_pelaporan;
        if(isset($shift_kerja)) $payload["shift_kerja"] = $shift_kerja;
        if(isset($mulai_shift)) $payload["mulai_shift"] = $mulai_shift;
        if(isset($selesai_shift)) $payload["selesai_shift"] = $selesai_shift;
        if(isset($waktu_kejadian)) $payload["waktu_kejadian"] = $waktu_kejadian;
        if(isset($lokasi_insiden)) $payload["lokasi_insiden"] = $lokasi_insiden;
        if(isset($detail_lokasi_insiden)) $payload["detail_lokasi_insiden"] = $detail_lokasi_insiden;
        if(isset($cidera)) $payload["cidera"] = $cidera;
        if(isset($detail_cidera_lainnya)) $payload["detail_cidera_lainnya"] = $detail_cidera_lainnya;
        if(isset($kronologi)) $payload["kronologi"] = $kronologi;
        if(isset($instansi_pemerintah)) $payload["instansi_pemerintah"] = $instansi_pemerintah;
        if(isset($nama_pejabat)) $payload["nama_pejabat"] = $nama_pejabat;
        if(isset($pemerintah_disampaikan_oleh)) $payload["pemerintah_disampaikan_oleh"] = $pemerintah_disampaikan_oleh;
        if(isset($pemerintah_tanggal)) $payload["pemerintah_tanggal"] = $pemerintah_tanggal;
        if(isset($asuransi)) $payload["asuransi"] = $asuransi;
        if(isset($nama_perusahaan)) $payload["nama_perusahaan"] = $nama_perusahaan;
        if(isset($asuransi_disampaikan_oleh)) $payload["asuransi_disampaikan_oleh"] = $asuransi_disampaikan_oleh;
        if(isset($asuransi_tanggal)) $payload["asuransi_tanggal"] = $asuransi_tanggal;
        if(isset($pihak_tiga)) $payload["pihak_tiga"] = $pihak_tiga;
        if(isset($nama_pihak_ketiga)) $payload["nama_pihak_ketiga"] = $nama_pihak_ketiga;
        if(isset($pihak_tiga_disampaikan_oleh)) $payload["pihak_tiga_disampaikan_oleh"] = $pihak_tiga_disampaikan_oleh;
        if(isset($pihak_tiga_tanggal)) $payload["pihak_tiga_tanggal"] = $pihak_tiga_tanggal;
        if(isset($tipe_insiden)) $payload["tipe_insiden"] = $tipe_insiden;
        if(isset($penjelasan_insiden)) $payload["penjelasan_insiden"] = $penjelasan_insiden;


        // ############## ORANG TERLIBAT #################
        $orang_terlibat = $this->request->getVar('orang_terlibat');
        $orang_terlibat_payload_arr = [];
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

            $orang_terlibat_payload = [];

            if(isset($status_karyawan)) $orang_terlibat_payload["status_karyawan"] = $status_karyawan;
            if(isset($nik)) $orang_terlibat_payload["nik"] = $nik;
            if(isset($name)) $orang_terlibat_payload["name"] = $name;
            if(isset($jk)) $orang_terlibat_payload["jk"] = $jk;
            if(isset($jabatan)) $orang_terlibat_payload["jabatan"] = $jabatan;
            if(isset($atasan)) $orang_terlibat_payload["atasan"] = $atasan;
            if(isset($umur)) $orang_terlibat_payload["umur"] = $umur;
            if(isset($pengalaman_tahun)) $orang_terlibat_payload["pengalaman_tahun"] = $pengalaman_tahun;
            if(isset($pengalaman_bulan)) $orang_terlibat_payload["pengalaman_bulan"] = $pengalaman_bulan;
            if(isset($sebagai)) $orang_terlibat_payload["sebagai"] = $sebagai;
            if(isset($perusahaan)) $orang_terlibat_payload["perusahaan"] = $perusahaan;

            $orang_terlibat_payload_arr[] = $orang_terlibat_payload;

            // $update_orangTerlibat = $this->qBuilder->insert_orangTerlibat($key, $orang_terlibat_payload);
        }

        $payload['orang_terlibat'] = $orang_terlibat_payload_arr;


        //############## KERUSAKAN #################
        $kerusakan = $this->request->getVar('kerusakan');
        $kerusakan_payload_arr = [];
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

            $kerusakan_payload = [];

            if(isset($jenis_kerusakan)) $kerusakan_payload["jenis_kerusakan"] = $jenis_kerusakan;
            if(isset($name)) $kerusakan_payload["name"] = $name;
            if(isset($tipe)) $kerusakan_payload["tipe"] = $tipe;
            if(isset($aset_perusahaan)) $kerusakan_payload["aset_perusahaan"] = $aset_perusahaan;
            if(isset($serial_number)) $kerusakan_payload["serial_number"] = $serial_number;
            if(isset($tingkat_kerusakan)) $kerusakan_payload["tingkat_kerusakan"] = $tingkat_kerusakan;
            if(isset($kerusakan_keparahan)) $kerusakan_payload["kerusakan_keparahan"] = $kerusakan_keparahan;
            if(isset($detail_kerusakan_kerugian)) $kerusakan_payload["detail_kerusakan_kerugian"] = $detail_kerusakan_kerugian;
            if(isset($perkiraan_biaya)) $kerusakan_payload["perkiraan_biaya"] = $perkiraan_biaya;

            $kerusakan_payload_arr[] = $kerusakan_payload;

            // $update_kerusakan = $this->qBuilder->update_kerusakan($key, $kerusakan_payload);
        }
        $payload['kerusakan_payload'] = $kerusakan_payload_arr;

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

        // $builder = $this->qBuilder->update($id, $payload);

        // if ($builder) {
        //     // if ($is_pic == 1) {
        //     //     $builder = $this->qBuilder->createTrx($payload2);
        //     // }
        //     $this->responz = array(
        //         "status"    => true,
        //         "message"   => "Updaate data finish.",
        //         "response"  => $builder,
        //         "errors"    => null
        //     );
        //     $rescod = 200;
        // }else{
        //     $this->responz = array(
        //         "status"    => false,
        //         "message"   => "Updaate data failed.",
        //         "response"  => $builder,
        //         "errors"    => null
        //     );
        //     $rescod = 200;
        // }

        return $this->respond($payload, 200);
    }

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
}
