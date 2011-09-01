<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Default page
|--------------------------------------------------------------------------
|
| Define a default page to show when none is specified (example.com/admin)
| For example, is you enter 'members', example.com/admin will load from
| example.com/admin/members
|
*/
$config['admin_default_page'] = '';

/*
|--------------------------------------------------------------------------
| Admin Pages
|--------------------------------------------------------------------------
|
| Here is where you can configure your admin pages/sections. For much more 
| detailed documentation, see:
|
|   http://www.someurlorother.com/admin-thing/documentation
|
| First, give your page a unique key:
|
| $config['admin']['UNIQUE_KEY']
|
| This will be used to access the page, i.e. example.com/admin/UNIQUE_KEY.
| Reserved keys are 'edit', 'delete' and 'dashboard', unless you change the
| dashboard() function in controllers/admin.php
|
| Next, configure the other options. 'name' is required. You must also 
| specify either 'view', 'table' or a custom function (see CUSTOM FUNCTIONS
| below). The rest of the fields are optional.
| 
| 'name'        - The human readable name for your page. Used in titles 
|                 and headings. REQUIRED.
|
| 'view'        - The view file you'd like to show for this page.
| 
| 'table'       - The database table you would like to use to populate 
|                 this page.
| 
| 'fields'      - The fields and titles you would like to show on the 
|                 admin page.
|                 @default All fields in table
| 
| 'view_only'   - fields you would like to display, but not make available
|                 for editing. Only really needed when the 'edit' permission 
|                 is set.
|                 @default null
| 
| 'permissions' - Which permissions (buttons) you want to enable for this 
|                 page. Possible values are: 'add', 'edit', 'delete', 'import',
|                 and 'export'. You can also define custom functionality by 
|                 passing in array where the key is a controller/method you 
|                 want the button to link to, and the value is the path to an 
|                 icon to use. Example:
|
| array('edit', array('my_controller/some_method' => 'path/to/icon.gif'));
|                 
|                 @default array('add', 'edit', 'delete')
|
| CUSTOM FUNCTIONS
|
| You can also define a completely custom page by adding a function named
| the same as your page in controllers/admin.php. For example, to define a
| custom function to build 'example.com/admin/members', you add a function
| called members() to controllers/admin.php
|
*/

$fields = array(
	'Name' => 'name', 
	'Account Type' => 'account_type', 
	'Created' => 'date_entered', 
	'Author' => 'created_by'
);
$view_only = array('date_entered', 'created_by');
$permissions = array('edit', 'delete');

$config['admin']['accounts']['table']       = 'accounts';
$config['admin']['accounts']['name']        = 'Accounts';
$config['admin']['accounts']['fields']      = $fields;
$config['admin']['accounts']['view_only']   = $view_only;
$config['admin']['accounts']['permissions'] = $permissions;

$config['admin']['contacts']['view']        = 'contacts';
$config['admin']['contacts']['name']        = 'Contacts';

$config['admin']['custom']['name']          = 'Custom';