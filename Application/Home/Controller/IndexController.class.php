<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
      D("person")->changePwd(1,"321","123");
    }
}