<?php 
require_once('_lib.php');
requireGet(); // Only allow GET


$synonyms = array();
$rst = $mysqli->query('SELECT group_concat(thesaurus.word) as synonyms from thesaurus group by id;');
if ($mysqli->connect_error) {
    fail('SQL connect fail');
}
if (!$rst) {
    fail('SQL error: ' . $mysqli->error);
}
if($rst->num_rows != 0){
    while($wordDB = $rst->fetch_object()){
        array_push($synonyms, explode(",", $wordDB->synonyms));
    }
} 

// Return message OK/200 and all words grouped as synonyms
httpJson('{"allWords": '.json_encode($synonyms).'}');
