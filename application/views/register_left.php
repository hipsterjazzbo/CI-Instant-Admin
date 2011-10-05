<?php $this->load->helper('form'); ?>

<h2>already registered?</h2>

<?= form_open('register/login', array('id' => 'login-form', 'class' => 'front-form')); ?>
<?= form_label('email', 'email') ?>
<?= form_input('email') ?>

<?= form_label('password', 'password') ?>
<?= form_input('password') ?>

<?= form_submit('submit', 'Login') ?>
<?= form_close(); ?>

<h2>not registered yet?</h2>

<?= validation_errors() ?>

<?= form_open('register', array('id' => 'register-form', 'class' => 'front-form')); ?>
<?= form_label('title', 'title') ?>
<?= form_dropdown('title', array('Mr', 'Mrs', 'Ms', 'Miss'), array('Mr')); ?>

<?= form_label('first name', 'first_name') ?>
<?= form_input('first_name') ?>

<?= form_label('last name', 'last_name') ?>
<?= form_input('last_name') ?>

<?= form_label('retail group', 'retail_group') ?>
<?= form_dropdown('retail_group', $groups) ?>

<?= form_label('store name', 'store') ?>
<?= form_dropdown('store', $stores) ?>

<?= form_label('email', 'email') ?>
<?= form_input('email') ?>

<?= form_label('repeat email', 'repeat_email') ?>
<?= form_input('repeat_email') ?>
<p class="blue"><a href="http://gmail.com/">Don't have an email account? <br>Get a free one here.</a></p>

<?= form_label('mobile', 'mobile') ?>
<?= form_input('mobile') ?>

<?= form_label('work phone', 'work_phone') ?>
<?= form_input('work_phone') ?>

<?= form_label('personal address', 'address_number') ?>
<?= form_input('address_number', 'number') ?>
<?= form_input('address_street', 'street') ?>
<?= form_input('address_suburb', 'suburb') ?>
<?= form_input('address_city', 'city') ?>
<?= form_input('address_postcode', 'postcode') ?>

<?= form_label('password', 'password') ?>
<?= form_password('password') ?>
<?= form_label('repeat password', 'password_conf') ?>
<?= form_password('password_conf') ?>

<?= form_submit('submit', 'register') ?>
<?= form_close(); ?>

<script>
    $(function() {
        $('select[name="retail_group"]').change(function() {
            $('select[name="store"]').html('<option disabled selected>Loading...</option>');
            
            $.post('/ajax/page_model/get_stores', { 'group_id': $(this).val() }, function(data) {
                $('select[name="store"]').html('');
                
                $.each(data, function() {
                    $('select[name="store"]').append('<option value="' + this.store_id + '">' + this.store_name + '</option>');
                });
            }, 'json');
        });
    });    
</script>