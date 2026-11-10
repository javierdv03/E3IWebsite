<?php
session_start();
if(!isset($_SESSION['Val'])) die();

session_destroy();
?>

<script>localStorage.clear(); top.location.href = "../Auth"; </script>