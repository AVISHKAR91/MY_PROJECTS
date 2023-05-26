<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <title>iDiscuss - coding Forum</title>
</head>

<body>
    <?php include 'partials/_header.php';?>
    <?php include 'partials/_dbconnect.php';?>
    <?php 
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id='$id'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result))
        {
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }
    ?>
    <?php
        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'POST')
        {
            $th_title =$_POST['title'];
            $th_desc = $_POST['desc'];
            $sql ="INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) 
            VALUES ('$th_title',  '$th_desc', '$id', '0', current_timestamp());";
            $result = mysqli_query($conn, $sql);
            $showAlert = true;
            if($showAlert)
            {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your thread has been added please wait ot discuss the community.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }

    ?>



    <!-- category container start here -->
    <div class="container my-4" id="ques">
        <div class="jumbotron">
            <h1 class="display-4"> Welcome to <?php echo  $catname ; ?> Forums</h1>
            <p class="lead"><?php echo  $catdesc ; ?> </p>
            <hr class="my-4">
            <p> This is peer to peer Forum for sharing knowledge with each other, No Spam / Advertising / Self-promote
                in the forums. Do not post copyright-infringing material.Do not post “offensive” posts, links or images.
                Do not cross post questions.Do not PM users asking for help.
                Remain respectful of other members at all times</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
        

        <div class="container">
            <h1 class="py-2">Start a Discussion</h1>
            <form action="<?php echo $_SERVER['REQUEST_URI']?>" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Thread Title</label>
                    <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">Keep your title as short as possible</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Elaborate your concern</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>

        <div class="container">
            <h1 class="py-2">Asked Questions</h1>
            <?php 
                $id = $_GET['catid'];
                $sql = "SELECT * FROM `threads` WHERE thread_cat_id =$id";
                $result = mysqli_query($conn, $sql);
                $noResult = true;
                while($row = mysqli_fetch_assoc($result))
                {
                    $noResult = false;
                    $id =   $row['thread_id'];
                    $title = $row['thread_title'];
                    $desc = $row['thread_desc'];
                    $thread_time = $row['timestamp'];
                     

                echo '<div class="media my-3">
                    <img src="https://source.unsplash.com/40x30/?profile" class="mr-3" alt="...">
                    <div class="media-body"><p class="font-weight-bold my-0">Anonymous User at '.$thread_time.'</p>
                        <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'" >'.$title.' </a></h5>
                        '. $desc.'
                        </div>
                </div>';
                }

               
                if($noResult){
                    echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                        <p class="display-4">No threads Found</p>
                        <p class="lead">Be the first person to ask the question.</p>
                        </div>
                    </div>';
                }
             ?>

            <?php include 'partials/_footer.php';?>



            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
                integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
                crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
                integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
                crossorigin="anonymous">
            </script>
</body>

</html>