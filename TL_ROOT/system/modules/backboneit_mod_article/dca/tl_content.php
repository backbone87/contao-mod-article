<?php

$GLOBALS['TL_DCA']['tl_content']['list']['sorting']['headerFields'][] = 'bbit_mod_art_hide';

$GLOBALS['TL_DCA']['tl_content']['palettes']['bbit_mod_multiArt']
	= '{type_legend},name,type'
	. ';{bbit_mod_art_legend},bbit_mod_art_multi,bbit_mod_art_multiTemplate'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,invisible,cssID,space';

$GLOBALS['TL_DCA']['tl_content']['palettes']['bbit_mod_pageArt']
	= '{title_legend},name,type'
	. ';{bbit_mod_art_legend},bbit_mod_art_page,bbit_mod_art_columns,bbit_mod_art_nosearch,bbit_mod_art_container'
	. ';{protected_legend:hide},protected'
	. ';{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_content']['fields']['bbit_mod_art_multi'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_multi'],
	'inputType'		=> 'multiColumnWizard',
	'eval'			=> array(
		'columnFields' => array(
			'id' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_id'],
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
				'label'		=> &$GLOBALS['TL_LANG']['tl_content']['cssID'],
				'exclude'	=> true,
				'inputType'	=> 'text',
				'eval'		=> array(
					'multiple'		=> true,
					'size'			=> 2,
					'style'			=> 'width: 100px;'
				)
			),
			'nosearch' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_nosearch_short'],
				'inputType'	=> 'checkbox',
				'eval'		=> array(
				)
			),
			'container' => array(
				'label'		=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_container_short'],
				'inputType'	=> 'checkbox',
				'eval'		=> array(
				)
			),
		),
// 		'tl_class'			=> 'clr'
	),
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

$GLOBALS['TL_DCA']['tl_content']['fields']['bbit_mod_art_page'] = array(
	'label'		=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_page'],
	'exclude'	=> true,
	'inputType'	=> 'pageTree',
	'eval'		=> array(
		'fieldType'		=> 'radio',
		'mandatory'		=> true,
		'tl_class'		=> 'clr'
	)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bbit_mod_art_columns'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_columns'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'options_callback'	=> array('IncludeArticleDCA', 'getLayoutSections'),
	'reference'			=> &$GLOBALS['TL_LANG']['tl_article'],
	'eval'				=> array(
		'mandatory'			=> true,
		'multiple'			=> true,
		'tl_class'			=> 'clr'
	)
);


$GLOBALS['TL_DCA']['tl_content']['fields']['bbit_mod_art_nosearch'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_nosearch'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'tl_class'			=> 'clr w50 cbx'
	)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bbit_mod_art_container'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_container'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'tl_class'			=> 'w50 cbx'
	)
);
