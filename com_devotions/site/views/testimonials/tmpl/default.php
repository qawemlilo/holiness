<?php
defined('_JEXEC') or die('Restricted access');
/*
$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_devotions/files/ui-lightness/jquery-ui-1.8.16.custom.css');
$document->addScript('components/com_devotions/files/jquery-1.6.2.min.js');
$document->addScript('components/com_devotions/files/jquery-ui-1.8.16.custom.min.js');
$document->addScript('components/com_devotions/files/script.js');
*/
?>

<form name="testimony" id="testimony" method="post" action="index.php?option=com_devotions&task=testimonial">
<div class="componentheading">
<h3><span class="vt_heading1"><span class="vt_heading2">Testimonials</span></span></h3>
</div>
<fieldset>
<p style="color: #07A0AD; font-weight: bold">
  Please let us know how God is changing your life through this website:
</p>

<table style="width: 100%"">
  <tbody>
    <tr>
      <td>
        <label>Your Name: <span class="red">*</span></strong> <br />
        <input type="text" name="name" value=""  />
      </td>
      <td>
        <label>Your email: <span class="red">*</span></strong> <br />
        <input type="text" name="email" value=""  />
      </td>
    </tr>
    <tr>
      <td>
        <label>Country: <span class="red">*</span></strong> <br />
        <input type="text" name="country" value=""  />
      </td>
      <td>
        <label>Town / City: <span class="red">*</span></strong> <br />
        <input type="text" name="city" value=""  />
      </td>
    </tr>
    <tr>
      <td>
        <label>Church / Ministry: <span class="red">*</span></strong> <br />
        <input type="text" name="church" value=""  />
      </td>
      <td>
        <label>Your Pastor's Name: <span class="red">*</span></strong> <br />
        <input type="text" name="pastor" value=""  />
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <label>Message: <span class="red">*</span></strong> <br />
        <textarea cols="30" rows="6" style="width: 40%" name="msg"></textarea>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="submit" name="submit" class="button white" value="Submit"  />
      </td>
    </tr>
</tbody>
</table>
</fieldset>
</form>
