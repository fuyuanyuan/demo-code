<?php
namespace Fun;

use Library\Error;
use \Phalcon\DI;

final class JArray
{
	/**
	 * 判断是否为数组
	 *
	 * @param  Array $array
	 * @return Boolean
	 */
	public static function if_array($array)
	{
		return is_array($array) && @count($array) > 0 ? true : false;
	}
	
	/**
	 * 二维数组横向求和
	 *
	 * @param array $arr 原数组
	 * @param array $field 需要取的字段
	 * @return array 结果
	 */
	public static function hor_sum($arr, $field = array())
	{
		if(!empty($field))
			$arr	= self::get_twodim_arr($arr, $field);		
		$sum	= array();
		foreach ($arr as $key => $value)
		{
			$sum[$key]	= @array_sum($value);
		}
		return $sum;
	}
	
	/**
	 * 二维数组纵向求和
	 *
	 * @param array $arr 原数组
	 * @param array $field 需要取的字段
	 * @return array 结果
	 */
	public static function ver_sum($arr, $field = array())
	{
		if(empty($arr))
			return array();
		
		$data	= array();
		foreach ($arr as $value)
		{
			foreach ($value as $key => $val)
			{
				if(!empty($field) && !in_array($key, $field))
					continue;
				$data[$key][]	= $val;
			}
		}
		return self::hor_sum($data);
	}
	
	/**
	 * 获得二维数组的指定列
	 *
	 * @param array $arr 原数组
	 * @param array $field 需要取的字段
	 * @return array 处理后的数组
	 */
	public static function get_twodim_arr($arr, $field, $ifKey = true)
	{
		$data	= array();
		if(!empty($field) && !empty($arr))
		{
			foreach ($arr as $key => $value)
			{
				$data[$key]	= self::get_arr($value, $field, $ifKey);				
			}
		}
		return $data;
	}
	
	/**
	 * 获得一维数组的指定列
	 *
	 * @param array $arr 原数组
	 * @param array $field 需要取的字段
	 * @return array 处理后的数组
	 */
	public static function get_arr($arr, $field, $ifKey = true)
	{
		$data	= array();
		if(!empty($field) && !empty($arr))
		{
			foreach ($field as $key => $value)
			{
				if ($ifKey)
				{
					$data[$value]	= $arr[$value];
				}
				else 
				{
					$data = $arr[$value];
				}
			}
		}
		return $data;
	}
	
	/**
	 * 多维数组中获得指定值
	 *
	 * @param array $arr
	 * @param string $key
	 * @return mixed
	 */
	public static function get($arr, $key)
	{
		$keys	= sprint_f("\$arr['%s']", str_replace('->', "']['", $key));
		$data	= @eval($keys);
		return $data;
	}
	
	/**
	 * 设置多维数组的值
	 *
	 * @param array $arr
	 * @param string $key
	 * @param mixed $val
	 * @return mixed
	 */
	public static function set($arr, $key, $val)
	{
		$keys	= explode('->', $key);
		if(count($keys) == 1)
			$arr[$key]	= $val;
		else
		{
			$tmp	= $arr;
			$str	= '';
			foreach ($keys as $k => $v)
			{
				$str .= "['$v']";
				eval("if(!is_array(\$arr$str) && !is_object(\$arr$str)) \$arr$str=array();");				
			}
			eval("\$arr$str=$val;");
		}
		return $arr;
	}
	
	/**
	 * 一维数组合并
	 *
	 * @param array $arr1
	 * @param array $arr2
	 * @return array
	 */
	public static function array_merge ($arr1, $arr2)
	{
		if (!empty($arr2))
		{
			foreach ($arr2 as $key => $value)
			{
				$arr1[$key]	= $value;
			}
		}
		return $arr1;
	}
	
	/**
	 * 二维数据合并
	 *
	 * @param array $arr1
	 * @param array $arr2
	 * @return array
	 */
	public static function array_merge_two ($arr1, $arr2)
	{
		if (!empty($arr2))
		{
			foreach ($arr2 as $key => $value)
			{
					if (!isset($arr1[$key]))
					{
						$arr1[$key]	= array();
					}
					$arr1[$key]	= self::array_merge($arr1[$key], $value);
			}
		}
		return $arr1;
	}
	
	/**
	 * 一维数组合并求和
	 *
	 * @param  Array $arr1
	 * @param  Array $arr2
	 * @return Array
	 */
	public static function array_merge_sum($arr1, $arr2)
	{
		if (!empty($arr2))
		{
			foreach ($arr2 AS $key => $value)
			{
				$arr1[$key]	+= $value;
			}
		}
		return $arr1;
	}
	
	/**
	 * 指定二维数组中的指定列的值作为数组的键值
	 *
	 * @param array $arr	数组
	 * @param string $key	键值
	 * @param bool $overflow是否覆盖
	 * @return array
	 */
	public static function array_two_setkey($arr, $keys, $overflow = true)
	{
		$data	= array();
		$keys	= is_array($keys) ? $keys : array($keys);
		foreach ($arr as $k => $val)
		{
			if (!empty($val[$keys[0]]))
			{
				if ($overflow)
				{
					$data[$val[$keys[0]]]	= $val;
				}
				else 
				{
					if (isset($keys[1]))
						$data[$val[$keys[0]]][$val[$keys[1]]]	= $val;
					else
						$data[$val[$keys[0]]][]	= $val;
				}
			}
			else
			{
				$data[$k]	= $val;
			}
			
		}
		return $data;
	}
	
	/**
	 * 三数组纵向求和
	 *
	 * @param unknown_type $array
	 * @return unknown
	 */
	public static function array_three_verticalSum($array)
	{
		if(empty($array))
			return array();
		
		$data	= array();
		foreach ($array AS $value)
		{
			if (is_array($value) && count($value) > 0)
			{
				foreach ($value AS $key => $val)
				{	
					if (is_array($val) && count($val) > 0)
					{
						foreach ($val AS $k => $v)
						{
							$data[$key][$k] += $v;
						}
					}
				}
			}
		}
		
		return $data;
	}
	
	/**
	 * 计算数组中两个键值之间的和
	 *
	 * @param array $arr
	 * @param int $start
	 * @param int $end
	 * @param int $step
	 * @return mixed
	 */
	public static function sum_between($arr, $start, $end, $step = 1, $keys = '')
	{
		$sum	= 0;
		for($i = $start; $i<=$end; $i=$i+$step)
		{
			@$sum	+= ($keys) ? $arr[$i][$keys] : $arr[$i];
		}
		return $sum;
	}
	
	/**
	 * 计算数组中指定键值的和
	 *
	 * @param array $arr
	 * @param string|array $list
	 * @param string $keys
	 * @return mixed
	 */
	public static function sum_list($arr, $list, $keys='')
	{
		if (is_string($list))
		{
			$list	= explode(',', $list);
		}
		$sum	= 0;
		foreach($list as $val)
		{
			$sum	+= ($keys) ? $arr[trim($val)][$keys] : $arr[trim($val)];
		}
		return $sum;
	}
	
	/**
	 * 获取数组维数
	 *
	 * @param  Array $array 数组
	 * @return Int
	 */
	public static function array_get_dim($array)
	{
		if (!is_array($array))
		{
			return 0;
		}
		else
		{
        	$num = 0;
        	foreach ($array AS $value)
        	{
            	$tempNum = self::array_get_dim($value);
            	if ($tempNum > $num)
            	{
            		$num = $tempNum;
            	}
        	}
  
        	return $num + 1;
		}
	}
	
	/**
	 * 数组运算
	 * JArray::calculate($data, '({10}+{11})/{12}', 'ip_count');
	 * @param unknown_type $arr
	 * @param unknown_type $list
	 * @param unknown_type $key
	 */
	public static function calculate($arr, $expression, $key='')
	{
		$suffix	= ($key) ? '"]["'.$key.'"]' : '"]';
		
		$expression	= str_replace(array('{','}'), array('$arr["', $suffix), $expression);
		
		return eval('return ' . $expression . ';');
	}
	
	/**
	 * 一维数组排序
	 *
	 * @param  Array  $array
	 * @param  String $order
	 * @return Array
	 */
	public static function array_one_value_sort($array, $order = 'DESC')
	{
		$list = array();
		if (is_array($array) && count($array) > 0)
		{
			foreach ($array AS $key => $value) {
				$val[$key]['value'] = $value;
				$list[$key] = array('key' => $key, 'value' => $value);
			}
			
			if ($order == 'DESC')
			{
				array_multisort($val, SORT_DESC, $list);
			}
			else 
			{
				array_multisort($val, SORT_ASC, $list);
			}
		}
		
		return $list;
	}
	
	/**
	 * 获取小于指定数值的数组
	 *
	 * @param  Array $array
	 * @param  Number $num
	 * @return Array
	 */
	public static function array_one_lessThan($array, $num, $key = '')
	{
		return self::array_one_ThanSize('lessthen', $array, $num, $key);
	}
	
	/**
	 * 获取大于指定数值的数组
	 *
	 * @param  Array $array
	 * @param  Number $num
	 * @return Array
	 */
	public static function array_one_Than($array, $num, $key = '')
	{
		return self::array_one_ThanSize('then', $array, $num, $key);
	}
	
	/**
	 * 比较一维数组大小
	 *
	 * @param unknown_type $type
	 * @param unknown_type $num
	 * @return unknown
	 */
	public static function array_one_ThanSize($type, $array, $num, $keys = '')
	{
		$list = array();
		if (is_array($array) && count($array) > 0)
		{
			foreach ($array AS $key => $value)
			{
				$tmpNum = !empty($keys) ? $value[$keys] : $value;
				if ($type == 'then')
				{
					if ($tmpNum >= $num)
					{
						$list[$key] = $value;
					}
				}
				else 
				{
					if ($tmpNum <= $num)
					{
						$list[$key] = $value;
					}
				}
			}
		}
		
		return $list;
	}

    static function deep_get($arr, $keyPieces, $default=null){
        if(is_string($keyPieces))
            $keyPieces = explode('.', $keyPieces);

        $key = array_shift($keyPieces);
        if($key===null) return $arr;

        if(is_array($arr) && array_key_exists($key, $arr))
            return self::deep_get($arr[$key], $keyPieces);
        return $default;
    }

}
