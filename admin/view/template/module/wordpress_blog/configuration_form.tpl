<?php echo $header; ?>
<script>
$(document).ready( function(){
	// Set Tabulasi
	$('#languages a').tabs();
	
	$('button, .buttons a').button();
	
	Feedback= {
		'container': null,
		'default': function(data){
			console.log("Default");
		},
		handleErrors: function(data){
			msg_num= 0;
			$.each(data, function(key, value){
				msg_num++;
				if( typeof(value) === "object" ){
					$.each(value, function(subkey, subvalue){
						console.log(typeof(subkey));
						error_msg= "";
						for(var i = 0, l = subvalue.length; i < l; i++) {
							error_msg+= '<div>'+subvalue[i]+'</div>';
							
						}
						$('<div class="error">'+error_msg+'</div>').insertAfter($('input[name="' + key + 
						'[' + subkey + ']"]'));
					});
				}else{
					$('<div class="error">'+value+'</div>').insertAfter($('input[name="' + key + '"]'));
					console.log(key + ': ' + value);
				}
			});
			
			if( msg_num != 0 ){
				alert("There're still errors. Please correct it.");
			}
		},
		'save': function(response){
			console.log(response);
			if( response.type == "error" ){
				this.handleErrors(response.data);
			}else if( response.type == "warning" ){
				$('<div class="warning">'+response.data+'</div>').insertBefore($('.box'));
			}else if( response.type == "redirect" ){
				if( response.url == "" ){
					window.location.reload();
				}else{
					window.location.href= decodeURIComponent(response.url);
				}
			}
		},
	}
	
	Ajax= {
		'type': "default",
		beforeSend: function(){
			$('.error, .warning').remove();
		},
		send: function(url, data){
			AjaxObj= this;
			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: url,
				data: data,
                beforeSend: function(){
					AjaxObj.beforeSend();
					AjaxObj.blockUI();
                },
                complete: function(){
					AjaxObj.unBlock();
                },
				success: function(data){
					type= AjaxObj.type;
					Feedback[type](data);
				}
			});
		},
		blockUI: function(){
			$.blockUI({ 
				message: '<h1>Loading...</h1>',
			});
		},
		unBlock: function(){
			$.unblockUI(); 
		},
	}
	
	$('#btn-save').live('click', function(e){
		$('#form').submit();
	})	
})
</script>
<style>
.ui-button-text-only .ui-button-text {
padding: .2em 1em;
}
.label,
.badge {
  display: inline-block;
  padding: 2px 4px;
  font-size: 11.844px;
  font-weight: bold;
  line-height: 14px;
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  white-space: nowrap;
  vertical-align: baseline;
  background-color: #999999;
}

.label {
  -webkit-border-radius: 3px;
     -moz-border-radius: 3px;
          border-radius: 3px;
}

.badge {
  padding-right: 9px;
  padding-left: 9px;
  -webkit-border-radius: 9px;
     -moz-border-radius: 9px;
          border-radius: 9px;
}

.label:empty,
.badge:empty {
  display: none;
}

a.label:hover,
a.label:focus,
a.badge:hover,
a.badge:focus {
  color: #ffffff;
  text-decoration: none;
  cursor: pointer;
}
.label-info,
.badge-info {
  background-color: #3a87ad;
}
.label-info a {
color: #FFF;
cursor: pointer;
border-color: rgba(0, 0, 0, 0);
-webkit-border-radius: 0;
-moz-border-radius: 0;
border-radius: 0;
}
.label-info a:hover, .label-info a:focus {
color: #FFF;
text-decoration: underline;
background-color: rgba(0, 0, 0, 0);
}
</style>
<div id="content">
	<div class="breadcrumb">
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
	<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<div class="box">
		<div class="heading">
		<h1><img src="view/image/user.png" alt="" /> <?php echo $heading_title; ?></h1>
		<div class="buttons">
<!--		<a onclick="$('#form').submit();" class="button" id="btn-save"><?php echo $button_save; ?></a>		-->
		<a class="" id="btn-save"><?php echo $button_save; ?></a>
		<a href="<?php echo $cancel; ?>" class="" id="btn-cancel"><?php echo $button_cancel; ?></a>
		</div>
		</div>
		<div class="content">
		<?php
		extract($modules);
		?>
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<table class="form">
<!--			<tr>
				<td>
				<label for="wordpress_url_feed">
				<span class="required">*</span> <?php echo $text_wordpress_url_feed; ?>
				</label>
				</td>
				<td>
				<input type="text" name="wordpress_url_feed" id="wordpress_url_feed" size="100" 
				value="<?php echo isset($wordpress_url_feed) ? $wordpress_url_feed : ""; ?>" />
				<?php if( isset($errors['wordpress_url_feed']) ){ ?>
				<span class="error"><?php echo $errors['wordpress_url_feed']; ?></span>
				<?php } ?>
				</td>
			</tr>-->
			<tr>
				<td>
				<label for="number_of_post_article">
				<span class="required">*</span> <?php echo $text_number_of_post_article; ?>
				</label>
				</td>
				<td>
				<input type="text" name="number_of_post_article" id="number_of_post_article" size="100" 
				value="<?php echo isset($number_of_post_article) ? $number_of_post_article : ""; ?>" />
				<?php if( isset($errors['number_of_post_article']) ){ ?>
				<span class="error"><?php echo $errors['number_of_post_article']; ?></span>
				<?php } ?>
				</td>
			</tr>
			<tr>
				<td>
				<div>
				<label for="format_date">
				<span class="required">*</span> <?php echo $text_format_date; ?>
				</label>
				</div>
				</td>
				<td>
				<div>
				<input type="text" name="format_date" id="format_date" size="100" 
				value="<?php echo isset($format_date) ? $format_date : ""; ?>" />
				<?php if( isset($errors['format_date']) ){ ?>
				<span class="error"><?php echo $errors['format_date']; ?></span>
				<?php } ?>
				</div>
				<div>
				<span class="label label-info"><?php echo $text_format_date_url; ?></span>
				</div>
				</td>
			</tr>
			<tr>
				<td>
				<label for="length_description">
				<span class="required">*</span> <?php echo $text_length_description; ?>
				</label>
				</td>
				<td>
				<input type="text" name="length_description" id="length_description" size="100" 
				value="<?php echo isset($length_description) ? $length_description : ""; ?>" />
				<?php if( isset($errors['length_description']) ){ ?>
				<span class="error"><?php echo $errors['length_description']; ?></span>
				<?php } ?>
				</td>
			</tr>
			</table>
			</form>
		</div>
	</div>
</div>
<?php echo $footer; ?> 