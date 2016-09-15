<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Backboneit_mod_article
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'ContentIncludeMultiArticles' => 'system/modules/backboneit_mod_article/ContentIncludeMultiArticles.php',
	'ContentIncludePageArticles'  => 'system/modules/backboneit_mod_article/ContentIncludePageArticles.php',
	'IncludeArticleDCA'           => 'system/modules/backboneit_mod_article/IncludeArticleDCA.php',
	'IncludeArticleUtils'         => 'system/modules/backboneit_mod_article/IncludeArticleUtils.php',
	'ModuleIncludeArticle'        => 'system/modules/backboneit_mod_article/ModuleIncludeArticle.php',
	'ModuleIncludeMultiArticles'  => 'system/modules/backboneit_mod_article/ModuleIncludeMultiArticles.php',
	'ModuleIncludePageArticles'   => 'system/modules/backboneit_mod_article/ModuleIncludePageArticles.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'bbit_mod_art_multi_container' => 'system/modules/backboneit_mod_article/templates',
	'bbit_mod_art_multi_ordered'   => 'system/modules/backboneit_mod_article/templates',
	'bbit_mod_art_multi_random'    => 'system/modules/backboneit_mod_article/templates',
	'bbit_mod_art_multi_unordered' => 'system/modules/backboneit_mod_article/templates',
));
