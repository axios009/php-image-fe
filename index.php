<?php

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mt-5">Login</h2>
        <form id="loginForm">
          <div class="mb-3">
            <label for="email" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <div id="message" class="mt-3"></div>
      </div>
    </div>
  </div>
</body>

</html>
<script type="text/javascript" src="./vendor/components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="./vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    checkService();

    $("#loginForm").submit(function (event) {
      event.preventDefault();
      var username = $("#username").val();
      var password = $("#password").val();

      $.ajax({
        url: 'http://localhost/php-image-be/auth.php/login',
        dataType: "json",
        type: 'POST',
        data: {
          username: username,
          password: password
        },
        success: function (response) {
          if (response) {
            window.location.href = "upload.php";
          } else {
            alert("Fail")
          }
        }
      });
    });
  });

  function checkService() {
    $.ajax({
      url: 'http://localhost/php-image-be/auth.php/health',
      dataType: "json",
      type: 'GET',
      cache: false,
      success: function (response) {
        if (response) {
          $("#message").html(response.status);
        } else {
          $("#message").html('Offline');
        }
      }
    });
  }
</script>