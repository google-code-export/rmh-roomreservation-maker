<?php
 
/*  Direct access of include files needs to prevented. In order to do that, the following constant defines PARENT.
    Any include page that has header included before, will have this constant defined. If the page is directly accessed,
    PARENT will not be defined. So we can perform this check on the include pages.
 */
    define('PARENT','rmhresmaker');

    include('core/config.php');
    include('core/globalFunctions.php');
    include('core/sessionManagement.php');
    
    include('permission.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo (isset($title) ? $title : 'Welcome') . ' | RMH Room Reservation Maker'; ?> </title>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="<?php echo CSS_DIR;?>/style.css"/>
        <script src="<?php echo JS_DIR;?>/libs/jquery-1.7.2.min.js"></script>
        <script src="<?php echo JS_DIR;?>/form.js"></script>
        <link rel="javascript" href="<?php echo JS_DIR;?>/libs/jquery.simplemodal.1.4.2.min.js"/>
        <link rel="javascript" href="<?php echo JS_DIR;?>/libs/jquery-1.6.2.min.js"/>
    </head>
<body class="<?php // $_ENV['/**browser **/'] ?>">

<div id="header">
    <h1><?php echo $title; ?></h1>
</div>
        <?php
            //show session messages
            showSessionMessage();
        ?>
<?php if(isset($_SESSION['logged_in'])) include_once (ROOT_DIR.'/navigation.php'); ?>