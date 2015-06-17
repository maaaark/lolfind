function dropdown_build_arr(array, value){ // array= ["Name-Option", "Value-Option"]
	out = [];
	for(i = 0; i<array.length; i++){
      image_path = false;
      if(typeof array[i][2] != "undefined" && array[i][2]){
         image_path = array[i][2];
      }
      
		if(value && array[i][1] == value){
			temp = {title: array[i][0], value: array[i][1], image: image_path, selected: true};
		} else {
			temp = {title: array[i][0], value: array[i][1], image: image_path};
		}
		out.push(temp);
	}
	return out;
}

function dropdown_leagues_arr(selected_value){
	temp = [
           ["Any Rank", "any", "/img/leagues/0_5.png"],
           ["Bronze", "bronze", "/img/leagues/bronze_1.png"],
           ["Silver", "silver", "/img/leagues/silver_I.png"],
           ["Gold", "gold", "/img/leagues/gold_I.png"],
           ["Platinum", "platinum", "/img/leagues/platinum_1.png"],
           ["Master", "master", "/img/leagues/master_I.png"],
           ["Challenger", "challenger", "/img/leagues/challenger_1.png"]];
	return dropdown_build_arr(temp, selected_value);
}

function dropdown_roles_arr(selected_value, addition){
	temp = [
            ["Any Role", "any"],
            ["Top", "top", ["/img/roles/tank.jpg", "rounded smaller"]],
            ["Jungle", "jungle", ["/img/roles/fighter.jpg", "rounded smaller"]],
            ["Mid", "mid", ["/img/roles/mage.jpg", "rounded smaller"]],
            ["ADC", "adc", ["/img/roles/marksman.jpg", "rounded smaller"]],
	        ["Support", "support", ["/img/roles/support.jpg", "rounded smaller"]]];
	if(addition){
		temp.push(addition);
	}
	return dropdown_build_arr(temp, selected_value);
}

function dropdown_languages_arr(selected_value, addition){
	temp = [["Any language", "any"], ["German", "german"], ["English", "english"]];
	if(addition){
		temp.push(addition);
	}
	return dropdown_build_arr(temp, selected_value);
}

function dropdown_region_arr(selected_value){
	temp = [["Any Region", "any"],["EUW", "euw"], ["NA", "na"]];
	return dropdown_build_arr(temp, selected_value);
}