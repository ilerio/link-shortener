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
      }
      .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        /* Set the fixed height of the footer here */
        height: 60px;
        background-color: #f5f5f5;
      }
  	</style>
  </head>
  <body>

    <div class="container-fluid text-center">
      <div class="jumbotron" style="margin-top: 5px;">
        <h2>The personal link shortener of</h2>
        <p><a href="http://ilerioyedele.com">Ileri</a></p>
      </div>

      <div class="row" id="err_msg_div" style="display: none">
        <div class="col-md-12">
          <div class="alert alert-danger" id="msg">
          </div>
        </div>
      </div>

      <div class="row" id="url_msg_div" style="display: none">
        <div class="col-md-12">
          <div class="alert alert-success">
            URL : <a id="url" href=""></a>
          </div>
        </div>
      </div>

      <form class="form-inline">
        <div class="form-group">
          <label for="input" class="sr-only">Input Url</label>
          <input type="url" class="form-control input-lg" name="url_input" id="url_input" placeholder="Enter a URL to be shortened" autofocus>
        </div>
        <button type="button" class="btn btn-lg btn-primary" id="butt">shorten</button>
      </form>
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
		<script>
			var app = {};
			app.errmsg = $('#err_msg_div').hide();
			app.msg = $('#msg');
			app.urlmsg = $('#url_msg_div').hide();
			app.url = $('#url');
			app.input = $('#url_input');
			app.butt = $('#butt');

			app.input.bind('keydown', function(e) {
				if (e.keyCode === 13) {
					e.preventDefault();
					app.Go(this);
				}
			});

			$(app.butt).click(function(){
				app.Go(app.input);
			});

			app.Go = function (obj) {
				$.ajax({
					url: 'null',
					type: 'post',
					data: {url: $(obj).val()},
					success: function(data) {
						app.errmsg.hide();
						app.urlmsg.hide();
						if (data == 'err_no_url') {
							app.msg.html("Please enter a URL.");
							app.errmsg.show();
							app.input.focus();
						} else if (data == 'err_not_url') {
							app.msg.html("Please enter a valid URL.");
							app.errmsg.show();
							app.input.focus();
						} else if (data == 'err_is_short') {
							app.msg.html("The URL is already a shortened URL.");
							app.errmsg.show();
							app.input.select();
						} else {
							app.url.html(data);
							app.url.attr('href', data);
							app.urlmsg.show();
              app.input.val(data).select();
						}
					}
				});
			}
    </script>
  </body>
</html>
