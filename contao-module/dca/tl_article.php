<?php

$palette = &$GLOBALS['TL_DCA']['tl_article']['palettes']['default'];
$palette = str_replace(',published', ',published,bbit_mod_art_hide', $palette);
unset($palette);

$label = &$GLOBALS['TL_DCA']['tl_article']['list']['label'];
$label['label_callback_bbit_mod_art'] = $label['label_callback'];
$label['label_callback'] = array('IncludeArticleDCA', 'callbackLabelArticle');
unset($label);

$GLOBALS['TL_DCA']['tl_article']['fields']['bbit_mod_art_hide'] = array(
	'label'				=> &$GLOBALS['TL_LANG']['tl_article']['bbit_mod_art_hide'],
	'exclude'			=> true,
	'inputType'			=> 'checkbox',
	'eval'				=> array(
		'tl_class'			=> 'clr w50 cbx',
	),
	'sql'				=> 'char(1) NOT NULL default \'\'',
);
