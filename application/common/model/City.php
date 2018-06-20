<?php
namespace app\common\model;
use think\Model; 
class City extends Model {
    public function getNormalCitysByParentId($parentId=0){
        $data = [
            'parent_id' => $parentId
        ];

        return $this->where($data)->select();
    }

    public function getNormalCitys() {
        $data = [
            'parent_id' => ['gt', 0],
        ];

        $order = ['id'=>'desc'];

        return $this->where($data)
            ->order($order)
            ->select();

    }
}