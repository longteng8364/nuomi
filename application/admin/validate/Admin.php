<?php
namespace app\admin\validate;
use think\Validate;

class Admin extends Validate {
    protected $rule = [
        ['username', 'require'],
        ['password', 'require']
    ];
}
