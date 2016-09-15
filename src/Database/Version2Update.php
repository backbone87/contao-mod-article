<?php

namespace BackboneIT\Contao\Article\Database;

use Contao\Database;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 * @deprecated
 */
class Version2Update {

	/**
	 * @var Database
	 */
	protected static $db;

	/**
	 * @return void
	 */
	public static function update() {
		self::$db = Database::getInstance();

		foreach([ 'tl_module' ] as $table) {
			self::renameColumns($table);
		}

		self::updateTypeNames();

		foreach([ 'tl_content', 'tl_module' ] as $table) {
			self::convertContainerColumn($table);
		}
	}

	/**
	 * renaming backboneit_mod_article_* columns into bbit_mod_art_*
	 *
	 * @param string $table
	 * @return void
	 */
	protected static function renameColumns($table) {
		if(self::$db->tableExists($table, null, true)) {
			return;
		}

		$create = self::$db->query('SHOW CREATE TABLE ' . $table)->row(true);
		$create = explode("\n", $create[1]);

		foreach($create as $line) {
			if(!preg_match('@^[^A-Za-z]*\`backboneit_mod_article_@', $line)) {
				continue;
			}

			$line = preg_replace('@(`backboneit_mod_article_([A-Za-z]+)`)@', '$1 `bbit_mod_art_$2`', $line, 1);
			$line = 'ALTER TABLE `' . $table . '` CHANGE COLUMN ' . rtrim($line, ',');

			self::$db->query($line);
		}
	}

	/**
	 * @return void
	 */
	protected static function updateTypeNames() {
		if(!self::$db->tableExists('tl_module', null, true)) {
			return;
		}

		$sql = <<<SQL
UPDATE	tl_module
SET		type = 'bbit_mod_art'
WHERE	type = 'backboneit_mod_article'
SQL;
		self::$db->query($sql);

		$sql = <<<SQL
UPDATE	tl_module
SET		type = 'bbit_mod_pageArt'
WHERE	type = 'backboneit_mod_pageArticles'
SQL;
		self::$db->query($sql);
	}

	/**
	 * @param string $table
	 * @return void
	 */
	protected static function convertContainerColumn($table) {
		if(!self::$db->tableExists($table, null, true)) {
			return;
		}
		if(!self::$db->fieldExists('bbit_mod_art_multiContainer', $table, true)) {
			return;
		}
		if(!self::$db->fieldExists('bbit_mod_art_multiTemplate', $table, true)) {
			$sql = 'ALTER TABLE ' . $table . ' ADD bbit_mod_art_multiTemplate varchar(255) NOT NULL default \'\'';
			self::$db->query($sql);
		}

		$sql = <<<SQL
UPDATE	$table
SET		bbit_mod_art_multiTemplate = 'hofff_content_references_container'
WHERE	bbit_mod_art_multiTemplate = ''
AND		bbit_mod_art_multiContainer = '1'
SQL;
		self::$db->query($sql);
	}

}
