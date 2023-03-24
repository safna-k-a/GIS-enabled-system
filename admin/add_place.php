<?php  
session_start();
require 'connection.php' ;
$email=$_SESSION['email'];
$sql='SELECT * FROM users WHERE email=:email';
$statement=$connection->prepare($sql);
$statement->execute([':email'=>$email]);
$user=$statement->fetch(PDO::FETCH_OBJ);

// select district from district table
$sql1='SELECT * FROM district';
$statement1=$connection->prepare($sql1);
$statement1->execute();
$districts=$statement1->fetchAll(PDO::FETCH_OBJ);
// print_r($districts);

// select places from place table 
$sql2='SELECT * FROM places';
$statement=$connection->prepare($sql2);
$statement->execute();
$places=$statement->fetchAll(PDO::FETCH_OBJ);

// delete place 
if(isset($_POST['delete'])){

$sql='DELETE FROM places WHERE id=:airport_name';
$statement = $connection -> prepare($sql);
$statement->execute([':airport_name'=>$airport_name]);
}
require '../header.php' ;

// adding place 
if(isset($_POST['add_place'])){
    $place=$_POST['place'];
    $district=$_POST['district'];
    $desc=$_POST['description'];
    $address=$_POST['address'];
    $latitude=$_POST['lat'];
    $longitude=$_POST['long'];
        $sql='INSERT INTO places(place_name,dist_id,address,description,latitude,longitude)VALUES (:place,:district,:address,:desc,:latitude,:longitude)';
        $statement=$connection->prepare($sql);
        if($statement->execute([':place'=>$place,':district'=>$district,':address'=>$address,':desc'=>$desc,':latitude'=>$latitude,':longitude'=>$longitude])){
            echo "<script>
            Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Registration success',
            showConfirmButton: false,
            timer: 1500
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
            <form action="" method="POST" class="text-center w-50 text-end ">
            <input type="text" name="place" placeholder="Enter Place" class="form-control  bdr w-100 mb-4">
            <select name="district" id="" class="form-control w-100 mb-4 bdr">
                <option value="" disabled selected>
                    Select District
                </option>
                <?php foreach($districts as $dist):?>
                    <option value="<?=$dist->id; ?>"> <?=$dist->dist_name;?> </option>
                <?php endforeach; ?> 
            </select> 
            <textarea  name="address" id="" placeholder="address" class="form-control bdr w-100 mb-4"></textarea>

            <textarea  name="description" id="" placeholder="description" class="form-control bdr w-100 mb-4"></textarea>

            <input type="text" name="lat" placeholder="Enter Latitude" class="form-control w-100 bdr mb-4">
            <input type="text" name="long" placeholder="Enter Longitude" class="form-control  bdr w-100 mb-4">
            <input type="submit" name="add_place" value="Submit" class="btn btn-light  mb-4">
            </form> 
            </div>
        </div>

            <div class="col-12 col-sm-5">
              <div class="gif">
                <img src="../images/login-bg.jpg" alt="image" class="img-fluid">
              </div>
        </div>
        <!-- place adding form end -->
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
                                        href="query.php?p_id=<?=$place->id;?>"
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
                </div>
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