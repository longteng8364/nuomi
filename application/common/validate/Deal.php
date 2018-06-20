<?php
namespace app\common\validate;
use think\Validate;

class Deal extends Validate {
    protected $rule = [
        'name' => 'require|max:25',
        'category_id' => 'require',
        'city_id' => 'require',
        'start_time' => 'require',
        'end_time' => 'require',
        'total_count' => 'require',
        'origin_price' => 'require',
        'current_price' => 'require'
    ];

    protected $scene = [
        'add' => ['name','category_id', 'city_id','start_time', 'end_time', 'total_count','origin_price', 'current_price']
    ];
}
