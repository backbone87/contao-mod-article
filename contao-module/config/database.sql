-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


CREATE TABLE `tl_content` (

  `bbit_mod_art_multi` blob NULL,
  `bbit_mod_art_multiTemplate` varchar(255) NOT NULL default '',

  `bbit_mod_art_page` int(10) unsigned NOT NULL default '0',
  `bbit_mod_art_columns` blob NULL,

  `bbit_mod_art_nosearch` char(1) NOT NULL default '',
  `bbit_mod_art_container` char(1) NOT NULL default '',

) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tl_module` (

  `bbit_mod_art_id` int(10) unsigned NOT NULL default '0',

  `bbit_mod_art_multi` blob NULL,

  `bbit_mod_art_page` int(10) unsigned NOT NULL default '0',
  `bbit_mod_art_setColumns` char(1) NOT NULL default '',
  `bbit_mod_art_columns` blob NULL,

  `bbit_mod_art_nosearch` char(1) NOT NULL default '',
  `bbit_mod_art_container` char(1) NOT NULL default '',
  `bbit_mod_art_multiTemplate` varchar(255) NOT NULL default '',

) ENGINE=MyISAM DEFAULT CHARSET=utf8;
