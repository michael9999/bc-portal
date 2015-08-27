<?php
/** @var $filter \Zend\Filter\Word\SeparatorToSeparator */
?>
<div class="wrap">

	<h2><?php esc_html_e( 'Livedocx Demo Results' , 'livedocx');?></h2>

	<div class="have-key">
		<?php foreach($testResults as $result) {?>
			<h3><?php echo ucfirst($filter->filter($result['demoName']));?></h3>
			<h4><?php echo ucfirst($filter->filter($result['demoSubname']));?></h4>
			<pre><?php echo $result['body']?></pre>
			<hr/>
		<?php }?>
	</div>

</div>