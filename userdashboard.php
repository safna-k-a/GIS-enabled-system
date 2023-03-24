<?php require 'header.php';
require 'connection.php';
echo "<script></script>";
$sql='SELECT * from district';
        $statement=$connection->prepare($sql);
        $statement->execute();
        $district=$statement->fetchAll(PDO::FETCH_OBJ);
  if(isset($_POST['district'])){
    $id=$_POST['district'];
    $sql='SELECT * from places where dist_id=:id';
        $statement=$connection->prepare($sql);
        $statement->execute([':id'=>$id]);
        $places=$statement->fetchAll(PDO::FETCH_OBJ);
}

if(isset($_POST['logout'])){
  session_unset();
  session_destroy();
  header("Location:index.php");

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
                        <a class="nav-link text-white" href="#">Log out</a>
                      </li>
                      
                    </ul>
                  </div>
                </div>
              </nav> 
        </div>
    </div>
    
    </div>
    
        <div class="udash py-5 vh-100">
        <!-- <div class="carousel-container">
  <div class="owl-carousel">
    <div><img src="images/p-forest.jpg"></div>
    <div><img src="images/p-beach.jpg"></div>
    <div><img src="images/p-mountain.jpg"></div>
  </div>
</div> -->
          <div class="row p-0 m-0">
            <div class="col-12 col-sm-6 px-5">
              <div class="owl-carousel owl-theme">
                <div class="item"><img src="images/alpy.jpg" class="rounded-3 shadow"></div>
                <div class="item"><img src="images/Varkala-Beach.png" class="rounded-3 shadow"></div>
                <div class="item"><img src="images/munnar.jpg" class="rounded-3 shadow"></div>
              </div>
              
            </div>
            <div class="col-12 col-sm-6 px-5 form-outer">
              <div class="px-5">
                <form action="districtresults.php" method="POST" class="bg-danger bg-opacity-50 rounded p-4">
                  <div class="text-dark fs-5">
                    You can search your destination based on district and rating.
                  </div>
                  <div class="pt-3">
                    <select id="mySelect" onchange="showSelect()" class="form-control rounded border border-danger mb-4">
                      <option value="" disabled selected>Choose Your Filters</option>
                      
                      <option value="option2">District</option>
                      <option value="option3">Rating</option>
                    </select>
                    
                    <div id="select2" style="display:none;">
                      <select class="form-control rounded border border-danger mb-4" name="district">
                        <option value="" disabled selected>Select a district</option>
                        <?php foreach($district as $dis): ?>
                        <option value="<?= $dis->id?>"><?= $dis->dist_name?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                    <div id="select3" style="display:none;">
                      <select class="form-control rounded border border-danger mb-4">
                        <option value="" disabled selected>Rating Range</option>
                        <option value="option1">2.5/5(poor)</option>
                        <option value="option2">3/5(average)</option>
                        <option value="option3">4/5(Good)</option>
                        <option value="option3">5/5(Excellent)</option>
                      </select>
                    </div>
                    <div class="text-center"  id="sub-btn"  style="display:none;">
                      <input type="submit" value="submit" class="btn btn-danger">
                    </div>
                  </div>
                </form>
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
              <p class="text-white text-end  cpwrite">Cookie Policy</p>
                <p class="text-white text-end  cpwrite">Cookie settings</p>
          </div>
        </div>
        
    
 </div>
 

 <?php require 'footer.php' ?>
