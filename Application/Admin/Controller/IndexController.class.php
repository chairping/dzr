<?php
namespace Admin\Controller;
use Admin\Services\MenuServices;
//use Think\Controller;
use Common\Controller\BaseController;
class IndexController extends BaseController {
    public function index(){
        

        $menus = MenuServices::getAdminMenu();
        $this->assign('menus', $menus);
        $this->display();
    }

   

}
