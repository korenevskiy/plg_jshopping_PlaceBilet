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
defined('_JEXEC') or die;
return;


/**
 * Список расширений и их расположения для последующего архивирования
 */
$pathExtentions = [];				//список Расширений для отдельного архивирования в пакет.
$pathExtentions['mod_PlaceBilet_tickets_5.1'] = realpath(__DIR__ . '/../../administrator/modules/mod_placebilet/');
$pathExtentions['plg_PlaceBilet_tickets_5.1'] = realpath(__DIR__ . '/placebilet/');

/**
 * Список расширений предназначенных копирования(разархивирования) в место папку пакета, с указанием нового имени
 */
$copyExtentions = [];
$copyExtentions['mod_PlaceBilet_tickets_5.1'] = __DIR__ . '/mod_placebilet';
$copyExtentions['plg_PlaceBilet_tickets_5.1'] = __DIR__ . '/plg_placebilet';


//$renameFolder = [];
//$renameFolder['mod_PlaceBilet_tickets_5.1'] = __DIR__;



$pathPackage = __DIR__;				//Папка располждения пакета
$packageName = 'pkg_PlaceBilet';	//Имя пакета. Требует такого же XML

//echo "<pre>";






/**
 * Архив пакета всех файлов всех расширений
 */
$zipPackage = new zip();
$zipPackage->open($pathPackage . "/$packageName.zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);
$zipPackage->addFile($pathPackage . "/$packageName.xml", "$packageName.xml");

/**
 * Список файлов для отображения результата в ответе
 */
$files = [];
$files[] = "/$packageName.zip";
$files[] = "$packageName.xml";

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
	
	$zipfile = new zip();
	$zipfile->open($pathPackage . "/$nameExt.zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);
	$zipfile->addDirectoryWithAllFiles($pathExt,$pathExt);
	$zipfile->close();
	
	$zipPackage->addFile($pathPackage . "/$nameExt.zip", "$nameExt.zip");
	$files[] = "$nameExt.zip --> count:" . count($minimizationLanguageCount);
}
$zipPackage->close();

/**
 * Извлекаем обратно архив расширения в папку где расположен пакет
 */
foreach ($copyExtentions as $nameExt => $pathExt){
	$pathArchive = $pathPackage . "/$nameExt.zip";//$pathExtentions[$nameExt]
	
	$zipfile = new zip();
	$zipfile->open($pathPackage . "/$nameExt.zip");
	$zipfile->extractTo($copyExtentions[$nameExt], null);
	$zipfile->close();
}



//echo "<br>";

header('Content-Type: application/json; charset=utf-8');
echo json_encode($files, JSON_PRETTY_PRINT);

//echo "</pre>";



class zip extends ZipArchive{
	/**
	 * 
	 * @param string $dir			Папка для архивирования , если пусто, то содержимое будет не сама папка а содержимое этой папки в архиве
	 * @param string $start = ''	Папка для указания архивирования только содержимого
	 */
	function addDirectoryWithAllFiles($dir, $start = ''){
		if (empty($start)) 
			$start = dirname($dir);
	
		if ($objs = glob($dir . '/*')) {
			foreach($objs as $obj) { 
				if (is_dir($obj))
					$this->addDirectoryWithAllFiles($obj, $start);
				else
					$this->addFile($obj,	str_replace(($start) . '/', '', $obj)	);
			}
		}
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