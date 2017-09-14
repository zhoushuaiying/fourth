
<DOCTYPE html>
<html lang=en">
<head>
	<meta charset="utf-8">
	<title>快递查询</title>
</head>

<body>
	
	<form>
	<label for="">快递单号</label>&nbsp;<input type="text" name="nu" id="nu"/><br/><br/>
	<label for="">快递公司</label>&nbsp;<select name="com" id="com"><
	<option value="">--请选择--</option>
	<option value="yunda">韵达快递</option>
	<option value="yuantong">圆通速递</option>
	<option value="zhongtong">中通速递</option>
	<option value="shentong">申通</option>
	<option value="shunfeng">顺丰</option>
	</select><br/><br/>
	<button type="button" id="search">查询</button>
	</form>
	<div>
	<iframe src="http://ww.baidu.com" frameborder="0" width="100%" height="500px" id="show">
	
	</iframe>
	</div>
</body>
<script src="./jquery-2.1.0.min.js"></script>
<script>
	
	$("#search").click(function()
	{
		var nu = $("#nu").val();
		var com= $("#com").val();
		if(nu == '' || nu == null || nu == undefined)
		{
			alert('请填写快递单号!');
			return false;
		}
		
		if(com == '' || com == null || com == undefined)
		{
			alert('请选择快递公司!');
			return false;
		}
		
		$.get('./search.php',{"nu":nu,"com":com},function(data){
			// alert(123);
			// console.log(data);
			$("#show").attr('src',data.url);
		},'json');
		
	});
	
</script>
</html>