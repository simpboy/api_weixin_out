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
            
    <script type="text/javascript">
        $(document).ready(function(){
            $(".click").click(function(){
                $(".tip").fadeIn(200);
            });

            $(".tiptop a").click(function(){
                $(".tip").fadeOut(200);
            });

            $(".sure").click(function(){
                $(".tip").fadeOut(100);
            });

            $(".cancel").click(function(){
                $(".tip").fadeOut(100);
            });

        });
    </script>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">数据表</a></li>
            <li><a href="#">基本内容</a></li>
        </ul>
    </div>

    <div class="rightinfo">

        <div class="tools">

            <ul class="toolbar">
                <li class="click"><span><img src="/Public/Admin/images/t01.png" /></span>添加</li>
                <li class="click"><span><img src="/Public/Admin/images/t02.png" /></span>修改</li>
                <li><span><img src="/Public/Admin/images/t03.png" /></span>删除</li>
                <li><span><img src="/Public/Admin/images/t04.png" /></span>统计</li>
            </ul>


            <ul class="toolbar1">
                <li><span><img src="/Public/Admin/images/t05.png" /></span>设置</li>
            </ul>

        </div>


        <table class="tablelist">
            <thead>
            <tr>
                <th><input name="" type="checkbox" value="" checked="checked"/></th>
                <th>编号<i class="sort"><img src="/Public/Admin/images/px.gif" /></i></th>
                <th>标题</th>
                <th>用户</th>
                <th>籍贯</th>
                <th>发布时间</th>
                <th>是否审核</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130908</td>
                <td>王金平幕僚：马英九声明字字见血 人活着没意思</td>
                <td>admin</td>
                <td>江苏南京</td>
                <td>2013-09-09 15:05</td>
                <td>已审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink"> 删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130907</td>
                <td>温州19名小学生中毒流鼻血续：周边部分企业关停</td>
                <td>uimaker</td>
                <td>山东济南</td>
                <td>2013-09-08 14:02</td>
                <td>未审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130906</td>
                <td>社科院:电子商务促进了农村经济结构和社会转型</td>
                <td>user</td>
                <td>江苏无锡</td>
                <td>2013-09-07 13:16</td>
                <td>未审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130905</td>
                <td>江西&quot;局长违规建豪宅&quot;：局长检讨</td>
                <td>admin</td>
                <td>北京市</td>
                <td>2013-09-06 10:36</td>
                <td>已审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130904</td>
                <td>中国2020年或迈入高收入国家行列</td>
                <td>uimaker</td>
                <td>江苏南京</td>
                <td>2013-09-05 13:25</td>
                <td>已审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130903</td>
                <td>深圳地铁车门因乘客拉闸打开 3人被挤入隧道</td>
                <td>user</td>
                <td>广东深圳</td>
                <td>2013-09-04 12:00</td>
                <td>已审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130902</td>
                <td>33次地表塌陷 村民不敢下地劳作(图)</td>
                <td>admin</td>
                <td>湖南长沙</td>
                <td>2013-09-03 00:05</td>
                <td>未审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130901</td>
                <td>医患关系：医生在替改革不彻底背黑锅</td>
                <td>admin</td>
                <td>江苏南京</td>
                <td>2013-09-02 15:05</td>
                <td>未审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130900</td>
                <td>山东章丘公车进饭店景点将自动向监控系统报警</td>
                <td>uimaker</td>
                <td>山东滨州</td>
                <td>2013-09-01 10:26</td>
                <td>已审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>
            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130903</td>
                <td>深圳地铁车门因乘客拉闸打开 3人被挤入隧道</td>
                <td>user</td>
                <td>广东深圳</td>
                <td>2013-09-04 12:00</td>
                <td>已审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130902</td>
                <td>33次地表塌陷 村民不敢下地劳作(图)</td>
                <td>admin</td>
                <td>湖南长沙</td>
                <td>2013-09-03 00:05</td>
                <td>未审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130901</td>
                <td>医患关系：医生在替改革不彻底背黑锅</td>
                <td>admin</td>
                <td>江苏南京</td>
                <td>2013-09-02 15:05</td>
                <td>未审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130900</td>
                <td>山东章丘公车进饭店景点将自动向监控系统报警</td>
                <td>uimaker</td>
                <td>山东滨州</td>
                <td>2013-09-01 10:26</td>
                <td>已审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>
            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130903</td>
                <td>深圳地铁车门因乘客拉闸打开 3人被挤入隧道</td>
                <td>user</td>
                <td>广东深圳</td>
                <td>2013-09-04 12:00</td>
                <td>已审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130902</td>
                <td>33次地表塌陷 村民不敢下地劳作(图)</td>
                <td>admin</td>
                <td>湖南长沙</td>
                <td>2013-09-03 00:05</td>
                <td>未审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            <tr>
                <td><input name="" type="checkbox" value="" /></td>
                <td>20130901</td>
                <td>医患关系：医生在替改革不彻底背黑锅</td>
                <td>admin</td>
                <td>江苏南京</td>
                <td>2013-09-02 15:05</td>
                <td>未审核</td>
                <td><a href="#" class="tablelink">查看</a>     <a href="#" class="tablelink">删除</a></td>
            </tr>

            </tbody>
        </table>


        <div class="pagin">
            <div class="message">共<i class="blue">1256</i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>
            <ul class="paginList">
                <li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>
                <li class="paginItem"><a href="javascript:;">1</a></li>
                <li class="paginItem current"><a href="javascript:;">2</a></li>
                <li class="paginItem"><a href="javascript:;">3</a></li>
                <li class="paginItem"><a href="javascript:;">4</a></li>
                <li class="paginItem"><a href="javascript:;">5</a></li>
                <li class="paginItem more"><a href="javascript:;">...</a></li>
                <li class="paginItem"><a href="javascript:;">10</a></li>
                <li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>
            </ul>
        </div>


        <div class="tip">
            <div class="tiptop"><span>提示信息</span><a></a></div>

            <div class="tipinfo">
                <span><img src="/Public/Admin/images/ticon.png" /></span>
                <div class="tipright">
                    <p>是否确认对信息的修改 ？</p>
                    <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                </div>
            </div>

            <div class="tipbtn">
                <input name="" type="button"  class="sure" value="确定" />&nbsp;
                <input name="" type="button"  class="cancel" value="取消" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>

            </div>
        </div>
        <div id="footer" class="footer">
            <span>仅供学习交流，请勿用于任何商业用途</span>
            <i>版权所有 2014 uimaker.com</i>
        </div>
    </div>
</body>
</html>