<?php
namespace app\index\controller;
use think\Controller;

class Index extends Base
{
    public function index()
    {
        // 获取首页大图数据
        $datus = model('Featured')->getFeaturedsByType(0);
        $datus = $datus->toArray();
        //dump($datus);exit;
        // 获取广告位数据
        $ads = model('Featured')->getFeaturedsByType(1);
        $ads = $ads->toArray();
        //dump($ads);exit;
        // 商品分类 数据-美食 推荐的数据
        $datas = model('Deal')->getNormalDealByCategoryCityId(1, $this->city->id);
        //dump($datas);exit;
        // 获取4个子分类
        $meishicates = model('Category')->getNormalRecommendCategoryByParentId(1, 4);
        return $this->fetch('',[
            'datu' => $datus,
            'ads' => $ads['data'][0],
            'datas' => $datas,
            'meishicates' => $meishicates,
            'controller' => 'index',
        ]);
    }
}
