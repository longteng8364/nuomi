<?php
namespace app\index\controller;

class User extends Base
{
    public function login()
    {
        // 获取session 
        $user = session('o2o_user','', 'o2o');
        if($user) {
           $this->redirect(url('index/index'));
        }
        return $this->fetch('',['controller'=>'login']);
    }
    public function register()
    {
        if(request()->isPost()){
            $data = input('post.');

            if(!captcha_check($data['verifycode'])) {
                $this->error('验证码不正确');
            }
            
            $validate = validate('User');
            if(!$validate->scene('register')->check($data)){
                $this->error($validate->getError());
            }

            if($data['password'] != $data['repassword']) {
                $this->error('两次输入的密码不一样');
            }
            // 随机生成密码的加盐字符串
            $data['code'] = mt_rand(100, 10000);
            $data['password'] = md5($data['password'].$data['code']);
            
            try {
                $res = model('User')->add($data);
            }catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            if($res) {
                $this->success('注册成功',url('user/login'));
            }else{
                $this->error('注册失败');
            }

        }else {
            return $this->fetch('', ['controller'=>'register']);
        }
    }

    public function logincheck() {
        //判定
        if(!request()->isPost()) {
           $this->error('提交不合法');
        }
        $data = input('post.');

        try {
            $user = model('User')->getUserByUsername($data['username']);
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }
        //print_r($user);

        if(!$user || $user->status != 1) {
            $this->error('该用户不存在');
        }

        if(md5($data['password'].$user->code) != $user->password) {
            $this->error('密码不正确');
        }

        model('User')->updateById(['last_login_time'=>time()], $user->id);

        session('o2o_user', $user, 'o2o');

        $this->success('登录成功', url('index/index'));

    }

    public function logout() {
        session(null, 'o2o');
        $this->redirect(url('user/login'));
    }
}
