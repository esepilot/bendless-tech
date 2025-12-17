<?php
/**
 * Fired during plugin deactivation
 */

class BendlessTech_Core_Deactivator {
    
    public static function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}
