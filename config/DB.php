<?php
class DB {
  public function connect(){
    require 'database.php';
      try {
      $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $pdo->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      echo 'Connection faileEd : ' . $e->getMessage();
    }
  }
  public static function query($query, $params = array()) {
    $statement = self::connect()->prepare($query);
    $statement->execute($params);
    if (explode(' ', $query)[0] == 'SELECT') {
      $data = $statement->fetchAll();
      return $data;
    }
  }
}
?>
