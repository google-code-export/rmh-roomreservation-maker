<?php
/**
 * Logout script
 * 
 * @author Prayas Bhattarai 
 */

    session_start();
    session_cache_expire(30);
    session_unset();
    session_destroy();
    session_write_close();
    header('Location:login.php');
?>