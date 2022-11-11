<?php
/* Smarty version 4.2.1, created on 2022-11-11 14:24:02
  from '/var/www/custom_software/src/Resources/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_636e4cf2244e38_99869813',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7bc0815143e1ed9d9ec34705932f49b6683ddc50' => 
    array (
      0 => '/var/www/custom_software/src/Resources/index.tpl',
      1 => 1668173033,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_636e4cf2244e38_99869813 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="container">
    <h1><?php echo NAME;?>
</h1>
    <p>Welcome to your site! Your directory is at <?php echo ROOT_PATH;?>
</p>

    <div class="yes">
        <?php
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? 5+1 - (0) : 0-(5)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration === 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration === $_smarty_tpl->tpl_vars['i']->total;?>
            <span></span>
        <?php }
}
?>
    </div>
</div><?php }
}
