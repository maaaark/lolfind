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
	fi_server_chat_add_text(json["sender"], json["message"]);
}

function fi_server_open_chat(userid, name){
	element = $("#chat_holder #chat_window_"+userid);
	if(typeof element != "undefiend" && element && element.html() && element.html().trim() != ""){
		// Chat Fenster bereits offen -> focus darauf legen
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
	}
}

function fi_server_bind_chat_sends(){
	$(".chat_window .chat_value_input").keypress(function (e) {
		if(e.which == 13){ // Enter
			if($(this).val().trim() != ""){
				fi_server_send({"type": "chat", "message": { "message": $(this).val().trim(), "receiver": $(this).attr("data-uId")}});
				fi_server_chat_add_text($(this).attr("data-uId"), $(this).val().trim());
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

function fi_server_chat_add_text(chat_user_id, message){
	element = $("#chat_holder #chat_window_"+chat_user_id);
	element.find(".chat_content").append("<div><b>"+chat_user_id+":</b> "+message+"</div>");
}

function fi_server_chat_send(value){
	var txt,msg;
	txt = $("msg");
	msg = txt.value;
	if(!msg) { 
		alert("Message can not be empty"); 
		return; 
	}
	txt.value="";
	txt.focus();
	fi_server_send({"type": "chat", "message": { "message": msg, "receiver": 2}}); 
}