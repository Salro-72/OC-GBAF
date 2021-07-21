<?php

function getComments($pdo){
    $sql ="SELECT * FROM commentsection";
    $result = $pdo->query($sql);
    while($row = $results->fetch_assoc()){
        echo $row['message'];
    }
}