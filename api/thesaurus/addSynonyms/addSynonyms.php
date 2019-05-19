<?php
require_once('/_lib.php');
requirePost();
$payload = payload();


$id = rand(0, 9999); // used as a way to group words


foreach ($payload->words as $word) {
    $str = $str . '('.$id.', "'.$mysqli->escape_string($word).'"),'; 
 }
$str = substr($str, 0, -1); // Removes the last comma

$rst = $mysqli->query('insert into thesaurus (id, word) values '.$str.';');

if ($mysqli->connect_error) fail('SQL connect fail');
if (!$rst) {
    fail('SQL error: ' . $mysqli->error);
}

//echo json_encode($payload);

httpOk("Saved");