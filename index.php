<?php

$url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."public";
header("Location: {$url}");
exit();
?>
