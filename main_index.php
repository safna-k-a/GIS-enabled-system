<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta http-equiv="refresh" content="15" -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tripadvizor</title>
    <style type="text/css">
	.star_rated { color: #790252; }
	.star {text-shadow: 0 0 1px #F48F0A; cursor: pointer;  }
</style>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css
        "
        />
    
            
            <!-- CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


            
            <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Philosopher&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tilt+Warp&display=swap" rel="stylesheet">


<link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@500&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
        <link rel="stylesheet" href="https://js.arcgis.com/4.25/esri/themes/light/main.css">
        <script src="https://js.arcgis.com/4.25"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
function ratestar($id, $rate){
	$.ajax({
		type: 'GET',
		url: 'rating.php',
		data: 'functionName=update&productid='+$id+'&rating='+$rate,
		success: function(data) { 
			location.reload();
		}
	});
}
</script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="../css/style.css">

  
</head>
<body>
<?php 
require 'connection.php';
if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql='SELECT * from places where id=:id';
        $statement=$connection->prepare($sql);
        $statement->execute([':id'=>$id]);
        $place=$statement->fetch(PDO::FETCH_OBJ);
        $sql='SELECT * from images where place_id=:id';
        $statement=$connection->prepare($sql);
        $statement->execute([':id'=>$place->id]);
        $images=$statement->fetchAll(PDO::FETCH_OBJ);
        $dist=$place->dist_id;
        $sql='SELECT * from district where id=:id';
        $statement=$connection->prepare($sql);
        $statement->execute([':id'=>$dist]);
        $district=$statement->fetch(PDO::FETCH_OBJ);
        $sql='SELECT * from hotels where place_id=:id';
        $statement=$connection->prepare($sql);
        $statement->execute([':id'=>$id]);
        $hotels=$statement->fetchAll(PDO::FETCH_OBJ);
        $sql='SELECT * from reviews where place_id=:id';
        $statement=$connection->prepare($sql);
        $statement->execute([':id'=>$id]);
        $user_reviews=$statement->fetchAll(PDO::FETCH_OBJ);

}
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("Location:index.php");
  
  }
  if(isset($_POST['submit'])){
      if(!isset($_SESSION['email'])){
        echo "<script>
          Swal.fire({
              position: 'top-center',
              icon: 'error',
              title: 'Please Login to Add Comment',
              showConfirmButton: false,
              timer: 3000
            }).then(function(){
              window.location='login.php';
            });
          </script>";  
      }
      else{
      $email=$_SESSION['email'];
      $sql='SELECT * from users where email=:email';
        $statement=$connection->prepare($sql);
        $statement->execute([':email'=>$email]);
        $user=$statement->fetch(PDO::FETCH_OBJ);
      $msg=$_POST['comments'];
      $sql='INSERT INTO reviews(user_id,place_id,review,rate) VALUES (:user_id,:place_id,:review,:rate)';
        $statement=$connection->prepare($sql);
        $statement->execute([':user_id'=>$user->id,':place_id'=>$id,':review'=>$msg,':rate'=>4]);
        if($statement){
          echo "<script>
          Swal.fire({
              position: 'top-center',
              icon: 'success',
              title: 'Review added successfully',
              showConfirmButton: false,
              timer: 3000
            }).then(function(){
              window.location='districtresults.php';
            });
          </script>";   
        }
  }
  }
 ?>
 <script>
  require([
    "esri/config",
    "esri/Map",
    "esri/views/MapView",
    "esri/widgets/Search",
    "esri/widgets/Expand",
    "esri/rest/locator",
    "esri/Graphic",
    "esri/layers/GraphicsLayer"
  ],(esriConfig, Map, MapView, Search,Expand,locator,Graphic,GraphicsLayer)=> {
    esriConfig.apiKey = "AAPK7d9e9e5691de4400beb5f15f352c6142fVO9J6cH_qnluFUuhWTpot5hsXl6xnGqChQpgXKBch0kIDGaxsS_MhPkqy0sUKEm";
    const placesLayer = new GraphicsLayer();
    const map = new Map({
      basemap: "arcgis-navigation", //Basemap layer service
      layers: [placesLayer]
    });

    const view = new MapView({
      container: "viewDiv",
      map: map,
      center: [76.5955013,8.8879509],
      zoom: 14,
      constraints: {
        snapToZoom: false
      }
    });

    view.popup.actions = [];
    view.popup.alignment = "bottom-left";

    const places = [
      ["Coffee shop", "coffee-shop"],
      ["Gas station", "gas-station"],
      ["Food", "restaurant"],
      ["Hotel", "hotel"],
      ["Parks and Outdoors", "park"]
    ];
    const select = document.createElement("select", "");
    select.setAttribute("class", "esri-widget esri-select");
    select.setAttribute(
      "style",
      "width: 175px; font-family: 'Avenir Next'; font-size: 1em"
    );
    places.forEach((p) => {
      const option = document.createElement("option");
      option.value = p[0];
      option.innerHTML = p[0];
      select.appendChild(option);
    });

    view.ui.add(select, "top-left");

    const geocodingServiceUrl = "http://geocode-api.arcgis.com/arcgis/rest/services/World/GeocodeServer";

    function findPlaces(category, pt) {
      locator
        .addressToLocations(geocodingServiceUrl,{
          location: pt,
          categories: [category],
          maxLocations: 25,
          outFields: ["PlaceName","Place_addr","ImageURL"],
        })
        .then((results) => {
          view.popup.close();
          placesLayer.graphics.removeAll();
          results.forEach((result) => {
            placesLayer.graphics.add(
              new Graphic({
                attributes: result.attributes,
                geometry: result.location,
                symbol: {
                  type: "web-style",
                  name: places[places.findIndex(a => a[0] === select.value)][1],
                  styleName: "Esri2DPointSymbolsStyle"
                },
                popupTemplate: {
                  title: "{PlaceName}",
                  content:
                    "{Place_addr}" +
                    "<br><br>"+"<img src='{ImageURL}' alt='Place image'>" +
                    result.location.x.toFixed(5) +
                    "," +
                    result.location.y.toFixed(5),
                },
              })
            );
          });
          if (results.length) {
            // const g = placesLayer.graphics.getItemAt(0);
            view.popup.open({
              features: placesLayer.graphics.toArray(),
              updateLocationEnabled: true,
            });
          }
        });
    }

       // Search for places in center of map
    view.when(() => {
      findPlaces(select.value, view.center);
    });

    // Listen for category changes and find places
    select.addEventListener("change", (event) => {
      findPlaces(event.target.value, view.center);
    });

    // Listen for mouse clicks and find places
    view.on("click", (event)=> {
      view.hitTest(event.screenPoint).then((response) => {
        if (response.results.length < 2) {
          // If graphic is not clicked, find places
          findPlaces(select.options[select.selectedIndex].text, event.mapPoint);
        }});
      });

    // Search term
    const term = "Kerala";
    let automate = true;

    // Add Search widget
    const search = new Search({
      view: view,
    });
    view.ui.add(new Expand({
      view:view,
      content:search,
      expanded:true,
      mode:"floating" }), "top-right");

    // Start suggestions
    view.when(() => {
      search.watch("activeSource", (source) =>{
        search.searchTerm = term.substring(0, 1);
        search.suggest(search.searchTerm);
      })
    });

    // Select last suggestion
    search.on("suggest-complete",(response)=> {
      if (!automate) {
        return;
      }
      if (search.searchTerm.length < term.length) {
        search.searchTerm = term.substring(0, search.searchTerm.length + 1);
        setTimeout(() => {
          search.suggest(search.searchTerm);
        }, 250);
      } else {
        if (response.results.length > 0) {
          search.search(response.results[0].results[0]);
        }
      }
    });

    search.on("select-result",(response)=>{
      if (!automate) {
        return;
      }
      if (response.result) {
        search.suggest(term);
        automate = false;
      }
    });

    search.goToOverride = (view, goToParams)=> {
      if (!automate) {
        return view.goTo(goToParams.target, goToParams.options);
      } else {
        return view.goTo(
          {
            center: goToParams.target.target,
            zoom: 11,
          },
          goToParams.options
        );
      }
    };

    search.on(["search-clear", "search-focus"], () => {
      automate = false;
    });
  });
</script>
<?php
	// $db = new Rating();
	// $data = $db->select();
?> 
 <div class="container-fluid d-flex flex-column align-items-between p-0 m-0">
    <div class="header px-3 py-4">
        <div class="namebar d-flex justify-content-between">
        <div class="logo  d-flex gap-2 w-50">
            <img src="images/logo2.png" alt="" class="img-fluid logo-img">
            <h3 class="text-white fs-2 name">Tripadvizor.com</h3>
        </div>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container bg">
                  
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                      
                      
                      
                    <li class="nav-item">
                      <form method="POST">
                        <a class="nav-link text-white" href="index.php" name="logout" onclick="return confirm('Are you sure?');"><i class="fa fa-sign-out" aria-hidden="true">Log out</a>
                        </form>
                      </li>
                      
                    </ul>
                  </div>
                </div>
              </nav> 
        </div>
    </div>
    
    </div>
    
        
          
        </div>
        <div class="container-fluid">
            <div class="d-flex flex-column">
              <h3 class="fs-2"><?=$place->place_name?></h3>
              <p class="fs-5"><?= $district->dist_name?></p>
              <div class="row p-0 m-0">
                <div class="col-12 col-sm-4 p-2">
                
                  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                 
                  <div class="carousel-inner">
                  <?php foreach($images as $m):?>
                      <div class="carousel-item active">
                      <img src="uploads/<?=$m->image?>" class="d-block w-100" alt="...">
                      </div>
                      <?php endforeach ?>
                      
                      </div>
                      
                      <!-- <div class="carousel-item">
                        <img src="..." class="d-block w-100" alt="...">
                      </div>
                      <div class="carousel-item">
                        <img src="..." class="d-block w-100" alt="...">
                      </div> -->
                   
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
                </div>
                <div class="col-12 col-sm-6 d-flex justify-content-center">
                  <div class="map-to-play w-75"><div id="viewDiv" style="width:100%;height:300px"></div></div>
                  </div>
                  
                  
                    <form action="" method="POST" class="d-flex flex-column">
                      <textarea name="comments" id="comments" cols="50" rows="5" placeholder="Previously visited? Give us your comments." class="my-2 rounded-3"></textarea>
                      <div class="comment-submit w-50">
                        <input type="submit" value="submit" name="submit" class="btn submit-btn text-white d-inline w-25 mb-2">
                      </div>
                    </form>
                  </div>
                  <div class="container-fluid row p-0 m-0 justify-content-center mb-5">
                    <div class="col-12 col-sm-12 text-center py-3">
                      <h5 class="text-white d-inline fs-4 rounded-2 p-2">Recent Reviews</h5>
                    </div> 
                  <?php foreach($user_reviews as $review):
                         $sql='SELECT * from users where id=:id';
                         $statement=$connection->prepare($sql);
                         $statement->execute([':id'=>$review->user_id]);
                         $user=$statement->fetch(PDO::FETCH_OBJ);
                      ?>
                      
                    <div class="hotels col-12 col-sm-3 light-bg border rounded pt-2">
                      <p class="fs-5" style="height:30px"><?=$user->first_name?></p>
                      <p class="" style="height:30px"><?=$review->review?></p>
                      </div>
                      <?php endforeach; ?>
                   
                  <div class="container-fluid row p-0 m-0 justify-content-center mb-5">
                  <div class="col-12 col-sm-12 text-center py-3">
                      <h5 class="text-white d-inline fs-4 rounded-2 p-2">Nearby Hotel Details</h5>
                    </div> 
                    <?php foreach($hotels as $h): ?>
                    <div class="hotels col-12 col-sm-3">
                      <p class="fs-3" style="height:60px"><?=$h->hotel_name?></p>
                      <img src="uploads/<?=$h->h_image ?>" alt="" class="img-fluid w-100" style="height:200px">
                      <div><?php
	                          for($i = 1; $i <= 5; $i++) {
	if($i <= $h->hotel_rate) {
	?>
	<span class="star_rated" onclick="ratestar(<?php echo $h->hotel_rate; ?>, <?php echo $i; ?>)">&#x2605;</span>
	<?php }  else {  ?>
	<span onclick="ratestar(<?php $h->hotel_rate;; ?>, <?php echo $i; ?>)">&#x2605;</span>
	<?php  }
	}
	?></div>
                    </div>
                    <?php endforeach; ?>
                    <!-- <div class="hotels col-12 col-sm-3">
                      <p class="fs-3">hotel name</p>
                      <img src="" alt="" class="img-fluid w-100">
                      <div>rating</div>
                    </div> -->
                    <!-- <div class="hotels col-12 col-sm-3">
                      <p class="fs-3">hotel name</p>
                      <img src="" alt="" class="img-fluid w-100">
                      <div>rating</div>
                    </div> -->
                  </div>
                  <!-- <div class="container-fluid row p-0 m-0 justify-content-center">
                    <div class="hotels col-12 col-sm-3">
                      <p class="fs-3">hospitals name</p>
                      <img src="" alt="" class="img-fluid w-100">
                      <div>rating</div>
                    </div>
                    <div class="hotels col-12 col-sm-3">
                      <p class="fs-3">hospitals name</p>
                      <img src="" alt="" class="img-fluid w-100">
                      <div>rating</div>
                    </div>
                    <div class="hotels col-12 col-sm-3">
                      <p class="fs-3">hospitals name</p>
                      <img src="" alt="" class="img-fluid w-100">
                      <div>rating</div>
                    </div>
                  </div>
                  <div class="container-fluid row p-0 m-0 justify-content-center">
                    <div class="hotels col-12 col-sm-3">
                      <p class="fs-3">restaurants name</p>
                      <img src="" alt="" class="img-fluid w-100">
                      <div>rating</div>
                    </div>
                    <div class="hotels col-12 col-sm-3">
                      <p class="fs-3">restaurants  name</p>
                      <img src="" alt="" class="img-fluid w-100">
                      <div>rating</div>
                    </div>
                    <div class="hotels col-12 col-sm-3">
                      <p class="fs-3">restaurants  name</p>
                      <img src="" alt="" class="img-fluid w-100">
                      <div>rating</div>
                    </div>
                  </div>

            ' -->
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
        <script>
          var map,marker;
          /*Map Initialization*/
          function initMap1(){
              map = new mappls.Map('map', {
                  center: [28.09, 78.3],
                  zoom: 5
              });
              /*Search plugin initialization*/
              var optional_config={
                  location:[28.61, 77.23],
                 pod:'City',
                  bridge:true,
                  tokenizeAddress:true,
                  filter:'cop:9QGXAM',
                  distance:true,
                  width:300,
                  height:300
              };
              new MapmyIndia.search(document.getElementById("auto"),optional_config,callback);
              map.addListener('load',function(){
                  var optional_config = {
                      location: [28.61, 77.23],
                      region: "IND",
                      height:300,
                  };
                  new mappls.search(document.getElementById("auto"), optional_config, callback);
                  function callback(data) {
                      console.log(data);
                      if (data) {
                          var dt = data[0];
                          if (!dt) return false;
                          var eloc = dt.eLoc;
                          var place = dt.placeName + ", " + dt.placeAddress;
                          /*Use elocMarker Plugin to add marker*/
                          if (marker) marker.remove();
                          mappls.pinMarker({
                              map: map,
                              pin: eloc,
                              popupHtml: place,
                              popupOptions: {
                                  openPopup: true
                              }
                          }, function(data){
                              marker=data;
                              marker.fitbounds();
                          })
                      }
                  }
              });
          }
      </script>
    
 </div>
 <script
            src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
            crossorigin="anonymous"
        ></script>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script
            src="https://code.jquery.com/jquery-3.6.3.min.js"
            integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
            crossorigin="anonymous"
        ></script>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script type="text/javascript">
function ratestar($id, $rate){
	$.ajax({
		type: 'GET',
		url: 'rating.php',
		data: 'functionName=update&productid='+$id+'&rating='+$rate,
		success: function(data) { 
			location.reload();
		}
	});
}
</script>
        
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="../js/script.js"></script>
</body>
</html>
        
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="../js/script.js"></script>
</body>
</html>

 <?php require 'footer.php' ?>