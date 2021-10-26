<?php
 /** ----------------------------------------------------------------------
 * plg_PlaceBilet - Plugin Joomshopping Component for CMS Joomla
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

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
$s = DS;

$url = $_SERVER['PHP_SELF'];
$url = substr($url,0, strrpos($url,'/')).'/';

//echo "$url <pre>".print_r($_SERVER, TRUE).'</pre>';
//return;
// Арабский ara ar-AA, Хинди hin hi-IN, Бенгальский ben bn-BD, портульгальский  por pt-PT


//https://habr.com/company/alconost/blog/231511/
//https://www.progamer.ru/dev/what-languages.htm
//https://tech.yandex.ru/keys/get/?service=trnsl
//https://www.ethnologue.com/statistics/size


$langin = htmlspecialchars(trim($_GET['langin']??'ru-RU'));
$lang = htmlspecialchars(trim($_GET['lang']??''));
$l = htmlspecialchars(empty($_GET['lang'])?'en-GB':'');
$file = $_GET['file']??'plg_jshopping_PlaceBilet'; 
$file = htmlspecialchars(trim($file));


$lngs = ['en-GB','fr-FR','de-DE','es-ES','pt-PT','zh-CN','it-IT','ja-JP','ko-KR','uk-UA','be-BY','pl-PL','tr-TR','nl-NL','sv-SE', 'ar-AA','hi-IN','bn-BD'];
foreach ($lngs as &$ln){
    $class = ($ln==$lang)?'act':' ';
    $ln_ = "<span class='$class'>$ln</span>";
    $ln = $ln_." <a class='$class' href=\"?langin=$langin&lang=$ln&file=$file\">,</a> ";
}

echo '<style>pre{background-color: #0031;}input{text-align: center;}.act{text-decoration:underline;}</style>';
echo 'Languages: '. implode(' ', $lngs).'<br>' ;//en-GB  fr-FR de-DE es-ES pt-PT it-IT zh-CN ja-JP ko-KR uk-UA be-BY  (pl-PL tr-TR )<br>';
echo "<form ><input name='langin' type='text' value='$langin'size=\"3\"> -->> <input name='lang' type='text' value='$lang$l'size=\"5\">.<input name='file' type='text' value='$file'>.ini <input type='submit' value='Перевести'/></form> <br>";
//$lng = $_SERVER['HTTP_USER_AGENT'];
//echo "<pre>";
//var_dump($_GET);
//echo "</pre>";
//echo "<pre>";
//var_dump($_SERVER);
//echo "</pre>";
//return;


$file_read = __DIR__."$s$langin$s$langin.$file.ini";//plg_jshopping_PlaceBilet.ini

echo "Translate file <span style='opacity:0.4'>".__DIR__."$s$langin$s</span><span>$langin.$file.ini</span><br>";


if(empty($_GET['lang'])) return;

$yandex_translate_key = $key = 'trnsl.1.1.20180430T025945Z.b402f2d0a475de5a.8d099a89dddd7aadaa70ef23c05770d0779db3fe';

list($lng,$lng2) = explode('-', $lang);
$lang = strtolower($lng).'-'.($lng2?strtoupper($lng2):strtoupper($lng));


$file2 = __DIR__.DS.$lang.DS.$lang.".$file.ini";

echo "Language: \$lang: $lang , \$lng: $lng <br>";
echo "<br>$url$lang/$lang.$file.ini<br>";
echo "<br><a href='$url$langin/$langin.$file.ini' target='_blank'>$langin.$file.ini</a><br>";
echo "<br><a href='$url$lang/$lang.$file.ini' target='_blank'>$lang.$file.ini</a><br>";




echo YATranslate('Привет', $lng).'<br>';
//return;

$strings = ParseFile($file_read);

//$strings = array_slice($strings, 0, 10);

//echo " <pre>Count:".count($strings)."  ".print_r($strings, TRUE).'</pre>';

$strings = TranslateArr($strings, $lng);

//echo " <pre>Count:".count($strings)."  ".print_r($strings, TRUE).'</pre>';

//return;

$text = arr2ini($strings);





//echo " <pre>".print_r($text, TRUE).'</pre>';
echo " <pre>Count:".count($strings)."</pre>";
echo " <pre>".print_r($text, TRUE).'</pre>';

//return;

if($lang == 'ru-RU')    return;

if(!is_dir(__DIR__.DS.$lang))
    mkdir (__DIR__.DS.$lang);

file_put_contents($file2, $text, FILE_APPEND);



function TranslateINI($lang = "ru-RU"){
        
        //use Joomla\Registry\Format;
        
//        \Joomla\Registry\Format\Ini::getInstance($type);
//        \Joomla\Registry\Registry::getInstance($id)->toString($format);
        
        
        //$words = JFactory::getLanguage()->load('plg_jshopping_PlaceBilet', __DIR__,'ru-RU');
        
        
        //toPrint($words,'$words Lang');
        
        $file = __DIR__.DS.'ru-RU'.DS.'ru-RU.plg_jshopping_PlaceBilet.ini';
        $ini = file_get_contents($file);
        
        $words = (array) \Joomla\Registry\Factory::getFormat('Ini')->stringToObject($ini);
//        $words = static::stringToObject($ini, ['supportArrayValues' => false,'parseBooleanWords'  => false,'processSections'    => false]);
        
        $words= array_slice($words, 0, 5);
        
        toPrint((array)$words,'$words stringToObject()',0);
        echo "<hr>";
               
//        return;
        foreach($words as $key => $word){
            
            $tran = translate($word,'ru-en');
        
//            var_dump($tran);
//            echo "$key : $word \t\t///  $tran <br>";
//            return;
            $words[$key] = $tran;
        }
        echo "<hr>";
        toPrint($words,'$words',0);
        
        
//        $words = \Joomla\Registry\Registry::getInstance('Bil')->loadFile($file, 'ini');
                
//        toPrint($words->get('JSHOP_TEXT_DISPLAY'),'JSHOP_TEXT_DISPLAY',0);     
//        toPrint($words->get('JSHOP_PLACE_BILET_DESC'),'JSHOP_PLACE_BILET_DESC',0);     
//        toPrint($words->toArray(),'$words Registry()',0);        
        
        echo "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
} 
    
function translate($word, $lang = "en-ru"){
        $key = "trnsl.1.1.20180430T025945Z.b402f2d0a475de5a.8d099a89dddd7aadaa70ef23c05770d0779db3fe";
        $yt_link = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$key."&text=".$word."&lang=$lang&format=plain";
//        $yt_link = "http://translate.yandex.net/api/v1.5/tr.json/getLangs?key=$key&text=$word&lang=".$lang;
//                    http://translate.yandex.net/api/v1.5/tr.json/getLangs? [key=<API-ключ>]& [ui=<код языка>]& [callback=<имя callback-функции>]
//        echo $yt_link;
            
        
//        $result = JFile::read($yt_link);
        $result = getSslPage($yt_link);
        
        toPrint($result,'$result ->'.$word);
        echo $word." - <br>";    
        
//        $ContextOptions= stream_context_create(["ssl"=>["verify_peer"=>false,"verify_peer_name"=>false]]);
//        $result = file_get_contents($yt_link,false, $ContextOptions); // получаем данные в JSON: {"code":200,"lang":"ru-en","text":["Sneakers basketball"]}
        
        $result = json_decode($result, true); // Преобразуем в массив
        //$word = $result['text'][0]; // Sneakers basketball
        
        return $result;
    }
    
function getSslPage($url) {
        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($ch, CURLOPT_HEADER, false);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
}

function YATranslate ($string, $lang2='en', $lang1='ru') {
	global $yandex_translate_key;
        
        static $url ;
        
        $string = urlencode($string);
        
        
        if(empty($url)){
            $url = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=$yandex_translate_key&text=$string&lang=$lang1-$lang2";
//            echo "<br>$url <a href='$url' target='_blank'>link</a><br>"; 
            $request = @file_get_contents($url);
            echo '<pre>'.print_r($request,TRUE).'</pre>';
        }
        else {
            $url = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=$yandex_translate_key&text=$string&lang=$lang1-$lang2";
            $request = @file_get_contents($url);
        }
//        if($request)echo 'TRUE-';
//        else echo 'FALSE-';

//        echo  "$string <br>------------".print_r($request,TRUE)."<br>----------$url <a href='$url' target='_blank'>link</a><br><br>";
//	$request = @file_get_contents($url);

	if ($request) {
		$array = json_decode($request, true);
		$text =  $array['text'][0];
//                echo '------------------------->>>'.print_r($array,TRUE);
	} else {
		$text = $string;
	}
//	return str_replace('"' , '\"' ,$text);//VALID!!!!  JSHOP_Q2
	return addcslashes ($text,'"');//VALID!!!!  JSHOP_PANEL_OLD_DESC
//	return quotemeta($text);//NOvalid...
//	return addslashes($text);//NOvalid...
//	return htmlspecialchars($text,ENT_QUOTES);//VALID!!!! 
}
function ParseFile($file=''){
    if(empty($file) || empty(file_exists($file)))        return FALSE;
    
    $strings = parse_ini_file($file, FALSE, INI_SCANNER_NORMAL);//parse_ini_string
    
    foreach ($strings as &$string){
        $string = trim($string);
    }
    
    return $strings;
}

function TextSplit ($text = ''){
    
}

function arr2ini(array $a, array $parent = array())
{
    $out = '';
    foreach ($a as $k => $v)
    {
        if (is_array($v))
        {
            //subsection case
            //merge all the sections into one array...
            $sec = array_merge((array) $parent, (array) $k);
            //add section information to the output
            $out .= '[' . join('.', $sec) . ']' . PHP_EOL;
            //recursively traverse deeper
            $out .= arr2ini($v, $sec);
        }
        else
        {
            //plain key->value case
            $out .= "$k=\"$v\"" . PHP_EOL;
        }
    }
    return $out;
}

function TranslateArr(array &$strings, $lang){
    
//    echo '!!!<pre>'.print_r($strings,TRUE).'</pre>';
    
    foreach ($strings as $k => &$str){
        
//        echo $k.': '.gettype($str). ' --'.print_r($str,TRUE).'<br>';
        if(is_array($str))
            $str = &TranslateArr($str, $lang);
        elseif(is_string($str))
            $str = &YATranslate($str, $lang);
        elseif(is_bool($str))
            $str = $str?'1':'0';
        else
            $str = $str;
    }
    
//    echo '!!!!!!!!<pre>'.print_r($strings,TRUE).'</pre>';
    
    return $strings;
    
}