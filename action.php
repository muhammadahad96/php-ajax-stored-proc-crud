<?php
//action.php  
if (isset($_POST["action"])) {
  $output = '';
  $connect = mysqli_connect("localhost", "root", "", "ajax_stproc");

  // Insert Data
  if ($_POST["action"] == "Add") {
    $first_name = mysqli_real_escape_string($connect, $_POST["firstName"]);
    $last_name = mysqli_real_escape_string($connect, $_POST["lastName"]);
    // Create insertUser() Stored Procedure
    $procedure = "  
      CREATE PROCEDURE insertUser(IN firstName varchar(250), lastName varchar(250))  
      BEGIN  
      INSERT INTO tbl_users(first_name, last_name) VALUES (firstName, lastName);   
      END;  
    ";

    // Drop Procedure if it exists
    if (mysqli_query($connect, "DROP PROCEDURE IF EXISTS insertUser")) {
      // Call insertUser() Stored Procedure
      if (mysqli_query($connect, $procedure)) {
        $query = "CALL insertUser('" . $first_name . "', '" . $last_name . "')";
        mysqli_query($connect, $query);
        echo 'Data Inserted';
      }
    }
  }

  // Update Data
  if ($_POST["action"] == "Edit") {
    $first_name = mysqli_real_escape_string($connect, $_POST["firstName"]);
    $last_name = mysqli_real_escape_string($connect, $_POST["lastName"]);
    // Create updateUser() Stored Procedure
    $procedure = "  
      CREATE PROCEDURE updateUser(IN user_id int(11), firstName varchar(250), lastName varchar(250))  
      BEGIN   
      UPDATE tbl_users SET first_name = firstName, last_name = lastName  
      WHERE u_id = user_id;  
      END;   
    ";
    // Drop Procedure if it exists
    if (mysqli_query($connect, "DROP PROCEDURE IF EXISTS updateUser")) {
      if (mysqli_query($connect, $procedure)) {
        // Call updateUser() Stored Procedure
        $query = "CALL updateUser('" . $_POST["id"] . "', '" . $first_name . "', '" . $last_name . "')";
        mysqli_query($connect, $query);
        echo 'Data Updated';
      }
    }
  }

  // Delete Data
  if ($_POST["action"] == "Delete") {
    // Create deleteUser() Stored Procedure
    $procedure = "  
      CREATE PROCEDURE deleteUser(IN user_id int(11))  
      BEGIN   
      DELETE FROM tbl_users WHERE u_id = user_id;  
      END;  
    ";
    // Drop Procedure if it exists
    if (mysqli_query($connect, "DROP PROCEDURE IF EXISTS deleteUser")) {
      if (mysqli_query($connect, $procedure)) {
        // Call deleteUser() Stored Procedure
        $query = "CALL deleteUser('" . $_POST["id"] . "')";
        mysqli_query($connect, $query);
        echo 'Data Deleted';
      }
    }
  }
}
