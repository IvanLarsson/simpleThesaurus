<?php
require_once('_lib.php');
requirePut();   // Only allow PUT 
$payload = payload(); // Get payload from request

$id = rand(0, 9999); // used as a way to group words

// Create value string for database insert
foreach ($payload->words as $word) {
    $str = $str . '('.$id.', "'.$mysqli->escape_string($word).'"),'; 
 }
$str = substr($str, 0, -1); // Removes the last comma

$rst = $mysqli->query('insert into thesaurus (id, word) values '.$str.';');

if ($mysqli->connect_error) fail('SQL connect fail');
if (!$rst) {
    fail('SQL error: ' . $mysqli->error);
}

// Returns 200
httpOk("Saved");