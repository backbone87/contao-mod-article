<?php

namespace BackboneIT\Contao\Article\Database;

use Contao\Database;
use Contao\Database\Result;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 * @deprecated
 */
class Version3Update {

	/**
	 * @var Database
	 */
	protected static $db;

	/**
	 * @return void
	 */
	public static function update() {
		self::$db = Database::getInstance();

		self::copyHideColumn();

		foreach([ 'tl_content', 'tl_module' ] as $table) {
			self::copyTemplateColumn($table);
		}

		foreach([ 'tl_module' ] as $table) {
			self::convertArticle($table);
		}

		foreach([ 'tl_content', 'tl_module' ] as $table) {
			self::convertMultiArticle($table);
		}

		foreach([ 'tl_content', 'tl_module' ] as $table) {
			self::convertPageArticle($table);
		}
	}

	/**
	 * @return void
	 */
	protected static function copyHideColumn() {
		if(!self::$db->fieldExists('bbit_mod_art_hide', 'tl_article', true)) {
			return;
		}

		if(!self::$db->fieldExists('hofff_content_hide', 'tl_article', true)) {
			$sql = 'ALTER TABLE tl_article ADD hofff_content_hide char(1) NOT NULL default \'\'';
			self::$db->query($sql);
		}

		$sql = <<<SQL
UPDATE
	tl_article
SET
	hofff_content_hide = '1'
WHERE
	hofff_content_hide = ''
	AND bbit_mod_art_hide = '1'
SQL;
		self::$db->query($sql);
	}

	/**
	 * @param string $table
	 * @return void
	 */
	protected static function copyTemplateColumn($table) {
		if(!self::$db->fieldExists('bbit_mod_art_multiTemplate', $table, true)) {
			return;
		}

		if(!self::$db->fieldExists('hofff_content_template', $table, true)) {
			$sql = 'ALTER TABLE ' . $table . ' ADD hofff_content_template varchar(255) NOT NULL default \'\'';
			self::$db->query($sql);
		}

		$sql = <<<SQL
UPDATE
	$table
SET
	hofff_content_template = bbit_mod_art_multiTemplate
WHERE
	hofff_content_template = ''
	AND	bbit_mod_art_multiTemplate != ''
SQL;
		self::$db->query($sql);
	}

	/**
	 * @param string $table
	 * @return void
	 */
	protected static function convertArticle($table) {
		self::convert($table, 'bbit_mod_art', function($result) use($table) {
			$id = $result->bbit_mod_art_id;
			if(!$id) {
				return;
			}

			$key = 'article.' . $id;
			$css = deserialize($result->cssID, true);

			$references = [];
			$references[$key]['_key'] = $key;
			$references[$key]['exclude_from_search'] = $result->bbit_mod_art_nosearch;
			$references[$key]['render_container'] = $result->bbit_mod_art_container;
			$references[$key]['css_classes'] = isset($css[1]) ? $css[1] : '';
			$references[$key]['css_id'] = isset($css[0]) ? $css[0] : '';

			self::setColumn($table, 'cssID', $id, [ '', '' ]);
			self::setColumn($table, 'bbit_mod_art_multiTemplate', $id, '');

			return $references;
		});
	}

	/**
	 * @param string $table
	 * @return void
	 */
	protected static function convertMultiArticle($table) {
		self::convert($table, 'bbit_mod_multiArt', function($result) {
			$multi = deserialize($result->bbit_mod_art_multi);
			if(!is_array($multi)) {
				return;
			}

			$references = [];
			foreach($multi as $row) {
				$key = 'article.' . $row['id'];

				$css = deserialize($row['cssID'], true);

				$references[$key]['_key'] = $key;
				$references[$key]['exclude_from_search'] = $row['nosearch'];
				$references[$key]['render_container'] = $row['container'];
				$references[$key]['css_classes'] = isset($css[1]) ? $css[1] : '';
				$references[$key]['css_id'] = isset($css[0]) ? $css[0] : '';
			}

			return $references;
		});
	}

	/**
	 * @param string $table
	 * @return void
	 */
	protected static function convertPageArticle($table) {
		self::convert($table, 'bbit_mod_pageArt', function($result) use($table) {
			$id = $result->bbit_mod_art_page;
			if(!$id) {
				return;
			}

			$key = 'page.' . $id;
			$css = deserialize($result->cssID, true);
			$targetSectionFilter = $table != 'tl_content' && !$result->bbit_mod_art_setColumns;
			$targetSectionFilter = $targetSectionFilter ? '1' : '';

			$references = [];
			$references[$key]['_key'] = $key;
			$references[$key]['source_sections'] = $targetSectionFilter ? [] : deserialize($result->bbit_mod_art_columns);
			$references[$key]['target_section_filter'] = $targetSectionFilter;
			$references[$key]['exclude_from_search'] = $result->bbit_mod_art_nosearch;
			$references[$key]['render_container'] = $result->bbit_mod_art_container;
			$references[$key]['css_classes'] = isset($css[1]) ? $css[1] : '';

			self::setColumn($table, 'cssID', $id, [ '', '' ]);
			self::setColumn($table, 'bbit_mod_art_multiTemplate', $id, '');

			return $references;
		});
	}

	/**
	 * @param string $table
	 * @param string $type
	 * @param callable $callback
	 * @return void
	 */
	protected static function convert($table, $type, callable $callback) {
		$result = self::getRowsByType($table, $type);
		if(!$result->numRows) {
			return;
		}

		self::addReferencesColumn($table);

		while($result->next()) {
			$references = call_user_func($callback, $result, $table, $type);
			$references === null || self::setReferences($table, $result->id, $references);
		}

		self::convertType($table, $type, 'hofff_content_references');
	}

	/**
	 * @param string $table
	 * @param string $type
	 * @return Result
	 */
	protected static function getRowsByType($table, $type) {
		$sql = 'SELECT * FROM ' . $table . ' WHERE type = ?';
		return self::$db->prepare($sql)->execute($type);
	}

	/**
	 * @param string $table
	 * @return void
	 */
	protected static function addReferencesColumn($table) {
		if(!self::$db->fieldExists('hofff_content_references', $table, true)) {
			$sql = 'ALTER TABLE ' . $table . ' ADD hofff_content_references blob NULL';
			self::$db->query($sql);
		}
	}

	/**
	 * @param string $table
	 * @param integer $id
	 * @param array $article
	 * @return void
	 */
	protected static function setReferences($table, $id, $references) {
		self::setColumn($table, 'hofff_content_references', $id, $references, true);
	}

	/**
	 * @param string $table
	 * @param string $column
	 * @param integer $id
	 * @param mixed $value
	 * @param boolean $safe
	 * @return void
	 */
	protected static function setColumn($table, $column, $id, $value, $safe = false) {
		if(!$safe && !self::$db->fieldExists($column, $table, true)) {
			return;
		}

		$sql = 'UPDATE ' . $table . ' SET ' . $column . ' = ? WHERE id = ?';
		self::$db->prepare($sql)->execute([ $value, $id ]);
	}

	/**
	 * @param string $table
	 * @param string $old
	 * @param string $new
	 * @return void
	 */
	protected static function convertType($table, $old, $new) {
		$sql = 'UPDATE ' . $table . ' SET type = ? WHERE type = ?';
		self::$db->prepare($sql)->execute($new, $old);
	}

}
