<?php
namespace app\common\model;

use think\Model;

class Deal extends BaseModel
{

	public function getDeals($bisId) {

		$result = $this->where(['id'=>$bisId])->paginate();
		return  $result;
	} 

	public function getNormalDeals($data = []) {
		$data['status'] = 1;
		$order = ['id'=>'desc'];

		$result = $this->where($data)
			->order($order)
			->paginate();

		//echo $this->getLastSql();
		return  $result;
	}

	public function getApplyDeals($data = []) {
		$data['status'] = 0;
		$order = ['id'=>'desc'];

		$result = $this->where($data)
			->order($order)
			->paginate();

		return  $result;
	}

	public function getNormalDealByCategoryCityId($id, $cityId, $limit=10) {
		$data  = [
			'end_time' => ['gt', time()],
			'category_id' => $id,
			'city_id' => $cityId,
			'status' => 1,
		];

		$order = [
			'listorder'=>'desc',
			'id'=>'desc',
		];

		$result = $this->where($data)
			->order($order);
		if($limit) {
			$result = $result->limit($limit);
		}
		return $result->select();
	}

	public function getDealByConditions($data=[], $orders) {
		if(!empty($orders['order_sales'])) {
			$order['buy_count'] = 'desc';
		}
		if(!empty($orders['order_price'])) {
			$order['current_price'] = 'desc';
		}
		if(!empty($orders['order_time'])) {
			$order['create_time'] = 'desc';
		}
		$order['id'] = 'desc';
		

		$datas[] = ' end_time> '.time();
		$datas[] = ' status= 1';

		if(!empty($data['se_category_id'])) {
			
			$datas[]="find_in_set(".$data['se_category_id'].",se_category_id)";
		}
		if(!empty($data['category_id'])) {
			
			$datas[]="category_id = ".$data['category_id'];
		}
		if(!empty($data['city_id'])) {
			
			$datas[]="city_id = ".$data['city_id'];
		}	
		
		$result = $this->where(implode(' AND ',$datas))
			->order($order)
			->paginate();
			
		return $result;
	}

	public function updateBuyCountById($id, $buyCount) {
		return $this->where(['id' => $id])->setInc('buy_count', $buyCount);

	}
}