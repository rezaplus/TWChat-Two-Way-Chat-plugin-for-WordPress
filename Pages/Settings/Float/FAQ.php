<?php
require_once  DTWP_DIR_path.'Classes/DBactions.php';
$current_url = '?page=DTWP_settings&tab=Float&sT=FAQ';
if(isset($_GET['Delete'])){
    DTWP_DBactions::Delete($_GET['Delete'],'DTWP_FAQ_',$current_url);
}
if(isset($_POST['submit'])){
	$getEditId = ( isset( $_GET['Edit'] ) ) ? $_GET['Edit'] : '';
    DTWP_DBactions::Update($_POST,$getEditId,'DTWP_FAQ_',$current_url);
}
    
if(isset($_GET['Edit'])){
    $DTWP_FAQ_Edit = get_option($_GET['Edit']);
}
    
?>
<table class="form-table dtwp-form-table">
    <tbody>
        <tr>
            <th scope="row">
            <?php esc_html_e('Question','DTWPLANG'); ?>
            </th>
            <td>
                <input type="text" name="DTW_FAQ_Question" value="<?php echo  isset($DTWP_FAQ_Edit) ? esc_attr( $DTWP_FAQ_Edit['DTW_FAQ_Question'] ) : ''; ?>" required>
            </td>
        <tr>
        <tr>
            <th scope="row">
            <?php esc_html_e('Answer','DTWPLANG'); ?>
            </th>
            <td>
                <textarea name="DTW_FAQ_Answer" required><?php echo  esc_textarea(isset($DTWP_FAQ_Edit) ? $DTWP_FAQ_Edit['DTW_FAQ_Answer'] : ''); ?></textarea>
            </td>
        <tr>
    </tbody>
</Table>
<button type="submit" name="submit" class="button button-primary" value="FAQ"><?php isset($_GET['Edit'])? esc_html_e('Save','DTWPLANG') : esc_html_e('Insert','DTWPLANG'); ?></button>
<?php 
	$IDs_list = get_option('DTWP_FAQ_list');
if(!empty($IDs_list)){ ?>
	<table class="wp-list-table widefat striped table-view-list faq_dtwp">
		<tbody>
			<tr>
				<th><?php esc_html_e('Question','DTWPLANG'); ?></th>
				<th><?php esc_html_e('Answer','DTWPLANG'); ?></th>
				<th><?php esc_html_e('Actions','DTWPLANG'); ?></th>
				<?php
				foreach($IDs_list as $id_faq){
					$FAQ_D = get_option($id_faq);
					$Question = esc_html($FAQ_D['DTW_FAQ_Question']);
					$Answer = esc_html($FAQ_D['DTW_FAQ_Answer']);
					$id = esc_html($FAQ_D['id']);
					echo "<tr><td> $Question </td>";
					echo "<td><p> $Answer </p></td>";
					echo "<td>";
					echo "<a href='?page=DTWP_settings&tab=Float&sT=FAQ&Delete=$id'>".__('Delete','DTWPLANG')."</a>";
					echo "<a href='?page=DTWP_settings&tab=Float&sT=FAQ&Edit=$id'>".__('Edit','DTWPLANG')."</a>";
					echo "</td>";
					echo "</tr>";
				}
				?>
			
		</tbody>
	</table>
<?php
}