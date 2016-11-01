<?php
namespace Fun;

use Library\Error;
use \Phalcon\DI;

final class JDate
{
	/**
	 * 日列表
	 *
	 * 例子：date::ListDay('2010-12-01', '2010-12-06');
	 * @param string $start 开始时间
	 * @param string $end 结束时间
	 * @return array 时间列表
	 */
	public static function listDay($start, $end, $asc = true)
	{
		$dayList	= array();
		if (!is_numeric($start))
			$start	= strtotime($start);
		if (!is_numeric($end))
			$end	= strtotime($end);
			
		if($end >= $start)
		{
			for ($i=$start; $i<=$end; $i = $i + 86400)
				$dayList[]	= date('Y-m-d', $i);
		}
		if (!$asc)
		{
			@krsort($dayList);
		}
		
		return $dayList;
	}
	
	/**
	 * 周列表
	 *
	 * @param int $year 年份
	 * @param int $month 月份
	 * @return array
	 */
	public static function listWeek($year = '', $month = '', $asc = true)
	{
		$year	= empty($year) ? date('Y') : $year;
		$month	= empty($month) ? date('m') : $month;
		$fristDay= $year.'-'.$month.'-01';
		//取得第一天是星期几
		$today	= date('N', strtotime($fristDay));
		$time	= strtotime($fristDay);
		$wi		= -($today+1)%7;
		$we		= date('t', $time);
		$week	= array();
		$yi		= 1;
		for($wi = $wi; $wi <= $we; $wi = $wi + 7)
		{
			$week[$yi]	= array(
						'starttime'	=> date('Y-m-d', $time+$wi*86400),
						'endtime'	=> date('Y-m-d', $time+($wi+6)*86400)
					);
			$yi++;
		}
		if (!$asc)
		{
			@krsort($week);
		}
		return $week;
	}

	/**
	 * 根据日期段获取周列表
	 *
	 * @param $startDate
	 * @param int $endDate
	 * @param bool|true $asc
	 * @return Array
	 */
	public static function listWeekDay($startDate, $endDate=0, $asc=true)
	{
		// 判断变量值是否合法
		$end = $endDate == 0 ? $startDate : $endDate;
		if (!$startDate || !$endDate || ($start = strtotime($startDate)) > ($end = strtotime($endDate))) {
			return false;
		}

		// 开始时间与结束时间为一天时
		if ($start == $end) {
			$title = self::getWeekDate($startDate, '1').' 至 '.self::getWeekDate($startDate, '7');
			$str[date('W', $start)] = array('title' => $title, 'start' => date('Y-m-d', $start), 'end' => date('Y-m-d', $end));
			return $str;
		}

		// 获取日期列表
		$dateList = self::listDay($startDate, $endDate);
		foreach ($dateList AS $key => $value)
		{
			// 开始整理为周列表
			$week = date('W', strtotime($value));
			if (empty($str[$week]))
			{
				$str[$week]['start']	= self::getWeekDate($value, '1');
				$str[$week]['end'] 		= self::getWeekDate($value, '7');
				$str[$week]['title'] 	= $str[$week]['start'].' 至 '.$str[$week]['end'];
			}
		}

		// 排序
		if (!$asc)
		{
			@krsort($str);
		}

		return $str;
	}

	/**
	 * 月份列表
	 *
	 * @param int $year 年份
	 * @return array
	 */
	public static function listMonth($year = '', $asc = true)
	{
		$month	= array();
		$year	= empty($year) ? date('Y') : $year;
		for ($i = 1;$i<=12;$i++)
		{
			$month[]	= sprintf('%04d-%02d', $year, $i);
		}
		if (!$asc)
		{
			@krsort($month);
		}
		return $month;			
	}
	
	/**
	 * 获取月份列表
	 *
	 * @param  String  $start 开始时间
	 * @param  String  $end	  结束时间
	 * @param  boolean $asc   是否倒序排序
	 * @return Array
	 */
	public static function ListMonthDay($start, $end, $asc = true) {
		$end = $end == 0 ? $start : $end;
	    if (!$start || !$end || ($start = strtotime($start)) > ($end = strtotime($end))) {
	    	return false;
	    }
	    
		if ($start == $end) {
			$str[date('Ym', $start)] = array('titel' => date('Y-m', $start), 'start' => date('Y-m-d', $start), 'end' => date('Y-m-d', $end));
			return $str;
		}

		$startYM = date('Ym', $start);
		$str[date('Ym', $start)]['title'] = date('Y-m', $start);
	    $str[date('Ym', $start)]['start'] = date('Y-m-d', $start);
	    $str[date('Ym', $start)]['end'] = date('Y-m', $start) . '-' . date('t', $start);

	    $oneDay = 60 * 60 * 24;
	    while ($start < $end) {
			$start += $oneDay;
			if (date('Ym', $start) != $startYM) {
				$str[date('Ym', $start)]['title'] = date('Y-m', $start);
				$str[date('Ym', $start)]['start'] = date('Y-m', $start) . '-01';
			}
	        $str[date('Ym', $start)]['end'] = date('Y-m-d', $start);
	    }
	    
	    if (!$asc)
		{
			@krsort($str);
		}
	    return $str;
	}
	
	/**
	 * 星期几
	 *
	 * @param int $weekid 周几
	 * @return string
	 */
	public static function weekName($time)
	{
		if (!is_numeric($time))
			$time	= strtotime($time);
		$weekid		= date('N', $time);
		$week	= array(
					1 => '星期一',
					2 => '星期二',
					3 => '星期三',
					4 => '星期四',
					5 => '星期五',
					6 => '星期六',
					7 => '星期日'
				);
		return $week[$weekid];
	}
		
	/**
	 * 格式化时间
	 * date函数的扩展,支持date函数的所有功能，新添加C格式化字符,用于显示中文星期几
	 * @param string $format 格式化字符串
	 * @param string|int $time 时间
	 * @return string
	 */
	public static function date($format, $time)
	{
		if (!is_numeric($time))
			$time	= strtotime($time);
		$date	= date($format, $time);
		
		//星期几 C
		$date	= str_replace('C', self::weekName($time), $date);
		return $date;
	}
	
	/**
	 * 指定日期开始多少天的时间
	 *
	 * @param int|string $time
	 * @param int $num
	 * @param string $format
	 * @return string
	 */
	public static function weekDate($time, $num, $format = 'Y-m-d')
	{
		if (!is_numeric($time))
			$time	= strtotime($time);		
		return	self::date($format, mktime(0,0,0,date('m', $time),date('d', $time)-date('N', $time)+$num,date('Y', $time)));
		
	}

	/**
	 * 获得指定日期周内的指定星期日期
	 *
	 * @param  String $date 日期
	 * @param  Int	  $week 所要获取的星期天
	 * @return string
	 */
	public static function getWeekDate($date, $week = 7)
	{
		--$week;
		
		$thisWeek = date('N', strtotime($date));
		--$thisWeek;
		return date('Y-m-d', strtotime(date('Y-m-d', strtotime($date . "-{$thisWeek} days")) . "+{$week} days"));
	}
	
	/**
	 * 查询是否为正确的日期格式
	 *
	 * @param  Int $time 指定的格式时间 2013-01-01
	 * @return string
	 */
	public static function isDatetime($time)
	{
		$preg  = '/(^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$)/';
		if (strlen($time) != 10 ){
			return false;
		} else if (!preg_match($preg, $time)) {
			return false;
		} 
		return true;
	}
}
