<?php
namespace ModernMedia\AWSS3;
/**
 * @var Admin\Panel\SettingsPanel $this
 */
$keys = AWSS3Plugin::inst()->get_option_aws_keys();
$plugin = AWSS3Plugin::inst();
?>

<form method="post" action="<?php echo $this->get_panel_url($this->get_id())?>">
	<?php
	$this->echo_nonce();
	?>
	<table class="form-table">
		<tbody>
		<tr>
			<th scope="row">
				<label for="id"><?php _e('Access Key ID')?></label>
			</th>
			<td>
				<input
					class="regular-text"
					type="text"
					name="id"
					id="id"
					value="<?php echo esc_attr($keys->id)?>"
				>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<label for="secret"><?php _e('Access Key Secret')?></label>
			</th>
			<td>
				<input
					class="regular-text"
					type="text"
					name="secret"
					id="secret"
					value="<?php echo esc_attr($keys->secret)?>"
					>
			</td>
		</tr>
		</tbody>
	</table>
	<?php submit_button(__('Save Changes'));?>
</form>

<?php
if ($plugin->is_option_aws_keys_valid()){
	$client = $plugin->get_client();
	$buckets = $client->listBuckets();
	var_dump($buckets);
}
 