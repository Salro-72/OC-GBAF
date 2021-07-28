<?php
// (A) INIT
session_start();
$_SESSION['user'] = 1; // For this demo only, fixed to 1
require "votes.php";
$results = [];

// (B) COMMON FUNCTION - GET REACTIONS 
function get () {
  global $REACT;
  global $results;
  $results['react'] = $REACT->get([$_POST['id']]);
  $results['user'] = $REACT->getUser([$_POST['id']], $_SESSION['user']);
}

// (C) HANDLE REQUEST
switch ($_POST['req']) {
  // (C1) SAVE REACTION
  case "save":
    $results['status'] = $REACT->save($_POST['id'], $_SESSION['user'], $_POST['react']) ? 1 : 0 ;
    if ($results['status']) { get(); }
    else { $results['error'] = $REACT->error; }
    break;

  // (C2) DELETE REACTION
  case "del":
    $results['status'] = $REACT->del($_POST['id'], $_SESSION['user']) ? 1 : 0 ;
    if ($results['status']) { get(); }
    else { $results['error'] = $REACT->error; }
    break;
}

// (D) RESPOND
/* $results = [
 *   "react" => REACTIONS FOR POST/VIDEO/PRODUCT
 *   "user" => USER REACTIONS
 *   "status" => 1 OR 0 (FOR SAVE + DELETE)
 *   "error" => ERROR MESSAGE, IF ANY
 * ] */
echo json_encode($results);