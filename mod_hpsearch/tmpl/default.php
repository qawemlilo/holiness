<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$document = &JFactory::getDocument();
$document->addStyleSheet('modules/mod_hpsearch/files/css/ui-lightness/jquery-ui-1.8.18.custom.css');
$document->addScript('modules/mod_hpsearch/files/js/jquery-1.7.1.min.js');
$document->addScript('modules/mod_hpsearch/files/js/jquery-ui-1.8.18.custom.min.js');
?>

<script type="text/javascript">
jQuery.noConflict();
(function ($) {
	$(function() {
		var availableTags = <?php echo json_encode($pastorsArr); ?>;
        
		$("#mod_search_searchword").autocomplete({
			source: availableTags,
            
            select: function(event, ui) {
                $(this).val(ui.item.value);
                $("#mod_hpsearch #submit").click();
            }
		});
	});
}(jQuery));
</script>
<form method="post" id="mod_hpsearch" action="index.php">
	<div class="search">
		<input type="text" onfocus="if(this.value=='Search for your friend') this.value='';" onblur="if(this.value=='') this.value='Search for your friend';" value="Search for your friend" size="20" class="inputbox" alt="Search friend" maxlength="20" id="mod_search_searchword" name="searchword"><input type="submit" id="submit" onclick="this.form.searchword.focus();" class="button" value="Search friend">	
    </div>
	<input type="hidden" value="search" name="task">
	<input type="hidden" value="com_devotions" name="option">
</form>