google.load('search', '1');
var newsSearch;


function initialize_map()
{
    var myOptions = {
	      zoom: 4,
	      mapTypeControl: true,
	      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
	      navigationControl: true,
	      navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
	      mapTypeId: google.maps.MapTypeId.ROADMAP      
	    }	
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
}
function initialize()
{
	if(geo_position_js.init())
	{
		document.getElementById('current').innerHTML="Receiving...";
		geo_position_js.getCurrentPosition(show_position,function(){document.getElementById('current').innerHTML="Couldn't get location"},{enableHighAccuracy:true});
	}
	else
	{
		document.getElementById('current').innerHTML="Functionality not available";
	}
	var searchControl = new google.search.SearchControl();
	searchControl.addSearcher(new google.search.WebSearch());
	searchControl.addSearcher(new google.search.LocalSearch());
	searchControl.addSearcher(new google.search.NewsSearch());
	searchControl.addSearcher(new google.search.ImageSearch());
	
}

function searchComplete(){
// Check that we got results
        var string = document.getElementById('news');
	
        if (newsSearch.results && newsSearch.results.length > 0) {
          for (var i = 0; i < newsSearch.results.length; i++) {

            // Create HTML elements for search results
            var p = document.createElement('p');
            var a = document.createElement('a');
            a.href = unescape(newsSearch.results[i].url);
            a.innerHTML = newsSearch.results[i].title;

            // Append search results to the HTML nodes
            p.appendChild(a);
            document.body.appendChild(p);
          }
        }
}



function show_position(p)
{
	document.getElementById('current').innerHTML="latitude="+p.coords.latitude.toFixed(2)+" longitude="+p.coords.longitude.toFixed(2);
	var pos=new google.maps.LatLng(p.coords.latitude,p.coords.longitude);
	geocoder = new google.maps.Geocoder();
	geocoder.geocode({'latLng':pos},function(results,status){
		
		if (status== google.maps.GeocoderStatus.OK){
			if (results[1]){
				map.setCenter(pos);
				map.setZoom(14);
				marker = new google.maps.Marker({
					position:pos,
					map:map,
					title: "<b>You are at</b>"+results[1].formatted_address,
				});
				var infowindow = new google.maps.InfoWindow({
					content:"<div id=\'form\'>" +
	"<form method=\'POST\' action=\'index.php\'>" +
    	"<input type='text' style=\'height: 45px; width: 150px;\'/ name =\'tweet\'><br />" +
        "<div id=\'add-image\'>" +
        	"<div id=\'add-image-box\'></div>" +
			"<input class=\'add-image-form\' type=\'file\' /><br />" +
        "</div>" +
	"<input  type=\'submit\' value=\'Tweet!\' >" +
	"</form>" +
"</div>" 

				});			

				google.maps.event.addListener(marker,'click',function(){
					infowindow.open(map,marker);
					$(".tweet-this a").tweetIt();
					newsSearch = new google.search.NewsSearch();
					newsSearch.setSearchCompleteCallback(this, searchComplete, null);
					newsSearch.execute(results[1].formatted_address);
					newsSearch.execute(results[2].formatted_address);
					newsSearch.execute(results[3].formatted_address);
					newsSearch.execute(results[4].formatted_address);
					google.search.Search.getBranding('branding');					
				});
			}	
		}
	
	});
}
