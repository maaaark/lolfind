var socket;
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
	console.log("incoming");
	element = $("#chat_holder #chat_window_"+json["sender"]);
	if(typeof element != "undefiend" && element && element.html() && element.html().trim() != ""){
		// Fenster bereits offen -> muss nichts mehr gemacht werden
	} else {
		fi_server_open_chat(json["sender"], "Sendername");
	}
	fi_server_chat_add_text(json["sender"], json, true);
}

function fi_server_open_chat(userid, name){
	element = $("#chat_holder #chat_window_"+userid);
	if(typeof element != "undefiend" && element && element.html() && element.html().trim() != ""){
		element.removeClass("minimized");
		element.find(".chat_value_input").focus();
	} else {
		html  = '<div id="chat_window_'+userid+'" class="chat_window">';
		html += '<div class="minimized_view">'+name+'</div>';
		html += '<div class="maximized_view">';
			html += '<div class="title_bar">';
			html += '<div class="options"><span class="chat_window_option minimize">-</span><span class="chat_window_option close_chat">x</span></div>';
			html += name+'</div>';
			html += '<div class="chat_content"></div>';
			html += '<div class="chat_bar"><input type="text" id="chat_value_input_'+userid+'" class="chat_value_input" data-uId="'+userid+'"></div>';
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
				fi_server_chat_add_text($(this).attr("data-uId"), {"message": $(this).val().trim(), "sender_username": fi_server_username});
			}
			$(this).val('');
		}
	});
}

function fi_server_bind_window_options(){
	$(".chat_window .options .chat_window_option").click(function(){
		if($(this).hasClass("close_chat")){
			$(this).parent().parent().parent().parent().remove();
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
	element.find(".chat_content").append("<div><b>"+json["sender_username"]+":</b> "+json["message"]+"</div>");
	
	if(typeof incoming_message != "undefined" && incoming_message){
        fi_server_update_nw_chat_list(json, json["sender"], true);
    } else {
        fi_server_update_nw_chat_list(json, fi_server_user);
    }
}

function fi_server_update_nw_chat_list(json, chat_other_user, incoming_message_status){
    $("#nw_chats_box #nw_chat_box_element_"+chat_other_user).remove();
    
    sender_username_temp = fi_server_username;
    sender_icon_temp     = fi_server_user_icon;
    if(typeof incoming_message_status != "undefined" && incoming_message_status){
        sender_username_temp = json["sender_username"];
        sender_icon_temp     = json["sender_icon"];
    }
    
    html  = '<div class="chat_box_element" id="nw_chat_box_element_'+chat_other_user+'" data-uID="'+chat_other_user+'" data-uName="'+fi_server_username+'">';
    html += '<img src="http://ddragon.leagueoflegends.com/cdn/'+fi_server_lol_patch+'/img/profileicon/'+sender_icon_temp+'.png" class="chat_summoner_icon">';
    html += '<div class="chat_element_title">'+fi_server_username+'</div>';
    html += '<div>';
    html += json["message"];
    html += '</div>';
    html += '<div class="chat_element_date">A few seconds ago</div>';
    html += '</div>';
    $("#nw_chats_box #chats_content").html(html + $("#nw_chats_box #chats_content").html());
}