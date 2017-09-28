<?php
/* Smarty version 3.1.30, created on 2017-09-27 03:43:54
  from "D:\wamp64\www\fourth\4.10\templates\base.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59cb1e7ad382c3_72342452',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '22765d4ffa7b9517bc31a165c72eb2ca8ed36f19' => 
    array (
      0 => 'D:\\wamp64\\www\\fourth\\4.10\\templates\\base.tpl',
      1 => 1506483831,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59cb1e7ad382c3_72342452 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_checkboxes')) require_once 'D:\\wamp64\\www\\fourth\\4.10\\Smarty\\plugins\\function.html_checkboxes.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html>
<head>
	<title>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2189259cb1e7ac49e06_80064068', "title");
?>

	</title>
</head>
<body>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2084559cb1e7ac5d684_55778766', "top");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_451459cb1e7ac69212_04629818', "body");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_363559cb1e7ac74d97_84888886', "foot");
?>


<?php echo smarty_function_html_checkboxes(array('name'=>'id','values'=>$_smarty_tpl->tpl_vars['cust_ids']->value,'output'=>$_smarty_tpl->tpl_vars['cust_names']->value,'selected'=>$_smarty_tpl->tpl_vars['customer_id']->value,'separator'=>'<br />'),$_smarty_tpl);?>

</body>
</html><?php }
/* {block "title"} */
class Block_2189259cb1e7ac49e06_80064068 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "title"} */
/* {block "top"} */
class Block_2084559cb1e7ac5d684_55778766 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
页头<?php
}
}
/* {/block "top"} */
/* {block "body"} */
class Block_451459cb1e7ac69212_04629818 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
内容<?php
}
}
/* {/block "body"} */
/* {block "foot"} */
class Block_363559cb1e7ac74d97_84888886 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
页脚<?php
}
}
/* {/block "foot"} */
}
