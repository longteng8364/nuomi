<?php
namespace app\index\controller;
use think\Controller;
class Lists extends Base
{
    public function index()
    {
        $firstCatIds = [];

        $categorys = model("Category")->getNormalCategorysByParentId();
        foreach($categorys as $category) {
            $firstCatIds[] = $category->id;
        }
        $id = input('id', 0, 'intval');
        $data = [];

        if(in_array($id, $firstCatIds)) { 
            $categoryParentId = $id;
            $data['category_id'] = $id;
        }elseif($id) {

            $category = model('Category')->get($id);
            if(!$category || $category->status !=1) {
                $this->error('数据不合法');
            }
            $categoryParentId = $category->parent_id;
            $data['se_category_id'] = $id;
        }else{ 
            $categoryParentId = 0;
        }
        $sedcategorys = [];

        if($categoryParentId) {
            $sedcategorys = model('Category')->getNormalCategorysByParentId($categoryParentId);
        }

        $orders = [];

        $order_sales = input('order_sales','');
        $order_price = input('order_price','');
        $order_time = input('order_time','');
        if(!empty($order_sales)) {
            $orderflag = 'order_sales';
            $orders['order_sales'] = $order_sales;
        }elseif(!empty($order_price)) {
            $orderflag = 'order_price';
            $orders['order_price'] = $orderflag;
        }elseif(!empty($order_time)) {
            $orderflag = 'order_time';
            $orders['order_time'] = $order_time;
        }else{
            $orderflag = '';
        }

        $data['city_id'] = $this->city->id; // add 
        // 根据上面条件来查询商品列表数据
        $deals = model('Deal')->getDealByConditions($data, $orders);
        return $this->fetch('', [
            'categorys' => $categorys,
            'sedcategorys' => $sedcategorys,
            'id' => $id,
            'categoryParentId' => $categoryParentId,
            'orderflag' => $orderflag,
            'deals' => $deals,
        ]);
    }
}
