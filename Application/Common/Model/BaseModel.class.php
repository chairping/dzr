<?php

namespace Common\Model;

/**
* 
*/
class BaseModel extends \Think\Model
{
	
	 public function getListWithCount($where, $pageIndex, $pageSize, $order) {

        $count= $this->where($where)->count();

        if($count < $pageIndex* $pageSize){
            $pageIndex= intval($count/$pageSize) + (($count % $pageSize > 0) ? 1 : 0);
        }


        $data=$this->where($where)
            ->page($pageIndex,$pageSize)
            ->order($order)
            ->select();

        return compact('data', 'count');
    }

}