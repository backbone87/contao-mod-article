<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'backboneit_mod_article_setColumns';

$GLOBALS['TL_DCA']['tl_module']['palettes']['backboneit_mod_article']
	= '{title_legend},name,type,backboneit_mod_article_id;'
	. '{protected_legend:hide},protected;'
	. '{expert_legend:hide},guests,backboneit_mod_article_nosearch,backboneit_mod_article_container';
	
$GLOBALS['TL_DCA']['tl_module']['palettes']['backboneit_mod_pageArticles']
	= '{title_legend},name,type,backboneit_mod_article_page,backboneit_mod_article_setColumns;'
	. '{protected_legend:hide},protected;'
	. '{expert_legend:hide},guests,backboneit_mod_article_nosearch,backboneit_mod_article_container';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['backboneit_mod_article_setColumns']
	= 'backboneit_mod_article_columns';

	

$GLOBALS['TL_DCA']['tl_module']['fields']['backboneit_mod_article_id'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['backboneit_mod_article_id'],
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('ModuleIncludeArticleDCA', 'getArticles'),
	'eval'				=> array(
		'mandatory'			=> true,
		'submitOnChange'	=> true,
		'chosen'			=> true,
//		'tl_class'			=> 'clr'
	),
	'wizard'			=> array(
		array('ModuleIncludeArticleDCA', 'editArticle')
	)
);



$GLOBALS['TL_DCA']['tl_module']['fields']['backboneit_mod_article_page'] = array(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['backboneit_mod_article_page'],
	'exclude'	=> true,
	'inputType'	=> 'pageTree',
	'eval'		=> array(
		'fieldType'		=> 'radio',
		'mandatory'		=> true,
		'tl_class'		=> 'clr'
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['backboneit_mod_article_setColumns'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['backboneit_mod_article_setColumns'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'submitOnChange'	=> true,
		'tl_class'			=> 'clr cbx'
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['backboneit_mod_article_columns'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['backboneit_mod_article_columns'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'options_callback'	=> array('ModuleIncludeArticleDCA', 'getLayoutSections'),
	'reference'			=> &$GLOBALS['TL_LANG']['tl_article'],
	'eval'				=> array(
		'multiple'			=> true,
		'tl_class'			=> 'clr'
	)
);



$GLOBALS['TL_DCA']['tl_module']['fields']['backboneit_mod_article_nosearch'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['backboneit_mod_article_nosearch'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'tl_class'			=> 'clr w50 cbx'
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['backboneit_mod_article_container'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['backboneit_mod_article_container'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'tl_class'			=> 'w50 cbx'
	)
);
