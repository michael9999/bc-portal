<div class="wrap">

	<h2><?php esc_html_e( 'Livedocx' , 'livedocx');?></h2>

	<div class="have-key">


		<?php
		$disabled = '';
		if(!empty($notWritablePaths)){
			$disabled = 'disabled="disabled"';
		?>
		<div id="setting-error-settings_updated" class="updated settings-error">
			<p>
				<strong>Warning:</strong>
				<div>Next directories should be writable for success demos executing:</div>
			</p>
			<?php foreach($notWritablePaths as $path) { ?>

				<div><?php echo $path;?></div>
			<?php }?>
			<br/>
		</div>
		<?php }?>
		<form method="post">
			<input type="submit" value="Run demos" <?php echo $disabled;?>/>
		</form>
	</div>

</div>