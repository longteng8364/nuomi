<?php
namespace app\admin\controller;
use think\Controller;
class Login extends  Controller
{
	public function index()
    {
        if(request()->isPost()) {
            $data = input('post.');
            //验证码
            if(!captcha_check($data['verifycode'])) {
                $this->error('验证码不正确');
                
            }

            $validate = validate('Admin');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            // 通过用户名 获取 用户相关信息
            $ret = model('Admin')->get(['username'=>$data['username']]);
            //判断是否存在该用户名
            if(!$ret) {
                $this->error('用户名有误');
            }
            //验证密码
            if($ret->password != md5($data['password'])) {
                $this->error('密码不正确','',1);
            }
            //所有验证通过
            
            session('admin', $ret, 'admin');
            return $this->success('登录成功', url('index/index'),1);
        }else {
            // 获取session
            $account = session('admin', '', 'admin');
            if($account) {
                return $this->redirect(url('index/index'));
            }
            return $this->fetch();
        }
    }

    public function logout() {
        // 清除session
        session(null, 'admin');
        // 跳出
        $this->redirect('login/index');
    }
}