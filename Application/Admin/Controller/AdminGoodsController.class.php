<?php
/**
 * Created by PhpStorm.
 * User: cp
 * Date: 16/11/11
 * Time: 22:22
 */

namespace Admin\Controller;


use Common\Controller\AdminController;

class AdminGoodsController extends AdminController
{
    public function index() {

        $this->display();
    }

    public function add() {

    }

    public function edit() {
        $this->display();
    }

}