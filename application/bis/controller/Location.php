<?php
namespace app\bis\controller;
use think\Controller;
class Location extends Base
{
    private $obj;
    public function _initialize(){
        $this->obj = model('BisLocation');
    }
    
    //门店列表
    public function index()
    {
        $bisId = $this->getLoginUser()->bis_id;
        $result = $this->obj->getNormalLocationByBisId($bisId);
        //dump($result);exit;
        return $this->fetch('',[
            'locations' => $result
        ]);
    }

    //门店添加
    public function add() {
        if(request()->isPost()) {
            $data = input('post.');
            //验证
            $validate = validate('Location');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            $bisId = $this->getLoginUser()->bis_id;
            $data['cat'] = '';
            if(!empty($data['se_category_id'])) {
                $data['cat'] = implode('|', $data['se_category_id']);
            }

            // 获取经纬度
            $lnglat = \Map::getLngLat($data['address']);
            if(empty($lnglat) || $lnglat['status'] !=0 || $lnglat['result']['precise'] !=1) {
                $this->error('无法获取数据，或者匹配的地址不精确');
            }

            // 门店入库
            $locationData = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'logo' => $data['logo'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'category_path' => $data['category_id'] . ',' . $data['cat'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
                'api_address' => $data['address'],
                'open_time' => $data['open_time'],
                'content' => empty($data['content']) ? '' : $data['content'],
                'is_main' => 0,
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
            ];
            $locationId = model('BisLocation')->add($locationData);
            if($locationId) {
                return $this->success('门店添加成功');
            }else {
                return $this->error('门店添加失败');
            }
        }else {
            //获取一级城市的数据
            $citys = model('City')->getNormalCitysByParentId();
            //获取一级栏目的数据
            $categorys = model('Category')->getNormalCategorysByParentId();
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys,
            ]);
        }
    }

    //门店详情
    public function detail() {
        $id = input('get.id');
        if(empty($id)) {
            return $this->error('ID错误');
        }
        //获取一级城市的数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级分类的数据
        $categorys = model('Category')->getNormalCategorysByParentId();

        // 获取门店数据
        $locationData = model('BisLocation')->get(['id'=>$id]);
        
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'locationData' => $locationData,
        ]);
    }

    //门店编辑
    public function edit($id){
        if(request()->isPost()) {
            $data = input('post.');
            //验证一下
            $validate = validate('Location');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            // 获取经纬度
            $lnglat = \Map::getLngLat($data['address']);
            if(empty($lnglat) || $lnglat['status'] !=0 || $lnglat['result']['precise'] !=1) {
                $this->error('无法获取数据，或者匹配的地址不精确');
            }

            // 门店入库
            $locationData = [
                'name' => $data['name'],
                'tel' => $data['tel'],
                'contact' => $data['contact'],
                'category_id' => $data['category_id'],
                'city_id' => $data['city_id'],
                'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
                'api_address' => $data['address'],
                'content' => empty($data['content']) ? '' : $data['content'],
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
            ];
            $locationId = model('BisLocation')->updateById($locationData, $id);
            if($locationId) {
                return $this->success('修改成功','location/index');
            }else {
                return $this->error('修改失败');
            }
        }else {
            //获取一级城市的数据
            $citys = model('City')->getNormalCitysByParentId();
            //获取一级栏目的数据
            $categorys = model('Category')->getNormalCategorysByParentId();
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys,
            ]);
        }
    }
    //状态修改
    public function status(){
        $data = input('get.');

        $res = $this->obj->where('id', $data['id'])->update(['status'=>$data['status']]);
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}
