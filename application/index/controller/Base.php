<?php
namespace app\index\controller;
use think\Controller;

class Base extends Controller
{
    public $city = '';
    public $account = '';

    public function _initialize() {
        // 城市数据
        $citys = model('City')->getNormalCitys();
        //用户数据

        $this->getCity($citys);
        // 获取首页分类的数据
        $cats = $this->getRecommendCats();
        $this->assign('citys', $citys);
        $this->assign('city', $this->city);
        $this->assign('cats', $cats);
        $this->assign('controller', strtolower(request()->controller()));
        $this->assign('user', $this->getLoginUser());
        $this->assign('title', '百度糯米');
    }

    public function getCity($citys) {
        foreach($citys as $city) {
            $city = $city->toArray();
            if($city['is_default'] == 1) {
                $defaultuname = $city['uname'];
                break; 
            }
        }

        $defaultuname = $defaultuname ? $defaultuname : 'beijing';
        if(session('cityuname', '', 'o2o') && !input('get.city')) {
            $cityuname = session('cityuname', '', 'o2o');
        }else {
            $cityuname = input('get.city', $defaultuname, 'trim');
            session('cityuname', $cityuname, 'o2o');
        }

        $this->city = model('City')->where(['uname'=>$cityuname])->find();
    }

    public function getLoginUser() {
        if(!$this->account) {
            $this->account = session('o2o_user', '', 'o2o');
        }
        return $this->account;
    }

    // 获取首页推荐当中的商品分类数据
    public function getRecommendCats() {
        $parentIds = $sedcatArr = $recomCats = [];
        $cats = model('Category')->getNormalRecommendCategoryByParentId(0,5);
        foreach($cats as $cat) {
            $parentIds[] = $cat->id;
        }
        // 获取二级分类的数据
        $sedCats = model('Category')->getNormalCategoryIdParentId($parentIds);

        foreach($sedCats as $sedcat) {
            $sedcatArr[$sedcat->parent_id][] = [
                'id' => $sedcat->id,
                'name' => $sedcat->name,
            ];
        }

        foreach($cats as $cat) {
            $recomCats[$cat->id] = [$cat->name, empty($sedcatArr[$cat->id]) ? [] : $sedcatArr[$cat->id]];
        }
        return $recomCats;
    }
}
