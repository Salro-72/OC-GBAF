<?php
class Reactions {
  // connexion avec le bdd
  private $pdo;
  private $stmt;
  function __construct () {
    try {
      $this->pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      );
    } catch (Exception $ex) { die($ex->getMessage()); }
  }
  // ferme la connexion avec le bdd
  function __destruct () {
    $this->pdo = null;
    $this->stmt = null;
  }

  // cherche tous le nbr de votes
  function get ($id) {
    $sql = "SELECT `id_acteur`, `vote`, COUNT(`vote`) `total` FROM `votes` WHERE `id_acteur` IN (?";
    $sql .= str_repeat(",?", count($id)-1);
    $sql .= ") GROUP BY `id_acteur`, `vote`";

    // (C2) RUN QUERY
    $reactions = [];
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($id);
    while ($r = $this->stmt->fetch(PDO::FETCH_NAMED)) {
      // $reactions[ID][REACTION] = TOTAL
      $reactions[$r['id_acteur']][$r['vote']] = $r['total'];
    }
    return $reactions;
  }

  // (D) GET REACTIONS SET BY SPECIFIED USER
  function getUser ($id, $uid) {
    // (D1) FORMULATE SQL QUERY
    $sql = "SELECT * FROM `votes` WHERE `id_user`=? AND `id_acteur` IN (?";
    $sql .= str_repeat(",?", count($id)-1) . ")"; 

    // (D2) GET USER REACTIONS
    $reactions = [];
    array_unshift($id, $uid);
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($id);
    while ($r = $this->stmt->fetch(PDO::FETCH_NAMED)) {
      // $reactions[ID] = REACTION
      $reactions[$r['id_user']] = $r['vote'];
    }
    return $reactions;
  }

  // (E) SAVE REACTION
  function save ($id, $uid, $react) {
    $this->stmt = $this->pdo->prepare(
      "REPLACE INTO `votes` (`id_acteur`, `id_user`, `vote`) VALUES (?,?,?)"
    );
    $this->stmt->execute([$id, $uid, $react]);
    return true;
  }

  // (F) DELETE REACTION
  function del ($id, $uid) {
    $this->stmt = $this->pdo->prepare(
      "DELETE FROM `votes` WHERE `id_acteur`=? AND `id_user`=?"
    );
    $this->stmt->execute([$id, $uid]);
    return true;
  }
}

// (G) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define('DB_HOST', 'localhost');
define('DB_NAME', 'demo');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// (H) CREATE NEW CONTENT OBJECT
$REACT = new Reactions();