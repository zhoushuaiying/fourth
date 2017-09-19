//导航栏
$(document).ready(function(){
	$(".nav_toggle").click( function(){
			$(".navbar").stop().slideToggle();
		});
});

//头部下拉
$(document).ready(function(){
//	$(".header .top .select .ul ul li:last-child").click(function(){
//		$(".header .top .select .ul ul").stop().slideToggle();
//	})
	$(".header .top .select .ul").hover(function(){
		$(this).find("ul").stop(false,true).slideToggle("fast");
	})
})
//******************************************address*****************************************
$(document).ready(function(){
	$(".address .add .bottom .right p:last-child label").click(function(){
		if($(this).find("input").is(":checked")){
			$(this).addClass("default")
		}else{
			$(this).removeClass("default")
		}
	})
})
//*************5-pro_list选项卡*******************************************************************************
// $(document).ready(function() {
	// $(".pro-navbar li").click(function(){
	// 	$(".pro-navbar li").eq($(this).index()).addClass("default").siblings().removeClass("default");
		// $(".tab").hide().eq($(this).index()).show();
		
	// });
// });
//**************************************6-pro_details图片的切换*************************************************
$(document).ready(function(){
	$(".pro_details .detail .pic li").click(function(){
		var index = $(this).index();
		$(this).parents(".pic").find('p').find("img").attr("src","images/inner/6-pro_details"+index+".jpg");
	})
	//规格
	$(".pro_details .detail .text .type dd li a").click(function(){
		$(this).addClass("default").parent().siblings().find("a").removeClass("default")
	})
	//数量的加减
	$(".pro_details .detail .reduce").click(function(){
		var num=parseInt($("#num").val());
		num--;
		if(num<1){return}
		$(this).parent().siblings("#num").val(num);				
	})
	
	$(".pro_details .detail .add").click(function(){
		var num=parseInt($("#num").val());
		num++;
		if(num>98){num=98}
		$(this).parent().siblings("#num").val(num);	
	})
	//输入框的判断
	var numVal=1;
	$(".pro_details .detail .text .number #num").focus(function(){
		var num1=$(this).val();
		return numVal=num1;
	})
	$(".pro_details .detail .text .number #num").blur(function(){
		var num2=$(this).val();
		if(isNaN(num2)||num2<=0||num2.substring(0,1)=='.'){
			$(this).val(numVal);
		}
	})
})
//**********************************8-register*********************************************************
$(document).ready(function(){
	$(".register .row .right .label").click(function(){
		if($(this).find("input").is(':checked')){
			$(this).addClass("default")
		}
		else{
			$(this).removeClass("default")
		}
	})
})
//***************************************9-register**************************************************
$(document).ready(function(){
	$(".login.register .right .input-group .left label").click(function(){
		if($(this).find("input").is(':checked')){
			$(this).addClass("default")
		}
		else{
			$(this).removeClass("default")
		}
	})
})
//************************************10-shop_cart***************************************************
$(document).ready(function(){
	//计算-数量+价钱*********************************
	function getTotal() {
		var len=$(".cart .cart-list li").length;
		 num = 0;
		 price = 0;
		for (var i=0; i<len; i++) {
			var isChecked = $(".cart .cart-list li").eq(i).children(".left1").find("label").find("input").is(":checked");
			if (isChecked) {
				//数量
				var num1=parseInt($(".cart .cart-list li").eq(i).children("div").find("#number").val());
				//总数量
				num += parseInt($(".cart .cart-list li").eq(i).children("div").find("#number").val());
				//总价钱
				price+=parseInt($(".cart .cart-list li").eq(i).children("div").find("p").find(".price").text())*num1;
			}
		}
		$(".cart .all .allnum").text(num)
	 	$(".cart .all .total").text(price.toFixed(2));
		return num;
	}
	
	//默认选上************************************
	$(".cart .allCheck #checkAll").prop("checked",true);
	$(".cart .allCheck label").addClass("default");
	$('.cart .cart-list li label input').prop("checked",true);
	$('.cart .cart-list li label').addClass("default");
	getTotal()
	//数量的加减********************************
	$(".cart .cart-list ul li div .reduce").click(function(){
		$(this).parents("li").find(".left1").find("label").find("input").prop("checked",true);
		$(this).parents("li").find(".left1").find("label").addClass("default")
		var num1=parseInt($(this).siblings("#number").val());
		num1--;
		if(num1<1){return}
		$(this).siblings("#number").val(num1);	
		
		 getTotal()
		 check()
	})
	$(".cart .cart-list ul li div .add").click(function(){
		$(this).parents("li").find(".left1").find("label").find("input").prop("checked",true);
		$(this).parents("li").find(".left1").find("label").addClass("default")
		var num1=parseInt($(this).siblings("#number").val());
		num1++;
		if(num1>98){num1=98}
		$(this).siblings("#number").val(num1);	
		
		 getTotal()
		 check()
	})
	//删除*********************************
	/*$(".cart .cart-list .dele").click(function(){
		$(this).parents(".cart .cart-list li").remove();
		check()
		getTotal()
	})*/
	//全选******************************
	$(".cart .allCheck #checkAll").click(function(){
		
		if($(this).is(':checked')){
			$(this).parent().addClass("default")
			$('.cart .cart-list li label input').prop("checked",true);
			$('.cart .cart-list li label').addClass("default");
			
		}else{
			$(this).parent().removeClass("default")
			$('.cart .cart-list li label input').prop("checked",false);
			$('.cart .cart-list li label').removeClass("default")
			$(".cart .all .allnum").text(0)
		}
		 getTotal()
	})
	//反选*******************************
	$('.cart .cart-list li label input').click(function(){
		if($(this).is(':checked')){
			$(this).parent().addClass("default");
		}
		else{
			$(this).parent().removeClass("default")
		}
		 check()
		 getTotal()
	})
	//封装反选函数**********************
	function check(){
		var num;
		var len=$(".cart .cart-list li").length;
		counct=0;
		for(var j=0;j<len;j++){
			if($('.cart .cart-list li label input').eq(j).is(":checked")){
				counct++;
			}
			if(counct==len){
				$(".cart .allCheck #checkAll").prop("checked",true);
				$(".cart .allCheck label").addClass("default");
			}
			if(counct!=len){
				$(".cart .allCheck #checkAll").prop("checked",false);
				$(".cart .allCheck label").removeClass("default");
			}
		}
	}
	//改变input的值********************
	var numVal=1;
	//获得焦点时的值，返回给numVal
	$(".cart .cart-list ul li div #number").focus(function(){
		var num1=$(this).val();
		numVal=num1;
	})
	//失去焦点时的值
	$(".cart .cart-list ul li div #number").blur(function(){
		$(this).parents("div").siblings(".left1").find("#check").prop("checked",true)
//		$('.cart .cart-list li label input').prop("checked",true);
		$(this).parents("div").siblings(".left1").find("label").addClass("default");
		var num2=$(this).val();
		//对值进行判断，符合要求，可以输入，不符合要求，值为numVal；
		if(isNaN(num2)||num2<=0||num2.substring(0,1)=='.'){
			$(this).val(numVal);
		}
		check()
		getTotal()
	})
})
//11confirm_order**************************************************************
$(document).ready(function(){
	$(".confirm .piao li input").focus(function(){
		(this.placeholder='请填写发票抬头')?this.placeholder='':false;
	})
	$(".confirm .piao li input").blur(function (){
		(this.placeholder=='')?this.placeholder='请填写发票抬头':false;
	})
	
	
	//input
	$(".confirm .way ul li label").click(function(){
		if($(this).find("input").is(':checked')){
			$(this).addClass("default").parent("li").siblings().find("label").removeClass("default")
		}
		else{
			$(this).removeClass("default")
		}
	})
	
	
	
	//默认选上
	$(".confirm .checkAll div label #all-Check").prop("checked",true);
	$('.confirm .checkAll div label').addClass("default");
	$('.confirm .confirm-list ul li label input').prop("checked",true);
	$('.confirm .confirm-list ul li label').addClass("default");
	getTotal()
	//计算-数量+价钱
	function getTotal() {
		var len=$('.confirm .confirm-list ul .li').length;
		 num2 = 0;
		 price=0;
		 litletotle = 0;
		for (var i=0; i<len; i++) {
			var isChecked = $('.confirm .confirm-list ul .li').eq(i).children(".div1").find("label").find("input").is(":checked");
			if (isChecked) {
				var num1=parseInt($(".confirm .confirm-list ul .li").eq(i).children("div").find("ul").find("li").find(".num").text());
				num2 += parseInt($(".confirm .confirm-list ul .li").eq(i).children("div").find("ul").find("li").find(".num").text());
				litletotle=num1*parseInt($(".confirm .confirm-list ul .li").eq(i).find(".much").text())-num1*parseInt($(".confirm .confirm-list ul .li").eq(i).find(".discount").text());
				price+=litletotle;
				
			}
			
		}
		$(".confirm .confirm-list ul .li").eq(i).find(".litle").text(litletotle.toFixed(2));
		$(".confirm.cart .All p .num").text(num2);
		$(".confirm.cart .All").find(".total").text(price.toFixed(2))
		$(".confirm.cart .All").find(".allCash").text(price.toFixed(2))
		return num2;
	}
	//全选+反选
		//全选
	$(".confirm .checkAll div label #all-Check").click(function(){
		
		if($(this).is(':checked')){
			$(this).parent().addClass("default")
			$('.confirm .confirm-list ul li label input').prop("checked",true);
			$('.confirm .confirm-list ul li label ').addClass("default");
			
		}else{
			$(this).parent().removeClass("default")
			$('.confirm .confirm-list ul li label input').prop("checked",false);
			$('.confirm .confirm-list ul li label ').removeClass("default")
		}
		 getTotal()
	})
	//反选
	$('.confirm .confirm-list ul li label input').click(function(){
		if($(this).is(':checked')){
			$(this).parent().addClass("default");
		}
		else{
			$(this).parent().removeClass("default")
		}
		
		 getTotal()
		check()
	})
	
	
	//封装反选函数
	function check(){
		var num;
		var len=$('.confirm .confirm-list ul .li').length;
		counct=0;
		for(var j=0;j<len;j++){
			if($('.confirm .confirm-list ul .li label input').eq(j).is(":checked")){
				counct++;
			}
			if(counct==len){
				$(".confirm .checkAll div label #all-Check").prop("checked",true);
				$(".confirm .checkAll div label").addClass("default");
			}
			if(counct!=len){
				$(".confirm .checkAll div label #all-Check").prop("checked",false);
				$(".confirm .checkAll div label").removeClass("default");
			}
		}
	}
	
	
	
})

