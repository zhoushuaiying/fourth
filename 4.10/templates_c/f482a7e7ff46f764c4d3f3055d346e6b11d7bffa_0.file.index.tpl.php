<?php
/* Smarty version 3.1.30, created on 2017-09-27 01:25:40
  from "D:\wamp64\www\fourth\4.10\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59cafe149ce4b2_33793572',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f482a7e7ff46f764c4d3f3055d346e6b11d7bffa' => 
    array (
      0 => 'D:\\wamp64\\www\\fourth\\4.10\\templates\\index.tpl',
      1 => 1506475538,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_59cafe149ce4b2_33793572 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_escape')) require_once './Smarty/plugins\\modifier.escape.php';
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\wamp64\\www\\fourth\\4.10\\Smarty\\plugins\\modifier.date_format.php';
?>
我的名字：<?php echo str_replace($_smarty_tpl->tpl_vars['name']->value,'e','1');?>

<br/>
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['name']->value)===null||$tmp==='' ? 'no' : $tmp);?>

<br/>
<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['name']->value, 'hex');?>

<br/>
<?php echo smarty_modifier_date_format(time());?>

<br/>
fsfsfsfsd



<?php $_smarty_tpl->_assignInScope('foo', array(1,2,3));
?>

<?php echo $_smarty_tpl->tpl_vars['foo']->value[2];?>



<?php
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, "db.conf", null, 0);
?>

<?php echo $_smarty_tpl->smarty->ext->configload->_getConfigVariable($_smarty_tpl, 'db_name');?>

<br>
<?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'db_host');?>


<br/>
<br/>
<br/>
<br/>
<br/>
<?php ob_start();
echo preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['sex']->value, $tmp);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>$_prefixVariable1), 0, false);
?>

<br/>
<br/>
<br/>
<?php if ($_smarty_tpl->tpl_vars['age']->value < 19) {?>
未成年
<?php } elseif ($_smarty_tpl->tpl_vars['age']->value >= 19 && $_smarty_tpl->tpl_vars['age']->value < 60) {?>
成年
<?php } elseif ($_smarty_tpl->tpl_vars['age']->value >= 60) {?>
老了
<?php }?>
<br/>
<br/>
<br/>

<ul>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['foo']->value, 'v', true);
$_smarty_tpl->tpl_vars['v']->iteration = 0;
$_smarty_tpl->tpl_vars['v']->index = -1;
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->iteration++;
$_smarty_tpl->tpl_vars['v']->index++;
$_smarty_tpl->tpl_vars['v']->first = !$_smarty_tpl->tpl_vars['v']->index;
$_smarty_tpl->tpl_vars['v']->last = $_smarty_tpl->tpl_vars['v']->iteration == $_smarty_tpl->tpl_vars['v']->total;
$__foreach_v_0_saved = $_smarty_tpl->tpl_vars['v'];
?>
    <li>
       <?php echo $_smarty_tpl->tpl_vars['v']->key;?>
 : <?php echo $_smarty_tpl->tpl_vars['v']->value;?>
 : <?php echo $_smarty_tpl->tpl_vars['v']->index;?>

       <?php if ($_smarty_tpl->tpl_vars['v']->first) {?>
       	一	
       <?php } elseif ($_smarty_tpl->tpl_vars['v']->last) {?>
       最后
       <?php }?>


    </li>
<?php
$_smarty_tpl->tpl_vars['v'] = $__foreach_v_0_saved;
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</ul>

<?php }
}
