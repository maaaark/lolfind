var socket;
var opened_chats = [];
var fi_chat_history_last_sender;
var fi_server_online 	= false;
var fi_server_user      = 0;
var fi_server_username  = "";
var fi_server_user_icon = "";

function fi_server_init() {
	try {
		socket = new WebSocket(fi_server_host);
		socket.onopen    = function(msg) { 
							    console.log("readyState FI-Network-Server: "+this.readyState);

							    fi_server_send({"type": "login", "values": fi_server_login });
						   };
		socket.onmessage = function(msg) {
								json = JSON.parse(msg.data);
								if(typeof json["type"] != "undefined"){
									if(json["type"] == "login_success"){
										if(this.readyState == 1 && typeof json["status"] != "undefined" && json["status"] == "true"){
											if(typeof json["data"] != "undefined"){
												if(typeof json["data"]["username"] != "undefined" && typeof json["data"]["user"] != "undefined" && json["data"]["user_icon"] != "undefined"){
													fi_server_user 		= json["data"]["user"];
													fi_server_username  = json["data"]["username"];
													fi_server_user_icon	= json["data"]["user_icon"];
							   						fi_server_online = true;
							   						open_still_opened_chat_windows();
						   						}
											}
							    		}
									} else if(json["type"] == "chat"){
										fi_server_chat_handle_incoming(json);
									}
									else if(json["type"] == "chathistory"){
										fi_server_chat_history_handle(json);
									}
									else if(json["type"] == "notification"){
										fi_server_notification_handle_incoming(json);
									}
								}
						   };

		socket.onclose   = function(msg) { 
							   fi_server_online = false;
							   console.log("FI-Network-Server disconnected");
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

function open_still_opened_chat_windows(){
	// Zuvor geöffnete Chat-Fenster öffnen, nur wenn Chat-Server online ist:
	if(typeof $.cookie("fi_opened_chats") != "undefined"){
		chat_windows_json = JSON.parse($.cookie("fi_opened_chats"));
		for(i = 0; i < chat_windows_json.length; i++){
			if(chat_windows_json[i]){
				minimized_status = false;
				if(typeof chat_windows_json[i]["minimized"] != "undefined" && chat_windows_json[i]["minimized"] == true){
					minimized_status = true;
				}

				opened_chats.push({
					"userid": chat_windows_json[i]["userid"],
					"name": chat_windows_json[i]["name"],
					"icon": chat_windows_json[i]["icon"],
					"minimized": minimized_status,
				});
				fi_server_open_chat(chat_windows_json[i]["userid"], chat_windows_json[i]["name"], chat_windows_json[i]["icon"], true, minimized_status);
			}
		}
	}
}

function fi_server_chat_handle_incoming(json){
    add_status = true;
	element    = $("#chat_holder #chat_window_"+json["sender"]);
	if(typeof element != "undefined" && element && element.html() && element.html().trim() != ""){
		// Fenster bereits offen -> muss nichts mehr gemacht werden
		element.removeClass("minimized");
	} else {
		fi_server_open_chat(json["sender"], json["sender_username"], json["sender_icon"]);
		add_status = false;
	}
	
	if(add_status){
        fi_server_chat_add_text(json["sender"], json, true);
    }
	
	// Ungelesen-Trigger hinzufpgen
	$("#chat_holder #chat_window_"+json["sender"]).addClass("unread_messages");
	
	// Ungelesen Count - Wert updaten
   el = $(".nw_navi_el.account_icon.nw_box_btn[data-box='chats_box']").find(".box_btn_hint");
   $("#chats_content #nw_chat_box_element_"+json["sender"]).addClass("new_msg");
   
   count_up_status = true;
   for(i = 0; i < fi_server_chats_counts.length; i++){
      if(typeof fi_server_chats_counts[i] != "undefined" && fi_server_chats_counts[i] != null && typeof fi_server_chats_counts[i]["userid"] != "undefined"){
         if(fi_server_chats_counts[i]["userid"] == json["sender"]){
            count_up_status = false;
         }
      }
   }
   if(count_up_status){
      // Hochzählen
      fi_server_chats_counts.push({"userid": json["sender"]});
      el = $(".nw_navi_el.account_icon.nw_box_btn[data-box='chats_box']").find(".box_btn_hint");
      if(typeof el != "undefined" && el){
         chat_count_temp = 0;
         if(el.html().trim() != "" && parseInt(el.html().trim()) > 0){
            chat_count_temp = parseInt(el.html().trim());
         }
         chat_count_temp++;
         el.html(chat_count_temp);
         el.removeClass("hidden");
      }
   }
}

function fi_server_open_chat(userid, name, icon, automatic_open, minimized_status){
	if(opened_chats == null || opened_chats == false){
		opened_chats = [];
	}

	if(automatic_open){
		// Wurde vom System geöffnet: nichts machen
	} else {
		status_add_temp = true;
		for(i = 0; i < opened_chats.length; i++){
			if(opened_chats[i] != null && opened_chats[i]["userid"] == userid){
				status_add_temp = false;
			}
		}
		if(status_add_temp == true){
			opened_chats.push({"userid": userid, "name": name, "icon": icon, "minimized": false});
			$.cookie("fi_opened_chats", JSON.stringify(opened_chats), { path: '/' });
		}
	}

	element = $("#chat_holder #chat_window_"+userid);
	if(typeof element != "undefined" && element && element.html() && element.html().trim() != ""){
		element.removeClass("minimized");
		element.find(".chat_value_input").focus();
		element.find(".chat_content").animate({ scrollTop: content_div.prop("scrollHeight") - content_div.height() }, 1);
		for(i = 0; i < opened_chats.length; i++){
			if(opened_chats[i] != null && opened_chats[i]["userid"] == userid){
				opened_chats[i]["minimized"] = false;
			}
		}
		$.cookie("fi_opened_chats", JSON.stringify(opened_chats), { path: '/' });
	} else {
		class_addition_temp = '';
		if(typeof minimized_status != "undefined" && minimized_status == true){
			class_addition_temp = ' minimized';
		}

		html  = '<div id="chat_window_'+userid+'" class="chat_window'+class_addition_temp+'" data-uID="'+userid+'">';
		html += '<div class="minimized_view">'+name+'</div>';
		html += '<div class="maximized_view">';
			html += '<div class="title_bar">';
			html += '<div class="options"><span class="chat_window_option minimize">-</span><span class="chat_window_option close_chat">x</span></div>';
			html += '<div class="chat_window_name">'+name+'</div></div>';
			html += '<div class="chat_content"><div class="history_holder"></div></div>';
			html += '<div class="chat_bar"><input type="text" id="chat_value_input_'+userid+'" class="chat_value_input" data-uId="'+userid+'" data-uName="'+name+'" data-uIcon="'+icon+'"></div>';
		html += '</div>';
		html += '</div>';
		$("#chat_holder").append(html);
		fi_server_bind_chat_sends();
		fi_server_bind_window_options();
		$("#chat_holder #chat_window_"+userid).find(".chat_value_input").focus();

		// Re minimize
		$("#chat_holder .chat_window.minimized .minimized_view").click(function(){
			$(this).parent().removeClass("minimized");
			content_div = $(this).parent().find(".chat_content");
			content_div.animate({ scrollTop: content_div.prop("scrollHeight") - content_div.height() }, 1);
			for(i = 0; i < opened_chats.length; i++){
				if(opened_chats[i] != null && opened_chats[i]["userid"] == $(this).parent().attr("data-uID")){
					opened_chats[i]["minimized"] = false;
				}
			}
			$.cookie("fi_opened_chats", JSON.stringify(opened_chats), { path: '/' });
		});

		if(fi_server_online){	// Wenn Chatserver online: Chat-Verlauf anfordern
			fi_server_send({"type": "chat", "message": { "load_history": true, "user": userid}});
		} else {
			offline_html  = '<div class="chat_msg_chat_offline">';
			offline_html += '<div class="chat_offline_smiley">:(</div>';
			offline_html += '<div>The chat-server is temporary offline.</div>';
			offline_html += '<div class="check_back_later">Please check back later.</div>';
			offline_html += '</div>';
			$('#chat_window_'+userid+' .chat_content').html(offline_html);
			$('#chat_window_'+userid+' #chat_value_input_'+userid).prop("disabled", true);
			$('#chat_window_'+userid+' #chat_value_input_'+userid).addClass("chat_offline");
			$('#chat_window_'+userid+' #chat_value_input_'+userid).val("The chat-server is offline ...");
		}
	}
	
	// NW Chats Box schließen
	$(".nw_navi_el.account_icon.nw_box_btn").removeClass("active");
	$("#nw_chats_box").removeClass("open");
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

				// Gelesen-Status speichern:
				if($(this).parent().parent().parent().hasClass("unread_messages")){
					$(this).parent().parent().parent().removeClass("unread_messages");

					fi_server_send({"type": "chat", "message": { "read_status": true, "user": fi_server_user, "other_user": $(this).attr("data-uId")} });

					// Wert updaten
					el = $(".nw_navi_el.account_icon.nw_box_btn[data-box='chats_box']").find(".box_btn_hint");
					if(typeof el != "undefined" && el){
						chats_count = parseInt(el.html().trim());
						if(chats_count <= 1){
							el.addClass("hidden");
							el.html("0");
						} else {
							chats_count--;
							el.removeClass("hidden");
							el.html(chats_count);
						}
					}
					$("#chats_content #nw_chat_box_element_"+$(this).parent().parent().attr("data-uID")).removeClass("new_msg");

					for(i = 0; i < fi_server_chats_counts.length; i++){
						if(typeof fi_server_chats_counts[i] != "undefined" && fi_server_chats_counts[i] != null && typeof fi_server_chats_counts[i]["userid"] != "undefined" && fi_server_chats_counts[i]["userid"] == $(this).parent().parent().attr("data-uID")){
							fi_server_chats_counts[i] = null;
						}
					}
				}
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
			for(i = 0; i < opened_chats.length; i++){
				if(opened_chats[i]["userid"] == $(this).parent().parent().parent().parent().attr("data-uID")){
					opened_chats[i]["minimized"] = true;
				}
			}
			$.cookie("fi_opened_chats", JSON.stringify(opened_chats), { path: '/' });
		}

		$("#chat_holder .chat_window.minimized .minimized_view").click(function(){
			$(this).parent().removeClass("minimized");
			$(this).parent().removeClass("minimized");
			content_div = $(this).parent().find(".chat_content");
			content_div.animate({ scrollTop: content_div.prop("scrollHeight") - content_div.height() }, 1);
			for(i = 0; i < opened_chats.length; i++){
				if(opened_chats[i]["userid"] == $(this).parent().attr("data-uID")){
					opened_chats[i]["minimized"] = false;
				}
			}
			$.cookie("fi_opened_chats", JSON.stringify(opened_chats), { path: '/' });
		});
	});
	
	// Gelesen Status händeln
	$(".chat_window .chat_content, .chat_window .chat_bar").click(function(){
      if($(this).parent().parent().hasClass("unread_messages")){
         $(this).parent().parent().removeClass("unread_messages");
         
         // Gelesen-Status speichern:
         fi_server_send({"type": "chat", "message": { "read_status": true, "user": fi_server_user, "other_user": $(this).parent().parent().attr("data-uID")} });
         
         // Wert updaten
         el = $(".nw_navi_el.account_icon.nw_box_btn[data-box='chats_box']").find(".box_btn_hint");
         if(typeof el != "undefined" && el){
            chats_count = parseInt(el.html().trim());
            if(chats_count <= 1){
               el.addClass("hidden");
               el.html("0");
            } else {
               chats_count--;
               el.removeClass("hidden");
               el.html(chats_count);
            }
         }
         $("#chats_content #nw_chat_box_element_"+$(this).parent().parent().attr("data-uID")).removeClass("new_msg");
         
         for(i = 0; i < fi_server_chats_counts.length; i++){
            if(typeof fi_server_chats_counts[i] != "undefined" && fi_server_chats_counts[i] != null && typeof fi_server_chats_counts[i]["userid"] != "undefined" && fi_server_chats_counts[i]["userid"] == $(this).parent().parent().attr("data-uID")){
               fi_server_chats_counts[i] = null;
            }
         }
      }
	});
}

function fi_server_chat_add_text(chat_user_id, json, incoming_message){
	element = $("#chat_holder #chat_window_"+chat_user_id);
	content_div = element.find(".chat_content");
	if(json["sender"] == fi_server_user){
		if(fi_chat_history_last_sender == json["sender"]){
			html = "<div class='chat_msg own'>"+json["message"]+"</div>";
		} else {
			html = "<div class='chat_msg own'><b>"+json["sender_username"]+":</b> "+json["message"]+"</div>";
		}
	} else {
		if(fi_chat_history_last_sender == json["sender"]){
			html = "<div class='chat_msg'>"+json["message"]+"</div>";
		} else {
			html = "<div class='chat_msg'><b>"+json["sender_username"]+":</b> "+json["message"]+"</div>";
		}
	}
	content_div.append(html + '<div class="chat_clear"></div>');
	fi_chat_history_last_sender = json["sender"];
	
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

function fi_server_chat_history_handle(json){
	if(typeof json["history"] != "undefined" && json["history"].length > 0){
		for(i = 0; i < json["history"].length; i++){
			if(json["history"][i]["sender"] == fi_server_user){
				if(fi_chat_history_last_sender == json["history"][i]["sender"]){
					html = "<div class='chat_msg own'>"+json["history"][i]["message"]+"</div>";
				} else {
					html = "<div class='chat_msg own'><b>"+json["history"][i]["sender_username"]+":</b> "+json["history"][i]["message"]+"</div>";
				}
			} else {
				if(fi_chat_history_last_sender == json["history"][i]["sender"]){
					html = "<div class='chat_msg'>"+json["history"][i]["message"]+"</div>";
				} else {
					html = "<div class='chat_msg'><b>"+json["history"][i]["sender_username"]+":</b> "+json["history"][i]["message"]+"</div>";
				}
			}
			$("#chat_window_"+json["user"]).find(".history_holder").append(html + '<div class="chat_clear"></div>');
			fi_chat_history_last_sender = json["history"][i]["sender"];
		}
	} else {
		$("#chat_window_"+json["user"]).find(".history_holder").html('');
	}
	content_div = $("#chat_window_"+json["user"]).find(".chat_content");
	content_div.animate({ scrollTop: content_div.prop("scrollHeight") - content_div.height() }, 1);
	
	// Ungelesen Status hinzufügen
	if(typeof json["unread"] != "undefined" && json["unread"]){
      $("#chat_window_"+json["user"]).addClass("unread_messages");
	}
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
				
				// Wert updaten
				el = $(".nw_navi_el.account_icon.nw_box_btn[data-box='notification_box']").find(".box_btn_hint");
				if(typeof el != "undefined" && el){
               notification_temp_count = 0;
               if(el.html().trim() != "" && parseInt(el.html().trim()) > 0){
                  notification_temp_count = parseInt(el.html().trim());
               }
               notification_temp_count++;
               el.html(notification_temp_count);
               el.removeClass("hidden");
				}
			}
		});
	}
}

function fi_server_notification_box_click(){ // Notifications als gelesen markieren4
   fi_server_send({"type": "notification_count_update", "message": { "sended_data": "true" } });
}

$(document).ready(function(){
   $(".nw_navi_el.account_icon.nw_box_btn[data-box='notification_box']").click(function(){
      el = $(".nw_navi_el.account_icon.nw_box_btn[data-box='notification_box']").find(".box_btn_hint");
      if(typeof el != "undefined" && el && el.html().trim() != "" && parseInt(el.html().trim()) > 0){
         el.addClass("hidden");
         el.html("0");
         fi_server_notification_box_click();
      }
   });
});