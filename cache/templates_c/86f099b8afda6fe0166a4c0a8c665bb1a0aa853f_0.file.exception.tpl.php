<?php
/* Smarty version 4.2.1, created on 2022-11-22 18:46:52
  from '/var/www/custom_software/src/App/Pages/Defaults/Resources/error/exception.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_637d0b0c1e4892_88481058',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '86f099b8afda6fe0166a4c0a8c665bb1a0aa853f' => 
    array (
      0 => '/var/www/custom_software/src/App/Pages/Defaults/Resources/error/exception.tpl',
      1 => 1669139211,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_637d0b0c1e4892_88481058 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- testing template -->
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['ROOT_PATH']->value;?>
/src/App/Pages/Defaults/Resources/styles/exception.css">
<div class="err-cont">
    <div class="err-header">
        <h1><?php echo $_smarty_tpl->tpl_vars['CLASS']->value;?>
: <?php echo $_smarty_tpl->tpl_vars['ERROR']->value;?>
</h1>
        <p>Error Code: <?php echo $_smarty_tpl->tpl_vars['CODE']->value;?>
</p>
    </div>
    <div class="err">
        <p>At <?php echo $_smarty_tpl->tpl_vars['FILE']->value;?>
, line <?php echo $_smarty_tpl->tpl_vars['LINE']->value;?>
</p>
        <pre data-lang="php"><?php echo $_smarty_tpl->tpl_vars['FILE_CODE']->value;?>
</pre>
    </div>
</div><?php }
}
