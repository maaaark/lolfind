var socket;
var opened_chats = [];

function fi_server_init() {
	try {
		socket = new WebSocket(fi_server_host);
		socket.onopen    = function(msg) { 
							   fi_server_send({"type": "login", "values": {"uID": fi_server_user}});
							   console.log("readyState FI-Network-Server: "+this.readyState); 
						   };
		socket.onmessage = function(msg) {
								json = JSON.parse(msg.data);
								if(typeof json["type"] != "undefined"){
									if(json["type"] == "chat"){
										fi_server_chat_handle_incoming(json);
									}
									else if(json["type"] == "notification"){
										fi_server_notification_handle_incoming(json);
									}
								}
						   };

		socket.onclose   = function(msg) { 
							   // log("Disconnected - status "+this.readyState);
							   // Nichts machen
						   };
	}
	catch(ex){ 
		console.log(ex); 
	}

	// Zuvor geöffnetete Chat-Fenster öffnen
	$(document).ready(function(){
		if(typeof $.cookie("fi_opened_chats") != "undefined"){
			chat_windows_json = JSON.parse($.cookie("fi_opened_chats"));
			console.log($.cookie("fi_opened_chats"));
			for(i = 0; i < chat_windows_json.length; i++){
				if(chat_windows_json[i]){
					fi_server_open_chat(chat_windows_json[i]["userid"], chat_windows_json[i]["name"], chat_windows_json[i]["icon"], true);
					opened_chats.push(chat_windows_json[i]);
				}
			}
		}
	});
}

function fi_server_send(object){
	try { 
		socket.send(JSON.stringify(object)); 
		//log('Sent: '+msg); 
	} catch(ex) { 
		// Exception nicht ausgeben
		//log(ex);
	}
}

function fi_server_chat_handle_incoming(json){
	element = $("#chat_holder #chat_window_"+json["sender"]);
	if(typeof element != "undefined" && element && element.html() && element.html().trim() != ""){
		// Fenster bereits offen -> muss nichts mehr gemacht werden
	} else {
		fi_server_open_chat(json["sender"], json["sender_username"], json["sender_icon"]);
	}
	fi_server_chat_add_text(json["sender"], json, true);
}

function fi_server_open_chat(userid, name, icon, automatic_open){
	if(opened_chats == null || opened_chats == false){
		opened_chats = [];
	}

	if(automatic_open){
		// Wurde vom System geöffnet: nichts machen
	} else {
		status = true;
		for(i = 0; i < opened_chats.length; i++){
			if(opened_chats[i]["userid"] == userid){
				status = false;
			}
		}
		if(status){
			opened_chats.push({"userid": userid, "name": name, "icon": icon});
			$.cookie("fi_opened_chats", JSON.stringify(opened_chats), { path: '/' });
		}
	}

	element = $("#chat_holder #chat_window_"+userid);
	if(typeof element != "undefined" && element && element.html() && element.html().trim() != ""){
		element.removeClass("minimized");
		element.find(".chat_value_input").focus();
	} else {
		html  = '<div id="chat_window_'+userid+'" class="chat_window" data-uID="'+userid+'">';
		html += '<div class="minimized_view">'+name+'</div>';
		html += '<div class="maximized_view">';
			html += '<div class="title_bar">';
			html += '<div class="options"><span class="chat_window_option minimize">-</span><span class="chat_window_option close_chat">x</span></div>';
			html += name+'</div>';
			html += '<div class="chat_content"></div>';
			html += '<div class="chat_bar"><input type="text" id="chat_value_input_'+userid+'" class="chat_value_input" data-uId="'+userid+'" data-uName="'+name+'" data-uIcon="'+icon+'"></div>';
		html += '</div>';
		html += '</div>';
		$("#chat_holder").append(html);
		fi_server_bind_chat_sends();
		fi_server_bind_window_options();
		$("#chat_holder #chat_window_"+userid).find(".chat_value_input").focus();
	}
}

function fi_server_bind_chat_sends(){
	$(".chat_window .chat_value_input").keypress(function (e) {
		if(e.which == 13){ // Enter
			if($(this).val().trim() != ""){
				fi_server_send({"type": "chat", "message": { "message": $(this).val().trim(), "receiver": $(this).attr("data-uId")}});
				fi_server_chat_add_text($(this).attr("data-uId"), {
					"message": 			 $(this).val().trim(),
					"sender": 			 fi_server_user,
					"sender_username": 	 fi_server_username,
					"receiver": 		 $(this).attr("data-uId"),
					"receiver_username": $(this).attr("data-uName"),
					"receiver_icon": 	 $(this).attr("data-uIcon"),
				});
			}
			$(this).val('');
		}
	});
}

function fi_server_bind_window_options(){
	$(".chat_window .options .chat_window_option").click(function(){
		if($(this).hasClass("close_chat")){
			$(this).parent().parent().parent().parent().remove();
			for(i = 0; i < opened_chats.length; i++){
				if(opened_chats[i]["userid"] == $(this).parent().parent().parent().parent().attr("data-uID")){
					opened_chats[i] = null;
				}
			}
			$.cookie("fi_opened_chats", JSON.stringify(opened_chats), { path: '/' });
		} else {
			$(this).parent().parent().parent().parent().addClass("minimized");
			$("#chat_holder .chat_window.minimized .minimized_view").click(function(){
				$(this).parent().removeClass("minimized");
			});
		}
	});
}

function fi_server_chat_add_text(chat_user_id, json, incoming_message){
	element = $("#chat_holder #chat_window_"+chat_user_id);
	content_div = element.find(".chat_content");
	content_div.append("<div><b>"+json["sender_username"]+":</b> "+json["message"]+"</div>");
	
	if(typeof incoming_message != "undefined" && incoming_message){
        fi_server_update_nw_chat_list(json, json["sender"], true);
    } else {
        fi_server_update_nw_chat_list(json, chat_user_id);
    }
    content_div.animate({ scrollTop: content_div.prop("scrollHeight") - content_div.height() }, 1);
}

function fi_server_update_nw_chat_list(json, chat_other_user, incoming_message_status){
    $("#nw_chats_box #nw_chat_box_element_"+chat_other_user).remove();
    
    sender_username_temp = json["receiver_username"];
    sender_icon_temp     = json["receiver_icon"];
    if(typeof incoming_message_status != "undefined" && incoming_message_status){
        sender_username_temp = json["sender_username"];
        sender_icon_temp     = json["sender_icon"];
    }
    
    html  = '<div class="chat_box_element" id="nw_chat_box_element_'+chat_other_user+'" data-uID="'+chat_other_user+'" data-uName="'+sender_username_temp+'" data-uIcon="'+sender_icon_temp+'">';
    html += '<img src="http://ddragon.leagueoflegends.com/cdn/'+fi_server_lol_patch+'/img/profileicon/'+sender_icon_temp+'.png" class="chat_summoner_icon">';
    html += '<div class="chat_element_title">'+sender_username_temp+'</div>';
    html += '<div>';
    html += json["message"];
    html += '</div>';
    html += '<div class="chat_element_date">A few seconds ago</div>';
    html += '</div>';
    $("#nw_chats_box #chats_content").html(html + $("#nw_chats_box #chats_content").html());
}

/* Notifications */
var opened_navigation_effect = false;
function fi_server_notification_handle_incoming(json){
	if(typeof json["notification_id"] != "undefined" && json["notification_id"] > 0){
		$.post("/notifications/get", {"notification_id": json["notification_id"]}).done(function(data){
			if(typeof data != "undefined" && data.trim() != ""){
				$("#notification_content").html(data.trim() + $("#notification_content").html());
				$("#nw_box_no_notifications").remove();

				if(opened_navigation_effect == false){
					$("body").append("<div class='notification_effect' id='notification_effect_holder'>"+data.trim()+"</div>");
					opened_navigation_effect = true;
				} else {
					$("#notification_effect_holder").prepend(data.trim());
				}

				$("#notification_effect_holder").animate({"opacity": "1"}, 500, "linear", function(){
					$("#notification_effect_holder").animate({"opacity": "1"}, 10000, "linear", function(){
						$("#notification_effect_holder").animate({"opacity": "0"}, 500, "linear", function(){
							$("#notification_effect_holder").remove();
							opened_navigation_effect = false;
						});
					});
				});
			}
		});
	}
}