<?php

namespace Home\Model;

use Think\Model;
use Home\Model\CommonModel;

class GoodsModel extends CommonModel {
    protected $tableName = "goods";

    /*
     * @author 曹梦瑶
     * 获取商品信息
     */
    public function getInfo($is_integral = 1) {
        $list = array();
        $list = $this->where(array(
            'status' => 1,
            'sale_status' => 1,
            'is_integral' => $is_integral,
        ))
            ->order('update_time desc')
            ->select();

        foreach ($list as $k => $v) {
            $list[$k]['price'] = round($v['price'] / 100, 2);
        }

        return $list;
    }

  /*
     * @author 曹梦瑶
     * 获取商品信息 通过搜索内容
     */
    public function getInfoBySearch($content) {
        $list = array();
        $list = $this->where(array(
            'status' => 1,
            'sale_status' => 1,
            'is_integral' => 1,
            'title' => array('like', '%'.$content.'%')
        ))
            ->order('update_time desc')
            ->select();

        foreach ($list as $k => $v) {
            $list[$k]['price'] = round($v['price'] / 100, 2);
        }

        return $list;
    }



    /*
     * @author 曹梦瑶
     * 根据产品id 获得产品信息
     */
    public function getInfoById($id) {
        $list = array();
        if($id) {
            $list = $this->where(array('id' => $id))->find();
            $list['price'] = round($list['price']/100, 2);

        }

//dd($this->getLastSql());
      return $list;
    }

    /*
     * @author 曹梦瑶
     * 根据产品id 获得产品信息
     */
    public function getInfoByIdArr($id_arr) {
        $list = array();
        if($id_arr) {
            $list = $this->
            where(array('id' => array('in', $id_arr)))
                ->field(array('id', 'title', 'cover_img_addr', 'price'))
            ->select();

            foreach ($list as $k =>$v) {
                $list[$k]['price'] = round($v['price']/100, 2);
            }
        }

//        dd($list,  $this->getLastSql());
      return $list;
    }

   /*
     * @author 曹梦瑶
     * 根据产品id 获得产品信息
     */
    public function getInfoByIdArr1($id_arr) {
        $list = array();
        if($id_arr) {
            $list = $this->
            where(array(
                'id' => array('in', $id_arr),
//                'type' => $type
            ))
                ->getField('id, title, cover_img_addr, price', true);

            foreach ($list as $k =>$v) {
                $list[$k]['price'] = round($v['price']/100, 2);
            }
        }


      return $list;
    }

    /*
     * @author 曹梦瑶
     * 根据分类查找信息
     */
    public function getSortInfo($sort_id) {
        $list = array();
        $list = $this->where(array(
            'status' => 1,
            'is_integral' => 2,
            'integral_sort_id' => $sort_id,
            'sale_status' => 1,
        ))
            ->select();
        return $list;
    }


}

?>