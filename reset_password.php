<?php
require 'connection.php';
require 'header.php';
 if (isset($_POST['submit'])) {
    $token = $_GET['token'];
    if(isset($_POST['pass'])&&isset(($_POST['cpass']))){
        $pass=$_POST['pass'];
        $cpass=$_POST['cpass'];
        if($pass!=$cpass){
            echo"Password not same";
        }
        else{
            $pass=md5($cpass);
            $sql='UPDATE users SET password=:pass WHERE token=:token';
            $statement=$connection->prepare($sql);
            if($statement->execute(['pass'=>$pass,'token'=>$token])){
                echo "<script>
                    Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Password Reset Successfully',
                    showConfirmButton: false,
                    timer: 2000
                    }).then(function(){
                    window.location='index.php';
                     });

            </script>";
            
                $_SESSION['message']="Password Reset successful";
                $_SESSION["session_code"]="success";
                $_SESSION["page"]="login.php";
            }
            else{
                echo "<script>
                    Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Sorry cannot reset',
                    showConfirmButton: false,
                    timer: 2000
                    }).then(function(){
                    window.location='index.php';
                     });

            </script>";
            }
        }

    }
}
else{
    
}
?>
<form action="" method="post" class="w-50 text-center">
                                    
                                
                                            <input type="password" placeholder="Password" class="form-control " id="" name="pass">
                                            <input type="password" placeholder="Confirm Password" class="form-control mt-2" id="" name="cpass">
                                            <input type="submit" value="Submit" name="submit" class="btn btn-primary d-block mt-3 w-100" />
                                            
                                    
                                                                
                                                                
                                </form>
<?php require 'footer.php';?>