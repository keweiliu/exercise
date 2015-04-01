<?php
function add_player($file_name) {
    if (! file_exists ( $filename )) {
        return false;
    }
    try {
        $file = fopen ( $file_name, 'r' );
        $key = fgetcsv ( $file );
    } catch ( Exception $e ) {
        return $e->getMessage ();
    } finally {
        if ($file) {
            $file . close ();
        }
    }
    with();
}
function run() {
}