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

        // Render view
        $this -> data['product_list'] = $dataProduct;
        $this -> render('product/list', $this -> data);
    }

    public function detail() {
        $this -> render('product/detail');
    }
}
