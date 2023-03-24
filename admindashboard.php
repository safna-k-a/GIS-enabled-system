<?php 
session_start();
if(!isset($_SESSION['email'])){
  header("Location:index.php");
}
require 'header.php';
require 'connection.php';
$email=$_SESSION['email'];
$sql='SELECT * FROM users WHERE email=:email';
$statement=$connection->prepare($sql);
$statement->execute([':email'=>$email]);
$user=$statement->fetch(PDO::FETCH_OBJ);
if(isset($_POST['logout'])){
  session_unset();
  session_destroy();
  header("Location:index.php");

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
                    <button class="btn text-light dropdown-toggle p-1 ms-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Hi  <?= $user->first_name; ?> !
                          </button>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php">Home</a>
                      </li>
                      
                      <li class="nav-item">
                        <a class="nav-link text-white" href="#contact">Contact Us</a>
                      </li>
                      
                      
                      <li class="nav-item">
                      <form method="POST">
                <button name="logout" onclick="return confirm('Are you sure?');">Logout</button></form>
                      </li>
                      
                    </ul>
                  </div>
                </div>
              </nav> 
        </div>
    </div>
    
    </div>
    
        <div class="dash py-5">
            <p class="Hey,Admin"></p>
            <div class="row p-0 m-0">
                <div class="col-12 col-sm-4 d-flex justify-content-center">
                    <div class="card" style="width: 18rem;">
                        <img src="images/addplace.jpg" class="card-img-top" alt="..." height="150px">
                        <div class="card-body">
                          <h5 class="card-title  text-white" style="background-color:#ff8d8d">Manage Locations</h5>
                          <p class="card-text text-white">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                          <a href="admin/add_place.php" class="btn card-button  text-white">Add</a>
                        </div>
                      </div>
                </div>
                <div class="col-12 col-sm-4 d-flex justify-content-center">
                    <div class="card" style="width: 18rem;">
                        <img src="images/addimage2.png" class="card-img-top" alt="..." height="150px">
                        <div class="card-body">
                          <h5 class="card-title  text-white" style="background-color:#ff8d8d">Add Image</h5>
                          <p class="card-text  text-white">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                          <a href="admin/add_image.php" class="btn card-button  text-white">Add</a>
                        </div>
                      </div>
                </div>
                <div class="col-12 col-sm-4 d-flex justify-content-center">
                    <div class="card" style="width: 18rem;">
                        <img src="images/addhotel.jpg" class="card-img-top" alt="..." height="150px">
                        <div class="card-body">
                          <h5 class="card-title text-white" style="background-color:#ff8d8d">Add Hotels</h5>
                          <p class="card-text  text-white">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                          <a href="admin/add_hotels.php" class="btn card-button  text-white">Add</a>
                        </div>
                      </div>
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
            </div>
        </div>
    
 </div>

 <?php require 'footer.php' ?>
