<?php
namespace Admin\Controller;
use Admin\Services\MenuServices;
use Think\Controller;
class IndexController extends Controller {
    public function index(){

        $menus = MenuServices::getAdminMenu();
        $this->assign('menus', $menus);
        $this->display();
    }

   

}
