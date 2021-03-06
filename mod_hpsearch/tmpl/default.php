<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$document = &JFactory::getDocument();
$document->addStyleSheet('modules/mod_hpsearch/files/css/ui-lightness/jquery-ui-1.8.18.custom.css');
$document->addScript('modules/mod_hpsearch/files/js/jquery-ui-1.8.18.custom.min.js');
?>

<script type="text/javascript">
jQuery.noConflict();
(function ($) {
	$(function() {
		var availableTags = <?php echo json_encode($pastorsArr); ?>;
        var pastorsObj = <?php echo json_encode($pastorsObj); ?>;
        
		$("#mod_search_searchword").autocomplete({
			source: availableTags,
            
            select: function(event, ui) {
                var name = ui.item.value, url = 'http://www.holinesspage.com/index.php?option=com_devotions&view=profile&pid=';
                
                if (pastorsObj.hasOwnProperty(name)) {
                    url = url + pastorsObj[name].id;
                    window.location.href = url;                    
                }
            }
		});
	});
}(jQuery));
</script>
<form method="post" id="mod_hpsearch" action="index.php">
	<div class="search">
		<input type="text" onfocus="if(this.value=='Search for your Christian friends') this.value='';" onblur="if(this.value=='') this.value='Search for your Christian friends';" value="Search for your Christian friends" size="20" class="inputbox" maxlength="20" id="mod_search_searchword" name="searchword"><input type="submit" id="submit" onclick="this.form.searchword.focus();" class="button" value="Search friend">
    </div>
	<input type="hidden" value="search" name="task">
	<input type="hidden" value="com_devotions" name="option">
</form>
