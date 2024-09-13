<?php

class HomeModel
{
    protected $table = 'products';

    public function get_list()
    {
        $data = [
            'Item 1',
            'Item 2',
            'Item 3'
        ];
        return $data;
    }

    public function get_detail($id)
    {
        $data = [
            'Item 1',
            'Item 2',
            'Item 3'
        ];
        return $data[$id];
    }
}
