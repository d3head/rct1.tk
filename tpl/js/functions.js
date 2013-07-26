function tab(type)
{
	if(type == 'urler')
	{
		if(jQuery(".urler").is(":hidden")) 
		{
			jQuery(".urler").slideDown("fast");
			jQuery(".upload").slideUp("fast");
			jQuery(".about").slideUp("fast");
			jQuery(".api").slideUp("fast");
			jQuery(".logo").removeClass("logo_active");
			jQuery("span:nth-child(1)").removeClass("link_active");
			jQuery("span:nth-child(2)").addClass("link_active");
			jQuery("span:nth-child(3)").removeClass("link_active");
			jQuery("#url").focus();
		} 
	}
	else if(type == 'upload')
	{
		if(jQuery(".upload").is(":hidden")) 
		{
			jQuery(".upload").slideDown("fast");
			jQuery(".about").slideUp("fast");
			jQuery(".urler").slideUp("fast");
			jQuery(".api").slideUp("fast");
			jQuery(".logo").removeClass("logo_active");
			jQuery("span:nth-child(1)").addClass("link_active");
			jQuery("span:nth-child(2)").removeClass("link_active");
			jQuery("span:nth-child(3)").removeClass("link_active");
		} 
	}
	else if(type == 'api')
	{
		if(jQuery(".api").is(":hidden")) 
		{
			jQuery(".api").slideDown("fast");
			jQuery(".about").slideUp("fast");
			jQuery(".urler").slideUp("fast");
			jQuery(".upload").slideUp("fast");
			jQuery(".logo").removeClass("logo_active");
			jQuery("span:nth-child(1)").removeClass("link_active");
			jQuery("span:nth-child(2)").removeClass("link_active");
			jQuery("span:nth-child(3)").addClass("link_active");
		} 
	}
	else if(type == 'about')
	{
		if(jQuery(".about").is(":hidden")) 
		{
			jQuery(".about").slideDown("fast");
			jQuery(".urler").slideUp("fast");
			jQuery(".upload").slideUp("fast");
			jQuery(".api").slideUp("fast");
			jQuery(".logo").addClass("logo_active");
			jQuery("span:nth-child(1)").removeClass("link_active");
			jQuery("span:nth-child(2)").removeClass("link_active");
			jQuery("span:nth-child(3)").removeClass("link_active");
		} 
	}

}