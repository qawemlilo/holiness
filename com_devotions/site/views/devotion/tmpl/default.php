<?phpdefined('_JEXEC') or die('Restricted access');jimport('joomla.filesystem.file');$document = &JFactory::getDocument();$document->addStyleSheet(JURI::base() . 'components/com_devotions/files/fancybox/jquery.fancybox-1.3.4.css');$document->addScript(JURI::base() . 'components/com_devotions/files/fancybox/jquery.fancybox-1.3.4.pack.js');$document->addScript(JURI::base() . 'components/com_devotions/files/devotion-v12.js');$css = '#dcomments p{margin-top:0px;color:#07A0AD;}#dcomments p strong{color:#444444;font-size:16px;}#dcomments p small{color:#5B5B5B;}';$document->addStyleDeclaration($css);if (is_array($this->blessings) && count($this->blessings) > 0) {    $jsObj = json_encode($this->blessings);    $js = "blessingButton({$jsObj});";    $document->addScriptDeclaration($js);}list($day, $mnth, $year) = explode(',', $this->devotion->dt);$profnamearray = explode(' ', $this->pastor->name);?><h1>Dear friend, hear the voice of the Lord today: <?php echo $this->devotion->scripture; ?></h1><p><div style="width: 100%">  <div id="photo" style="border: 1px solid #DDDDDD; width: 154px; padding: 0px; height: 154px; float:left">    <a href="<?php echo JRoute::_('index.php?option=com_devotions&view=profile&Itemid=6&pid=' . $this->pastor->id); ?>">     <img src="<?php echo JURI::base(); ?>components/com_devotions/files/users/<?php echo $this->pastor->url . '?t=' . time(); ?>" title="<?php echo $this->pastor->name; ?>" onerror="this.src='<?php echo JURI::base(); ?>components/com_devotions/files/blank.png';" alt="<?php echo $this->pastor->name; ?>" style="width:150px; height: 150px; border-radius: 3px; -moz-border-radius: 3px;" />     <!-- <?php echo $this->pastor->url; ?> -->    </a>  </div>    <div style="width: 400px; font-weight: bold; margin-left: 10px; padding: 0px; height: 154px; float:left">    <a style="display: block; padding-left: 45px; padding-top: 15px; padding-bottom: 15px; background: url(/components/com_devotions/files/prayer.png) no-repeat; background-position: left 7px" href="<?php echo JRoute::_('index.php?option=com_devotions&view=admin&layout=new'); ?>">Share a New Devotion</a>    <a style="display: block; background: url(/components/com_devotions/files/back-arrow.png) no-repeat; background-position: left -2px; padding-top: 5px; padding-bottom: 5px; padding-left: 45px;"  href="<?php echo JRoute::_('index.php?option=com_devotions&view=profile&Itemid=6&pid=' . $this->pastor->id); ?>">View <?php echo $profnamearray[0]; ?>'s Divine Profile </a>  </div>  <div style="display: block; height:2px; clear:left;">     &nbsp;  </div></div></p><p><strong>Name: </strong><a href="<?php echo JRoute::_('index.php?option=com_devotions&view=profile&Itemid=6&pid=' . $this->pastor->id); ?>"><?php echo $this->pastor->name; ?></a></p><p><strong>Goes to (Church/Ministry): </strong> <?php echo $this->pastor->church; ?></p><p><strong>Day: </strong> <?php echo $day; ?></p><p><strong>Date: </strong> <?php echo $mnth . ' ' . $year; ?></p><p><strong>Today's theme: </strong> <?php echo $this->devotion->theme; ?></p><p><strong>Today's scripture: </strong> <?php echo $this->devotion->scripture; ?></p><p><strong>The scripture reads as follows:</strong> <?php echo $this->devotion->reading; ?></p><p><strong>Bible translation used: </strong><?php echo $this->devotion->bible; ?></p><?phpif(is_array($this->devotions) && count($this->devotions) > 0) :?><table id="rec_dev_table"><?php    $leftside = '<ul>';    $rightside = '<ul>';        $counter = 0;        foreach($this->devotions as $_devotion) {        $li = '<li>';        $li .= '<a href="' . JRoute::_('index.php?option=com_devotions&view=devotion&Itemid=6&dId=' . $_devotion->id) . '">';        $li .= $_devotion->theme;        $li .= '</a></li>';                if ($counter < 5) {                    $leftside .= $li;        }        else {            $rightside .= $li;        }                $counter += 1;    }        $leftside .= '</ul>';    $rightside .= '</ul>';?>  <tr>     <td style="width: 50%"><?php echo $leftside;  ?></td>    <td style="width: 50%"><?php echo $rightside; ?></td>  </tr>   </table><?phpendif;?><p><strong>Today's devotion: </strong><?php echo $this->devotion->devotion; ?></p><p><a href="<?php echo JRoute::_('index.php?option=com_devotions&view=devotion&dId=' . $this->devotionId); ?>" class="button white" onclick="blessMe(<?php echo "'{$this->devotionId}', '{$this->user->id}'"; ?>); return false;"> >> This devotion has truly blessed me << </a></p><div id="blessingsDiv" style="margin-top: 10px; padding-left:10px;">&nbsp;</div><p><span id="page_navigation" class="pagination" style="text-align: left;">&nbsp;</span><span id="total-pages" style="display: block; width: 70%; text-align: center;">&nbsp;</span></p><p><strong>Today's confession / prayer: </strong><?php echo $this->devotion->prayer; ?></p><p>  <ul>    <li class="print"><a href="#" onclick="javascript: window.print()">Print out this devotion</a></li>    <li class="download"><a href="index.php?option=com_devotions&task=download&dId=<?php echo $this->devotionId; ?>" target="_blank">Download this devotion</a></li>    <li class="email"><a href="#data" id="emaildevotion" title="Email this devotion to a friend">Email this devotion to a friend</a></li>  </ul></p><?php/* ----------------------------------------   Commenting Form   --------------------------------- */echo $this->commentForm;/* -------------------------------------------------------- Commments -------------------------------*/echo $this->comments;/* -------------------------------------------------------- Hidden popup email form -------------------------------*/include_once(dirname(__FILE__) . DS . 'email.php');?>