<?php defined('_JEXEC') or die('Restricted access');$urlObj = &JFactory::getURI();$currentUrl = $urlObj->toString();function getImage($id) {    $exts = array('png','gif','jpeg', 'jpg');    $f = JPATH_COMPONENT . DS . 'files' .  DS . 'users' .  DS . 'user_' . $id . '.';        $img = $currentUrl . "/components/com_devotions/files/users/user_{$id}.";    $theimge = '/components/com_devotions/files/blank.png';    foreach($exts as $ext) {        $tempimg = $f . $ext;        if(JFile::exists($tempimg)) {            $theimge =  $img . $ext .'?t=' . time();            break;        }    }        return $theimge;}if($this->sword) {    echo "<h1 class=\"dev_header\">Search results for: $this->sword </h1>";}elseif($this->pid) {    $_pastor = $this->model->getPastor($this->pid);        echo "<h1 class=\"dev_header\">Devotions by $_pastor->name </h1>";}else {    echo '<h1 class="dev_header">Daily Devotions</h1>';}?><div>  <form action="index.php?option=com_devotions&view=devotions&Itemid=6<?php if($this->pid) echo '&pid=' . $this->pid; ?>" method="post" name="myform">   Display # <?php echo $this->pagination->getLimitBox() . " &nbsp; &nbsp; <span style=\"margin-left: 200px;\"> " . $this->pagination->getPagesCounter(); ?></span>  </form></div><?phpif(is_array($this->devotions) && count($this->devotions) > 0) {    foreach($this->devotions as $devotion) {         $pastor = $this->model->getPastor($devotion->pastor);    ?>        <div class="devotion">            <a href="index.php?option=com_devotions&view=devotion&Itemid=6&dId=<?php echo $devotion->id; ?>">                                <img src="/components/com_devotions/files/users/<?php echo $pastor->url . '?t=' . time(); ?>" onerror="this.src='/components/com_devotions/files/blank.png';" class="pastor_img" alt="<?php echo $devotion->name; ?>" style="width: 64px; height: 64px;" title="<?php echo $devotion->name; ?>">                <h3><?php echo $devotion->theme; ?></h3>                                <strong>Name:</strong>  <?php echo $pastor->name; ?><br />                <strong>Scripture:</strong>  <?php echo $devotion->scripture; ?>                            </a>        </div>        <?php    }   }?><div>    <?php echo $this->pagination->getPagesLinks(); ?></div>