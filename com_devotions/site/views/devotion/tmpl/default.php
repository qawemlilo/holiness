<?phpdefined('_JEXEC') or die('Restricted access');$document = &JFactory::getDocument();$document->addStyleSheet('/components/com_devotions/files/fancybox/jquery.fancybox-1.3.4.css');$document->addScript('/components/com_devotions/files/devotion.js');$css = '#dcomments p {   margin-top: 0px;   color: #07A0AD;}#dcomments p strong {   color: #444444;   font-size: 16px;}#dcomments p small {   color: #5B5B5B;}';$document->addStyleDeclaration($css);$document = &JFactory::getDocument();$urlObj = &JFactory::getURI();$currentUrl = $urlObj->toString();function getImage($id) {    $exts = array('png','gif','jpeg', 'jpg');    $f = JPATH_COMPONENT . DS . 'files' .  DS . 'users' .  DS . 'user_' . $id . '.';        $img = $currentUrl . "/components/com_devotions/files/users/user_{$id}.";    $theimge = '/components/com_devotions/files/blank.png';    foreach($exts as $ext) {        $tempimg = $f . $ext;        if(JFile::exists($tempimg)) {            $theimge =  $img . $ext;            break;        }    }        return $theimge;}list($day, $mnth, $year) = explode(',', $this->devotion->dt);?><h1>Dear friend, hear the voice of the Lord today: <?php echo $this->devotion->scripture; ?></h1><p><div id="photo" style="border: 1px solid #DDDDDD; width: 154px; padding: 0px; height: 154px;"><a href="index.php?option=com_devotions&view=devotions&Itemid=6&pid=<?php echo $this->pastor->id; ?>">   <img src="/components/com_devotions/files/users/<?php echo $this->pastor->url . '?t=' . time(); ?>" title="<?php echo $this->pastor->name; ?>" onerror="this.src='/components/com_devotions/files/blank.png';" alt="<?php echo $this->pastor->name; ?>" style="width:150px; height: 150px;" /></a></div></p><p><strong>Name: </strong><a href="<?php echo JRoute::_('index.php?option=com_devotions&view=devotions&Itemid=6&pid=' . $this->pastor->id); ?>"><?php echo $this->pastor->name; ?></a></p><p><strong>Goes to (Church/Ministry): </strong> <?php echo $this->pastor->church; ?></p><p><strong>Day: </strong> <?php echo $day; ?></p><p><strong>Date: </strong> <?php echo $mnth . ' ' . $year; ?></p><p><strong>Today's theme: </strong> <?php echo $this->devotion->theme; ?></p><p><strong>Today's scripture: </strong> <?php echo $this->devotion->scripture; ?></p><p><strong>The scripture reads as follows:</strong> <?php echo $this->devotion->reading; ?></p><p><strong>Bible translation used: </strong>  <?php echo $this->devotion->bible; ?></p><?phpif(is_array($this->devotions) && count($this->devotions) > 0) :?><table id="rec_dev_table"><?php    $leftside = '<ul>';    $rightside = '<ul>';        $counter = 0;        foreach($this->devotions as $_devotion) {        $li = '<li>';        $li .= '<a href="index.php?option=com_devotions&view=devotion&Itemid=6&dId=' . $_devotion->id . '">';        $li .= $_devotion->theme;        $li .= '</a></li>';                if ($counter < 5) {                    $leftside .= $li;        }        else {            $rightside .= $li;        }                $counter += 1;    }        $leftside .= '</ul>';    $rightside .= '</ul>';?><tr>     <td style="width: 50%">        <?php echo $leftside;  ?>    </td>    <td style="width: 50%">        <?php echo $rightside; ?>    </td></tr>   </table><?phpendif;?><p><strong>Today's devotion: </strong><?php echo $this->devotion->devotion; ?></p><p><strong>Today's confession / prayer:</strong><?php echo $this->devotion->prayer; ?></p><p>  <ul>    <li class="print"><a href="#" onclick="javascript: window.print()">Print out this devotion</a></li>    <li class="download"><a href="index.php?option=com_devotions&task=download&dId=<?php echo $_GET['dId']; ?>" target="_blank">Download this devotion</a></li>    <li class="email"><a href="#data" id="emaildevotion" title="Email this devotion to a friend">Email this devotion to a friend</a></li>  </ul></p><div style="height: 5px; margin: 10px 0px 15px 0px; background: url('templates/vt_create/images/h3.gif') repeat-x;"> &nbsp; </div><!----------------------------------------   Commenting System   ---------------------------------><h1 style="font-size:140%">Child of God, what have you learnt from this devotion???</h1><h1 style="font-size:140%; margin-bottom: 10px; margin-top: 5px"><a href="<?php echo  JRoute::_('index.php?option=com_devotions&view=devotions&Itemid=6&pid=' . $this->pastor->id); ?>"><?php echo $this->pastor->name; ?></a> would love to know.</h1><form name="commentForm" action="index.php" method="post" /><p><label for="comment" style="font-weight: normal">Comment: <span class="red">*</span></label> <br> <textarea style="border: 1px solid #07A0AD" cols="30" rows="5" name="comment"></textarea></p><p><input type="hidden"  name="name" value="<?php echo $this->user->name; ?>" /> <input type="hidden"  name="userid" value="<?php echo $this->user->userid; ?>" /><input type="hidden"  name="devotionid" value="<?php echo $this->devotion->id;  ?>" /> <input type="hidden"  name="option" value="com_devotions" /> <input type="hidden"  name="task" value="comment" /> <?php echo JHTML::_( 'form.token' ); ?><input type="submit" class="button white" name="submit" value="Share" /></p></form><?phpif($this->comments && count($this->comments) > 0) { ?><div id="dcomments"><div style="margin-left: 5px; margin-top: 10px; margin-bottom: 10px;">  <form action="index.php?option=com_devotions&view=devotion&Itemid=6<?php if($this->devotion->id) echo '&dId=' . $this->devotion->id; ?>" method="post" name="myform">   Display # <?php echo $this->pagination->getLimitBox(); ?></span>  </form></div><?php    $comments = '';    foreach($this->comments as $comment) {        $p = '<p>';        $imgsrc = getImage($comment->userid);        $usr = $this->model->getUser($comment->userid);         $nam = $usr->name ? $usr->name : $comment->full_name;        $p .= "<img src=\"/components/com_devotions/files/users/{$this->getUrl[$comment->userid]['url']}\" onerror=\"this.src='/components/com_devotions/files/blank.png';\" class=\"pastor_img\" alt=\"{$nam}\" style=\"border: 1px solid #DDDDDD; width: 64px; height: 64px; margin-right: 10px; float: left;\" title=\"{{$nam}\" />";        $p .= '<h3 style="margin-top: -5px">' . $nam . '</h3>';        $p .= '<small>' . JHTML::Date($comment->ts) . '</small><br />';        $p .= '<span style="color: #07A0AD; line-height: 1.5em">' . $comment->comment_text . '</span>';        $p .= '</p>';        $p  .= '<p style="height:1px; clear:both;"> &nbsp; </p>';        $comments .= $p;     }         echo $comments;?><div>    <?php echo $this->pagination->getPagesLinks(); ?></div></div><?php}include_once(dirname(__FILE__) . DS . 'email.php');?>