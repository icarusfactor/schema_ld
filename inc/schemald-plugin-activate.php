<?php
/**
 * @package  SchemaldPlugin
 */

class SchemaldPluginActivate
{
	public static function activate() {
		flush_rewrite_rules();
	}
}
