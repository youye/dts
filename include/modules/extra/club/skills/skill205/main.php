<?php

namespace skill205
{

	$ragecost=80;
	
	function init() 
	{
		define('MOD_SKILL205_INFO','club;battle;');
		eval(import_module('clubbase'));
		$clubskillname[205] = '咆哮';
	}
	
	function acquire205(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
	}
	
	function lost205(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
	}
	
	function check_unlocked205(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		return $pa['lvl']>=15;
	}
	
	function skill_onload_event(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$chprocess($pa);
	}
	
	function skill_onsave_event(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$chprocess($pa);
	}
	
	function get_rage_cost205(&$pa = NULL)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill205'));
		return $ragecost;
	}
	
	function strike_prepare(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if ($pa['bskill']!=205) return $chprocess($pa, $pd, $active);
		if (!\skillbase\skill_query(205,$pa) || !check_unlocked205($pa))
		{
			eval(import_module('logger'));
			$log .= '你尚未解锁这个技能！';
			$pa['bskill']=0;
		}
		else
		{
			$rcost = get_rage_cost205($pa);
			if (($pa['rage']>=$rcost)&&($pa['wep_kind']=="G"))
			{
				eval(import_module('logger'));
				if ($active)
					$log.="<span class=\"lime\">你对{$pd['name']}发动了技能「咆哮」！</span><br>";
				else  $log.="<span class=\"lime\">{$pa['name']}对你发动了技能「咆哮」！</span><br>";
				$pa['rage']-=$rcost;
				addnews ( 0, 'bskill205', $pa['name'], $pd['name'] );
			}
			else
			{
				if ($active)
				{
					eval(import_module('logger'));
					$log.='怒气不足或其他原因不能发动。<br>';
				}
				$pa['bskill']=0;
			}
		}
		$chprocess($pa, $pd, $active);
	}	
	
	function get_physical_dmg_multiplier(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$r=Array();
		if ($pa['bskill']==205) 
		{
			eval(import_module('logger'));
			if ($active)
				$log.='<span class="yellow">「咆哮」使你造成的物理伤害提高了20%！</span><br>';
			else  $log.='<span class="yellow">「咆哮」使敌人造成的物理伤害提高了20%！</span><br>';
			$r=Array(1.2);
		}
		return array_merge($r,$chprocess($pa,$pd,$active));
	}
	
	function calculate_ex_attack_dmg(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if ($pa['bskill']==205) 
		{
			eval(import_module('logger'));
			if ($active)
				$log.='<span class="yellow">「咆哮」使你造成的属性伤害提高了80%！</span><br>';
			else  $log.='<span class="yellow">「咆哮」使敌人造成的属性伤害提高了80%！</span><br>';
		}
		return $chprocess($pa, $pd, $active);
	}
	
	function calculate_ex_single_dmg_multiple(&$pa, &$pd, $active, $key)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if ($pa['bskill']==205) 
		{
			return $chprocess($pa, $pd, $active, $key)*1.8;
		}
		return $chprocess($pa, $pd, $active, $key);
	}
	
	function apply_weapon_inf(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('armor','wound','logger'));
		if ($pa['bskill']==205)
		for ($i=0; $i<strlen($inf_place); $i++)
			if (isset($pa['attack_wounded_'.$inf_place[$i]]) && $pa['attack_wounded_'.$inf_place[$i]]>0)
			{
				$pa['attack_wounded_'.$inf_place[$i]]*=2;
			}
		
		$chprocess($pa, $pd, $active);
	}

	function parse_news($news, $hour, $min, $sec, $a, $b, $c, $d, $e)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		eval(import_module('sys','player'));
		
		if($news == 'bskill205') 
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"clan\">{$a}对{$b}发动了技能<span class=\"yellow\">「咆哮」</span></span><br>\n";
		
		return $chprocess($news, $hour, $min, $sec, $a, $b, $c, $d, $e);
	}
}

?>
