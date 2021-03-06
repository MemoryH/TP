<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\daima\twothink\public/../application/home/view/default/notice\index.html";i:1521958270;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/static/static/static/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/static/static/static/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>
</head>
<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="index.html" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid" id="content">
        <?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <div class="row noticeList">
            <a href="<?php echo url('Notice/intro?id='.$vo['id']); ?>">
            <div class="col-xs-2">
                <img class="noticeImg" src="<?php echo $vo['img']; ?>" />
            </div>
            <div class="col-xs-10">
                <p class="title"><?php echo $vo['title']; ?></p>
                <p class="intro"><?php echo $vo['content']; ?></p>
                <p class="info">浏览: <?php echo $vo['read_view']; ?> <span class="pull-right"><?php echo date("Y-m-d H:i:s",$vo['create_time']); ?></span> </p>
            </div>
            </a>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>


        <!--<?php echo $page; ?>-->
    </div>
    <button class="btn" id="add" page="0">显示更多</button>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/static/static/static/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/static/static/static/bootstrap/js/bootstrap.js"></script>

<script type="text/javascript">
    $(function () {
        //时间戳转换为日期格式
//        function fTime(thetime) {
//            var date = new Date(thetime*1000);
//            return date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
//        }
//        console.log(fTime(1521875573))
        $('#add').click(function () {
            var page = ($(this).attr('page')-0)+1
            $(this).attr('page',page);
            var data = {
              'page':page
            };
            $.post('/home/notice/index',data,function (arr) {
                if ((arr['total']-1) ==page){
//                    console.log(arr[0])

                    $.each(arr[0],function (i,n) {
                        //时间戳转换为时间
                        var unixTimestamp = new Date( n['create_time']*1000 )
                        var commonTime = unixTimestamp.toLocaleString();
                        $('#content').append('<div class="row noticeList"> <a href="/home/notice/intro/id/'+n['id']+'.html"><div class="col-xs-2"> <img class="noticeImg" src="'+n['img']+'" /> </div> <div class="col-xs-10"> <p class="title">'+n['title']+'</p> <p class="intro"><?php echo $vo['content']; ?></p> <p class="info">浏览: '+n['read_view']+' <span class="pull-right">'+commonTime+'</span> </p> </div> </a> </div>')
                    })
                }else {
                    alert('没更多了');
                }
            })
        })
    })
</script>
</body>
</html>