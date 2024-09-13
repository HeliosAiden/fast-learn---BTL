<?php

class Product extends Controller
{
    public function index()
    {
        echo 'Danh sach san pham';
    }

    public function list_product() {
        $product = $this -> model('ProductModel');
        $data = $product -> get_product_list();
        echo '<pre>';
            print_r($data);
        echo '</pre>';
    }
}
