<?php
namespace app\admin\controller;
use think\Controller;
class Featured extends Base
{
    private  $obj;
    public function _initialize() {
        $this->obj = model("Featured");
    }

	public function index() {
		// 获取推荐位类别
		$types = config('featured.featured_type');
		$type = input('get.type', 0 ,'intval');
		// 获取列表数据
		$results = $this->obj->getFeaturedsByType($type);

		return $this->fetch('', [
			'types' => $types,
			'results' => $results,
			
		]);
	}
    public function add() {
		if(request()->isPost()) {
			$data = input('post.');

			$id = model('Featured')->add($data);
			if($id) {
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else {
			// 获取推荐位类别 
			$types = config('featured.featured_type');
			return $this->fetch('', [
				'types' => $types,
			]);
		}
	}
}
