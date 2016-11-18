<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>收货地址</title>
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
<body>
	<header class="top-header fixed-header">
		<a class="icona" href="javascript:history.go(-1)">
				<img src="/Public/Home/images/left.png"/>
			</a>
		<h3>收货地址</h3>
			
			<a class="text-top" >
			</a>
	</header>
	
	<div class="contaniner fixed-conta" style="margin-top: 18%;">
		<form action="" method="post" class="change-address" id="save">
			<ul>
				<li>
					<label class="addd">收货人姓名：</label>
					<input type="text" value="" required="required"/>
				</li>
				<li>
					<label class="addd">手机号：</label>
					<input type="tel" value="" required="required"/>
				</li>

				<li>
					<label class="addd">详细地址：</label>
					<textarea required="required"></textarea>
				</li>
			</ul>
			
			<!--<ul>-->
				<!--<li class="checkboxa">-->
					<!--<input type="checkbox" id="check"/>-->
					<!--<label class="check" for="check" onselectstart="return false"  >设置为默认地址</label>-->
				<!--</li>-->
			<!--</ul>-->
			<ul>
				<li>
					<h3>重置</h3>
				</li>
			</ul>
			<input type="submit" value="保存" />
		</form>
	</div>
	
	<script src="/Public/Home/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(".checkboxa label").on('touchstart',function(){
			if($(this).hasClass('checkd')){
				$(".checkboxa label").removeClass("checkd");
			}else{
				$(".checkboxa label").addClass("checkd");
			}
		})
	</script>
	

</body>
</html>