<?php
class ProductModel extends Model
{

    public function get_product_list()
    {
        return [
            'San pham 1',
            'San pham 2',
            'San pham 3'
        ];
    }

    public function get_detail($id) {
        $data = [
            'San pham 1',
            'San pham 2',
            'San pham 3'
        ];
        return $data[$id];
    }
}
