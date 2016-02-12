<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Controller;

class AdminController extends Controller {

	/**
	 * 后台控制器初始化
	 */
	protected function _initialize(){
		$userId = is_login();
	}
	/**
	 * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
	 *
	 * @param string $model 模型名称,供M函数使用的参数
	 * @param array  $data  修改的数据
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	final protected function editRow ( $model ,$data, $where , $msg ){
		$id    = array_unique((array)I('id',0));
		$id    = is_array($id) ? implode(',',$id) : $id;
		//如存在id字段，则加入该条件
		$fields = M($model)->getDbFields();
		if(in_array('id',$fields) && !empty($id)){
			$where = array_merge( array('id' => array('in', $id )) ,(array)$where );
		}

		$msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );
		if( M($model)->where($where)->save($data)!==false ) {
			$this->success($msg['success'],$msg['url'],$msg['ajax']);
		}else{
			$this->error($msg['error'],$msg['url'],$msg['ajax']);
		}
	}

	/**
	 * 禁用条目
	 * @param string $model 模型名称,供M函数使用的参数
	 * @param array  $where 查询时的 where()方法的参数
	 * @param array  $msg   执行正确和错误的消息,可以设置四个元素 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	protected function forbid ( $model , $where = array() , $msg = array( 'success'=>'状态禁用成功！', 'error'=>'状态禁用失败！')){
		// $data    =  array('status' => 0);
		$data    =  array('status' => 0, 'update_time'=>time());
		$this->editRow( $model , $data, $where, $msg);
	}


	/**
	 * 条目假删除
	 * @param string $model 模型名称,供M函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	protected function delete ( $model , $where = array() , $msg = array( 'success'=>'删除成功！', 'error'=>'删除失败！')) {
		$data['status']         =   -1;
		$this->editRow(   $model , $data, $where, $msg);
	}

	/**
	 * 设置一条或者多条数据的状态
	 */
	public function setStatus($Model=CONTROLLER_NAME){

		$ids    =   I('request.ids');
		$status =   I('request.status');
		if(empty($ids)){
			$this->error('请选择要操作的数据');
		}

		$map['id'] = array('in',$ids);
		switch ($status){
			case -1 :
				$this->delete($Model, $map, array('success'=>'删除成功','error'=>'删除失败'));
				break;
			case 0  :
				$this->forbid($Model, $map, array('success'=>'禁用成功','error'=>'禁用失败'));
				break;
			case 1  :
				$this->resume($Model, $map, array('success'=>'启用成功','error'=>'启用失败'));
				break;
			default :
				$this->error('参数错误');
				break;
		}
	}
	/**
	 * 通用分页列表数据集获取方法
	 *
	 *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
	 *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
	 *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
	 *
	 * @param sting|Model  $model   模型名或模型实例
	 * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
	 * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
	 *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
	 *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
	 *
	 * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
	 * @param string        $target  分页内容替换目标ID
	 * @param string        $page_id 分页外层div的id
	 * @author 朱亚杰 <xcoolcc@gmail.com>
	 *
	 * @return array|false
	 * 返回数据集
	 */
	protected function lists ($model,$where=array(),$order='',$field=true,$target='',$page_id=''){
		$options    =   array();
		$REQUEST    =   (array)I('request.');
		if(is_string($model)){
			$model  =   M($model);
		}

		$OPT        =   new \ReflectionProperty($model,'options');
		$OPT->setAccessible(true);

		$pk         =   $model->getPk();
		if($order===null){
			//order置空
		}else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
			$options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
		}elseif( $order==='' && empty($options['order']) && !empty($pk) ){
			$options['order'] = $pk.' desc';
		}elseif($order){
			$options['order'] = $order;
		}
		unset($REQUEST['_order'],$REQUEST['_field']);

		if(empty($where)){
			$where  =   array('status'=>array('egt',0));
		}
		if( !empty($where)){
			$options['where']   =   $where;
		}
		$options      =   array_merge( (array)$OPT->getValue($model), $options );
		$total        =   $model->where($options['where'])->count();

		if( isset($REQUEST['r']) ){
			$listRows = (int)$REQUEST['r'];
		}else{
			$listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
		}
		$config = '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%';
		$page = new \Think\Page($total, $listRows, $REQUEST);
		if( !(empty($target) || empty($page_id) ) ) {
			$page = new \Think\Pageajax($total, $listRows, $REQUEST, $target, $page_id);
			$config = '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER% %ajax%';
		}
		if($total>$listRows){
			$page->setConfig('theme',$config);
		}
		$p =$page->show();
		$this->assign('_page', $p? $p: '');
		$this->assign('_total',$total);
		$options['limit'] = $page->firstRow.','.$page->listRows;

		$model->setProperty('options',$options);


		return $model->field($field)->select();
	}



	/**
	 * 通用分页列表数据集获取方法
	 *
	 *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
	 *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
	 *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
	 *
	 * @param sting|Model  $model   模型名或模型实例
	 * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
	 * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
	 *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
	 *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
	 *
	 * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
	 * @param string        $target  分页内容替换目标ID
	 * @param string        $page_id 分页外层div的id
	 * @author 许智皓优化		加入多表联查，分组
	 *
	 * @return array|false
	 * 返回数据集
	 */
	protected function lists2 ($model,$where=array(),$order='',$field=true, $join='',$group= '',$target='',$page_id=''){

		$REQUEST    =   (array)I('request.');

		if(is_string($model)){
			$model  =   M($model);
		}

		if($order===null){
			$order = NULL;
		}
		$total = 0;

		if(!checkStr($join) && !checkStr($group)){
			$total = $model->where($where)->count();
		}
		else if(checkStr($join) && !checkStr($group)){
			$total = $model->join($join)->where($where)->count();
		}
		else if(!checkStr($join) && checkStr($group)){

			$total = $model->where($where)->count('distinct '.$group.'');
		}
		else if(checkStr($join) && checkStr($group)){

			$total = $model->join($join)->where($where)->count('distinct '.$group.'');
		}

		//     	if(checkStr($join)){
		//     		$total = $model->join($join)->where($where)->count();
		//     	}else{
		//     		$total = $model->where($where)->count();
		//     	}


		if( isset($REQUEST['r']) ){
			$listRows = (int)$REQUEST['r'];
		}else{
			$listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
		}



		$config = '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%';
		$page = new \Think\Page($total, $listRows, $REQUEST);

		if( !(empty($target) || empty($page_id) ) ) {
			$page = new \Think\Pageajax($total, $listRows, $REQUEST, $target, $page_id);
			$config = '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER% %ajax%';
		}
		if($total>$listRows){
			$page->setConfig('theme',$config);
		}

		$p =$page->show();
		$this->assign('_page', $p? $p: '');
		$this->assign('_total',$total);
		$options['limit'] = $page->firstRow.','.$page->listRows;


		$res = NULL;
		if(!checkStr($join) && !checkStr($group)){
			$res = $model->field($field)->where($where)->order($order)->limit($page->firstRow,$page->listRows)->select();
		}
		else if(checkStr($join) && !checkStr($group)){
			$res = $model->field($field)->join($join)->where($where)->order($order)->limit($page->firstRow,$page->listRows)->select();

		}
		else if(!checkStr($join) && checkStr($group)){
			$res = $model->field($field)->group($group)->where($where)->order($order)->limit($page->firstRow,$page->listRows)->select();
		}
		else if(checkStr($join) && checkStr($group)){
			$res = $model->field($field)->join($join)->group($group)->where($where)->order($order)->limit($page->firstRow,$page->listRows)->select();

		}
		// echo $model->getlastsql();exit;
		return $res;
	}
}
