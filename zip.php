<?php
 /** ----------------------------------------------------------------------
 * plg_PlaceBilet - Упаковщик для расширения архивирует а потом архивирует архивы в один с добавлением файла XML и прочего
 * Потом разархивирует архивы в новое место где располагается папка пакета
 * В результате в новой папке пакета находятся архивы и папки расширений
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @package plg_PlaceBilet
 * Websites: //explorer-office.ru/download/joomla/category/view/1
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 **/ 
//defined('_JEXEC') or die;
//return;

header('Content-Type: application/json; charset=utf-8');


/**
 * Список расширений и их расположения для последующего архивирования
 */		/** @var array $pathExtentions */
$pathExtentions = [];				//список Расширений для отдельного архивирования в пакет.
$pathExtentions['mod_PlaceBilet_tickets'] = realpath(__DIR__ . '/../../administrator/modules/mod_placebilet/');
$pathExtentions['plg_PlaceBilet_tickets'] = realpath(__DIR__ . '/placebilet/');

/**
 * Список расширений предназначенных копирования(разархивирования) в место папку пакета, с указанием нового имени
 */		/** @var array $copyExtentions */
$copyExtentions = [];
$copyExtentions['mod_PlaceBilet_tickets'] = __DIR__ . '/mod_placebilet';
$copyExtentions['plg_PlaceBilet_tickets'] = __DIR__ . '/plg_placebilet';

$filesIgnore = [];
$filesIgnore[] = 'ControllerA/StatisticsController.php';

//echo json_encode($verExtentions, JSON_PRETTY_PRINT);return;

//$renameFolder = [];
//$renameFolder['mod_PlaceBilet_tickets_5.1'] = __DIR__;



/** @var array $pathPackage */
/** @var array $packageName */
$pathPackage = __DIR__;				//Папка располждения пакета
$packageName = 'pkg_PlaceBilet';	//Имя пакета. Требует такого же XML

//echo "<pre>";


/** 
 * Список версий расширений
 */		/** @var array $verExtentions */
$verExtentions = [];
foreach ($pathExtentions as $ext => $pathExt){
	$name = basename($pathExt.'/');
	$xmlExt = $pathExt . '/' . $name . '.xml';
	if(! file_exists($xmlExt))
		continue;
	$xmlExt = simplexml_load_file($xmlExt);
	$verExtentions[$ext] = (string)$xmlExt->version;
}




/**
 * Архив пакета всех файлов всех расширений
 */		/** @var ZipArchive $zipPackage */
$zipPackage = new zip();
$zipPackage->open($pathPackage . "/$packageName.zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);
$zipPackage->addFile($pathPackage . "/$packageName.xml", "$packageName.xml");

/**
 * Список файлов для отображения результата в ответе
 */
$files = [];
$files[] = "/$packageName.zip";
$files[] = "/$packageName.xml";

$i = 0;

/**
 * Архивируем расширения и добавляем архив расширения в архив пакета
 */
foreach ($pathExtentions as $nameExt => $pathExt){
	$minimizationLanguageCount = &HelperMinification::languageMinificationRaw($pathExt.'/language/');
//	$minimizationLanguageCount[] = ++$i;
	
//echo "<br>";
//echo $pathExt.'/language';
//echo json_encode($minimizationLanguageCount, JSON_PRETTY_PRINT) . ' ' .  ++$i;
//echo json_encode($minimizationLanguageCount, JSON_PRETTY_PRINT);
	
	
	/** @var ZipArchive $zipfile */
	$zipfile = new zip();
	$zipfile->open("$pathPackage/{$nameExt}_{$verExtentions[$nameExt]}.zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);
	$isIgnoreFiles = 
		$zipfile->addDirectoryWithAllFiles($pathExt, $pathExt, $filesIgnore);
	$zipfile->close();
	
	$files["{$nameExt}_{$verExtentions[$nameExt]}.zip"] = $isIgnoreFiles;
	
	if($isIgnoreFiles){
		$zipfile->open("$pathPackage/{$nameExt}_{$verExtentions[$nameExt]}_full.zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);
		$zipfile->addDirectoryWithAllFiles($pathExt, $pathExt);
		$zipfile->close();
		$files[] = "{$nameExt}_{$verExtentions[$nameExt]}_full.zip --> languages:" . count($minimizationLanguageCount);
	}
	
	$zipPackage->addFile("$pathPackage/{$nameExt}_{$verExtentions[$nameExt]}.zip", "{$nameExt}_{$verExtentions[$nameExt]}.zip");
	$files[] = "{$nameExt}_{$verExtentions[$nameExt]}.zip      --> languages:" . count($minimizationLanguageCount);
}
$zipPackage->close();

//scandir($dir,  SCANDIR_SORT_NONE);
//$files = [];
//foreach (scandir(__DIR__,  SCANDIR_SORT_NONE) as $i => $file){
//	$files[$file] = is_dir($file);
//}
//echo json_encode($files, JSON_PRETTY_PRINT);
//echo json_encode(scandir(__DIR__,  SCANDIR_SORT_NONE), JSON_PRETTY_PRINT);
//return;
//echo json_encode($copyExtentions, JSON_PRETTY_PRINT);return;

/**
 * Извлекаем обратно архив расширения в папку где расположен пакет
 */
foreach ($copyExtentions as $nameExt => $pathExt) {
//	$pathArchive = $pathPackage . "/$nameExt.zip";//$pathExtentions[$nameExt]
	$zipfile = new zip();
	
	if(is_dir($pathExt.'/'))
		removeDirectory($pathExt.'/');
	
	if($err = $zipfile->open(__DIR__ . "/{$nameExt}_{$verExtentions[$nameExt]}.zip") && mkdir(basename($pathExt).'/')){//, 0777, true
		
		$zipfile->extractTo($pathExt);	// $pathPackage.'/'.
$files[$nameExt] = '/'.basename($pathExt) . '/ '.($err === true ? ' OK ' : $err);
		$zipfile->close();
	}
}



//echo "<br>";

//header('Content-Type: application/json; charset=utf-8');
echo json_encode($files, JSON_PRETTY_PRINT);

//echo "</pre>";

function removeDirectory($dir) {  
    $files = glob($dir . '/*');  
    foreach ($files as $file) {  
        is_dir($file) ? removeDirectory($file) : unlink($file);  
    }
    return rmdir($dir);
}  


class zip extends ZipArchive{
	/**
	 * 
	 * @param string $dir				Папка для архивирования , если пусто, то содержимое будет не сама папка а содержимое этой папки в архиве
	 * @param string $removeSfx = ''	Часть пути который будет удаляться в каждом пути файла в архиве, иначе в архиве будет полный путь файла из файловой системы.
	 * @param array $filesExclusion 	файлы исклющающиеся из архивирования ['mod_extension.xml','src/Field/button.php']
	 * @return array					Список файлов которые найдены и исключились из архива
	 */
	function addDirectoryWithAllFiles($dir, $removeSfx = '', $filesExclusion = []){
		if (empty($removeSfx)) 
			$removeSfx = dirname($dir);
		
		$filesExcluded = [];
		
		foreach(glob($dir . '/*') ?: [] as $path) {
			if (is_dir($path))
				$filesExcluded = array_merge($filesExcluded, $this->addDirectoryWithAllFiles($path, $removeSfx, $filesExclusion));
			else{
				$name = str_replace($removeSfx . '/', '', $path);
				if(in_array($name, $filesExclusion)){
					$filesExcluded[] = $name;
				}
				else
					$this->addFile($path, $name);
			}
		}
		return $filesExcluded;
	}
}



class HelperMinification{


	public static function languageMinificationRaw($pathLanugageDir = ''){
		
		
//		$lang = JFactory::getApplication()->getLanguage();
		
		$default_path = $pathLanugageDir ?: __DIR__;
		
//		$dir = getcwd();
		
		$dir = $default_path;
		
		while(!file_exists($dir . '/language')){
			$dir = dirname($dir);
		}

		$dir .= '/language/*';
		
//		$files = Joomla\Filesystem\Folder::files($dir, "raw.ini", true, true);
		
//		$dirs = scandir($dir,  SCANDIR_SORT_NONE);
//		$dirs = glob($dir . '/*');
//		$dirs = array_filter(glob('*'), 'is_dir');
		
		$files = [];
		
		foreach (array_filter(glob($dir), 'is_dir') as &$dir){
			foreach (glob($dir.'/*.raw.ini') as $file){
				$text = file_get_contents($file);
				$countLines = count(explode("\n", $text));
				$text = str_replace("\n[", "[{<!>}][", $text);			//	\n[		-
				$text = str_replace("]\n", "][{<!>}]", $text);			//	]\n		-
				$text = str_replace("]\r", "][{<!>}]", $text);			//	]\r		-
				$text = str_replace("\";\r\n", "\";[{<!>}]", $text);	//	";\r\n	-
				$text = str_replace("\";\n", "\";[{<!>}]", $text);		//	";\n	-
				$text = str_replace("\";\r", "\";[{<!>}]", $text);		//	";\r	-
				
				$text = str_replace("\"\r\n", "\"[{<!>}]", $text);		//	"\r\n	-
				$text = str_replace("\"\n", "\"[{<!>}]", $text);		//	"\n		-
				$text = str_replace("\"\r", "\"[{<!>}]", $text);		//	"\r		-
				
				$text = str_replace("\r\n", '', $text);					//	\r\n	-
				$text = str_replace("\n", '', $text);					//	\n		-
				$text = str_replace("\r", '', $text);					//	\r		-
				$text = str_replace('[{<!>}]', PHP_EOL, $text);			
				$file = str_replace('.raw.ini', '.ini', $file);
				$f = file_put_contents($file, $text);
				$file = str_replace(__DIR__ . '/../../../../../', '.ini', $file);
				
				
				$countLines2 = count(explode("\n", $text));
//				$files[] = str_replace($default_path, '', $file) ." -- count:$countLines , newCount:$countLines2";
				$files[str_replace($default_path, '', $file)] = " -- count:$countLines , newCount:$countLines2";
			}
		}
		return $files;
	}
}
return;