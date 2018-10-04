<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>link shortener</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Jaldi" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  	<style>
      html {
        position: relative;
        min-height: 100%;
      }
      body {
        font-family: 'Jaldi', sans-serif;
        /* Margin bottom by footer height */
        margin-bottom: 60px;
        max-width: 100%;
      }
      .wb {
        word-break: break-all;
      }
      .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        /* Set the fixed height of the footer here */
        height: 60px;
        background-color: #e9ecef;
      }
  	</style>
  </head>
  <body>

    <div class="jumbotron text-center">
      <div class="container-fluid">
        <h2>Login</h2>
      </div>
    </div>
    <div class="container-fluid">

      <div class="row" id="err_msg_div" style="display: <?php if(validation_errors() != '' || isset($error)) echo 'inline'; else echo 'none'; ?>">
        <div class="col-md-12 text-center">
          <div class="alert alert-danger" id="msg">
            <?php if(isset($error)) echo '<p>'.$error.'</p>'; ?>
            <?php echo validation_errors(); ?>
          </div>
        </div>
      </div>
      
      <div class="container" style="margin-top:30px">
        <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default">
              <div class="panel-body">
                  <form role="form" action="" method="POST">
                    <div class="form-group">
                      <label for="InputUsername" class="sr-only">Username</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="un" class="form-control" placeholder="Username" maxlength="20"  autofocus>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="InputPassword1" class="sr-only">Password</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" name="pw" class="form-control" placeholder="Password" maxlength="50" >
                      </div>
                      <!--a href="#" class="pull-right small">Forgot password?</a--><!-- TODO -->
                    </div>
                    <button type="submit" class="btn btn-primary btn-md">Sign in</button>
                    <a href="/" class="btn btn-default btn-md" role="button">Link shortner</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>

    <footer class="footer">
      <div class="container">
        <br/>
        ileri.pw &copy; <?php echo date('Y'); ?>
      </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
