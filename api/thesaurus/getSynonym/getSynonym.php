<?php
require_once('_lib.php');
requireGet();

if (!isset($_GET['word'])) httpErr(400, 'word must be specified');

$word = $_GET['word'];

$synonyms = array();
$rst = $mysqli->query('SELECT word FROM thesaurus WHERE id = (SELECT ID FROM thesaurus WHERE word = "'.$mysqli->escape_string($word).'" ) ;');
if ($mysqli->connect_error) {
    fail('SQL connect fail');
}
if (!$rst) {
    fail('SQL error: ' . $mysqli->error);
}
if($rst->num_rows != 0){
    while($wordDB = $rst->fetch_object()){
        array_push($synonyms, $wordDB->word);
    }
} 

// Return message OK/200
httpJson('{"word":"'.$word.'", "synonyms": '.json_encode($synonyms).'}');