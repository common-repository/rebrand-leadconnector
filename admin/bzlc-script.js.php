jQuery(document).ready(function() {

<?php //if ( isset( $rebranding['plugin_name'] ) && !empty( $rebranding['plugin_name'])  ) : ?>
<!--
var  leadtext = jQuery("#app h1");
leadtext.text(leadtext.text().replace("LeadConnector", "<?php //echo $rebranding['plugin_name'];?>"));
-->
	
<?php //endif; ?>
jQuery(".hideBtn").attr("disabled", true);
});
