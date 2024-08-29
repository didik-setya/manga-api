<?php
require 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class Home extends RestController
{
    public function homepage_get()
    {
        $data_homepage = $this->m1->homepage();
        $this->response([
            'status' => true,
            'data' => $data_homepage
        ], 200);
    }

    public function view_manga_get()
    {
        $url1 = $this->uri->segment(3);
        $url2 = $this->uri->segment(4);
        $link = $url1 . '/' . $url2;

        $data = $this->m1->get_detail($link);


        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function chapter_get()
    {
        $url1 = $this->uri->segment(2);
        $url2 = $this->uri->segment(3);
        $url3 = $this->uri->segment(4);

        $link = $url1 . '/' . $url2 . '/' . $url3;

        $data = $this->m1->get_chapter($link);

        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function search_get()
    {
        $keyword = $this->uri->segment(3);

        if ($keyword) {
            $data = $this->m1->search($keyword);
            $this->response([
                'status' => true,
                'data' => $data
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'msg' => 'Please enter an keyword'
            ], 200);
        }
    }
}
