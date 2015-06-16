function dropdown_build_arr(array, value){ // array= ["Name-Option", "Value-Option"]
	out = [];
	for(i = 0; i<array.length; i++){
		if(value && array[i][1] == value){
			temp = {title: array[i][0], value: array[i][1], selected: true};
		} else {
			temp = {title: array[i][0], value: array[i][1]};
		}
		out.push(temp);
	}
	return out;
}

function dropdown_leagues_arr(selected_value){
	temp = [["Bronze", "bronze"], ["Silver", "silver"], ["Gold", "gold"], ["Platinum", "platinum"], ["Master", "master"], ["Challenger", "challenger"]];
	return dropdown_build_arr(temp, selected_value);
}

function dropdown_roles_arr(selected_value, addition){
	temp = [["ADC", "adc"], ["Mid", "mid"], ["Support", "support"], ["Top", "top"], ["Jungle", "jungle"]];
	if(addition){
		temp.push(addition);
	}
	return dropdown_build_arr(temp, selected_value);
}

function dropdown_languages_arr(selected_value, addition){
	temp = [["German", "german"], ["English", "english"]];
	if(addition){
		temp.push(addition);
	}
	return dropdown_build_arr(temp, selected_value);
}

function dropdown_region_arr(selected_value){
	temp = [["EUW", "euw"], ["NA", "na"]];
	return dropdown_build_arr(temp, selected_value);
}