<?php

/**
 * Utilities shared across classes for EXPORT
 */
class EPIE_Utilities_Export {
	/*
	 * Check if current user can run export 
	 */
	public static function can_export() {
		return EPIE_Utilities::is_admin();
	}
}
