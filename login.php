<?php  
session_start();
require 'connection.php' ;
require 'header.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(isset($_POST['mail_id'])&&isset($_POST['password'])){
    $email=$_POST['mail_id'];
    $password=$_POST['password'];

        $sql= 'SELECT * FROM users WHERE email=:email LIMIT 1';
        $stmt = $connection->prepare($sql);
        $stmt -> execute(['email' => $email]);
        $exists = $stmt->fetch(PDO :: FETCH_OBJ);
        if(!$exists){
            echo  "<script> Swal.fire('Email Id Already Exist') </script>";
        }
        else{
            $check_pass=$exists->password;
            $password=md5($password);
            if($check_pass!=$password){
                echo  "<script> Swal.fire('Invalid Password') </script>";
            }
            else{
                if($exists->status==1){
                    $_SESSION['email']=$email;
                    echo "<script>window.location.href='userdashboard.php'</script>";
                }
                else{
                    $_SESSION['email']=$email;
                    echo "<script>window.location.href='admindashboard.php'</script>";
                }
            }
        }
}

// mail code 



//Load Composer's autoloader
require 'vendor/autoload.php';
$db = new PDO("mysql:host=localhost;dbname=gis_system", "root", "");
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$token = bin2hex(random_bytes(32));

if(isset($_POST['reset']) && $_POST['mail'])
{
    $email_address = $_POST['mail'];
    $query = $db->prepare("UPDATE users   SET token=:token WHERE email=:email");
    $query->execute(array(':token' => $token, ':email' => $email_address));
    $reset_url = "http://localhost/GIS_PROJECT_2/reset_password.php?token=" . $token;



    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'orisystestmail@gmail.com';                     //SMTP username
        $mail->Password   = 'kxixeqhvptqgmjvi';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('orisystestmail@gmail.com', 'project');
        $mail->addAddress($email_address);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'password reset';
        $mail->Body    = 'To reset your password, please click the following link:'.$reset_url;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo "<script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Please Check Your Email',
                showConfirmButton: false,
                timer: 2000
              }).then(function(){
                window.location='index.php';
              });

            </script>";
    } catch (Exception $e) {
        echo '<script>alert("Message not sent");</script>';
    }
}

 ?>
 <div class="vh-100 container-fluid d-flex flex-column align-items-between p-0 m-0">
    <div class="header px-3 py-4">
        <div class="namebar d-flex justify-content-between">
        <div class="logo  d-flex gap-2 w-50">
            <img src="images/logo2.png" alt="" class="img-fluid logo-img">
            <h3 class="text-white fs-2 name">Tripadvizor.com</h3>
        </div>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                  
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php">Home</a>
                      </li>
                      
                      <li class="nav-item">
                        <a class="nav-link text-white" href="#contact">Contact Us</a>
                      </li>
                      
                    </ul>
                  </div>
                </div>
              </nav> 
        </div>
    </div>
    
    </div>
    
        <div class="content py-5 row m-0 login justify-content-between">
            
            <div class="col-12 col-sm-6 ps-5">
                <form action="" method="POST" class="d-flex flex-column gap-4 py-5 rounded-4 px-4" onsubmit="return login_validate()">
                  <h3>LOGIN</h3>
                    <input type="text" name="mail_id" id="email" placeholder="Email" class="form-control">
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                    <input type="submit" value="Log-in" name="login" class="btn submit-btn text-white d-block ">
                    <a href="register.php" value="" class="btn btn-info d-block">Create New Account</a>
                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">Forgot Password</a>
                </form>
            </div>
            <div class="col-12 col-sm-5">
              <div class="gif">
                <img src="images/login-bg.jpg" alt="image" class="img-fluid">
              </div>
          </div>
        </div>
        <div class="footer row px-2 m-0 d-flex  bg w-100 py-4" id="contact">
            <div class="text-start col-12 col-sm-4">
                <p class="text-white  cpwrite">Terms and conditions</p>
            </div>
            <div class="text-start  col-12 col-sm-4">
                <p class="text-white text-center">&copy Tripadvizor.com,2023</p>
            </div>
            <div class="text-start  col-12 col-sm-4">
                <p class="text-white text-end  cpwrite">Privacy Policy</p>
                <p class="text-white text-end  cpwrite">Cookie Policy</p>
                <p class="text-white text-end  cpwrite">Cookie settings</p>
            </div>
        </div>
    
 </div>
 <!-- modal  -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" >
                    <div class="d-flex">
                        <div class="w-75"><input type="text" placeholder="email" id="check_mail" name="mail" class="form-control  p-2"></div>
                            <p id="status" class="ms-2"></p>
                        </div> 
                        <div class="d-flex mt-3" >
                            <input type="submit" name="reset" value="Submit" name="reset" class="btn btn-primary">
                        </div>
                    </div> 
                </form>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
                              
        </div>
    </div>
</div>

<?php require 'footer.php' ?>