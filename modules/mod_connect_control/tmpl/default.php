<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_connect_control
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */

defined('_JEXEC') or die;

echo "<br> $send <br>";
?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>


<div id="connect_control">
    

</div>

<div id="timeClew" algin=center></div>

<script type="text/javascript">
var url = "meter-connect" //要跳转的地址
var obj = document.getElementById("timeClew"), time = 5;
function setTimeClew(){
 obj.innerHTML = "正在返回...... " + (time--) + "秒后自动跳转，如果没有自动跳转<a href=\"" + url + "\">请点这里<\/a>";
 if(time < 0){ window.location.href = url; }else{ setTimeout(setTimeClew, 1000) }
}
setTimeClew();
</script>
</html>