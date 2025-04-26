<?php

namespace App\Controllers\MyGallery;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use Sparkhizb\UmmuPhotos;
use Sparkhizb\GviewsHelper;
use Sparkhizb\UmmuUpload;

class PhotosController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->ummu = new UmmuPhotos();
        $this->gViews = new GviewsHelper();
        $this->upload = new UmmuUpload();
    }

    public function index()
    {
        // 
    }

    public function show($id = null)
    {
        $limit = $this->request->getVar('limit');
        $offset = $this->request->getVar('offset');
        $sort = $this->request->getVar('sort');
        $order = $this->request->getVar('order');
        $search = $this->request->getVar('search');

        $payload = [
            "limit" => (int) $limit,
            "offset" => (int) $offset,
            "sort" => (string) $sort,
            "order" => (string) $order,
            "search" => (string) $search,
            "date" => [
                "from" => "",
                "to" => ""
            ],
            "created_by" => true
        ];

        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => session()->get('token')
        ];

        $response = $this->ummu->show($params);

        return $this->respond($response, 200);
    }

    public function create()
    {
        $upload = $this->upload->create();

        if ($upload['status'] == true) {
            $filename = $upload['name'];
            $folder = $upload['folder'];
            $url = $upload['url'];

            $body = [
                "filename"  => $filename,
                "folder"    => $folder,
                "path"      => "",
                "url"       => $url
            ];

            $params = [
                "payload"   => $body,
                "token"     => session()->get('token')
            ];

            $response = $this->ummu->insert($params);

            return $this->respond($response, 200);
        }

        // // $file = $this->request->getFile('filename');
        // // // $filepath = '/home/qroot/Documents/test_import.xlsx';
        // // $filepath = $file;

        // // $body = [
        // //     "file" => new \CURLFILE($filepath)
        // // ];

        // // $params = [
        // //     "payload"        => $body,
        // //     "token"          => session()->get('token')
        // // ];

        // // // $response = $this->ummu->excel_to_array($params);

        // // // return $this->respond($response, 200);
        // // // $body = $this->request->getJsonVar('body');

        // // // $params = [
        // // //     "payload" => $body,
        // // //     "token" => session()->get('token')
        // // // ];

        // // // $response = $this->ummu->insert($params);

        // return $this->respond($body, 200);
    }

    public function update($id = null)
    {
        // $update = $this->mahasiswaHelper->update($id);
        // return $this->respond($update, 200);
    }

    public function delete($id = null)
    {
        $params = [
            "id" => $id,
            "payload" => [],
            "token" => session()->get('token')
        ];

        $response = $this->ummu->delete($params);

        return $this->respond($response, 200);
    }
}
