<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'bbit_mod_art_setColumns';

$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_mod_art']
	= '{title_legend},name,type'
	. ';{bbit_mod_art_legend},bbit_mod_art_id,bbit_mod_art_nosearch,bbit_mod_art_container'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID';
	
$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_mod_multiArt']
	= '{title_legend},name,type'
	. ';{bbit_mod_art_legend},bbit_mod_art_multi,bbit_mod_art_multiTemplate'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend},guests,cssID,space';
	
$GLOBALS['TL_DCA']['tl_module']['palettes']['bbit_mod_pageArt']
	= '{title_legend},name,type'
	. ';{bbit_mod_art_legend},bbit_mod_art_page,bbit_mod_art_setColumns,bbit_mod_art_nosearch,bbit_mod_art_container'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['subpalettes']['bbit_mod_art_setColumns']
	= 'bbit_mod_art_columns';


$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_mod_art_multi'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_multi'],
	'inputType'		=> 'multiColumnWizard',
	'eval'			=> array(
		'columnFields' => array(
			'id' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_id'],
				'inputType'	=> 'select',
				'options_callback'	=> array('IncludeArticleDCA', 'getArticles'),
				'eval'		=> array(
					'mandatory'		=> true,
					'chosen'		=> true,
					'style'			=> 'width: 280px;'
				),
				'wizard'			=> array(
					array('IncludeArticleDCA', 'editArticle')
				),
			),
			'cssID' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['cssID'],
				'exclude'	=> true,
				'inputType'	=> 'text',
				'eval'		=> array(
					'multiple'		=> true,
					'size'			=> 2,
					'style'			=> 'width: 100px;'
				)
			),
			'nosearch' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_nosearch_short'],
				'inputType'	=> 'checkbox',
				'eval'		=> array(
				)
			),
			'container' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_container_short'],
				'inputType'	=> 'checkbox',
				'eval'		=> array(
				)
			),
		),
//		'tl_class'			=> '',
	),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_mod_art_id'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_id'],
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('IncludeArticleDCA', 'getArticles'),
	'eval'				=> array(
		'mandatory'			=> true,
		'submitOnChange'	=> true,
		'chosen'			=> true,
//		'tl_class'			=> 'clr'
	),
	'wizard'			=> array(
		array('IncludeArticleDCA', 'editArticle')
	)
);


$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_mod_art_page'] = array(
	'label'		=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_page'],
	'exclude'	=> true,
	'inputType'	=> 'pageTree',
	'eval'		=> array(
		'fieldType'		=> 'radio',
		'mandatory'		=> true,
		'tl_class'		=> 'clr'
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_mod_art_setColumns'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_setColumns'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'submitOnChange'	=> true,
		'tl_class'			=> 'clr cbx'
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_mod_art_columns'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_columns'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'options_callback'	=> array('IncludeArticleDCA', 'getLayoutSections'),
	'reference'			=> &$GLOBALS['TL_LANG']['tl_article'],
	'eval'				=> array(
		'multiple'			=> true,
		'tl_class'			=> 'clr'
	)
);


$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_mod_art_nosearch'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_nosearch'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'tl_class'			=> 'clr w50 cbx'
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['bbit_mod_art_container'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['bbit_mod_art_container'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'tl_class'			=> 'w50 cbx'
	)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bbit_mod_art_multiTemplate'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_multiTemplate'],
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('IncludeArticleDCA', 'getMultiTemplates'),
	'eval'				=> array(
		'includeBlankOption'=> true,
		'tl_class'			=> 'clr'
	)
);
