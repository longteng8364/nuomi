<?php
namespace app\index\validate;
use think\Validate;

class User extends Validate {
    protected $rule = [
        'username' => 'require|max:25',
        'email' => 'email',
        'password' => 'require',
        'repassword' => 'require'
    ];

    protected $scene = [
        'register' => ['username', 'email', 'password', 'repassword'],
        'login' => ['username', 'password']
    ];
}
