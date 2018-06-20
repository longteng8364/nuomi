<?php
namespace app\admin\controller;
use think\Controller;
class Bis extends Controller
{
    private $obj;
    public function _initialize() {
        $this->obj = model("Bis");
    }
    
    /* 商户列表*/
    public function index() {
        $bis = $this->obj->getBisByStatus(1);
        return $this->fetch('', [
            'bis' => $bis,
        ]);
    }
    /* 入驻申请列表 */
    public function apply() {
        $bis = $this->obj->getBisByStatus();
        return $this->fetch('', [
            'bis' => $bis,
        ]);
    }

    public function detail() {
        $id = input('get.id');
        if(empty($id)) {
            return $this->error('ID错误');
        }
        //获取一级城市的数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级分类的数据
        $categorys = model('Category')->getNormalCategorysByParentId();

        // 获取商户数据
        $bisData = model('Bis')->get($id);
        $locationData = model('BisLocation')->get(['bis_id'=>$id, 'is_main'=>1]);
        
        $accountData = model('BisAccount')->get(['bis_id'=>$id, 'is_main'=>1]);
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'bisData' => $bisData,
            'locationData' => $locationData,
            'accountData' => $accountData,
        ]);
    }

    // 修改状态
    public function status() {
        $data = input('get.');

        $res = $this->obj->save(['status'=>$data['status']], ['id'=>$data['id']]);
        $location = model('BisLocation')->save(['status'=>$data['status']], ['bis_id'=>$data['id'], 'is_main'=>1]);
        $account = model('BisAccount')->save(['status'=>$data['status']], ['bis_id'=>$data['id'], 'is_main'=>1]);
        if($res && $location && $account) {
            // 发送邮件
            // \phpmailer\Email::send($data['email'],$title, $content);
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }

    }

}
