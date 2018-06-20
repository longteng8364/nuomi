<?php
namespace app\common\validate;
use think\Validate;

class Location extends Validate {
    protected $rule = [
        'name' => 'require|max:25',
        'logo' => 'require',
        'city_id' => 'require',
        'se_city_id' => 'require',
        'category_id' => 'require',
        'address' => 'require',
        'tel' => 'require',
        'contact' => 'require',
        'open_time' => 'require'
    ];

    protected $scene = [
        'add' => ['name', 'logo', 'city_id', 'se_city_id', 'category_id', 'address', 'tel', 'contact', 'open_time'],

        'edit' => ['name', 'city_id', 'se_city_id', 'category_id', 'address', 'tel', 'contact']
    ];

    
}
