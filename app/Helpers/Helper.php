<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Helper
{
	public static function deleteFileOnStorage($urlFiles = null)
	{
		// Get storage path to delete the image in storage
		// $prefixPath = request()->getHttpHost() . '/storage/';
		$prefixPath = asset('uploads');
		if (is_array($urlFiles)) {
			foreach ($urlFiles as $urlFile) {
				$storagePath = Str::remove($prefixPath, $urlFile);
				Storage::delete($storagePath);
			}
		} else {
			$storagePath = Str::remove($prefixPath, $urlFiles);
			Storage::delete($storagePath);
		}
	}
}