// JavaScript Document
$(document).ready(function(){
//	var check_num = $('#check_num').val();

	/*购物车货物列别模块自适应配比*/
	$(".main_con_goods ul li div").width($(window).width()-140-10+"px");
	/*无货物模式下中间体高度*/
	$(".no_goods").height($(window).height()-$(".head_info").height()-$(window).height()*0.06+"px");
	/*删除弹窗默认高度*/
	$(".del_tc").height($(window).height()+"px");
	
	
	/*购物车货物加减法计算*/
	/*加法计算*/
	$(".main_con_goods li div .money .add").click(function(){
		var num = $(this).parent().parent().parent().index();
		var nums = $(".main_con_goods li div").length;
		var value = parseInt($(".main_con_goods ul").children().eq(num).find("div").find(".money").find(".num").val());
		value++;
		if(value<=99){
			$(".main_con_goods ul").children().eq(num).find("div").find(".money").find(".num").val(value);
		}
		
		//当选中一个商品时需要计算一次商品的数量和总价
		var pricss = 0;
		for (var i = 0; i < nums; i++) {
			if($(".main_con_goods ul").children().eq(i).find(".circle").css("background-color") == "rgb(191, 57, 42)"){
				var num_temp = 0;
				var price_temp = 0;
				num_temp += parseInt($(".main_con_goods ul").children().eq(i).find("div").find(".money").find(".num").val());
				var tmep = $(".main_con_goods ul").children().eq(i).find("div").find(".money").find("font").html();
				tmep = tmep.substring(0,tmep.length-1);
				price_temp += parseFloat(tmep);
				pricss+= num_temp*price_temp;
			}
		}
		$(".settlement_left").html("<font class=\"zongji\">总计：</font><font class=\"money\">￥"+pricss+"</font><br />（点击去结算进行购买产品）");
	});
	/*减法计算*/
	$(".main_con_goods li div .money .del").click(function(){
		var num = $(this).parent().parent().parent().index();
		var nums = $(".main_con_goods li div").length;
		var value = parseInt($(".main_con_goods ul").children().eq(num).find("div").find(".money").find(".num").val());
		value--;
		if(value>0){
			$(".main_con_goods ul").children().eq(num).find("div").find(".money").find(".num").val(value);
		}
		
		
		//当选中一个商品时需要计算一次商品的数量和总价
		var pricss = 0;
		for (var i = 0; i < nums; i++) {
			if($(".main_con_goods ul").children().eq(i).find(".circle").css("background-color") == "rgb(191, 57, 42)"){
				var num_temp = 0;
				var price_temp = 0;
				num_temp += parseInt($(".main_con_goods ul").children().eq(i).find("div").find(".money").find(".num").val());
				var tmep = $(".main_con_goods ul").children().eq(i).find("div").find(".money").find("font").html();
				tmep = tmep.substring(0,tmep.length-1);
				price_temp += parseFloat(tmep);
				pricss+= num_temp*price_temp;
			}
		}
		$(".settlement_left").html("<font class=\"zongji\">总计：</font><font class=\"money\">￥"+pricss+"</font><br />（点击去结算进行购买产品）");
	});
	
	
	/*选择一个商品的点击事件*/
	$(".main_con_goods li .circle").click(function(){
		var num = $(this).parent().index();
		var nums = $(".main_con_goods li div").length;
		
		if($(".main_con_goods ul").children().eq(num).find(".circle").css("background-color") == "rgba(0, 0, 0, 0)"){
			$(".main_con_goods ul").children().eq(num).find(".circle").css("background-color","#bf392a");
			$(".main_con_goods ul").children().eq(num).find(".circle").css("border","1px solid #bf392a");

			var check_num = $('#check_num').val();
			// alert(check_num);exit;
			var goodsid = $(this).children('input').val();

			var strs_arr= new Array(); //定义一数组
			strs_arr = check_num.split(","); //字符分割
			strs_arr.push(goodsid);

			var str_str =   strs_arr.toString();
			$('#check_num').val(str_str);

		}else{
			$(".main_con_goods ul").children().eq(num).find(".circle").css("background-color","rgba(0, 0, 0, 0)");
			$(".main_con_goods ul").children().eq(num).find(".circle").css("border","1px solid #bab9b9");


			var check_num = $('#check_num').val();
			var goodsid = $(this).children('input').val();

			var strs_arr= new Array(); //定义一数组
			strs_arr = check_num.split(","); //字符分割

			for(var i=0;i< strs_arr.length;i++) {
				if(goodsid == strs_arr[i]) {
					strs_arr.splice(i, 1);
				}
			}
			// strs_arr.push(goodsid);

			var str_str =   strs_arr.toString();
			$('#check_num').val(str_str);

		}
		
		//当选中一个商品时需要显示删除按钮
		for (var i = 0; i < nums; i++) {
			if($(".main_con_goods ul").children().eq(i).find(".circle").css("background-color") == "rgb(191, 57, 42)"){
				$(".main_con_allchoose img").css("display","block");
				break;
			}
			$(".main_con_allchoose img").css("display","none");
		}
		
		//当选中一个商品时需要计算一次商品的数量和总价
		var pricss = 0;
		for (var i = 0; i < nums; i++) {
			if($(".main_con_goods ul").children().eq(i).find(".circle").css("background-color") == "rgb(191, 57, 42)"){
				var num_temp = 0;
				var price_temp = 0;
				num_temp += parseInt($(".main_con_goods ul").children().eq(i).find("div").find(".money").find(".num").val());
				var tmep = $(".main_con_goods ul").children().eq(i).find("div").find(".money").find("font").html();
				tmep = tmep.substring(0,tmep.length-1);
				price_temp += parseFloat(tmep);
				pricss+= num_temp*price_temp;
			}
		}
		$(".settlement_left").html("<font class=\"zongji\">总计：</font><font class=\"money\">￥"+pricss+"</font><br />（点击去结算进行购买产品）");
	});
	
	/*全选按钮点击事件*/
	$(".main_con_allchoose .circle").click(function(){
		var num = $(this).parent().index();
		var nums = $(".main_con_goods li div").length;
		if($(this).css("background-color") == "rgba(0, 0, 0, 0)"){
			$(this).css("background-color","#bf392a");
			$(this).css("border","1px solid #bf392a");

			$('#check_num').val("");
			var strs_arr= new Array(); //定义一数组

			//全选选中时，需要选中所有商品列表
			for (var i = 0; i < nums; i++) {
				$(".main_con_goods ul").children().eq(i).find(".circle").css("background-color","#bf392a");
				$(".main_con_goods ul").children().eq(i).find(".circle").css("border","1px solid #bf392a");

				// alert(check_num);exit;
				var goodsid = $(".main_con_goods ul").children().eq(i).find(".gid").val();

				strs_arr.push(goodsid);
			}

			var str_str =   strs_arr.toString();
			$('#check_num').val(str_str);

			//当选中一个商品时需要显示删除按钮
			$(".main_con_allchoose img").css("display","block");
			
		}else{
			$(this).css("background-color","rgba(0, 0, 0, 0)");
			$(this).css("border","1px solid #bab9b9");
			
			//全选选中时，需要选中所有商品列表
			for (var i = 0; i < nums; i++) {
				$(".main_con_goods ul").children().eq(i).find(".circle").css("background-color","rgba(0, 0, 0, 0)");
				$(".main_con_goods ul").children().eq(i).find(".circle").css("border","1px solid #bab9b9");
			}
			$('#check_num').val("");
			//当选中一个商品时需要显示删除按钮
			$(".main_con_allchoose img").css("display","none");
		}
		
		
		//当选中一个商品时需要计算一次商品的数量和总价
		var pricss = 0;
		for (var i = 0; i < nums; i++) {
			if($(".main_con_goods ul").children().eq(i).find(".circle").css("background-color") == "rgb(191, 57, 42)"){
				var num_temp = 0;
				var price_temp = 0;
				num_temp += parseInt($(".main_con_goods ul").children().eq(i).find("div").find(".money").find(".num").val());
				var tmep = $(".main_con_goods ul").children().eq(i).find("div").find(".money").find("font").html();
				tmep = tmep.substring(0,tmep.length-1);
				price_temp += parseFloat(tmep);
				pricss+= num_temp*price_temp;
			}
		}
		$(".settlement_left").html("<font class=\"zongji\">总计：</font><font class=\"money\">￥"+pricss+"</font><br />（点击去结算进行购买产品）");
	});
});

/*
 
 * 删除商品，弹出是否确认删除弹窗
 * 
 * */
function del_goods(){
	$(".del_tc").css("display","block");
}

function del_goods_cancel(){
	$(".del_tc").css("display","none");
}
