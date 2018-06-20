<?php
namespace app\api\controller;
use think\Controller;
class Category extends Controller {
    private $obj;
    public function _initialize(){
        $this->obj = model('Category');
    }
    public function getCategoryByParentId(){
        $id = input('post.id');
        if(!$id){
            $this->error('id不合法');
        }

        $categorys = $this->obj->getNormalcategorysByParentId($id);

        if(!$categorys){
            return show(0, 'error');
        }else{
            return show(1, 'success', $categorys);
        }
    }
}