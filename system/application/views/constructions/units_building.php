<?php
if(isset($messages)) {
?>
<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em; width: 80%; margin-left: auto; margin-right: auto; display: block;"> 
					<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<strong>Building:</strong> <?php foreach($messages as $m) { echo $m . "<br />"; } ?><br /><br />Build time: <?php echo secondtoword($buildtime); ?></p>

				</div>
<?php
}
?>