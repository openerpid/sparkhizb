<?php

namespace Sparkhizb;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: Sparkhizb LIB
* Description: 
* =============================================
*/

use Sparkhizb\Helpers\Curl;

class UmmuUpload
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->curli = new Curl();
    }

    public function filepath()
    {
        $file_upload    = $this->request->getFile('file_upload');
        $ci_file        = new \CodeIgniter\Files\File($file_upload);

        $filepath = '';
        if ($ci_file->getBasename()) {
            if (! $file_upload->hasMoved()) {
                $filepath = WRITEPATH . 'uploads/' . $file_upload->store();
            }
        }

        return $filepath;
    }

    public function path_upload($fileVar)
    {
        $ci_file        = new \CodeIgniter\Files\File($fileVar);

        $filepath = '';
        if ($ci_file->getBasename()) {
            if (! $fileVar->hasMoved()) {
                $filepath = WRITEPATH . 'uploads/' . $fileVar->store();
            }
        }

        return $filepath;
    }

    public function create()
    {
        $file_upload = $this->request->getFile('file_upload');
        $folder = date("Ymd");
        $folder_path = FCPATH. 'uploads/' .$folder. '/';

        if ($file_upload) {
            if (!$file_upload->hasMoved()) {
                $newName = $file_upload->getRandomName();
                $file_upload->move($folder_path, $newName);
                $data = [
                    'status'    => true,
                    'name'      => $newName,
                    'folder'    => $folder,
                    'url'       => base_url(). 'uploads/' .$folder. '/' .$newName,
                ];
            }else{
                $data = [
                    'status' => false,
                    'errors' => 'The file has already been moved.'
                ];
            }
        }else{
            $data = [
                'status' => false,
                'errors' => 'The file required.'
            ];
        }

        return $data;
    }

    public function create_20250228()
    {
        // $validationRule = [
        //     'file_upload' => [
        //         'label' => 'Image File',
        //         'rules' => [
        //             'uploaded[file_upload]',
        //             'is_image[file_upload]',
        //             'mime_in[file_upload,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
        //             'max_size[file_upload,500]',
        //             // 'max_dims[foto_mahasiswa,1024,768]',
        //         ],
        //     ],
        // ];

        $file_upload = $this->request->getFile('file_upload');
        $folder = date("Ymd");
        $folder_path = FCPATH. 'uploads/' .$folder. '/';


        // if (! $this->validate($validationRule)) {
        //     $data = [
        //         'status'        => false,
        //         'errors'        => $this->validator->getErrors()
        //     ];
        //     return $this->respond($data, 200);
        // }

        if (!$file_upload->hasMoved()) {
            $newName = $file_upload->getRandomName();
            $file_upload->move($folder_path, $newName);
            $data = [
                'status'    => true,
                'name'      => $newName,
                'folder'    => $folder,
                'url'       => base_url(). 'uploads/' .$folder. '/' .$newName,
            ];
        }else{
            $data = [
                'status' => false,
                'errors' => 'The file has already been moved.'
            ];
        }

        return $data;
    }

    public function create2($data)
    {
        // $validationRule = [
        //     'file_upload' => [
        //         'label' => 'Image File',
        //         'rules' => [
        //             'uploaded[file_upload]',
        //             'is_image[file_upload]',
        //             'mime_in[file_upload,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
        //             'max_size[file_upload,500]',
        //             // 'max_dims[foto_mahasiswa,1024,768]',
        //         ],
        //     ],
        // ];

        // $file_upload = $this->request->getFile('file_upload');
        $file_upload = $data;
        $folder = date("Ymd");
        $folder_path = FCPATH. 'uploads/' .$folder. '/';


        // if (! $this->validate($validationRule)) {
        //     $data = [
        //         'status'        => false,
        //         'errors'        => $this->validator->getErrors()
        //     ];
        //     return $this->respond($data, 200);
        // }

        if (!$file_upload->hasMoved()) {
            $newName = $file_upload->getRandomName();
            $file_upload->move($folder_path, $newName);
            $data = [
                'status'    => true,
                'name'      => $newName,
                'folder'    => $folder,
                'url'       => base_url(). 'uploads/' .$folder. '/' .$newName,
            ];
        }else{
            $data = [
                'status' => false,
                'errors' => 'The file has already been moved.'
            ];
        }

        return $data;
    }
}
