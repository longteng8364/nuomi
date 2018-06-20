<?php
namespace app\admin\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $account = session('admin', '', 'admin');
        if(!$account){
            return $this->redirect(url('login/index'));
        }
        return $this->fetch();
    }
    
    public function welcome(){
       $data = [
           'date' => date('Y-m-d H:i:s'),
       ];
       return "今天是 " . date('Y-m-d') . ' 祝你工作愉快！';
    }

    public function test(){
        \Map::getLngLat('河北省秦皇岛市世极城堡小区');
    }

    public function map(){
        return \Map::staticimage('秦皇岛世极城堡');
    }
}
