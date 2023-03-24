<?php  require 'connection.php' ?>
<?php require 'header.php' ?>
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
                        <a class="nav-link text-white" href="login.php">Login/Sign Up</a>
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
    
        <div class="content py-5 row m-0">
            <div class="col-12 col-sm-6 d-flex justify-content-center">
                <img src="images/image_processing20200403-30876-1v93pbd.gif" alt="" class="img-fluid rounded-4 shadow w-75">
            </div>
            <div class="col-12 col-sm-6 d-flex flex-column justify-content-around py-4 description">
                <h3 class="fs-1">Need a perfect guide to pick your holiday destination?</h3>
                <h3 class="fs-1">We are happy to help you..!!</h3>
                <a href="districtresults.php" class="btn explore text-white fs-5 w-50 py-4">Explore Destinations</a>
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

<?php require 'footer.php' ?>