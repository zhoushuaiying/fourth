{include file="header.tpl"}
fsfsfsfsd
{*
Smarty的多行
注释
不会发送到浏览器
*}


{assign var=foo value=[1,2,3]}

{$foo[2]}


{config_load file="db.conf"}
{$smarty.config.db_name}
<br>
{#db_host#}