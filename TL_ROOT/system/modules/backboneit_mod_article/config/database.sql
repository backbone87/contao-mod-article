-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


CREATE TABLE `tl_module` (
  `backboneit_mod_article_id` int(10) unsigned NOT NULL default '0',
  `backboneit_mod_article_nosearch` char(1) NOT NULL default '',
  `backboneit_mod_article_container` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
