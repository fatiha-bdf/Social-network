<?php
class DB {
  public function connect(){
    try {
      $pdo = new PDO('mysql:host=127.0.0.1;dbname=camagru;charset=utf8', 'flan', '');
      $pdo->setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);
      return $pdo;
    } catch (PDOException $e) {
      echo 'Connection failed : ' . $e->getMessage();
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
