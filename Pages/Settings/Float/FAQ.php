<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once  TWCH_DIR_path.'Classes/DBactions.php';
$current_url_TWCH = '?page=TWCH_settings&tab=Float&sT=FAQ';
if(isset($_GET['Delete'])){
    TWCH_DBactions::Delete(sanitize_text_field($_GET['Delete']),'TWCH_FAQ_',$current_url);
}
if(isset($_POST['submit'])){
	$getEditId_TWCH = sanitize_text_field(( isset( $_GET['Edit'] ) ) ? $_GET['Edit'] : '');
	$fields_TWCH = array(
		'TWCH_FAQ_Question' => sanitize_text_field( $_POST['TWCH_FAQ_Question'] ),
		'TWCH_FAQ_Answer' => sanitize_text_field( $_POST['TWCH_FAQ_Answer'] )
	);
    TWCH_DBactions::Update($fields_TWCH,$getEditId_TWCH,'TWCH_FAQ_',$current_url_TWCH);
}
if(isset($_GET['Edit'])){
    $TWCH_FAQ_Edit = get_option(sanitize_text_field($_GET['Edit']));
}
    
?>
<table class="form-table TWCH-form-table">
    <tbody>
        <tr>
            <th scope="row">
            <?php esc_html_e('Question','TWCHLANG'); ?>
            </th>
            <td>
                <input type="text" name="TWCH_FAQ_Question" value="<?php echo  isset($TWCH_FAQ_Edit) ? esc_attr( $TWCH_FAQ_Edit['TWCH_FAQ_Question'] ) : ''; ?>" required>
            </td>
        <tr>
        <tr>
            <th scope="row">
            <?php esc_html_e('Answer','TWCHLANG'); ?>
            </th>
            <td>
                <textarea name="TWCH_FAQ_Answer" required><?php echo  esc_textarea(isset($TWCH_FAQ_Edit) ? $TWCH_FAQ_Edit['TWCH_FAQ_Answer'] : ''); ?></textarea>
            </td>
        <tr>
    </tbody>
</Table>
<button type="submit" name="submit" class="button button-primary" value="FAQ"><?php isset($_GET['Edit'])? esc_html_e('Save','TWCHLANG') : esc_html_e('Insert','TWCHLANG'); ?></button>
<?php 
	$IDs_list = get_option('TWCH_FAQ_list');
if(!empty($IDs_list)){ ?>
	<table class="wp-list-table widefat striped table-view-list faq_TWCH">
		<tbody>
			<tr>
				<th><?php esc_html_e('Question','TWCHLANG'); ?></th>
				<th><?php esc_html_e('Answer','TWCHLANG'); ?></th>
				<th><?php esc_html_e('Actions','TWCHLANG'); ?></th>
				<?php
				foreach($IDs_list as $id_faq){
					$FAQ_D = get_option($id_faq);
					echo "<tr><td>".esc_html($FAQ_D['TWCH_FAQ_Question'])."</td>";
					echo "<td><p>". esc_html($FAQ_D['TWCH_FAQ_Answer']) ."</p></td>";
					echo "<td>";
					echo "<a href='?page=TWCH_settings&tab=Float&sT=FAQ&Delete=".esc_html($FAQ_D['id'])."'>".esc_html('Delete','TWCHLANG')."</a>";
					echo "<a href='?page=TWCH_settings&tab=Float&sT=FAQ&Edit=".esc_html($FAQ_D['id'])."'>".esc_html('Edit','TWCHLANG')."</a>";
					echo "</td>";
					echo "</tr>";
				}
				?>
			
		</tbody>
	</table>
<?php
}