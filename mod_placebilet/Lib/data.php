<?php defined('_JEXEC') or die;
 /** ----------------------------------------------------------------------
 * plg_PlaceBilet - Plugin Joomshopping Component for CMS Joomla
 * ------------------------------------------------------------------------
 * author    Sergei Borisovich Korenevskiy
 * @copyright (C) 2019 //explorer-office.ru. All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 1.1.1
 * @package		Jshopping
 * @subpackage  plg_placebilet
 * Websites: //explorer-office.ru/download/
 * Technical Support:  Forum - //fb.com/groups/multimodulefb.com/groups/placebilet/
 * Technical Support:  Forum - //vk.com/placebilet
 * -------------------------------------------------------------------------
 **/

namespace API\Kultura\Pushka;

//TicketData
class PushkaData implements \JsonSerializable {
	
	public static function new(array|string $data = []) : static {
		return new static($data);
	}
	
	function __construct(array|string $data = []){		

		if(is_string($data)){
			$data = (array) json_decode($data,false);
		}
		
		foreach (static::$filter as $param => $type){
			if(is_string ($type) && isset($data[$param])) {
				$this->{$param} = $data[$param];
				settype($this->{$param}, $type);
				if(static::$addInObjectDataString && str_ends_with($param, 'date') && $data[$param] && is_numeric($data[$param])){
					$prop = "{$param}_string";
					$this->$prop = date("Y-m-d H:i:s",$data[$param]);//date( 'Y-mM-d H:i:s' );;
				}
				continue;
			}
			if(is_array ($type)){
				$params = $type;
				foreach ($params as $param_child  => $type){
					if(isset($data[$param][$param_child])){
						$this->{"{$param}_{$param_child}"} = $data[$param][$param_child];
						settype($this->{"{$param}_{$param_child}"}, $type);
						if(static::$addInObjectDataString && str_ends_with($param_child, 'date') && is_numeric($data[$param][$param_child])){
							$prop = "{$param}_{$param_child}_string";
							$this->$prop = date("Y-m-d H:i:s",$data[$param][$param_child]);//date( 'Y-mM-d H:i:s' );;
						}
					}
				}
			}
		}
	}
	
	
	public function __set($param, $value) {
		if(is_scalar($value) && isset(static::$filter[$param])){
			$this->$param = $value;
			if(static::$addInObjectDataString && str_ends_with($param, 'date') && is_numeric($value)){
				$prop = "{$param}_{$index}_string";
				$this->$prop = date("Y-m-d H:i:s",$value);//date( 'Y-mM-d H:i:s' );;
			}
		}elseif(is_array($value) && isset(static::$filter[$param])){
			foreach ($value as $index => $child){
				if(isset(static::$filter[$param][$index])){
					$prop = "{$param}_{$index}";
					$this->$prop = $value;
					if(static::$addInObjectDataString && str_ends_with($index, 'date') && is_numeric($value)){
						$prop = "{$param}_{$index}_string";
						$this->$prop = date("Y-m-d H:i:s",$value);//date( 'Y-mM-d H:i:s' );;
					}
				}
						
			}
		}else{
			$this->$param = $value;
		}
	}
	
    public function __toString()
    {
        return json_encode($this);//JSON_UNESCAPED_UNICODE JSON_UNESCAPED_SLASHES JSON_PRETTY_PRINT
    }

    public function jsonSerialize() : mixed {
		
		$data = [];
		
//		foreach (self::$requaires as $prop){
//			if(empty($this->{$prop})){
//				throw new Exception('Для \''. get_class($this).'\' нет: ' . $prop);
//			}
//		}
		
		foreach (static::$filter as $param => $type){
			if(is_string ($type) && isset($this->{$param}) && $this->{$param}) {
				$data[$param] = $this->{$param} ?? '';
				settype($data[$param], $type);
				continue;
			}
			if(is_array ($type)){
				$params = $type;
				foreach ($params as $param_child  => $type){
					if(isset($this->{$param}[$param_child])){
						if(empty($this->{$param}[$param_child]))
							continue;
						$data[$param][$param_child] = $this->{$param}[$param_child];
						settype($data[$param][$param_child], $type);
					}elseif(isset($this->{"{$param}_{$param_child}"})){
						if(empty($this->{"{$param}_{$param_child}"}))
							continue;
						$data[$param][$param_child] = $this->{"{$param}_{$param_child}"};
						settype($data[$param][$param_child], $type);
					}elseif(isset($this->$param_child)){
						if(empty($this->$param_child))
							continue;
						$data[$param][$param_child] = $this->$param_child;
						settype($data[$param][$param_child], $type);
					}
				}
			}
		}
		return $data;
    }
	
	/** 
	 * Массив наименований свойств требуемый для запроса в реестр 
	 * @var array $requaires
	 */
	public static array $filter = [
	];
	
	public static bool $addInObjectDataString = false;
	
	/** 
	 * Список обязательных свойств
	 * @var array $requaires
	 */
//	public static array $requaires = [
//	];
	
}