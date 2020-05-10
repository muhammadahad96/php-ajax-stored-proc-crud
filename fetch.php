<?php
//fetch.php  
$connect = mysqli_connect("localhost", "root", "", "ajax_stproc");

if (isset($_POST["id"])) {
  $output = array();
  // Create whereUser() Stored Procedure
  $procedure = "  
    CREATE PROCEDURE whereUser(IN user_id int(11))  
    BEGIN   
    SELECT * FROM tbl_users WHERE u_id = user_id;  
    END;   
  ";
  // Drop Procedure if it exists
  if (mysqli_query($connect, "DROP PROCEDURE IF EXISTS whereUser")) {
    if (mysqli_query($connect, $procedure)) {
      // Call whereUser() Stored Procedure
      $query = "CALL whereUser(" . $_POST["id"] . ")";
      $result = mysqli_query($connect, $query);
      while ($row = mysqli_fetch_array($result)) {
        $output['first_name'] = $row["first_name"];
        $output['last_name'] = $row["last_name"];
      }
      echo json_encode($output);
    }
  }
}
