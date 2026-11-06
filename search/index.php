<?php
$query = $_SERVER['QUERY_STRING'] ?? '';
$location = '../index.php' . ($query !== '' ? '?' . $query : '');
header('Location: ' . $location, true, 302);
exit;