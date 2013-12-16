<?php echo $header; ?>
<script>
$(document).ready( function(){
	$('button, .buttons a, .filter a').button();
})
</script>
<script>
$(document).ready( function(){
	$('#btn-add-module').live('click', function(e){
		e.preventDefault();
		num_table_row= parseInt($('#lookbook-module-list tbody tr').length) - 1;
		if( num_table_row > 0 ){
			num_table_row= parseInt($('#lookbook-module-list tbody tr:last-child').attr('data-row-id')) + 1;
		}
		$cloneObj= $('#lookbook-module-list tbody tr:first-child').clone();
		cloneObj_html= String($cloneObj.html());
		new_module= cloneObj_html.replace(/row_id/gi, num_table_row);
		$(new_module).appendTo('#lookbook-module-list tbody')
		.wrapAll('<tr data-row-id="' + num_table_row + '">').find('select, input').removeAttr('disabled');
	})
	
	$('.btn-remove').live('click', function(e){
		e.preventDefault();
		$obj= $(this);
		$obj.parent().parent().remove();
	});
})
</script>
<style>
.list thead td a, .list thead td, .list tfoot td {
padding: 7px;
}
.ui-button-text-only .ui-button-text {
padding: .2em 1em;
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
      <h1><img src="view/image/product.png" alt=""> <?php echo $heading_title; ?></h1>
      <div class="buttons">
	  <a onclick="$('#form').submit();" class=""><?php echo $button_save; ?></a>
	  <a href="<?php echo $cancel; ?>" class=""><?php echo $button_cancel; ?></a>
	  </div>
    </div>
    <div class="content">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<table id="lookbook-module-list" class="list">
			<thead>
			<tr>
<!--			<td><?php echo $entry_category; ?></td>
			<td class="left"><span class="required">*</span> <?php echo $entry_dimension; ?></td>-->
			<td><?php echo $entry_layout; ?></td>
			<td><?php echo $entry_position; ?></td>
			<td><?php echo $entry_type; ?></td>
			<td><?php echo $entry_status; ?></td>
			<td><?php echo $entry_sort_order; ?></td>
			<td>&nbsp;</td>
			</tr>
			</thead>
			<tbody>
			<tr data-row-id="row_id" style="display: none;">
			<td>
			<select name="wordpress_blog_module[row_id][layout_id]" disabled="disabled">
			<?php
			foreach( $layouts as $key=>$layout ){
			?>
				<option value="<?php echo $layout['layout_id']; ?>">
				<?php echo $layout['name']; ?></option>
			<?php
			}
			?>
			</select>
			</td>
			<td>
			<select name="wordpress_blog_module[row_id][position]" disabled="disabled">
			<?php
			foreach( $positions as $key=>$position ){
			?>
				<option value="<?php echo $key; ?>"><?php echo $position; ?></option>
			<?php
			}
			?>
			</select>
			</td>
			<td>
			<select name="wordpress_blog_module[row_id][type]" disabled="disabled">
			<?php
			foreach( $types as $type ){
			?>
				<option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
			<?php
			}
			?>
			</select>
			</td>
			<td>
			<select name="wordpress_blog_module[row_id][status]" disabled="disabled">
			<?php
			$statuses= array("1"=>"enabled", "0"=>"disabled");
			foreach( $statuses as $key=>$value ){
			?>
				<option value="<?php echo $key; ?>"><?php echo ucfirst($value); ?></option>
			<?php
			}
			?>
			</select>
			</td>
			<td class="right">
			<input type="text" name="wordpress_blog_module[row_id][sort_order]" 
			value="" size="3" disabled="disabled" />
			</td>
			<td>
			<a href="#" class="button btn-remove"><?php echo $button_remove; ?></a>
			</td>
			</tr>
			<?php
			foreach( $modules as $row_id=>$conf ){
			?>
				<tr data-row-id="<?php echo $row_id; ?>">
				<td>
				<select name="wordpress_blog_module[<?php echo $row_id; ?>][layout_id]">
				<?php
				foreach( $layouts as $key=>$layout ){
					$selected= "";
					$layout_id= ( isset($conf['layout_id']) ) ? $conf['layout_id']: "";
					if( $layout['layout_id'] == $layout_id ){
						$selected= " selected=\"selected\"";
					}
				?>
					<option value="<?php echo $layout['layout_id']; ?>"<?php echo $selected; ?>>
					<?php echo $layout['name']; ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select name="wordpress_blog_module[<?php echo $row_id; ?>][position]">
				<?php
				foreach( $positions as $key=>$position ){
					$selected= "";
					$cur_position= ( isset($conf['position']) ) ? $conf['position']: "";
					if( $key == $cur_position ){
						$selected= " selected=\"selected\"";
					}
				?>
					<option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $position; ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select name="wordpress_blog_module[<?php echo $row_id; ?>][type]">
				<?php
				foreach( $types as $type ){
					$selected= "";
					$cur_type= ( isset($conf['type']) ) ? $conf['type']: "";
					if( $type == $cur_type ){
						$selected= " selected=\"selected\"";
					}					
				?>
					<option value="<?php echo $type; ?>"<?php echo $selected; ?>><?php echo ucfirst($type); ?></option>
				<?php
				}
				?>
				</select>
				</td>
				<td>
				<select name="wordpress_blog_module[<?php echo $row_id; ?>][status]">
				<?php
				$statuses= array("1"=>"enabled", "0"=>"disabled");
				foreach( $statuses as $key=>$value ){
					$selected= "";
					$status= ( isset($conf['status']) ) ? $conf['status']: "";
					if( $key == $status ){
						$selected= " selected=\"selected\"";
					}
				?>
					<option value="<?php echo $key; ?>"<?php echo $selected; ?>>
					<?php echo ucfirst($value); ?></option>
				<?php
				}
				?>
				</select>						
				</td>
				<td class="right">
				<input type="text" name="wordpress_blog_module[<?php echo $row_id; ?>][sort_order]" 
				value="<?php echo ( isset($conf['sort_order']) ) ?  $conf['sort_order'] : ""; ?>" size="3" />
				</td>
				<td>
				<a href="#" class="button btn-remove"><?php echo $button_remove; ?></a>
				</td>
				</tr>
			<?php
			}
			?>
			</tbody>
			<!-- Button Adding Module -->
			<tfoot>
			<tr>
			<td colspan="5">&nbsp;</td>
			<td>
			<a href="#" id="btn-add-module" class="button"><?php echo $button_add_module; ?></a>
			</td>
			</tr>
			</tfoot>
		</table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>