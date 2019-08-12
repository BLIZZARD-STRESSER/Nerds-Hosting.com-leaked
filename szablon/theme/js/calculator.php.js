var GAME_DATA = {
   "18":[
      {
         "id":"18",
         "name":"Counter-Strike: Global Offensive",
         "min":"12",
         "max":"32",
         "loc":"1",
         "loc_name":"",
         "pub":0.40,
         "priv":0.60
      }
   ],
   "2":[
      {
         "id":"2",
         "name":"Counter-Strike 1.6",
         "min":"12",
         "max":"32",
         "loc":"1",
         "loc_name":"",
         "pub":0.37,
         "priv":0.52 
      }
   ],
   "4":[
      {
         "id":"4",
         "name":"Minecraft",
         "min":"1",
         "max":"15",
         "loc":"1",
         "loc_name":"",
         "pub":1,
         "priv":2
      }
   ],
   "1":[
      {
         "id":"1",
         "name":"SAMP",
         "min":"50",
         "max":"500",
         "loc":"1",
         "loc_name":"",
         "pub":0.05,
         "priv":0.10
      }
   ],
   "21":[
      {
         "id":"21",
         "name":"TeamSpeak 3",
         "min":"5",
         "max":"500",
         "loc":"4",
         "loc_name":"",
         "pub":0.05,
         "priv":0.1
      }
   ]
}
jq = jQuery.noConflict();

function buildList(key){
	var game = GAME_DATA[key][0];
	var slotList = jq('.slotList');
	var locList = jq('.locList');
	
	slotList.empty();
	for(var i = parseInt(game['min'], 10); i <= parseInt(game['max'], 10); i++){
		slotList.append(jq('<option>').text(i).val(i));
	}
	
	locList.empty();
	for(var l = 0; l < GAME_DATA[key].length; l++){
		locList.append(jq('<option>').text(GAME_DATA[key][l]['loc_name']).val(l));
	}
	
	locationChange();
}

function locationChange(){
	var gameList = jq('.gameList');
	var typeList = jq('.typeList');
	var locList = jq('.locList');
	
	var key = gameList.val();
	var game = GAME_DATA[key][locList.val()];		
	
	typeList.empty();	
	
	if(parseFloat(game['priv']) > 0.0){
		typeList.append(jq('<option>').text('Premium').val(1));		
	}
		
	if(parseFloat(game['pub']) > 0.0){
		typeList.append(jq('<option>').text('Lite').val(2));	
	}	
	
	updatePrice();
}

function updatePrice(){
	var gameList = jq('.gameList');
	var typeList = jq('.typeList');
	var locList = jq('.locList');
	var slotList = jq('.slotList');
	
	var key = gameList.val();	
	var game = GAME_DATA[key][locList.val()];
	
	var slot_price = (typeList.val() == 1)? parseFloat(game['priv']) : parseFloat(game['pub']);
	
	var price = Math.ceil(slot_price * slotList.val() * 100) / 100;
	
	jq('#calc a').text(price.toFixed(2) + ' EUR');
}

jq(document).ready(function(){
	var gameList = jq('.gameList');
	var typeList = jq('.typeList');
	var locList = jq('.locList');
	var slotList = jq('.slotList');
	var firstKey = null;
	
	for(var key in GAME_DATA){
		if(firstKey == null) firstKey = key;
		var value = GAME_DATA[key][0];
		gameList.append(jq('<option>').text(value['name']).val(key));
	}	
	
	gameList.change(function(){
		var key = this.value;
		buildList(key);
	});
	
	locList.change(locationChange);
	
	typeList.change(updatePrice);
	slotList.change(updatePrice);
	
	
	buildList(firstKey);
});