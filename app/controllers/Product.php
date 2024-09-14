<?php

class Product extends Controller
{

    public $data = [];

    public function index()
    {
        echo 'Danh sach san pham';
    }

    public function list_product() {
        $product = $this -> model('ProductModel');
        $dataProduct = $product -> get_product_list();

        $title = 'Danh mục sản phẩm';

        // Render view
        $this -> data['product_list'] = $dataProduct;
        $this -> data['page_title'] = $title;
        $this -> render('product/list', $this -> data);
    }

    public function detail($id = 0) {
        $product = $this -> model('ProductModel');
        $dataProduct = $product -> get_detail($id);
        $this -> data['sub_content']['info'] = $dataProduct;
        $this -> data['sub_content']['title'] = 'Chi tiet san pham';
        $this -> data['content'] = 'product/detail';
        $this -> render('layouts/client', $this -> data);
    }
}
