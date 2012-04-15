<?php
/**
 * Logout script
 * 
 * @author Prayas Bhattarai 
 */
include_once('core/config.php');
    session_start();
    session_cache_expire(30);
    session_unset();
    session_destroy();
    session_write_close();
    header('Location: '.BASE_DIR.DS.'login.php');
?>