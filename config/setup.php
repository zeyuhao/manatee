<?php
# Database Connection
include 'config/connection.php';

# Error strings
include 'config/errors.php';

# Constants:
//DEFINE('D_TEMPLATE', 'template');

# Includes the following:
# functions/page.php;
# functions/user.php;
# functions/validation.php;
# functions/images.php
foreach (glob("functions/*.php") as $filename)
{
    include $filename;
}

# Variables
include 'config/variables.php';
?>