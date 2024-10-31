jQuery(document).ready(function() {
	
	jQuery('.llc-wl-setting-tabs').on('click', '.llc-wl-tab', function(e) {
		e.preventDefault();
		var id = jQuery(this).attr('href');
		jQuery(this).siblings().removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.llc-wl-setting-tabs-content .llc-wl-setting-tab-content').removeClass('active');
		jQuery('.llc-wl-setting-tabs-content').find(id).addClass('active');
	});
});
 
