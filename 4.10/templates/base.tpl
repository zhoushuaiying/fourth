<!DOCTYPE html>
<html>
<head>
	<title>
	{block name="title"}{/block}
	</title>
</head>
<body>
{block name="top"}页头{/block}
{block name="body"}内容{/block}
{block name="foot"}页脚{/block}

{html_checkboxes name='id' values=$cust_ids output=$cust_names
   selected=$customer_id  separator='<br />'}
</body>
</html>