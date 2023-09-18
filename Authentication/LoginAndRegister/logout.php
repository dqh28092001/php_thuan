<?php
  session_start();
  unset($_SESSION['username']);
  header('location: ../../View/index.php?page=1');

?>