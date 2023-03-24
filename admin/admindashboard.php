<?php  
session_start();
require 'connection.php' ;
$email=$_SESSION['email'];
$sql='SELECT * FROM users WHERE email=:email';
$statement=$connection->prepare($sql);
$statement->execute([':email'=>$email]);
$user=$statement->fetch(PDO::FETCH_OBJ);

$sql1='SELECT * FROM district';
$statement1=$connection->prepare($sql1);
$statement1->execute();
$districts=$statement1->fetchAll(PDO::FETCH_OBJ);
// print_r($districts);

require '../header.php' ;

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
                    <button class="btn text-light dropdown-toggle p-1 ms-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    				            Hi  <?= $user->first_name; ?> !
  				          </button>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="admindashboard.php">Home</a>
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
                    <a href="add_place.php" value="" class="btn btn-info w-50 mb-5 ">Add Place</a>
                    <a href="add_image.php" value="" class="btn btn-info w-50"> Add image</a>
            </div>
            <div class="col-12 col-sm-5">
              <div class="gif">
                <img src="../images/login-bg.jpg" alt="image" class="img-fluid">
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
 
<?php require '../footer.php' ?>