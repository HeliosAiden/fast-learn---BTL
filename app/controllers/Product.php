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
        $this -> data['product_list'] = $dataProduct;
        $this -> data['page_title'] = $title;
        $this -> data['url'] = 'product/list';
        $this -> render_layout('client', $this -> data);
    }

    public function detail($id = 0) {
        $product = $this -> model('ProductModel');
        $dataProduct = $product -> get_detail($id);
        $this -> data['info'] = $dataProduct;
        $this -> data['title'] = 'Chi tiet san pham';
        $this -> data['page_title'] = 'Chi tiet san pham';
        $this -> data['url'] = 'product/detail';
        $this -> render_layout('client', $this -> data);
    }

}
