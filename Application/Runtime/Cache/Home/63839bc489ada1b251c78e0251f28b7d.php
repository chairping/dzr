<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>产品详情</title>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/loaders.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/base.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Home/css/swiper.min.css"/>
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
<!--<body>-->
<body style="background-image:url(<?php echo ($spots_img_addr); ?>);background-position:center; background-repeat:repeat-y">
	<header class="detail-header fixed-header">
		<a href="javascript:history.go(-1)"><img src="/Public/Home/images/detail-left.png"/></a>


	</header>
	
	
	<div class="contaniner fixed-contb" >
		<section class="detail" style="text-align:center;">
			<!--<figure class="swiper-container">-->
				<!--<ul class="swiper-wrapper">-->
					<!--<li class="swiper-slide">-->
						<!--<a href="#">-->
							<!--<img src="/Public/Home/images/detail-ban02.png"/>-->
						<!--</a>-->
					<!--</li>-->

				<!--</ul>-->
				<!--<div class="swiper-pagination">-->
				<!--</div>-->
			<!--</figure>-->
			<!--<div style="width: 10%;"></div>-->
			<dl class="jiage" style="text-align:center;float: inherit;">
				<dt>
					<img src="<?php echo ($goods_info["cover_img_addr"]); ?>" style="text-align:center; width:200px; height:250px;"/>
				</dt>
				<dt>
					<h3><?php echo ($goods_info["title"]); ?></h3>
					<!--<div class="collect">-->
						<!--<img src="/Public/Home/images/detail-heart-hei.png"/>-->
						<!--<p>收藏</p>-->
					<!--</div>-->
				</dt>
				<dd>
					<b>￥<?php echo ($goods_info["price"]); ?></b>
				</dd>
			</dl>
			


			

			

		</section>
	</div>
	
	
		<footer class="detail-footer fixed-footer">
			<input type="hidden" id="id" value="<?php echo ($goods_info["id"]); ?>">
			<input type="hidden" id="num" value="1">
			<a href="javascript:;" class="go-car">
				<input type="button" value="加入购物车"/>
			</a>
			<a href="javascript:;" class="buy">
				立即购买
			</a>
		</footer>
	
<script src="/Public/Home/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	$(window).scroll(function() {
	    if ($(".detail-header").offset().top > 50) {
        $(".detail-header").addClass("change");
    } else {
        $(".detail-header").removeClass("change");
    }
	});
</script>
<script src="/Public/Home/js/swiper.min.js"></script>

	<script>
		$(function(){

			$(".buy").click(function(){
				var id = $('#id').val();
				var num = $('#num').val();

//				$.ajax({
//					type: "post",//数据提交的类型（post或者get）
//					url: "/index.php/Goods/buy",//数据提交得地址
//					data: {id: id, num:num},//提交的数据(自定义的一些后台程序需要的参数)
//					dataType: "json",//返回的数据类型
//					success: function (data) {
//
//						setTimeout(function(){
							window.location.href='/index.php/Goods/buy?id=' + id + '&num='+ num;
//						},1000);

//
//					}
//				});


			});

		});
	</script>



</body>
</html>