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
        <h2>Dashboard</h2>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row text-center" id="err_msg_div" style="display: none">
        <div class="col-md-12">
          <div class="alert alert-danger" id="err_msg">
          </div>
        </div>
      </div>
      <div class="row" id="msg_div" style="display: none">
        <div class="col-md-12">
          <div class="alert alert-success" id="msg">
          </div>
        </div>
      </div>

      <table class="table table-responsive">
        <thead>
          <tr>
            <th>url</th>
            <th>code</th>
            <th>edit</th>
            <th>delete</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        foreach ($links as $key => $value):
          echo "<tr>";
          echo "<td>".urldecode($value->url)."</td>";
          echo "<td>".$value->code."</td>";
        ?>
          <td><a id="edit_<?php echo $key; ?>" style="text-decoration:none;color:blue;" href="#" onclick="showEdit(<?php echo 'url=\''.urldecode($value->url).'\', code=\''.$value->code.'\', num='.$key ?>)"><i class="fa fa-pencil"></i></a></td>
          <td><a id="delete_<?php echo $key; ?>" style="text-decoration:none;color:red;" href="#" onclick="showDelete(<?php echo 'num='.$key ?>)"><i class="fa fa-times"></a></i></td>
        <?php
          echo "</tr>";
        endforeach; 
        ?>
        </tbody>
      </table>

      <a href="/logout" class="btn btn-default btn-md" role="button">Logout</a>

      <!-- Edit Modal -->
      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Edit URL and Code</h4>
            </div>
            <div class="modal-body">
              <form class="form-inline">
                <div class="form-group">
                  <input type="text" class="form-control" id="edit_url">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="edit_code">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button id="" type="button" class="btn btn-primary edit_yes" onclick="update(document.getElementById('edit_url').value, document.getElementById('edit_code').value, this.id)">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Delete Modal -->
      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Delete URL and Code</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this url and code?</p>
            </div>
            <div class="modal-footer">
              <button id="" type="button" class="btn btn-danger del_yes" onclick="del(this.id)">Yes</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
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
    <script>

      let edit_url;
      let edit_code;
      let id;
      let timed_event;

      $('#editModal').on('show.bs.modal', function(event) {
        let modal = $(this);
        modal.find('#edit_url').val(edit_url);
        modal.find('#edit_code').val(edit_code);
        modal.find('.edit_yes').attr('id', id);
      });

      $('#deleteModal').on('show.bs.modal', function(event) {
        let modal = $(this);
        modal.find('.del_yes').attr('id', id);
      });

      function showEdit(url, code, num) {
        edit_url = url;
        edit_code = code;
        id = num;
        $('#editModal').modal('show');
      }

      function showDelete(num) {
        id = num;
        $('#deleteModal').modal('show');
      }

      function update(url, code, id) {
        $('#editModal').modal('hide');
        $.ajax({
          url: 'update',
          type: 'post',
          data: {url: url, code: code, id: id},
          success: function(data) {
            if (data == 'err_no_change') {
              $('#err_msg').html('Update unsuccessful: there was no change to the url and code.');
              $('#err_msg_div').show();
              reIn5();
            } else if (data == 'err_code_exists') {
              $('#msg').html('Partial update: the url was updated.');
              $('#msg_div').show();
              reIn5();
            } else if (data == 'fail') {
              $('#err_msg').html('Update unsuccessful: an error occured.');
              $('#err_msg_div').show();
              reIn5();
            } else if (data == 'success') {
              $('#msg').html('Update usuccessful.');
              $('#msg_div').show();
              reIn5();
            }
          }
        });
      }

      function del(num) {
        $('#deleteModal').modal('hide');
        $.ajax({
          url: 'delete',
          type: 'post',
          data: {num: num},
          success: function(data) {
            if (data == 'success') {
              $('#msg').html('Delete successful.');
              $('#msg_div').show();
              reIn5();
            } else if (data == 'fail') {
              $('#err_msg').html('Delete unsuccessful: an error occured.');
              $('#err_msg_div').show();
              reIn5();
            }
          }
        });
      }

      function reIn5() {
        setTimeout(function(){
          window.location.reload(1);
        }, 3500);
      }
      
    </script>
  </body>
</html>
