<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['backboneit_mod_article']
	= '{title_legend},name,type,backboneit_mod_article_id;{protected_legend:hide},protected;{expert_legend:hide},guests';
	
$GLOBALS['TL_DCA']['tl_module']['fields']['backboneit_mod_article_id'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['backboneit_mod_article_id'],
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('ModuleIncludeArticleDCA', 'getArticles'),
	'eval'				=> array(
		'mandatory'			=> true,
		'submitOnChange'	=> true,
		'tl_class'			=> 'clr'
	),
	'wizard'			=> array(
		array('ModuleIncludeArticleDCA', 'editArticle')
	)
);
