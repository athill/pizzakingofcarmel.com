<?php

class Utils {

	function setJson($file, $data) {
		// echo $file;
		file_put_contents($file, json_encode($data));
	}

	function getJson($file) {
		return json_decode(file_get_contents($file), true);
	}

	function copyDirRecursive($source, $dest) {
		foreach (
					$iterator = new RecursiveIteratorIterator(
					new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
					RecursiveIteratorIterator::SELF_FIRST) as $item
				) {
			$file = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
			echo $file.'<br>';
			if ($item->isDir()) {
				if (!file_exists($file)) {
					mkdir($file);
				}
			} else {
				copy($item, $file);
			}
		}		
	}

    function emptyDirectory($dirname,$self_delete=false) {
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file))
					@unlink($dirname."/".$file);
				else
					$this->emptyDirectory($dirname.'/'.$file,true);
			}
		}
		closedir($dir_handle);
		if ($self_delete){
			@rmdir($dirname);
		}
		return true;
    }	

	function getFilename($filename) {
		global $site;
		return (strpos($filename, '/') == 0) ? 
			$site['fileroot'].$filename : 
			$filename;
	}

/**
 * TODO: Test and 
 */
	
	// function listfilesin1 ($dir = ".", $depth=0) {
	//     echo "Dir: ".$dir."<br/>";
	//     foreach(new DirectoryIterator($dir) as $file) {
	//         if (!$file->isDot()) {
	//             if ($file->isDir()) {
	//                 $newdir = $file->getPathname();
	//                 listfilesin1($newdir, $depth+1);
	//             } else {
	//                 echo "($depth)".$file->getPathname() . "<br/>";
	//             }
	//         }
	//     }
	// }
	// function listfilesin2 ($dir = ".", $depth=0) {
	//     echo "Dir: ".$dir."<br/>";
	//     foreach(new RecursiveDirectoryIterator($dir) as $file) {
	//         if ($file->hasChildren(false)) {
	//             $newdir = $file->key();
	//             listfilesin2($newdir, $depth+1);
	//         } else {
	//             echo "($depth)".$file->key() . "<br/>";
	//         }
	//     }
	// }	

}
?>