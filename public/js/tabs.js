function init_tabs(){
	$(".tabs_holder .tabs .tab").click(function(){
		$(this).parent().find(".active").removeClass("active");
		$(this).addClass("active");

		$(this).parent().parent().find(".tab_content.active").removeClass("active");
		$(this).parent().parent().find(".tab_content[data-tab='"+$(this).attr("data-tab")+"']").addClass("active");
	});

	$(".tabs_holder .tabs").each(function(){
		first_tab = $(this).find(".tab").first();
		$(this).find(".active").removeClass("active");
		first_tab.addClass("active");
		$(this).parent().find(".tab_content[data-tab='"+first_tab.attr("data-tab")+"']").addClass("active");
	});
}

$(document).ready(function(){
	init_tabs();
});