<?php
/**
 * @package  SchemaldPlugin
 */

class SchemaldPluginDeactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
	}
}
