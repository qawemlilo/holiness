<?php
defined('_JEXEC') or die( 'Restricted access' );

$user =& JFactory::getUser();
$pastor = $this->pastor;
?>

<form enctype="multipart/form-data" name="create_profile" id="myform" method="post" action="index.php">

<?php include_once('new_head.php'); ?>


<fieldset>
<legend>Create Profile</legend>

<div id="photo" style="border: 1px solid #DDDDDD; width: 154px; height: 154px; margin-left: 265px;">
<img src="/components/com_devotions/files/users/<?php echo $pastor->url; ?>?t=<?php echo time(); ?>" style="width:150px; height: 150px;" title="<?php echo $pastor->name; ?>" onerror="this.src='/components/com_devotions/files/blank.png';" alt="<?php echo $pastor->name; ?>" />
</div>

<p>
    <label for="profilephoto">Picture (150 x 150)</label> <input type="file" size="40" name="profilephoto" id="profilephoto" >
</p>

<p>
  <label for="name">Full name <span class="red">*</span></label> <input type="text" id="name" name="name" value="<?php echo $pastor->name; ?>" /> 
</p>

<p>
  <label for="email">E-mail <span class="red">*</span></label> <input type="text" id="email" name="email" value="<?php echo $pastor->email; ?>" /> 
</p>

<p>
  <label for="church">Goes to (Church/Ministry) <span class="red">*</span></label> <input id="church" type="text" name="church" value="<?php echo $pastor->church; ?>" /> 
</p>

<p>
  <label for="submit" style="vertical-align: top;">&nbsp;</label><input type="submit" class="button white" name="submit" value="Save" />  <input type="button" class="button white" value="Cancel" onclick="location.href='index.php?option=com_devotions&task=cancel';" />
</p>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="userid" value="<?php echo $user->id; ?>" />
<input type="hidden" name="pastorid" value="<?php echo $pastor->id; ?>" />
<input type="hidden" name="option" value="com_devotions">
<input type="hidden" name="task" value="edit_profile">
</fieldset>
</form>
