<?php

class Utils {

	function setJson($file, $data) {
		// echo $file;
		file_put_contents($file, json_encode($data));
	}

	function getJson($file) {
		return json_decode(file_get_contents($file), true);
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