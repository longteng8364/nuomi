<?php
namespace app\bis\controller;
use think\Controller;
class Deal extends Base
{
    private $obj;
    public function _initialize(){
        $this->obj = model('deal');
    }
    
    //团购列表
    public function index()
    {
        $bisId = $this->getLoginUser()->bis_id;
        $result = $this->obj->getDeals($bisId);
        //dump($result);exit;
        return $this->fetch('',[
            'deals' => $result
        ]);
    }

    //添加
    public function add() {
        $bisId = $this->getLoginUser()->bis_id;
        if(request()->isPost()) {
            $data = input('post.');
              //校验数据
            $validate = validate('deal');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            $location = model('BisLocation')->get($data['location_ids'][0]);
            $deals = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'image' => $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',', $data['se_category_id']),
                'city_id' => $data['city_id'],
                'location_ids' => empty($data['location_ids']) ? '' : implode(',', $data['location_ids']),
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'notes' => $data['notes'],
                'description' => $data['description'],
                'bis_account_id' => $this->getLoginUser()->id,
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint,
            ];

            $id = model('Deal')->add($deals);
            if($id) {
                $this->success('添加成功', url('deal/index'));
            }else {
                $this->error('添加失败');
            }

        }else {
            //获取一级城市的数据
            $citys = model('City')->getNormalCitysByParentId();
            //获取一级栏目的数据
            $categorys = model('Category')->getNormalCategorysByParentId();
            return $this->fetch('', [
                'citys' => $citys,
                'categorys' => $categorys,
                'bislocations' => model('BisLocation')->getNormalLocationByBisId($bisId),
            ]);
        }
    }

    //查看详情
    public function detail(){
        $id = input('get.id');
        $dealData = model('deal')->get(['id'=>$id]);
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
            'deal' => $dealData,
            'citys' => $citys,
            'categorys' => $categorys,
            'locationData' => $locationData
        ]);
    }

    //编辑
    public function edit($id) {
        if(request()->isPost()) {
            $data = input('post.');
              //校验数据
            $validate = validate('deal');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            $deal = model('Deal')->get(['id'=>$id]);
            $newData = [
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'city_id' => $data['city_id'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'notes' => $data['notes'],
                'description' => $data['description'],
            ];

            $res = model('Deal')->updateById($newData, $id);
            if($res) {
                $this->success('修改成功', url('deal/index'));
            }else {
                $this->error('修改失败');
            }

        }else {
            return $this->error('error');
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
