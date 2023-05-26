<?php
   // INSERT INTO `notes` (`s_no`, `title`, `description`, `tstamp`) VALUES (NULL, 'Buy Books', 'Please buy books from store.', current_timestamp());
    $insert = false;
    $update = false;
    $delete = false;
    // connecting to database
    $servername  = "localhost";
    $username = "root";
    $password = "";
    $database = "notes";

    $conn = mysqli_connect($servername, $username, $password, $database);

    //Die if connection was not successful
    if(!$conn)
    {
      die("Sorry we failed to connect:". mysqli_connect_error());
    }
    
    if(isset($_GET['delete']))
    {
       $s_no = $_GET['delete'];
       $delete = true;
       //update SQL statement / Prepare Statement
       $result = $conn->prepare("DELETE FROM `notes` WHERE `s_no` = ? ");
       //$result = mysqli_query($conn, $sql);

       //Bind Variables to prepare statement as parameters;
       $result ->bind_param('i',$s_no);
       
       $result -> execute();
    } 
     //exit();
    if ($_SERVER['REQUEST_METHOD']=='POST')
    {
          if(isset($_POST['s_noEdit']))
          {
                //Update he record;
            $s_no = $_POST["s_noEdit"];
            $title = $_POST["titleEdit"];
            $description = $_POST["descriptionEdit"];

            //update SQL statement / Prepare Statement
            //$result = $conn->prepare("UPDATE `notes` SET title = '$title', `description` = '$description' WHERE `notes`.`s_no` = '$s_no'");
            $result = $conn->prepare("UPDATE notes SET `title`= ?, `description`=?  WHERE `s_no`=?");
            //$result = mysqli_query($conn, $sql);

            //Bind Variables to prepare statement as parameters;
            $result ->bind_param('ssi', $title, $description, $s_no);

            //Execute prepare statement
            $result->execute();
              if ($result)
                {
                  
                  $update = true;
                }
              else
                {
                  echo "The record has not update successful because of this error--->".mysqli_error($conn);
                }
          } 
          else
          {
              $title = $_POST["title"];
              $description = $_POST["description"];

                //Insert SQL statement //Prepare Statement
              $result = $conn->prepare("Insert into `notes` (title, description) values(?, ?)");

                
              //$result = mysqli_prepare($conn, $sql);
                if ($result)
                    {
                      //Bind Variables to prepare statement as parameters;
                      mysqli_stmt_bind_param($result, 'ss', $title, $description);
                      //$result->mysqli_stmt_bind_param("$result", 'ss', $title, $description);

                      //Execute prepare statement
                      //mysqli_stmt_execute($result);
                      $result->execute();
                    }
                else
                    {
                      echo "The record has not inserted successful because of this error--->".mysqli_error($conn);
                    }
          }
    }
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">

    <title>iNotes - Notes taking made easy</title>

</head>

<body>
    <!-- Edit modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit modal
</button>-->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this node</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/CRUD/index.php" method="post">
                        <input type="hidden" name="s_noEdit" id="s_noEdit">
                        <div class="form-group">
                            <label for="title">Note Title</label>
                            <input type="text" class="form-control" name="titleEdit" id="titleEdit"
                                aria-describedby="emailHelp">

                        </div>

                        <div class="form-group">
                            <label for="desc">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">PHP CRUD</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact US</a>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php 
      if($insert)
          {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong>Your note has been submitted successfully.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
          }
    ?>
    <?php 
      if($delete)
          {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong>Your note has been deleted successfully.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
          }
    ?>
    <?php 
      if($update)
          {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong>Your note has been updated successfully.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
          }
    ?>
    <div class="container my-4">
        <h2>Add a Note</h2>
        <form action="/CRUD/index.php" method="post">
            <div class="form-group">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">

            </div>

            <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">s_no</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT * FROM `notes`";
                $result = mysqli_query($conn, $sql);  
                $s_no=0; 
                while($row = mysqli_fetch_assoc($result))
                      {
                        $s_no = $s_no + 1;
                        echo "<tr>
                        <th scope='row'>". $s_no."</th>
                        <td>".$row['title']."</td>
                        <td>".$row['description']."</td>
                        <td><button class='edit btn btn-sm btn-primary' id=".$row['s_no'].">Edit</button> 
                        <a href='/CRUD/index.php?delete=$row[s_no]'> 
                        <button class='delete btn btn-sm btn-primary'>delete</button></a></td>
                        </tr>";
                        
                      }
             ?>


            </tbody>
        </table>
    </div>
    <hr>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="http://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            titleEdit.value = title;
            descriptionEdit.value = description;
            s_noEdit.value = e.target.id;
            $('#editModal').modal('toggle');
            console.log(e.target.id)
        })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ", );
            s_no = e.target.id.substr(1, );

            if (confirm("press a button!")) {
                console.log("yes");
                //console.log(s_no);
                window.location = '/CRUD/index.php?delete=$row[s_no]';
            } else {
                console.log("no");
            }




        })
    })
    </script>

</body>

</html>