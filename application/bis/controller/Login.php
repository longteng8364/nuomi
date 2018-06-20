<?php
namespace app\bis\controller;
use think\Controller;
class Login extends  Controller
{
	public function index()
    {
        if(request()->isPost()) {
            $data = input('post.');

            $validate = validate('Login');
            if(!$validate->check($data)){
            $this->error($validate->getError());
            }
            //通过用户名获取用户信息
            $ret = model('BisAccount')->get(['username'=>$data['username']]);

            if(!$ret || $ret->status !=1 ) {
                $this->error('该用户不存在，或未被审核通过');
            }

            if($ret->password != md5($data['password'].$ret->code)) {
                $this->error('密码不正确');
            }
            //登录成功，更新一下最后登录时间
            model('BisAccount')->updateById(['last_login_time'=>time()], $ret->id);
            // 保存用户信息  
            session('bisAccount', $ret, 'bis');
            return $this->success('登录成功', url('index/index'));


        }else {
            // 获取session
            $account = session('bisAccount', '', 'bis');
            if($account) {
                return $this->redirect(url('index/index'));
            }
            return $this->fetch();
        }
    }

    public function logout() {
        // 清除session
        session(null, 'bis');
        // 跳出
        $this->redirect('login/index');
    }
}