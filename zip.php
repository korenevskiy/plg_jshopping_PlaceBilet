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



//defined('_JEXEC') or die;	return;

error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: application/json; charset=utf-8');

$Comment = "\n";
$Comment .= "\n Home page: https://explorer-office.ru/download/";
$Comment .= "\n SUPPORTS: ";
$Comment .= "\n GitHub: https://github.com/korenevskiy/plg_jshopping_PlaceBilet ";
$Comment .= "\n ChatMax: https://max.ru/join/l2YuX1enTVg2iJ6gkLlaYUvZ3JKwDFek5UXtq5FipLA";
$Comment .= "\n VK.com: https://vk.com/placebilet";
$Comment .= "\n Telegram: https://t.me/placebilet";

/**
 * Список расширений и их расположения для последующего архивирования
 */		/** @var array $pathExtentions */
$pathExtentions = [];				//список Расширений для отдельного архивирования в пакет.
$pathExtentions['mod_PlaceBilet_tickets']		= realpath(__DIR__ . '/../../administrator/modules/mod_placebilet/');
$pathExtentions['plg_PlaceBilet_tickets']		= realpath(__DIR__ . '/placebilet/');
$pathExtentions['ext_PlaceBilet_statistics']	= realpath(__DIR__ . '/ext_statistics/');


/**
 * Список расширений предназначенных копирования(разархивирования) в место папку пакета, с указанием нового имени
 */		/** @var array $copyExtentions */
$copyExtentions = [];
$copyExtentions['mod_PlaceBilet_tickets'] = __DIR__ . '/mod_placebilet';
$copyExtentions['plg_PlaceBilet_tickets'] = __DIR__ . '/plg_placebilet';

$filesIgnore = [];
$filesIgnore[] = 'ControllerA/StatisticsController.php';


/**
 * Список расширений архивы которых нужно упаковать в главный пакетный архив
 * Ключ: имя расширения, Значение: имя пакета. Требует таких же XML файлов
 */		/** @var array $pathPackages */
$pathPackages=[];
$pathPackages['mod_PlaceBilet_tickets'] = 'pkg_PlaceBilet';
$pathPackages['plg_PlaceBilet_tickets'] = 'pkg_PlaceBilet';

/** @var array $pathPackage */
/** @var array $packageName */
$pathPackage = __DIR__;				//Папка располждения пакета
//$packageName = 'pkg_PlaceBilet';	

//echo json_encode($pathExtentions, JSON_PRETTY_PRINT);
//return;

//$renameFolder = [];
//$renameFolder['mod_PlaceBilet_tickets_5.1'] = __DIR__;



/**
 * Список файлов для отображения результата в ответе
 */
$files = ['__________________'.date('Y-m-d H:i:s', time()).'__________________'];

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


//$packages = array_flip(($pathPackages));//array_unique
foreach (array_flip($pathPackages) as $packageName => $zip){
//	$packages[$packageName] = 
	$zip = new zip();
	$zip->open($pathPackage . "/$packageName.zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);
	
	if(file_exists($pathPackage . "/$packageName.xml")){
		$zip->addFile($pathPackage . "/$packageName.xml", "$packageName.xml");
		
	}
	$files[] = "/$packageName.zip";
	
	foreach ($pathPackages as $ext => $pckName){
		if($packageName == $pckName)
			$pathPackages[$ext] = $zip;
	}
}


/**
 * Архив пакета всех файлов всех расширений
 */		/** @var ZipArchive $zipPackage */
 
$i = 0;

/**
 * Архивируем расширения и добавляем архив расширения в архив пакета
 */
foreach ($pathExtentions as $nameExt => $pathExt){
	$languagesCountMin = HelperMinification::languageMinificationRaw($pathExt.'/language/');
	$langsCount = count($languagesCountMin);
//	$languagesCountMin[] = ++$i;
	
//echo "<br>";
//echo $pathExt.'/language';
//echo json_encode($languagesCountMin, JSON_PRETTY_PRINT) . ' ' .  ++$i;
//echo json_encode($languagesCountMin, JSON_PRETTY_PRINT);
	
	$patNew = $pathPackage . '/' . $nameExt;
	$ver	= $verExtentions[$nameExt] ?? '';
	
	/** @var ZipArchive $zipfile */
	$zipfile = new zip();
	$zipfile->open("$patNew.zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);
	$isIgnoreFiles = 
		$zipfile->addDirectoryWithAllFiles($pathExt, $pathExt, $filesIgnore);
	$zipfile->setArchiveComment("version:$ver \n $nameExt \n$nameExt.zip");
//	$zipfile->comment;
	$zipfile->close();
	
	if(file_exists("$pathPackage/{$nameExt}_{$ver}.zip"))
		unlink("$pathPackage/{$nameExt}_{$ver}.zip");
	
	copy("$patNew.zip", "{$patNew}_{$ver}.zip");
	
	
	$files[] = "{$nameExt}.zip    ".str_pad(' ', strlen($ver))."     --> languages:" . str_pad($langsCount, strlen($langsCount), STR_PAD_LEFT) . ($isIgnoreFiles? "     excluded: ". implode(', ', $isIgnoreFiles) : '');
	$files[] = "{$nameExt}_{$ver}.zip        --> languages:" . str_pad($langsCount, strlen($langsCount)) . ($isIgnoreFiles? "     excluded: ". implode(', ', $isIgnoreFiles) : '');
	
	
	if($isIgnoreFiles){
		$zipfile->open("$pathPackage/{$nameExt}_full.zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);
		$zipfile->addDirectoryWithAllFiles($pathExt, $pathExt);
		$zipfile->close();
		$files[] = "{$nameExt}_full.zip    ".str_pad(' ', strlen($ver))."     --> languages:" . $langsCount;
		
		
		if(file_exists("$pathPackage/{$nameExt}_{$ver}_full.zip"))
			unlink("$pathPackage/{$nameExt}_{$ver}_full.zip");
		
		copy("$pathPackage/{$nameExt}_full.zip", "$pathPackage/{$nameExt}_{$ver}_full.zip");
		$files[] = "{$nameExt}_{$ver}_full.zip        --> languages:" . $langsCount;
	}
	
	
	/** добавление архива расширения в архив пакета */
	if($pathPackages[$nameExt] ?? false){
		$pathPackages[$nameExt]->addFile("$patNew.zip", "$nameExt.zip");
	
		$pathPackages[$nameExt]->setArchiveComment($pathPackages[$nameExt]->comment . " version:$ver \n $nameExt.zip \n\n");
//		$pathPackages[$nameExt]->comment;
	
	}
	
}

foreach (array_unique($pathPackages, SORT_REGULAR) as $zipPackage){
	$zipPackage->setArchiveComment($zipPackage->comment . $Comment);
	$zipPackage->close();
}


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