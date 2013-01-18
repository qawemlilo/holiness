<?php 
defined('_JEXEC') or die('Restricted access'); 
?>


    <span class="breadcrumbs pathway">
      <a class="pathway" href="<?php echo JURI::base(); ?>">Home</a>
      <a class="pathway" href="<?php echo JRoute::_('index.php?option=com_devotions&view=admin'); ?>">Admin</a>
      <a class="pathway" href="<?php echo JRoute::_('index.php?option=com_devotions&view=profile&pid=' . $pid); ?>">My Divine Profile</a>
      <?php echo $items; ?> 
    </span>    
