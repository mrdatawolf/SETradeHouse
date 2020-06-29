<?php
require 'vendor/autoload.php';
require 'config.php';
require 'functions.php';
$title= $title ?? 'test';

new Models\Database();
new Models\Users();

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){

    header("location: login.php");
}

$thisCluster = (object) [
  'title' => \Models\Clusters::find($_SESSION["cluster_id"])->title,
  'id' => $_SESSION["cluster_id"]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?=$title;?></title>
  <script src="https://kit.fontawesome.com/b61a9642d4.js" crossorigin="anonymous"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <link href="public/css/default.css" type="text/css" rel="stylesheet">
  <script src="public/js/default.js"></script>
  <script>
      if(localStorage.getItem("clusterId") === undefined) {
          localStorage.setItem("clusterId", 1);
      }
  </script>
</head>
<body>
<?php require_once('menubar.php'); ?>
