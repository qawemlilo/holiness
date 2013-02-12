<?php 
defined('_JEXEC') or die('Restricted access'); 
?>

  <div style="width: 380px; float: left">
    <span class="breadcrumbs pathway">
      <a class="pathway" href="<?php echo JURI::base(); ?>">Home</a>
      <a class="pathway" href="<?php echo JRoute::_('index.php?option=com_devotions&view=admin'); ?>">Admin</a>
      <a class="pathway" href="<?php echo JRoute::_('index.php?option=com_devotions&view=profile&pid=' . $pastor->id); ?>">My Divine Profile</a>
      <?php echo $items; ?> 
    </span>
  </div>
  <div style="width: 310px; float: left; color: #fff">
    Hi <?php echo $pastor->name; ?>, thank you for continuing to spread God's Word using the Holiness Page website!!!
  </div>
  <div style="clear:left">
    &nbsp;
  </div>
