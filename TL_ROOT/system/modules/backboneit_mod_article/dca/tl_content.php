<?php

$GLOBALS['TL_DCA']['tl_content']['palettes']['bbit_mod_multiArt']
	= '{type_legend},name,type,bbit_mod_art_multi'
	. ';{protected_legend:hide},guests,protected'
	. ';{expert_legend:hide},invisible,bbit_mod_art_multiContainer,cssID,space';
	

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
					'submitOnChange'=> true,
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
					'style'			=> 'width: 120px;'
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
		'tl_class'			=> 'clr'
	),
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bbit_mod_art_multiContainer'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_content']['bbit_mod_art_multiContainer'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'tl_class'			=> 'w50 cbx'
	)
);
