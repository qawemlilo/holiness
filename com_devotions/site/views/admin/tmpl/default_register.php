<?php
defined('_JEXEC') or die( 'Restricted access' );
$user =& JFactory::getUser();

?>

<form enctype="multipart/form-data" name="create_profile" id="myform" method="post" action="index.php">

<?php include_once('new_head.php'); ?>

<fieldset>
<legend>Create Profile</legend>
<p>
    <label for="photo">Picture (150 x 150)</label> <input type="file" size="40" name="photo" id="photo" />
</p>

<p>
  <label for="name">Full name <span class="red">*</span></label> <input type="text" id="name" name="name" value="<?php echo $user->name; ?>" /> 
</p>

<p>
  <label for="email">E-mail <span class="red">*</span></label> <input type="text" id="email" name="email" value="<?php echo $user->email; ?>" /> 
</p>

<p>
  <label for="church">Goes to (Church/Ministry) <span class="red">*</span></label> <input type="text" name="church" id="church" value="" /> 
</p>

<p>
  <label for="submit" style="vertical-align: top;">&nbsp;</label><input type="submit" class="button white" name="submit" value="Submit" />  <input type="button" class="button white" value="Cancel" onclick="location.href='index.php?option=com_devotions&task=cancel';" />
</p>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="userid" value="<?php echo $user->id; ?>" />
<input type="hidden" name="option" value="com_devotions">
<input type="hidden" name="task" value="save_profile">
</fieldset>
</form>