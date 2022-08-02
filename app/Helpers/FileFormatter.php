<?php

namespace App\Helpers;

/**
 * Format file name.
 */
class FileFormatter
{
	public static function name($path = '')
	{
		return request()->getHttpHost() . '/storage/' . $path;
	}
}