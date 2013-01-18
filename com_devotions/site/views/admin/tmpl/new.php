<?php
defined('_JEXEC') or die('Restricted access');

$document = &JFactory::getDocument();
$document->addStyleSheet('/components/com_devotions/files/ui-lightness/jquery-ui-1.8.16.custom.css');
$document->addScript('/components/com_devotions/files/jquery-1.6.2.min.js');
$document->addScript('/components/com_devotions/files/jquery-ui-1.8.16.custom.min.js');
$document->addScript('/components/com_devotions/files/script.js');

?>

<form name="new_devotion" id="myform" method="post" action="index.php">

<?php include_once('new_head.php'); ?>

<fieldset>
<legend>New Devotion</legend>

<div class="photo">
    <img src="/components/com_devotions/files/users/<?php echo $this->pastor->url; ?>?t=<?php echo time(); ?>" style="width:150px; height: 150px;" title="<?php echo $this->pastor->name; ?>" onerror="this.src='/components/com_devotions/files/blank.png';" alt="<?php echo $this->pastor->name; ?>" />
</div>

<p style="margin-top: 5px; padding-bottom: 0px;">
<strong>Name:</strong> <input type="text" name="name" value="<?php echo $this->pastor->name; ?>"  style="border: 1px solid #fff; background: #fff" readonly="readonly" />
</p>

<p style="margin-top: 0px;">
<strong for="ps">Goes to :</strong> <input type="text" name="ps" value="<?php echo $this->pastor->church; ?>"  style="border: 1px solid #fff; background: #fff" readonly="readonly" /> 
</p>

<p>
<label for="dt">Date <span class="red">*</span></label> <input type="text" name="dt"  id="dt" style="background: #fff;  border: 1px solid #a5acb2;" value="" /> 
</p>

<p>
<label for="theme">Today's theme <span class="red">*</span></label> 
<input type="text" name="theme" value="" /> 
</p>

<p>
<label for="book">Today's scripture <span class="red">*</span></label> 
<select id="book" name="book">
<?php 
    $opts = '';
    foreach($books as $book){
        $opts .= '<option value="' . $book . '">' . $book . '</option>';
    }
    
    echo $opts; 
?>
</select>
</p>
<p>
<label> &nbsp; </label> 
<strong>Chapter <span class="red">*</span></strong>
<select id="chapter" name="chapter">
<?php 
    $opts2 = '';
    for($i = 1; $i < 151; $i++) {
        $opts2 .= '<option value="' . $i . '">' . $i . '</option>';
    }
    
    echo $opts2; 
?>
</select>

<strong>Verse <span class="red">*</span></strong> 
<select id="verse" name="verse">
<?php 
    $opts3 = '';
    for($c = 1; $c < 177; $c++) {
        $opts3.= '<option value="' . $c . '">' . $c . '</option>';
    }
    
    echo $opts3; 
?>
</select>
</p>

<p>
  <label for="reading" style="vertical-align: top;">The scripture reads as follows <span class="red">*</span> </label> 
  <textarea cols="30" rows="5" name="reading"></textarea>
</p>

<p>
  <label for="bible" style="vertical-align: top;">Bible translation used <span class="red">*</span> </label> 
  <input type="text" name="bible" value="" /> 
</p>

<p>
  <label for="devotion" style="vertical-align: top;">Today's devotion <span class="red">*</span> </label> 
  <textarea cols="30" rows="5" name="devotion"></textarea>
</p>

<p>
  <label for="prayer" style="vertical-align: top;">Today's confession / prayer <span class="red">*</span> </label> 
  <textarea cols="30" rows="5" name="prayer"></textarea>
</p>

<p>
  <label for="required" style="vertical-align: top;">&nbsp;</label> Fields marked with an asterisk (<span class="red">*</span>) are required.
</p>

<p>
  <label for="submit" style="vertical-align: top;">&nbsp;</label><input type="submit" class="button white" name="submit" value="Submit" /> <input type="button" class="button white" value="Cancel" onclick="location.href='index.php?option=com_devotions&task=cancel';" />
</p>

<p>
&nbsp;
</p>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="pastor_id" value="<?php echo $this->pastor->id; ?>" />
<input type="hidden" name="option" value="com_devotions">
<input type="hidden" name="task" value="save_devotion">
</fieldset>
</form>
