<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: form.html');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Server Information</title>
</head>
<body>
<h2>Server Information:</h2>
<ul>
    <li>Client IP: <?php echo $_SERVER['REMOTE_ADDR']; ?></li>
    <li>Browser: <?php echo $_SERVER['HTTP_USER_AGENT']; ?></li>
    <li>Current Script: <?php echo $_SERVER['PHP_SELF']; ?></li>
    <li>Request Method: <?php echo $_SERVER['REQUEST_METHOD']; ?></li>
    <li>Script Path: <?php echo $_SERVER['SCRIPT_FILENAME']; ?></li>
</ul>
</body>
</html>