<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_updata
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;
?>

<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>


<div id="electrical">
The Last record's contoller_electrical_id is : <?php echo $data_pos;?>
<br>
The Last record's datetime is : <?php echo $time_pos;?>
<br>


<div id="timeClew" algin=center></div>

<script type="text/javascript">
//var url = "index.php/upload-data" //要跳转的地址
//var url = "index.php/yee-upload" //要跳转的地址
var url = "index.php/upload-local" //要跳转的地址
var obj = document.getElementById("timeClew"), time = 30;
function setTimeClew(){
 obj.innerHTML = "上传记录成功! " + (time--) + "秒后自动下一次数据上传，如果没有自动跳转<a href=\"" + url + "\">请点这里<\/a>";
 if(time < 0){ window.location.href = url; }else{ setTimeout(setTimeClew, 1000) }
}
setTimeClew();
</script>

</div>
</html>