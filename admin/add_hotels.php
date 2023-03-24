<?php  
session_start();
require 'connection.php' ;
$email=$_SESSION['email'];
$sql='SELECT * FROM users WHERE email=:email';
$statement=$connection->prepare($sql);
$statement->execute([':email'=>$email]);
$user=$statement->fetch(PDO::FETCH_OBJ);

$sql1='SELECT * FROM places';
$statement1=$connection->prepare($sql1);
$statement1->execute();
$places=$statement1->fetchAll(PDO::FETCH_OBJ);
// print_r($districts);
require '../header.php' ;
// adding place 
if(isset($_POST['add_hotel'])){
    $place=$_POST['place'];
    $h_name=$_POST['h_name'];
    $rate=$_POST['rate'];
    $image= $_FILES['image']['name'];
    $temp=$_FILES['image']['tmp_name'];
    $target="../uploads/".basename($image);
        $sql='INSERT INTO hotels(place_id,hotel_name,hotel_rate,h_image)VALUES (:place,:h_name,:rate,:image)';
        $statement=$connection->prepare($sql);
        if($statement->execute([':place'=>$place,':h_name'=>$h_name,':rate'=>$rate,':image'=>$image])){
          $move_pic=move_uploaded_file($temp,$target);
            
            echo "<script>
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'added successful',
                showConfirmButton: false,
                timer: 3000
                })
            </script>";
               
            }
}


?>
 <div class="vh-100 container-fluid d-flex flex-column align-items-between p-0 m-0">
    <div class="header px-3 py-4">
        <div class="namebar d-flex justify-content-between">
        <div class="logo  d-flex gap-2 w-50">
            <img src="../images/logo2.png" alt="" class="img-fluid logo-img">
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
                        <a class="nav-link text-white" href="../admindashboard.php">Home</a>
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
    
        <div class="content py-5 row m-0 login justify-content-center ">
           <!-- form   -->
            <div class="col-12 row align-self-end col-sm-6 ps-5 ">
            <div >
            <form action="" method="POST" enctype="multipart/form-data" class="text-center w-50  ">
        <!-- select place  -->
          <input type="name" name="h_name" placeholder="Hotel Name" class="form-control w-100 bdr mb-4">

          <select name="rate" id="" class="form-control w-100 mb-4 bdr">
                <option value="" disabled selected> Select rate</option> 
                <option value="1"> 1 </option>
                <option value="2"> 2</option>
                <option value="3"> 3 </option>
                <option value="4"> 4 </option>
                <option value="5"> 5 </option>
            </select>
            <select name="place" id="" class="form-control w-100 mb-4 bdr">
                <option value="" disabled selected>
                    Select Place
                </option>
                <?php foreach($places as $place):?>
                    <option value="<?=$place->id; ?>"> <?=$place->place_name;?> </option>
                <?php endforeach; ?> 
            </select> 
            <input type="file" name="image" placeholder="select image" class="form-control w-100 bdr mb-4">
       
            <input type="submit" name="add_hotel" value="Submit" class="btn btn-light  mb-4">
            </form>
            </div>
        </div>

            <div class="col-12 col-sm-5">
              <div class="gif">
                <img src="../images/login-bg.jpg" alt="image" class="img-fluid">
              </div>
        </div>
        <!-- place adding form end -->
    <?php if(isset($_POST['address'])){?>
    <div class="mt-3 w-75 mx-auto">
                    <table
                        class="table table-primary table-striped border border-2"
                    >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>place</th>
                                <th>Address</th>
                                <th>Description</th>
                                <th colspan="2">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $id=1; 
                            foreach( $places as $place):?>
                            <tr>
                                <td><?=$id++;?></td>
                                <td><?=$place->place_name;?></td>
                                <td><?=$place->address;?></td>
                                <td><?=$place->description;?></td>
                                <td>
                                    <a
                                        class="btn btn-success text-light edit"
                                        href="add_place.php?id=<?=$place->id;?>"
                                        >Edit</a
                                    >
                                </td>
                                <td>
                                    <a
                                        class="btn btn-danger text-light edit"
                                        href="add_place.php?id=<?=$place->id;?>"
                                        >Delete</a
                                    >
                                </td>
                                <?php endforeach ?>
                            </tr>
                        </tbody>
                    </table>
                <div class="col-12 col-lg-12 d-flex justify-content-center m-0 p-0">
                   <!-- <form action="admin.php">
                   <button class="btn btn-outline-light" type="submit" >Back</button>
                   </form> -->
                </div>
                </div><?php }?>
    </div>
    
    <!-- footer  -->
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
    <!-- footer end -->
    
 </div>
 
<?php require '../footer.php' ?>