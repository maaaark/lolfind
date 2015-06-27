function open_team_invitation(invitation_id){
    html  = "<div style='text-align: center;padding: 40px;'><img src='/img/ajax-loader.gif' style='height: 50px;'>";
    html += "<div style='padding-top: 10px;'>Content is loading ...</div>";
    html += '</div>';
    showLightbox(html, function(lightbox_content){
        $.post("/teams/invite/show", {"invitation_id": invitation_id }).done(function(data){
            lightbox_content.html(data);
        });
    });
}