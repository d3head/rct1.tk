<!DOCTYPE html> 
<html lang='ru'>
	<head>
		<title><?=$pageName?></title>
		<meta charset="utf-8">
		<meta name="Author" content="rc">
		<meta name="Generator" content="<?=$mConfig['system']['version']?>" />
		<link rel="stylesheet" href="/tpl/css/global.css" />	
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/tpl/js/functions.js"></script>
		<script type="text/javascript" src="/tpl/js/upload.js" ></script>
		<script type="text/javascript" src="/tpl/js/jquery.tipsy.js"></script>
		<script type="text/javascript" src="/tpl/js/jgrowl/jquery.jgrowl_minimized.js"></script>
		<script type='text/javascript'>
			$(function() {
				$('.tip').tipsy({gravity: 'w'});
				$('.ltip').tipsy({gravity: 's'});
				
				var btnUpload	= $('#upload');
				var status		= $('#status');
				
				new AjaxUpload(btnUpload, {
					action: 'upload',
					name: 	'uploadfile',
					onSubmit: function(file, ext){
						 if (!(ext && /^(jpg|png|jpeg|gif|rar|zip|tar)$/.test(ext))) { 
							status.html('');
							
							<?
							$Func->jAlert('Недопустимый формат', 'Загружать можно только JPEG, GIF, PNG, RAR, ZIP, TAR!', 'in', 'red', 'true');
							?>
							
							return false;
						}
						status.html('<img src="/tpl/i/loading.gif" alt="" />');
					},
					onComplete: function(file, response) {
						status.html('');
						if(response === "filesize") {
							
							<?
							$Func->jAlert('Превышен максимальный размер', 'Максимальный размер файла не должен превышать 15 мегабайт', 'in', 'red', 'true');
							?>
							
						} else if(response === "error") {
							$('<li></li>').appendTo('#files').text(file).addClass('error');
						} else {
							$('<li></li>').appendTo('#files').html(response).addClass('success');
						}
					}
				});
				
			});
			
			jQuery(document).ready(function() {	
				jQuery('#urler').submit(function() {
					jQuery("#loading").html("<img src='/tpl/i/loading.gif' alt='' />");
					
					var url = jQuery('#url').val();
					
					if(url == '')
					{
						jQuery("#loading").html('');
						
						<?
						$Func->jAlert('Ошибка', 'Вы не ввели ссылку', 'in', 'red', 'false');
						?>
						
					}
					else
					{
						jQuery.post('/api/url/add/',{'url':url},
							function(data) {
								jQuery('#url').val(data.shorturl);
								
								jQuery("#url").ready(function() { 
									jQuery("#url").stop().animate({ backgroundColor: "#caffb2"}, 200); 
								},function() { 
									jQuery("#url").stop().animate({ backgroundColor: "#ffffff"}, 200); 
								});
								
								if(data.status == 'ok')
								{
									jQuery('#url').attr('title', 'Ссылка добавлена в базу!');								
									jQuery('#url').tipsy({trigger: 'focus', gravity: 'n'});
								}
								else if(data.status == 'already')
								{
									jQuery('#url').attr('title', 'Ссылка уже была в базе!');								
									jQuery('#url').tipsy({trigger: 'focus', gravity: 'n'});
								}
								else
								{
									jQuery('#url').attr('title', 'Что-то пошло не так...');								
									jQuery('#url').tipsy({trigger: 'focus', gravity: 'n'});
								}									
								
								jQuery("#url").select();
								
								jQuery("#loading").html('');
							}, 'json');
							
					}
					
					return false;
				});
			});
		</script>
	</head>
	<body class="background">
		<div id="content">