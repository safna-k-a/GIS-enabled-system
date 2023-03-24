<?php  require 'connection.php' ;
require 'header.php';
// registration code 
if(isset($_POST['f_name'])&&isset($_POST['l_name'])&&isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['con_password'])){ //check values

  $f_name=$_POST['f_name'];
  $l_name=$_POST['l_name'];
  $email=$_POST['email'];
  $password1=$_POST['password'];
  $password2=$_POST['con_password'];
 

  echo $f_name,$l_name,$email,$password1,$password2;

  $sql= 'SELECT * FROM  users WHERE email=:email LIMIT 1';
  $stmt = $connection->prepare($sql);
  $stmt -> execute(['email' => $email]);
  $exists = $stmt->fetch(PDO :: FETCH_ASSOC);
  if($exists){
      echo  "<script> Swal.fire('Mail id already exist') </script>";
  }
  else{
      if($password1!=$password2){
          echo  "<script> Swal.fire('password mismatch') </script>";
      }
      else{
          $status=1;
          $password1=md5($password2);
          $sql='INSERT INTO users(first_name, last_name, email, password,status) VALUES (:f_name,:l_name,:email,:password,:status)';
          $statement=$connection->prepare($sql);
      
          if($statement->execute(['f_name'=>$f_name,'l_name'=>$l_name,'email'=>$email,'password'=>$password1,'status'=>$status])){
              echo "<script>
              Swal.fire({
                  position: 'top-center',
                  icon: 'success',
                  title: 'Registration successful',
                  showConfirmButton: false,
                  timer: 3000
                }).then(function(){
                  window.location='index.php';
                });
              </script>";   
          }
          else{
              echo "<script>
              Swal.fire({
                  position: 'top-center',
                  icon: 'error',
                  title: 'Registration failed',
                  showConfirmButton: false,
                  timer: 1500
                }).then(function(){
                  window.location='register.php';
                });
              </script>";
          }
      }
  }



} ?>
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
                        <a class="nav-link text-white" href="#">Home</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link text-white" href="#">Contact Us</a>
                      </li>
                      
                      
                    </ul>
                  </div>
                </div>
              </nav> 
        </div>
    </div>
    
    </div>
    
        <div class="content pt-2 row m-0 login container-fluid justify-content-around">
          <div class="col-12 col-sm-5 image-fluid h-50"><img src="images/trip-concept-illustration_114360-1247.jpg"></div>
          <div class="col-12 col-sm-4">
            <div class="d-flex">
                <h3 class=" fs-3">Enter Personal Details</h3>
            </div>
            
            <div class=" reg_form p-5 mb-5">
            <form action="" method="POST" enctype="multipart/form-data" class="" onsubmit="return validate()">
                    <div><input type="text" name="fname" id="fname" placeholder="First Name" class="form-control mt-2 p-2 border border-danger shadow"></div>
                    <div><input type="text" name="lname" id="lname" placeholder="Last Name" class="form-control mt-3 p-2 border border-danger shadow"></div>
                    
                    <div><input type="email" name="email" id="email" placeholder="Email" class="form-control mt-3 p-2 border border-danger"></div>
                    <div><input type="password" name="password" id="password" placeholder="Password" class="form-control mt-3 p-2 border border-danger"></div>
                    <div><input type="password" name="c_password" id="c_password" placeholder="Confirm Password" class="form-control mt-3 p-2 border border-danger"></div>
                    <div><input type="text" name="phone" id="phone" placeholder="Phone Number" class="form-control mt-3 p-2 border border-danger"></div>
                    
                    
                    
                    
                    <div><input type="submit" name="submit" value="SUBMIT" class="form-control btn btn-success mt-3 p-2 submit-btn"></div>
                    <div><a href="login.php" name="create" value="Already have an Account??" class="form-control btn btn-danger mt-3 mb-3 p-3 bg-opacity-75">Already have an Account?</a></div>

                </form>
          </div>
          </div>
        </div>
        <div class="footer row px-2 m-0 d-flex  bg w-100 py-4   ">
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

<?php require 'footer.php' ?>