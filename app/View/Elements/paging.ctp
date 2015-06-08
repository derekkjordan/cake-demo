<?php
	if ( !isset($record_type) )
	{
		$record_type = 'record';
	}
	$params = $this->Paginator->params();
?>
<div class="clear"></div>
<div class="paging-wrap">
	<?php
		if ( $params['pageCount'] > 1 ) :
	?>
	<div class="limits">
		<p><?php echo ucfirst($record_type) ?>s per page:</p>
		<?php
			if ( !isset($limits) )
			{
				$limits = array(10,25,50,100);
			}

			$limit_links = array();

			foreach ($limits as $limit)
			{
				if ( $limit==$params['limit'] )
				{
					$limit_links[] = $limit;
				}
				else
				{
					$limit_links[] = $this->Html->link($limit,array('limit'=>$limit));
				}
			}

			echo $this->Html->nestedList($limit_links);
		?>
	</div>
	<div class="clear"></div>
	<?php
		endif;
	?>
	<p>
		<?php
			echo $this->Paginator->counter(array(
				'format' => 'Page {:page} of {:pages}, showing {:current} '.$record_type.'s out of {:count} total, starting on '.$record_type.' {:start}, ending on {:end}'
			));
		?>
	</p>
	<div class="paging">
	<?php
		if ( $params['pageCount'] > 1 )
		{
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		}
	?>
	</div>
</div>
