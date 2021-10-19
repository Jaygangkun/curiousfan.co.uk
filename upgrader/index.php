<?php require_once 'filesList.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP FansOnly Upgrader</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">

</head>
<body>
<div class="container mt-5">
    <div class="card shadow p-5">
    <h1>PHP FansOnly Upgrader v1.8.1 to v1.9</h1>
    <h3>What's new?</h3>

    <?php if(!isset($_GET['backup'])): ?>
    <div class="alert alert-danger">
        MAKE SURE TO HAVE A BACKUP OF EVERYTHING BEFORE PROCEEDING IN CASE OF FAILURE.<br>
        CHECK YOUR CURRENT VERSION, IF YOU DON'T HAVE V1.8.1 - CONTACT ME. YOU CANNOT UPGRADE DIRECTLY TO V1.9 IF YOU HAVE LOWER THAN V1.8.1
    </div>

    <div class="alert alert-secondary">
    <ul class="p-1">
        <li>Add more than one image in a post</li>
        <li>Send locked/free images via Messaging System</li>
        <li>Send locked/free video via Messaging System</li>
        <li>Send locked/free audio via Messaging System</li>
        <li>Send locked/free zip via Messaging System</li>
        <li>Youtube style progress loading bar at the top</li>
        <li>Added Emoji Support - now emoji from your phone will show instead of ??? characters</li>
        <li>Revamped messaging system on mobile (full view, users into dropdown as people said it's difficult to click)</li>
        <li>Fixed issue with report content form</li>
        <li>Fixed issue with scroll not loading more content on android mobile devices</li>
        <li>Fixed issue with verification requests showing people who didn't apply as creators</li>
        <li>Fixed issue with deleting a content report</li>
    </ul>
    </div>

    <h3 class="mt-3">What files have changed?</h3>

    <div class="alert alert-secondary p-4">
    <ol class="p-3">
    <?php
    foreach($filesList as $f) {
        if(empty($f)) continue;
        echo '<li>' . $f . '</li>';
    }
    ?>
    </ol>
    </div>

    <?php endif; ?>

    <h3 class="mt-3">Proceed with the update.</h3>

    <?php if(!isset($_GET['backup'])) { ?>
    <a href="index.php?backup=true" class="btn btn-primary">
        I have a backup and my current version is v1.8.1 - Continue
    </a>
    <?php } ?>

    <?php if (isset($_GET['backup'])) { ?>
    
    <div class="alert alert-info">
        Ok, you have confirmed that you have a backup and your current version is v1.8.1, click below to proceed
    </div>

    <a href="process-upgrade.php" class="btn btn-primary">
        Proceed with the upgrader
    </a>
    <?php } ?>

    <div class="ugrade-message"></div>
    

</div>
</body>
</html>