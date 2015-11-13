<?php

class IncludeArticleDCA extends Backend {

	public function hookIsVisibleElement($row, $visible) {
		return $visible && !$row->bbit_mod_art_hide;
	}

	public function callbackLabelArticle($row, $label) {
		$callback = $GLOBALS['TL_DCA']['tl_article']['list']['label']['label_callback_bbit_mod_art'];
		$label = call_user_func_array(
			array(static::importStatic($callback[0]), $callback[1]),
			func_get_args()
		);

		if($row['bbit_mod_art_hide']) {
			$label .= sprintf(
				' <span style="color:#4b85ba;padding-left:3px">[%s]</span>',
				$GLOBALS['TL_LANG']['tl_article']['bbit_mod_art_hide'][0]
			);
		}

		return $label;
	}

	public function getArticles($objDC) {
		$this->import('BackendUser', 'User');

		$arrPids = array();
		$arrAlias = array();

		if(!$this->User->isAdmin) {
			foreach($this->User->pagemounts as $intID) {
				if(isset($arrPids[$intID]))
					continue;
				$arrPids[$intID] = true;
				foreach($this->getChildRecords($intID, 'tl_page') as $pid) {
					$arrPids[$pid] = true;
				}
			}

			if(empty($arrPids))
				return $arrAlias;

			$objAlias = $this->Database->prepare('
				SELECT
					a.id,
					a.title,
					a.inColumn,
					p.title AS parent
				FROM
					tl_article AS a
				LEFT JOIN
					tl_page AS p ON p.id = a.pid
				WHERE
					a.pid IN(' . implode(',', array_map('intval', array_keys($arrPids))) . ')
				ORDER BY
					parent, a.sorting'
			)->execute();
		} else {
			$objAlias = $this->Database->prepare('
				SELECT
					a.id,
					a.title,
					a.inColumn,
					p.title AS parent
				FROM
					tl_article AS a
				LEFT JOIN
					tl_page AS p ON p.id = a.pid
				ORDER BY
					parent, a.sorting
			')->execute();
		}

		if(!$objAlias->numRows)
			return $arrAlias;

		$this->loadLanguageFile('tl_article');

		while($objAlias->next())
			$arrAlias[$objAlias->parent][$objAlias->id] = sprintf(
				'%s (%s, ID %s)',
				$objAlias->title,
				strlen($GLOBALS['TL_LANG']['tl_article'][$objAlias->inColumn])
					? $GLOBALS['TL_LANG']['tl_article'][$objAlias->inColumn]
					: $objAlias->inColumn,
				$objAlias->id
			);

		return $arrAlias;
	}

	public function editArticle(DataContainer $objDC) {
		$GLOBALS['TL_JAVASCRIPT']['bbit.cto.articleWizard'] = 'system/modules/backboneit_mod_article/html/js/bbit.cto.articleWizard.js';
		return sprintf(
			' <a href="contao/main.php?do=article&amp;table=tl_content&amp;id=" class="bbit_cto_articleWizard" title="%s">%s</a>',
			$GLOBALS['TL_LANG']['MSC']['bbit_cto_articleWizard_edit'],
			$this->generateImage('edit.gif', $GLOBALS['TL_LANG']['MSC']['bbit_cto_articleWizard_edit'])
		) . sprintf(
			' <a href="contao/main.php?do=article&amp;table=tl_article&amp;act=edit&amp;id=" class="bbit_cto_articleWizard" title="%s">%s</a>',
			$GLOBALS['TL_LANG']['MSC']['bbit_cto_articleWizard_header'],
			$this->generateImage('header.gif', $GLOBALS['TL_LANG']['MSC']['bbit_cto_articleWizard_header'])
		);
	}


	public function getMultiTemplates() {
		return $this->getTemplateGroup('bbit_mod_art_multi_');
	}


	public function getLayoutSections() {
		$this->loadLanguageFile('tl_article');
		$arrSections = trimsplit(',', $GLOBALS['TL_CONFIG']['customSections']);
		array_unshift($arrSections, 'header', 'left', 'right', 'main', 'footer');
		return $arrSections;
	}



	private static $objInstance;

	public static function getInstance() {
		if(isset(self::$objInstance))
			return self::$objInstance;

		return self::$objInstance = new self();
	}

}
