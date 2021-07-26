<?php

class Vote{

    private $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function like($id_billet, $id_user){
        $req = $pdo->prepare("SELECT * FROM $id_billet WHERE id = ?")
        $req->execute(array([$id_billet]);
        if($req->rowCount() > 0){
            $req = $this->pdo->prepare('INSERT INTO vote SET id_billet=?, id_user=?, vote= 1');
            $req->execute([$id_billet, $id_user, $vote]);
            return true;
        } else {
            echo 'Error!';
        }
    }

    public function dislike($id_billet, $id_user){

    }
}