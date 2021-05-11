<?php

//dichiarazione db e collegamento
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "db-hotel";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn && $conn->connect_error) {
  echo "connection failed =>" . $conn->connect_error;
}
  //injections
  if ($_GET['id']) {
    $stmt = $conn->prepare("SELECT * FROM stanze WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();


    //ciclo while per stampare i risultati
    while($row = $result->fetch_assoc()) {
      ?>
      <div><?= 'ID:' .$row['id'] ?></div>
      <div><?= 'room' .$row['room_number'] ?></div>
      <div><?= 'beds number' .$row['beds'] ?></div>
      <div><?= 'floor' .$row['floor'] ?></div>
      <div><a href="/db-hotel/"><?= 'back to room selection' ?></a></div>
      <?php
    }
  } else {

    $sql = "SELECT room_number, id, floor FROM stanze";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      //ciclo while per stampare i risultati
      while ($row) {
      ?>
        <div><a href="/db-hotel/?id=<?= $row['id'] ?>"><?= "Room " .$row['room_number']; ?></a></div>
      <?php
        $row = $result->fetch_assoc();
      }

    } else if ($result) {
      echo "no results";
    } else {
      echo "query error";
    }
    //terminare la connessione al db
    $conn->close();
  }
 ?>
