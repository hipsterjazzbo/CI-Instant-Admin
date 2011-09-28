<?php $this->load->view('admin/common/header'); ?>

			<article class="module width_full">
				<?= $table ?>
			</article><!-- end of stats article -->
			
			<script>
				$(function() {
					$('.action_delete').click(function() {
						if(confirm('Are you sure you want to delete this record?')) {
							window.location = $(this).attr('href');
						}
					});
				});
			</script>
			
<?php $this->load->view('admin/common/footer'); ?>