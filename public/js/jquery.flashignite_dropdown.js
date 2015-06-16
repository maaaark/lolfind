var selection_click_status = false;
$.fn.makeSelect = function(name, data){
	temp_id = "selection_"+$(this).attr("id");
	object  = this;
	html_start    = '<div class="select_box" id="'+temp_id+'">';
	html_selected = '<div class="selected_object">Please select an option</div>';

	input_html    = '<input type="hidden" name="'+name+'" id="'+temp_id+'_val">';
	object.html(input_html);
	html = '<div class="select_row">';
	$.each(data, function(key, value){
		class_addition = '';
		if(typeof value["selected"] != "undefined" && value["selected"] == true){
			class_addition = ' selected';
		}

		val = value["title"];
		if(typeof value["value"] != "undefined"){
			val = value["value"];
		}

		temp = '<div class="select_option'+class_addition+'" data-id="'+temp_id+'" data-value="'+val+'">';
		if(typeof value["image"] != "undefined"){
			temp += '<div class="image"><img class="sel_img" src="'+value["image"]+'"></div>';
		}
		temp += value["title"];
		if(typeof value["description"] != "undefined"){
			temp += '<div class="description">'+value["description"]+'</div>';
		}
		temp += '</div>';
		
		if(typeof value["selected"] != "undefined" && value["selected"] == true){
			html_selected = '<div class="selected_object">'+temp+'</div>';
			$("#"+temp_id+"_val").val(val);
		}
		html += temp;
	});
	html += '</div>';
	html = html_start + html_selected + html + '</div>';
    object.html(object.html() + html);
	object.find(".select_row").css("width", object.find(".selected_object").first().outerWidth() - 5);

	$("#"+temp_id+".select_box").find(".select_row .select_option").click(function(){
		$("#"+$(this).attr("data-id")).find(".selected_object").html($(this).get(0).outerHTML);
		$("#"+$(this).attr("data-id")+"_val").val($(this).attr("data-value"));
	});

    $("#"+temp_id+".select_box").click(function(){
    	selection_click_status = true;
    	select_object = $(this);
    	select_object.find(".select_row").css("width", select_object.find(".selected_object").first().outerWidth()-5);
    	if(select_object.hasClass("opened")){
    		select_object.removeClass("opened");
    	} else {
    		$(".select_box").removeClass("opened");
    		select_object.addClass("opened");
    	}
    });
};

$(document).ready(function(){
	$("body").click(function(){
		if(selection_click_status == false){
			$(".select_box").removeClass("opened");
		}
		selection_click_status = false;
	});
});