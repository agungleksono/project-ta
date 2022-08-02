<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Helper
{
	public static function deleteFileOnStorage($urlFile = null)
	{
		// Get storage path to delete the image in storage
		$prefixPath = request()->getHttpHost() . '/storage/';
		$storagePath = Str::remove($prefixPath, $urlFile);
		Storage::delete($storagePath);
	}
}