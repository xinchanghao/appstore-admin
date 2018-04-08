<?php
namespace Admin\Controller;
use Admin\Common\Controller\LC;

class IndexController extends LC {
    public function index(){
        header('Content-Type:text/html; charset=utf-8');
        $Dao=M("apps");
        $list=$Dao->order('DownloadCount desc')->limit(5)->select();
//        $down=$Dao->field('AppName,COUNT(DownloadCount)')->group('AppName')->select();//查询类似应用的相应总量；
        $down=array(
            'sum'=>$Dao->SUM('DownloadCount'),
            'avg'=>$Dao->AVG('DownloadCount'),
            'max'=>$Dao->MAX('DownloadCount'),
            'count'=>$Dao->count('DownloadCount'),
        );
        $this->assign('down',$down);
        $this->assign('list',$list);
        $this->display();
    }

}