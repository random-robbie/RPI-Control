<?php
echo "<pre>";
$test = shell_exec('/var/www/stats.sh');
print  $test;
echo "</pre>";
?>

