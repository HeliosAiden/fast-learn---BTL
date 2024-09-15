<?php

class Product extends Controller
{

    public $data = [];

    public function index()
    {
        $this -> list_product();
    }

    public function list_product() {
        $product = $this -> model('ProductModel');
        $dataProduct = $product -> get_product_list();

        $title = 'Danh mục sản phẩm';

        // Render view
        $this -> data['data']['product_list'] = $dataProduct;
        $this -> data['data']['page_title'] = $title;
        $this -> data['view'] = 'product/list';
        $this -> render($this -> data['view'], $this -> data['data']);
    }

    public function detail($id = 0) {
        $product = $this -> model('ProductModel');
        $dataProduct = $product -> get_detail($id);
        $this -> data['data']['info'] = $dataProduct;
        $this -> data['data']['title'] = 'Chi tiet san pham';
        $this -> data['data']['page_title'] = 'Chi tiet san pham';
        $this -> data['content'] = 'product/detail';
        $this -> render($this -> data['content'], $this -> data['data']);
    }
}
