<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PHP AJAX Crud - Stored Procedure</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f1f1f1;
    }

    .box {
      width: 750px;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-top: 100px;
    }
  </style>
</head>

<body>
  <div class="container box">
    <h3 align="center">PHP Ajax Crud - Insert Update Delete with Stored Procedure</h3>
    <br /><br />
    <br /><br />
    <label>Enter First Name</label>
    <input type="text" name="first_name" id="first_name" class="form-control" />
    <br />
    <label>Enter Last Name</label>
    <input type="text" name="last_name" id="last_name" class="form-control" />
    <br /><br />
    <div align="center">
      <input type="hidden" name="u_id" id="user_id" />
      <button type="button" name="action" id="action" class="btn btn-warning">Add</button>
    </div>
    <br />
    <br />
    <div id="result" class="table-responsive">
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>

</html>

<script>
  $(document).ready(function() {
    fetchUser();

    // Fetch User Data
    function fetchUser() {
      var action = "select";
      $.ajax({
        url: "select.php",
        method: "POST",
        data: {
          action: action
        },
        success: function(data) {
          $('#first_name').val('');
          $('#last_name').val('');
          $('#action').text("Add");
          $('#result').html(data);
        }
      });
    }

    // Insert User Data
    $('#action').click(function() {
      var firstName = $('#first_name').val();
      var lastName = $('#last_name').val();
      var id = $('#user_id').val();
      var action = $('#action').text();
      if (firstName != '' && lastName != '') {
        $.ajax({
          url: "action.php",
          method: "POST",
          data: {
            firstName: firstName,
            lastName: lastName,
            id: id,
            action: action
          },
          success: function(data) {
            alert(data);
            fetchUser();
          }
        });
      } else {
        alert("Both Fields are Required");
      }
    });

    // Update User Data 
    $(document).on('click', '.update', function() {
      var id = $(this).attr("id");
      $.ajax({
        url: "fetch.php",
        method: "POST",
        data: {
          id: id
        },
        dataType: "json",
        success: function(data) {
          $('#action').text("Edit");
          $('#user_id').val(id);
          $('#first_name').val(data.first_name);
          $('#last_name').val(data.last_name);
        }
      })
    });

    // Delete User Data
    $(document).on('click', '.delete', function() {
      var id = $(this).attr("id");
      if (confirm("Are you sure you want to remove this data?")) {
        var action = "Delete";
        $.ajax({
          url: "action.php",
          method: "POST",
          data: {
            id: id,
            action: action
          },
          success: function(data) {
            fetchUser();
            alert(data);
          }
        })
      } else {
        return false;
      }
    });
  });
</script>