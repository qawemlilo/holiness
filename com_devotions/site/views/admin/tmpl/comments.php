<?phpdefined('_JEXEC') or die('Restricted access');include_once('head.php');?><div style="margin-top:15px">  <form action="index.php?option=com_devotions&task=comments_admin&dId=<?php echo $this->dId; ?>" method="post" name="myform">    Display # <?php echo $this->pagination->getLimitBox() . " &nbsp; &nbsp; ". $this->pagination->getPagesCounter(); ?>  </form></div><table class="adminlist" id="tracker">  <caption>Comments: <?php echo $this->theme;?> </caption>    <thead>      <tr>        <th scope="col"   style="width: 35%">          <strong>Date</strong>        </th>        <th scope="col">            <strong>Name</strong>        </th>        <th scope="col">            <strong>Comment</strong>        </th>        <th scope="col">            &nbsp;        </th>      </tr>	</thead>        <tbody>    <?php    if(is_array($this->comments) && count($this->comments) > 0) {          foreach($this->comments as $comment) {        $tr = '<tr>';        $tr .= '<td style="vertical-align: top; border-bottom: 1px solid #07A0AD">' . $comment->ts . '</td>';        $tr .= '<td style="vertical-align: top;  border-bottom: 1px solid #07A0AD">' . $comment->full_name . '</td>';        $tr .= '<td style="vertical-align: top;  border-bottom: 1px solid #07A0AD">' . $comment->comment_text . '</td>';        $tr .= "<td style=\"align:center;  border-bottom: 1px solid #07A0AD\"><a style=\"color:red;\" href=\"index.php?option=com_devotions&task=comment_delete&comId={$comment->id}\">Delete</a></td>";        $tr .= '</tr>';                echo $tr;      }    }    ?>    </tbody></table><div style="margin-top:15px">    <?php echo $this->pagination->getPagesLinks(); ?></div>