<?php
/**
 * Fired during plugin deactivation
 */

class StayDesk_Deactivator {
    
    public static function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}
