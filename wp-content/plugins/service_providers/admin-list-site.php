<div class="wrap">  
 <?php    echo "<h2>" . __( 'Site Listing' ) . "</h2>"; ?>  
<table class="widefat page fixed" cellspacing="0">
  <tbody>
<?php
global $wpdb;
$sql = "SELECT *FROM ".PRO_TABLE_PREFIX."tutorial where  1";
$results = $wpdb->get_results($sql);
if(count($results) > 0)
{
    foreach($results as $result)
	{
	echo "<tr>
	<td>".$result-> name."</td><td>".$result->website."</td><td>".$result->description."</td>
	</tr>";
	}				
}
?>
  </tbody>
</table>
</div>