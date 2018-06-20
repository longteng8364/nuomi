<?php
namespace app\common\validate;
use think\Validate;

class Login extends Validate {
    protected $rule = [
        ['username', 'require'],
        ['password', 'require']
    ];
}
