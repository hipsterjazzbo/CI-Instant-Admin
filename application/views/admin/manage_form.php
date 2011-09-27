<?php $this->load->helper('form'); ?>
<?php $this->load->view('admin/common/header'); ?>

			<article class="module width_full">
				<header><h3>Edit Record</h3></header>
				<?= form_open('email/send') ?>
					<div class="module_content">
						<?php foreach($form_fields as $form_field): ?>
							<fieldset>
								<label><?= $form_field['label'] ?></label>
								<input type="<?= $form_field['type'] ?>" name="<?= $form_field['db_field'] ?>" value="<?= $row->$form_field['db_field'] ?>">
							</fieldset>
						<?php endforeach; ?>
						<div class="clear"></div>
					</div>
					<footer>
						<div class="submit_link">
							<input type="submit" value="Publish" class="alt_btn">
							<input type="reset" value="Reset">
						</div>
					</footer>
				<?= form_close() ?>
			</article>

<?php $this->load->view('admin/common/footer'); ?>