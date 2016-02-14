<?php
return array(
	/* 模板相关配置 */
	'TMPL_PARSE_STRING' => array(
		'__STATIC__' => __ROOT__ . '/Public/static',
		'__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
		'__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
		'__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
	),
	'MENU_LIST'=>array(
		'user'=>array(
				'menuName'=>'用户信息',
				'controllerName'=>'index',
				'subMenu' => array( array(
						'url'=>'Index/userList',
						'controllerName'=>'index',
						'menuName'=>'用户列表',
					),
				),
		),
		'award'=>array(
			'menuName'=>'奖励信息',
			'controllerName'=>'award',
			'subMenu' => array( array(
					'url'=>'award/awardList',
					'controllerName'=>'award',
					'menuName'=>'奖励列表',
				),
			),
		),
	),

);