<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>信息管理系统界面</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript">
        $(function(){
            //顶部导航切换
            $(".nav li a").click(function(){
                $(".nav li a.selected").removeClass("selected")
                $(this).addClass("selected");
            })
        })



        $(function(){
            //导航切换
            $(".menuson .header").click(function(){
                var $parent = $(this).parent();
                $(".menuson>li.active").not($parent).removeClass("active open").find('.sub-menus').hide();

                $parent.addClass("active");
                if(!!$(this).next('.sub-menus').size()){
                    if($parent.hasClass("open")){
                        $parent.removeClass("open").find('.sub-menus').hide();
                    }else{
                        $parent.addClass("open").find('.sub-menus').show();
                    }


                }
            });

            // 三级菜单点击
            $('.sub-menus li').click(function(e) {
                $(".sub-menus li.active").removeClass("active")
                $(this).addClass("active");
            });

            $('.title').click(function(){
                var $ul = $(this).next('ul');
                $('dd').find('.menuson').slideUp();
                if($ul.is(':visible')){
                    $(this).next('.menuson').slideUp();
                }else{
                    $(this).next('.menuson').slideDown();
                }
            });
        })
    </script>
    <style type="text/css">
        body{
            margin:0px;
            padding:0px;
            text-align:center;
            background:#e9fbff;
        }
        #container{
            position:relative;
            margin:0 auto;
            padding:0px;
            width:1200px;
            text-align:left;
        }
    </style>
</head>
<body>
    <div id="container">
        <div id="top" class="toptop">
            <div class="topleft">
                项目推荐管理系统
            </div>

            <ul class="nav">
                <!--li><a href="default.html" target="rightFrame" class="selected"><img src="/Public/Admin/images/icon01.png" title="工作台" /><h2>工作台</h2></a></li>
                <li><a href="imgtable.html" target="rightFrame"><img src="/Public/Admin/images/icon02.png" title="模型管理" /><h2>模型管理</h2></a></li>
                <li><a href="imglist.html"  target="rightFrame"><img src="/Public/Admin/images/icon03.png" title="模块设计" /><h2>模块设计</h2></a></li>
                <li><a href="tools.html"  target="rightFrame"><img src="/Public/Admin/images/icon04.png" title="常用工具" /><h2>常用工具</h2></a></li>
                <li><a href="computer.html" target="rightFrame"><img src="/Public/Admin/images/icon05.png" title="文件管理" /><h2>文件管理</h2></a></li>
                <li><a href="tab.html"  target="rightFrame"><img src="/Public/Admin/images/icon06.png" title="系统设置" /><h2>系统设置</h2></a></li-->
            </ul>

            <div class="topright">
                <ul>
                    <li><span><img src="/Public/Admin/images/help.png" title="帮助"  class="helpimg"/></span><a href="#">帮助</a></li>
                    <li><a href="#">关于</a></li>
                    <li><a href="login.html" target="_parent">退出</a></li>
                </ul>

                <div class="user">
                    <span>admin</span>
                    <i>消息</i>
                    <b>5</b>
                </div>

            </div>
        </div>
        <div id="bottom">
            <div id="left" style="float:left; width:187px;">
                <div class="lefttop"><span></span>通讯录</div>

                <dl class="leftmenu">

                    <dd>
                        <div class="title">
                            <span><img src="/Public/Admin/images/leftico01.png" /></span>管理信息
                        </div>
                        <ul class="menuson">

                            <li>
                                <div class="header">
                                    <cite></cite>
                                    <a href="index.html" target="rightFrame">首页模版</a>
                                    <i></i>
                                </div>
                                <ul class="sub-menus">
                                    <li><a href="javascript:;">文件管理</a></li>
                                    <li><a href="javascript:;">模型信息配置</a></li>
                                    <li><a href="javascript:;">基本内容</a></li>
                                    <li><a href="javascript:;">自定义</a></li>
                                </ul>
                            </li>

                            <li>
                                <div class="header">
                                    <cite></cite>
                                    <a href="right.html" target="rightFrame">数据列表</a>
                                    <i></i>
                                </div>
                                <ul class="sub-menus">
                                    <li><a href="javascript:;">文件数据</a></li>
                                    <li><a href="javascript:;">学生数据列表</a></li>
                                    <li><a href="javascript:;">我的数据列表</a></li>
                                    <li><a href="javascript:;">自定义</a></li>
                                </ul>
                            </li>

                            <li class="active"><cite></cite><a href="right.html" target="rightFrame">数据列表</a><i></i></li>
                            <li><cite></cite><a href="imgtable.html" target="rightFrame">图片数据表</a><i></i></li>
                            <li><cite></cite><a href="form.html" target="rightFrame">添加编辑</a><i></i></li>
                            <li><cite></cite><a href="imglist.html" target="rightFrame">图片列表</a><i></i></li>
                            <li><cite></cite><a href="imglist1.html" target="rightFrame">自定义</a><i></i></li>
                            <li><cite></cite><a href="tools.html" target="rightFrame">常用工具</a><i></i></li>
                            <li><cite></cite><a href="filelist.html" target="rightFrame">信息管理</a><i></i></li>
                            <li><cite></cite><a href="tab.html" target="rightFrame">Tab页</a><i></i></li>
                            <li><cite></cite><a href="error.html" target="rightFrame">404页面</a><i></i></li>
                        </ul>
                    </dd>


                    <dd>
                        <div class="title">
                            <span><img src="/Public/Admin/images/leftico02.png" /></span>其他设置
                        </div>
                        <ul class="menuson">
                            <li><cite></cite><a href="flow.html" target="rightFrame">流程图</a><i></i></li>
                            <li><cite></cite><a href="project.html" target="rightFrame">项目申报</a><i></i></li>
                            <li><cite></cite><a href="search.html" target="rightFrame">档案列表显示</a><i></i></li>
                            <li><cite></cite><a href="tech.html" target="rightFrame">技术支持</a><i></i></li>
                        </ul>
                    </dd>


                    <dd><div class="title"><span><img src="/Public/Admin/images/leftico03.png" /></span>编辑器</div>
                        <ul class="menuson">
                            <li><cite></cite><a href="#">自定义</a><i></i></li>
                            <li><cite></cite><a href="#">常用资料</a><i></i></li>
                            <li><cite></cite><a href="#">信息列表</a><i></i></li>
                            <li><cite></cite><a href="#">其他</a><i></i></li>
                        </ul>
                    </dd>


                    <dd><div class="title"><span><img src="/Public/Admin/images/leftico04.png" /></span>日期管理</div>
                        <ul class="menuson">
                            <li><cite></cite><a href="#">自定义</a><i></i></li>
                            <li><cite></cite><a href="#">常用资料</a><i></i></li>
                            <li><cite></cite><a href="#">信息列表</a><i></i></li>
                            <li><cite></cite><a href="#">其他</a><i></i></li>
                        </ul>
                    </dd>
                </dl>
            </div>
            <div id="right" style="float:left; width:1013px;">
            
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>

    <div class="formbody">

        <div class="formtitle"><span>基本信息</span></div>

        <ul class="forminfo">
            <li><label>文章标题</label><input name="" type="text" class="dfinput" /><i>标题不能超过30个字符</i></li>
            <li><label>关键字</label><input name="" type="text" class="dfinput" /><i>多个关键字用,隔开</i></li>
            <li><label>是否审核</label><cite><input name="" type="radio" value="" checked="checked" />是&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="radio" value="" />否</cite></li>
            <li><label>引用地址</label><input name="" type="text" class="dfinput" value="http://www.uimaker.com/uimakerhtml/uidesign/" /></li>
            <li><label>文章内容</label><textarea name="" cols="" rows="" class="textinput"></textarea></li>
            <li><label>&nbsp;</label><input name="" type="button" class="btn" value="确认保存"/></li>
        </ul>


    </div>

            </div>
        </div>
        <div id="footer" class="footer">
            <span>仅供学习交流，请勿用于任何商业用途</span>
            <i>版权所有 2014 uimaker.com</i>
        </div>
    </div>
</body>
</html>