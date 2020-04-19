<?php
require 'vendor/autoload.php';
require 'config.php';
require 'functions.php';
$title= $title ?? 'test';

new Models\Database();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?=$title;?></title>
  <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <link href="public/css/default.css" type="text/css" rel="stylesheet">
  <script src="public/js/default.js"></script>
  <script>
      if(localStorage.getItem("clusterId") === undefined) {
          localStorage.setItem("clusterId", 1);
      }
  </script>
</head>
<body>
