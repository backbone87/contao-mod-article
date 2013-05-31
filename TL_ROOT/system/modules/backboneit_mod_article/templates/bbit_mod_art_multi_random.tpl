<ul class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<?php $arrArticles = $this->articles; shuffle($arrArticles); foreach($arrArticles as $i => $arrArticle): $arrCSS = deserialize($arrArticle['cssID'], true); ?>
<li class="<?php echo $arrCSS[1]; if($i == 0) echo ' first'; ?> block"<?php if(strlen($arrCSS[0])): ?> id="<?php echo $arrCSS[0]; ?>"<?php endif; ?>>
<?php echo IncludeArticleUtils::generateArticle(
		$arrArticle['id'],
		$arrArticle['nosearch'],
		$arrArticle['container'],
		$this->column
); ?>
</li>
<?php endforeach; ?>
</ul>