<?php
/**
*  企业资料
*/
namespace App\Controller;
use Org\Nx\Response;
class DownloadController extends PublicController{

	
	private $model = null;
	
	//继承父类
	public function __construct(){
		parent::__construct();
		$this->stats = D('Downloadstats');
	}
	
	//企业资料统计
	public function dstats(){
		
		if( IS_POST ){
			$res = $this->stats->search();
		
			$data = array(
				'result' => $res['data'],
				//'page' => $res['page'],
				
			);
			//p($data['result']);die;
			if($data['result'] == null ){
				Response::show(401,'没有更多数据!');
				
			}else{
				Response::show(200,'数据获取成功!',$data);
				
			}
		}else{
			Response::show(402,'参数不合法!');
			
		}
       
	}
	//谁下载的
	public function downwho(){
		
		if( IS_POST ){
			$res = $this->stats->downwho();
		
			$data = array(
				'result' => $res['data'],
				//'page' => $res['page'],
				
			);
			//p($data['result']);die;
			if($data['result'] == null ){
				Response::show(401,'没有更多数据!');
				
			}else{
				Response::show(200,'数据获取成功!',$data);
				
			}
		}else{
			Response::show(402,'参数不合法!');
			
		}
	}
	
	
}

?>