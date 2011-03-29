<?php

class ModuleIncludeArticleDCA extends Backend {

	public function getArticles(DataContainer $objDC) {
		$this->import('BackendUser', 'User');
		
		$arrPids = array();
		$arrAlias = array();

		if(!$this->User->isAdmin) {
			foreach($this->User->pagemounts as $intID) {
				if(isset($arrPids[$intID]))
					continue;
				$arrPids[$intID] = true;
				$arrPids = array_merge($arrPids, array_flip($this->getChildRecords($intID, 'tl_page', true)));
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
			)->execute($objDC->id);
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
			')->execute($objDC->id);
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
		if($objDC->value < 1)
			return '';
		return sprintf(
			' <a href="contao/main.php?do=article&amp;table=tl_article&amp;act=edit&amp;id=%s" title="%s" style="padding-left:3px;">%s</a>',
			$objDC->value,
			sprintf(specialchars($GLOBALS['TL_LANG']['tl_content']['editalias'][1]), $objDC->value),
			$this->generateImage('alias.gif', $GLOBALS['TL_LANG']['tl_content']['editalias'][0], 'style="vertical-align:top;"')
		);
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(isset(self::$objInstance))
			return self::$objInstance;
			
		return self::$objInstance = new self();
	}
	
}
