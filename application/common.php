<?php

// 应用公共文件
function status($status){
    if($status == 1){
        $str = "<span class='label label-success radius'>正常</span>";
    }elseif($status == 0){
        $str = "<span class='label label-danger radius'>待审</span>";
    }else{
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    
    return $str;
}
/* 
    参数$type 0=>get  1=>post
*/
function doCurl($url, $type=0, $data=[]){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    if($type == 1){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
}

// 商户入驻申请的文案
function bisRegister($status) {
    if($status == 1) {
        $str = "入驻申请成功";
    }elseif($status == 0) {
        $str = "待审核，审核后平台方会发送邮件通知，请关注邮件";

    }elseif($status == 2) {
        $str = "非常抱歉，您提交的材料不符合条件，请重新提交";
    }else {
        $str = "该申请已被删除";
    }
    return $str;
}

 /* 通用的分页样式*/
function pagination($obj) {
    if(!$obj) {
        return '';
    }
    $params = request()->param();
    return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->appends($params)->render().'</div>';
}

function getSeCityName($path) {
    if(empty($path)) {
        return '';
    }
    if(preg_match('/,/', $path)) {
        $cityPath = explode(',', $path);
        $cityId = $cityPath[1];
    }else {
        $cityId = $path;
    }

    $city = model('City')->get($cityId);
    return $city->name;
}

function countLocation($ids) {
    if(!$ids) {
        return 1;
    }

    if(preg_match('/,/', $ids)) {
        $arr = explode(',', $ids);
        return count($arr);
    }

}

// 设置订单号
function setOrderSn() {
    list($t1, $t2) = explode(' ', microtime());
    //echo $t1."<br />";
    //echo $t2."<br/>";exit;
    $t3 = explode('.', $t1*10000);
    return $t2.$t3[0].(rand(10000, 99999));
}