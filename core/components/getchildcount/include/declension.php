<?php
/*
 * Get the column names for a mysql table MODX
 * This algorithm taken from https://github.com/
 *
 * @param string $tablenames 
 * table name without a prefix
 * @param string $lang
 *
 * @return string
 * */
function getColumns($tablenames) {
    try {
        global $modx;
        global $table_prefix; // get the table prefix
        // add a prefix to the database name
        $tablenames=$table_prefix.$tablenames;
        /*require_once MODX_BASE_PATH.'/config.core.php';
        require_once MODX_CORE_PATH.'model/modx/modx.class.php';
        $condb = new modX();        
        //debug connection
        $modx->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $modx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/
        // get column names
        $query = $modx->prepare("DESCRIBE $tablenames");
        $query->execute();
        $table_names = $query->fetchAll(PDO::FETCH_COLUMN);
        return $table_names;
        //Close connection
        /*$condb = null;*/
    } catch(PDOExcepetion $e) {
        echo $e->getMessage();
    }
}