<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>产品列表</title>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/loaders.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/base.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/style.css"/>
      <script src="/Public/Home/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    	$(window).load(function(){
    		$(".loading").addClass("loader-chanage")
    		$(".loading").fadeOut(300)
    	})
    </script>
</head>
<!--loading页开始-->
<!--<div class="loading">-->
	<!--<div class="loader">-->
        <!--<div class="loader-inner pacman">-->
          <!--<div></div>-->
          <!--<div></div>-->
          <!--<div></div>-->
          <!--<div></div>-->
          <!--<div></div>-->
        <!--</div>-->
	<!--</div>-->
<!--</div>-->
<!--loading页结束-->
<body style="background-image:<?php echo ($f); ?>">
	<!--<header class="top-header fixed-header">-->
		<!--<a class="icona" href="javascript:history.go(-1)">-->
				<!--<img src="/Public/Home/images/left.png"/>-->
			<!--</a>-->
		<!--<h3>产品列表</h3>-->

	<!--</header>-->
	
	<div class="contaniner fixed-conta">
		<section class="list">
			<!--<figure><img src="/Public/Home/images/list-ban01.png"/></figure>-->
			<div class="search">
				<input type="search" placeholder="请输入要查找的产品信息" />
				<label><a><img src="/Public/Home/images/list-search.png"/></a></label>
			</div>
			<!--<nav>-->
				<!--<ul>-->
					<!--<li>-->
						<!--<a href="#">-->
							<!--<span>全部</span>-->
						<!--</a>-->
					<!--</li>-->
					<!--<li class="list-active">-->
						<!--<a href="#">-->
							<!--<span>销量</span>-->
							<!--<img src="/Public/Home/images/up-red.png"/>-->
						<!--</a>-->
					<!--</li>-->
					<!--<li>-->
						<!--<a href="#">-->
							<!--<span>价格</span>-->
						<!--</a>-->
					<!--</li>-->
					<!--<li>-->
						<!--<a href="#">-->
							<!--<span>评价</span>-->
						<!--</a>-->
					<!--</li>-->
				<!--</ul>-->
			<!--</nav>-->
			<ul class="wall">
				<?php foreach($pro_arr as $k => $v){ ?>
				<li class="pic">
					<a href="/index.php/Goods/index?goods_id=<?php echo ($v["id"]); ?>&scenic_spots_id=<?php echo ($spots_id); ?>">
						<img src="<?php echo ($v["cover_img_addr"]); ?>"/>
						<p><?php echo ($v["title"]); ?></p>
						<b>￥<?php echo ($v["price"]); ?></b>
					</a>
				</li>
				<?php } ?>
			</ul>
		</section>
	</div>
	<footer class="page-footer fixed-footer" id="footer">
		<ul>
			<li class="active">
				<a href="index.html">
					<img src="/Public/Home/images/footer01.png"/>
					<p>首页</p>
				</a>
			</li>
			<li>
				<a href="shopcar.html">
					<img src="/Public/Home/images/footer003.png"/>
					<p>购物车</p>
				</a>
			</li>

			<li>
				<a href="self.html">
					<img src="/Public/Home/images/footer004.png"/>
					<p>我的订单</p>
				</a>
			</li>
		</ul>
	</footer>

<script src="/Public/Home/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/Public/Home/js/jaliswall.js"></script>
	<script type="text/javascript">
	$(window).load(function(){
		$('.wall').jaliswall({ item: '.pic' });
	});
	</script>
</body>
</html>