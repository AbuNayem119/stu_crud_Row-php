<?php
    session_start();

    $conn = new mysqli('localhost','root','','stu_crud');
    include_once "function.php";

    if (isset($_SESSION['name']) || isset($_SESSION['email'])) {
        header("location:dashboard.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>CRUD</title>
</head>
<body>

    <?php
    
        if (isset($_POST['submit'])) {

            $name = $_POST['name'];
            $uname = $_POST['uname'];

            //Email Management....
            $email = $_POST['email'];
            echo $email_check = email_check($email,$conn);

            $cell = $_POST['cell'];

            //Password Management....
            $pass = $_POST['pass'];
            $hash_pass = password_hash($pass, PASSWORD_DEFAULT);

            // Image Management.....
            $img_name = $_FILES['img']['name'];
            $explode = explode(".",$img_name);
            $array_end_part = end($explode);
            $final_img_name = md5(time().rand().$img_name).".".$array_end_part;
            $tmp_img = $_FILES['img']['tmp_name'];


            if (empty($name)||empty($uname)||empty($email)||empty($cell)||empty($pass)||empty($img_name)) {
                $mess = "<p class='alert alert-danger'> Field Must not be Empty !<button style='float:right;' class='close' data-bs-dismiss='alert' >&times;</button></p>";

            }elseif(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
                $mess = "<p class='alert alert-danger'> Email is Incorrect !<button style='float:right;' class='close' data-bs-dismiss='alert' >&times;</button></p>";

            }elseif($email_check == false){
                $mess = "<p class='alert alert-danger'> Email alredy exists !<button style='float:right;' class='close' data-bs-dismiss='alert' >&times;</button></p>";

            }else{

                move_uploaded_file($tmp_img, "admin_img/".$final_img_name);

                $sql = "INSERT INTO admin (name, uname, email, cell, pass, image) VALUES ('$name','$uname','$email','$cell','$hash_pass','$final_img_name')";
                $conn -> query($sql);


                $mess = "<p class='alert alert-success'> Data send successfully !<button style='float:right;' class='close' data-bs-dismiss='alert' >&times;</button></p>";

            }

        }
    
    
    
    
    
    
    
    ?>



    <div class="mt-2 w-50 mx-auto mess">
        <?php
            if (isset($mess)) {
            echo $mess;
            }
        ?>
    </div>
    <div class="mt-2 w-50 mx-auto card">
        <div class="card-body">
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                <h2>Admin Registration</h2>
                <hr>
                <div class="form-group">
                    <label for="">Name</label>
                    <input name="name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">User Name</label>
                    <input name="uname" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input name="email" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Cell</label>
                    <input name="cell" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input name="pass" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <input name="img" type="file" class="form-control">
                </div>
                <input name="submit" type="submit" class="mt-2 btn btn-success">
            </form>
        </div>
        <div class="card-footer">
            <a style="display: block;" class="btn btn-info" href="index.php">Sign In</a>
        </div>
    </div>










    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>