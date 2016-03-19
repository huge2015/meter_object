<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_param_update
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */

defined('_JEXEC') or die;
?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>


<div id="#electrical">
    <h1></h1>
          
   正在返回......
</div>

<div id="timeClew" algin=center></div>

<script type="text/javascript">
var url = "index.php/param-set" //要跳转的地址
var obj = document.getElementById("timeClew"), time = 3;
function setTimeClew(){
 obj.innerHTML = "更新成功! " + (time--) + "秒后返回，如果没有自动跳转<a href=\"" + url + "\">请点这里<\/a>";
 if(time < 0){ window.location.href = url; }else{ setTimeout(setTimeClew, 1000) }
}
setTimeClew();
</script>
</html>