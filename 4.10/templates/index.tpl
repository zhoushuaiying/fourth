我的名字：{$name|str_replace:'e':'1'}
<br/>
{$name|default:'no'}
<br/>
{$name|escape:'hex'}
<br/>
{$smarty.now|date_format}
<br/>
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

<br/>
<br/>
<br/>
<br/>
<br/>
{include file="header.tpl" title="{$sex|count_characters}"}
<br/>
<br/>
<br/>
{if $age lt 19}
未成年
{elseif $age gte 19 and $age lt 60}
成年
{elseif $age gte 60}
老了
{/if}
<br/>
<br/>
<br/>

<ul>
{foreach $foo as $v}
    <li>
       {$v@key} : {$v} : {$v@index}
       {if $v@first}
       	一	
       {elseif $v@last}
       最后
       {/if}


    </li>
{/foreach}
</ul>

