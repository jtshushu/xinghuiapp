<?php
/**
 * 企业产品统计
 */
namespace Home\Model;
use Common\Model\BaseModel;

class ProductModel extends BaseModel{
	
	public function search($pagesize=15){

		//搜索
		$where = array();
		$title = I('get.title');
		if ($title) {
			$where['title'] = array('like',"%$title%");
		}
		$where['a.uid'] = cookie(userid) ;
		//翻页
		$count = $this->alias('a')->join('left join __PRODUCT_STATS__ b on b.pro_id = a.id left join __USER__ c on c.id = a.uid')
		->where($where)->group('b.pro_id')->count();
		//p($count);
		$page = new \Think\Page($count,$pagesize);
		//配置分页
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
	
		$data['data'] = $this->alias('a')
		->field(array("count(b.pro_id)"=>"countstats",'a.title','b.pro_id','c.companyname'))
		->join('left join __PRODUCT_STATS__ b on b.pro_id = a.id
			left join __USER__ c on c.id = a.uid
		')	
		->where($where)
		->limit($page->firstRow.','.$page->listRows)
		->order('a.id desc')
		->group('b.pro_id')
		->select();
		//p($this->_Sql());
		
		return $data;
	}
	
	//前端搜索
	public function searchFront($pagesize=15){
		$where['uid'] = cookie(userid);
		//翻页
		$count = $this->where($where)->count();
		$page = new \Think\Page($count,$pagesize);
		//配置分页
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		$data['data'] = $this
		->where($where)
		->limit($page->firstRow.','.$page->listRows)
		->order('id desc')
		->select();
		
		return $data;
	}
	
	
	//添加前
	public function _before_insert(&$data, $option){
		$data['addtime'] = time();
		$data['uid'] = cookie(userid);
		$data['pic'] = json_encode($_POST['pic']);
	}
	
	
	
	
	
	//谁点击的统计
	public function countwho($pagesize=15){
		
		$where = [];
		$where['pro_id'] = I('get.pro_id');
		$m = M('Product_stats');
		
		//翻页
		$count = $m->alias('a')->join('left join __USER__ b on b.id=a.user_id')
		->where($where)->group('a.user_id')->count();
		$page = new \Think\Page($count,$pagesize);
		//配置分页
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		
		
		$data['data'] = $m->alias('a')
		->field(array('count(a.pro_id)'=>'links','b.username,b.phone'))
		->join('left join __USER__ b on b.id=a.user_id')
		->where($where)
		->group('a.user_id')
		->limit($page->firstRow.','.$page->listRows)
		->select();
		//p($this->_Sql());
		return $data;
		
		
		
	}
}