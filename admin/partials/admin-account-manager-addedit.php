<?php
	/**
	 * Provide a dashboard view for the plugin
	 *
	 * This file is used to markup the public-facing aspects of the plugin.
	 *
	 * @link       https://codeboxr.com
	 * @since      1.0.7
	 *
	 * @package    Cbxwpsimpleaccounting
	 * @subpackage Cbxwpsimpleaccounting/admin/partials
	 */

	if ( ! defined( 'WPINC' ) ) {
		die;
	}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<div id="cbxaccountingloading" style="display:none"></div>
	<h1 class="wp-heading-inline wp-heading-inline-account-edit"><?php esc_html_e( 'CBX Accounting: Add/Edit Account', 'cbxwpsimpleaccounting' ); ?></h1>
	<p>
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=cbxwpsimpleaccounting_accmanager' ) ); ?>"
		   class="button button-primary" role="button"><?php esc_html_e( 'Go Back to Account Manager', 'cbxwpsimpleaccounting' ) ?></a> <?php echo '<a class="button" href="' . admin_url('admin.php?page=cbxwpsimpleaccounting_accmanager&view=addedit') . '">' . esc_attr__('Add New Account', 'cbxwpsimpleaccounting') . '</a>'; ?>
	</p>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-1">

			<!-- main content -->
			<div id="post-body-content">
				<div id="cbxaccounting_accmanager" class="meta-box-sortables ui-sortable">

					<div class="postbox">
						<?php $submit_btn_value = $acc_data['id'] > 0 ? esc_html__( 'Edit Account', 'cbxwpsimpleaccounting' ) : esc_html__( 'Add Account', 'cbxwpsimpleaccounting' ); ?>
						<h3><span><?php echo $submit_btn_value; ?></span></h3>
						<div class="inside">
							<div id="cbxwpsimpleaccounting">
								<form id="cbacnt-account-form" class="form-horizontal" action="" method="post">
									<div class="cbacnt-msg-box below-h2">
										<p class="cbacnt-msg-text">
											<?php
												if ( isset( $_SESSION['cbxwpsimpleaccounting_log_addeditresponse'] ) ) {
													$validation_errors = $_SESSION['cbxwpsimpleaccounting_log_addeditresponse'];
													if ( is_array( $validation_errors ) && sizeof( $validation_errors ) > 0 ) {
														foreach ( $validation_errors as $validation_error ) {
															echo '<div class="alert alert-info" role="alert"><p>' . $validation_error['msg'] . '</p></div>';
														}
													}

													unset( $_SESSION['cbxwpsimpleaccounting_log_addeditresponse'] );
												}

											?>
										</p>
									</div>
									<input name="cbacnt-acc-id" id="cbacnt-acc-id" type="hidden" value="<?php echo $acc_data['id']; ?>" />
									<?php wp_nonce_field( 'add_new_acc', 'new_acc_verifier' ); ?>

									<div class="form-group">
										<label class="cbacnt-acc cbacnt-label col-sm-2 control-label" for="cbacnt-acc-title"><?php esc_html_e( 'Title', 'cbxwpsimpleaccounting' ); ?></label>
										<div class="col-sm-10 error_container">
											<input name="cbacnt-acc-title" id="cbacnt-acc-title" type="text" value="<?php echo $acc_data['title']; ?>" class="cbacnt-acc regular-text form-control" placeholder="<?php esc_html_e( 'Title', 'cbxwpsimpleaccounting' ); ?>" data-rule-required="true"  data-rule-minlength="5" data-rule-maxlength="200" autofocus />
										</div>
									</div>
									<div class="form-group">
										<label class="cbacnt-acc cbacnt-label col-sm-2 control-label"
											   for="cbacnt-acc-type"><?php esc_html_e( 'Type', 'cbxwpsimpleaccounting' ); ?></label>

										<div class="col-sm-10 error_container">
											<label for="cbacnt-acc-type-cash" class="radio-inline">
												<input type="radio" name="cbacnt-acc-type" class="cbacnt-acc-type"
													   id="cbacnt-acc-type-cash" required
													   value="cash" <?php if ( $acc_data['type'] === 'cash' ) {
													echo 'checked';
												} ?>/><span
													class="cbacnt-acc-type-cash-color"><?php esc_html_e( 'Cash', 'cbxwpsimpleaccounting' ); ?></span>
											</label>

											<label for="cbacnt-acc-type-bank" class="radio-inline">
												<input type="radio" name="cbacnt-acc-type" class="cbacnt-acc-type"
													   id="cbacnt-acc-type-bank" required
													   value="bank" <?php if ( $acc_data['type'] === 'bank' ) {
													echo 'checked';
												} ?>/><span
													class="cbacnt-acc-type-bank-color"><?php esc_html_e( 'Bank', 'cbxwpsimpleaccounting' ); ?></span>
											</label>
										</div>
									</div>

									<?php
										$bank_entry_display = '';
										if ( $acc_data['type'] === 'cash' ) {
											$bank_entry_display = 'display: none';
										}
									?>

									<div class="form-group cbxacc_bankdetails" style="<?php echo $bank_entry_display; ?>">
										<label class="cbacnt-acc cbacnt-label col-sm-2 control-label"
											   for="cbacnt-acc-acc-no"><?php esc_html_e( 'Account No.', 'cbxwpsimpleaccounting' ); ?></label>

										<div class="col-sm-10 error_container">
											<input name="cbacnt-acc-acc-no" id="cbacnt-acc-acc-no" type="text" value="<?php echo $acc_data['acc_no']; ?>"
												   class="cbacnt-acc-acc-no regular-text form-control" placeholder="<?php esc_html_e( 'Account No.', 'cbxwpsimpleaccounting' ); ?>" />
										</div>
									</div>

									<div class="form-group cbxacc_bankdetails" style="<?php echo $bank_entry_display; ?>">
										<label class="cbacnt-acc cbacnt-label col-sm-2 control-label"
											   for="cbacnt-acc-acc-name"><?php esc_html_e( 'Account Name', 'cbxwpsimpleaccounting' ); ?></label>

										<div class="col-sm-10 error_container">
											<input name="cbacnt-acc-acc-name" id="cbacnt-acc-acc-name" type="text"
												   value="<?php echo $acc_data['acc_name']; ?>" class="cbacnt-acc-acc-name regular-text form-control" placeholder="<?php esc_html_e( 'Account Name', 'cbxwpsimpleaccounting' ); ?>" />
										</div>
									</div>

									<div class="form-group cbxacc_bankdetails" style="<?php echo $bank_entry_display; ?>">
										<label class="cbacnt-acc cbacnt-label col-sm-2 control-label"
											   for="cbacnt-acc-bank-name"><?php esc_html_e( 'Bank Name', 'cbxwpsimpleaccounting' ); ?></label>

										<div class="col-sm-10 error_container">
											<input name="cbacnt-acc-bank-name" id="cbacnt-acc-bank-name" type="text"
												   value="<?php echo $acc_data['bank_name']; ?>" class="cbacnt-acc-bank-name regular-text form-control" placeholder="<?php esc_html_e( 'Bank Name', 'cbxwpsimpleaccounting' ); ?>" />
										</div>
									</div>

									<div class="form-group cbxacc_bankdetails" style="<?php echo $bank_entry_display; ?>">
										<label class="cbacnt-acc cbacnt-label col-sm-2 control-label"
											   for="cbacnt-acc-branch-name"><?php esc_html_e( 'Branch Name', 'cbxwpsimpleaccounting' ); ?></label>

										<div class="col-sm-10 error_container">
											<input name="cbacnt-acc-branch-name" id="cbacnt-acc-branch-name" type="text"
												   value="<?php echo $acc_data['branch_name']; ?>" class="cbacnt-acc-branch-name regular-text form-control" placeholder="<?php esc_html_e( 'Branch Name', 'cbxwpsimpleaccounting' ); ?>" />
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-2"></div>
										<div class="col-sm-10">
											<input type="hidden" name="cbxwpsimpleaccounting_acc_addedit" value="1" />

											<?php $submit_btn_value = $acc_data['id'] > 0 ? 'Update account' : 'Add new account' ?>
											<input id="cbacnt-new-acc" class="btn btn-primary" type="submit"
												   name="cbacnt-new-acc"
												   value="<?php esc_html_e( $submit_btn_value, 'cbxwpsimpleaccounting' ); ?>" />

											<a href="<?php echo esc_url( admin_url( 'admin.php?page=cbxwpsimpleaccounting_accmanager' ) ); ?>"
											   class="btn btn-default" role="button"><?php esc_html_e( 'Cancel', 'cbxwpsimpleaccounting' ) ?></a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div> <!-- .inside -->
				</div> <!-- .postbox -->
			</div> <!-- .meta-box-sortables .ui-sortable -->
			<?php
				//include( 'sidebar.php' );
			?>
		</div> <!-- post-body-content -->
	</div> <!-- #post-body .metabox-holder .columns-2 -->
	<div class="clear"></div>
	</div>
</div>
