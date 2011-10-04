<?php $this->load->helper('form'); ?>

<h2>already registered?</h2>

<?= form_open('register/login'); ?>
    <?= form_label('email address', 'email') ?>
    <?= form_input('email') ?>
    
    <?= form_label('password', 'password') ?>
    <?= form_input('password') ?>
    
    <?= form_submit('submit', 'Login') ?>
<?= form_close(); ?>

<?= form_open('register'); ?>
    <?= form_label('title', 'title') ?>
    <?= form_dropdown('title', array('Mr', 'Mrs', 'Ms', 'Miss'), array('Mr')); ?>
    
    <?= form_label('first name', 'first_name') ?>
    <?= form_input('first_name') ?>
    
    <?= form_label('last name', 'last_name') ?>
    <?= form_input('last_name') ?>
    
    <?= form_label('retail group', 'retail_group') ?>
    <?= form_dropdown('retail_group', $groups) ?>

    <?= form_label('store name', 'store') ?>
    <?= form_dropdown('store', array('Please choose a retail group')) ?>
    
    <?= form_label('email', 'email') ?>
    <?= form_input('email') ?>
    
    <?= form_label('repeat email', 'repeat_email') ?>
    <?= form_input('repeat_email') ?>
<?= form_close(); ?>