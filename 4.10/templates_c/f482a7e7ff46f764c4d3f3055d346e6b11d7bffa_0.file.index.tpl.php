<?php
/* Smarty version 3.1.30, created on 2017-09-26 03:48:18
  from "D:\wamp64\www\fourth\4.10\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59c9ce02130c80_08739037',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f482a7e7ff46f764c4d3f3055d346e6b11d7bffa' => 
    array (
      0 => 'D:\\wamp64\\www\\fourth\\4.10\\templates\\index.tpl',
      1 => 1506397695,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_59c9ce02130c80_08739037 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

fsfsfsfsd



<?php $_smarty_tpl->_assignInScope('foo', array(1,2,3));
?>

<?php echo $_smarty_tpl->tpl_vars['foo']->value[2];?>



<?php
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, "db.conf", null, 0);
?>

<?php echo $_smarty_tpl->smarty->ext->configload->_getConfigVariable($_smarty_tpl, 'db_name');?>

<br>
<?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'db_host');
}
}
