<?php
if(!defined('IN_SMSOT')) {
	exit;
}
class temp {
	var $replacecode = array('search' => array(), 'replace' => array());
	var $language = array();
	var $file = '';
	
	function template($tplfile, $tpldir, $file, $cachefile) {
		
		$this->file = $file;
		if($fp = @fopen(ROOT.$tplfile, 'r')) {
			$template = @fread($fp, filesize(ROOT.$tplfile));
			fclose($fp);
			$template = str_replace('<?exit?>', '', $template);
		} else {
			$tpl = $tpldir.'/'.$file.'.php';
			$tplfile = $tplfile != $tpl ? $tpl.', '.$tplfile : $tplfile;
			$this->error('template_notfound', $tplfile);
			error('template_notfound',$tplfile);
		}
		
		$var_regexp = "((\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*(\-\>)?[a-zA-Z0-9_\x7f-\xff]*)(\[[a-zA-Z0-9_\-\.\"\'\[\]\$\x7f-\xff]+\])*)";
		$const_regexp = "([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)";

		$template = preg_replace("/([\n\r]+)\t+/s", "\\1", $template);
		$template = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);

		$template = preg_replace_callback("/[\n\r\t]*\{date\((.+?)\)\}[\n\r\t]*/i", array($this, 'parse_template_callback_datetags_1'), $template);
		$template = preg_replace_callback("/[\n\r\t]*\{avatar\((.+?)\)\}[\n\r\t]*/i", array($this, 'parse_template_callback_avatartags_1'), $template);
		$template = preg_replace_callback("/[\n\r\t]*\{eval\}\s*(\<\!\-\-)*(.+?)(\-\-\>)*\s*\{\/eval\}[\n\r\t]*/is", array($this, 'parse_template_callback_evaltags_2'), $template);
		$template = preg_replace_callback("/[\n\r\t]*\{eval\s+(.+?)\s*\}[\n\r\t]*/is", array($this, 'parse_template_callback_evaltags_1'), $template);
    $template = preg_replace_callback("/[\n\r\t]*\{css\}[\n\r\t]*/is", array($this, 'parse_template_callback_loadcsstemplate'), $template);

		$template = str_replace("{LF}", "<?=\"\\n\"?>", $template);
		$template = preg_replace("/\{(\\\$[a-zA-Z0-9_\-\>\[\]\'\"\$\.\x7f-\xff]+)\}/s", "<?=\\1?>", $template);
		
    $template = preg_replace_callback("/\{hook\/(\w+?)(\s+(.+?))?\}/i", array($this, 'parse_template_callback_hooktags_13'), $template);
		
		$template = preg_replace_callback("/$var_regexp/s", array($this, 'parse_template_callback_addquote_1'), $template);
		$template = preg_replace_callback("/\<\?\=\<\?\=$var_regexp\?\>\?\>/s", array($this, 'parse_template_callback_addquote_1'), $template);


		$template = preg_replace_callback("/[\n\r\t]*\{template\s+([a-z0-9_:\/]+)\}[\n\r\t]*/is", array($this, 'parse_template_callback_stripvtags_template1'), $template);
		$template = preg_replace_callback("/[\n\r\t]*\{template\s+(.+?)\}[\n\r\t]*/is", array($this, 'parse_template_callback_stripvtags_template1'), $template);
		$template = preg_replace_callback("/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/is", array($this, 'parse_template_callback_stripvtags_echo1'), $template);


		$template = preg_replace_callback("/([\n\r\t]*)\{if\s+(.+?)\}([\n\r\t]*)/is", array($this, 'parse_template_callback_stripvtags_if123'), $template);
		$template = preg_replace_callback("/([\n\r\t]*)\{elseif\s+(.+?)\}([\n\r\t]*)/is", array($this, 'parse_template_callback_stripvtags_elseif123'), $template);
		$template = preg_replace("/\{else\}/i", "<? } else { ?>", $template);
		$template = preg_replace("/\{\/if\}/i", "<? } ?>", $template);

		$template = preg_replace_callback("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r\t]*/is", array($this, 'parse_template_callback_stripvtags_loop12'), $template);
		$template = preg_replace_callback("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*/is", array($this, 'parse_template_callback_stripvtags_loop123'), $template);
		$template = preg_replace("/\{\/loop\}/i", "<? } ?>", $template);
		

		$template = preg_replace("/\{$const_regexp\}/s", "<?=\\1?>", $template);
		if(!empty($this->replacecode)) {
			$template = str_replace($this->replacecode['search'], $this->replacecode['replace'], $template);
		}
		$template = preg_replace("/ \?\>[\n\r]*\<\? /s", " ", $template);

		if(!@$fp = fopen(ROOT.$cachefile, 'w')) {
			error('directory_notfound',dirname(ROOT.$cachefile));
		}

		$template = preg_replace("/\<\?(\s{1})/is", "<?php\\1", $template);
		$template = preg_replace("/\<\?\=(.+?)\?\>/is", "<?php echo \\1;?>", $template);

		flock($fp, 2);
		fwrite($fp, $template);
		fclose($fp);
		
	}

	function parse_template_callback_datetags_1($matches) {
		return $this->datetags($matches[1]);
	}
	function parse_template_callback_avatartags_1($matches) {
		return $this->avatartags($matches[1]);
	}
	function parse_template_callback_evaltags_2($matches) {
		return $this->evaltags($matches[2]);
	}
	function parse_template_callback_evaltags_1($matches) {
		return $this->evaltags($matches[1]);
	}
	function parse_template_callback_addquote_1($matches) {
		return $this->addquote('<?='.$matches[1].'?>');
	}
	function parse_template_callback_stripvtags_template1($matches) {
		return $this->stripvtags('<? include temp(\''.$matches[1].'\'); ?>');
	}
	function parse_template_callback_stripvtags_echo1($matches) {
		return $this->stripvtags('<? echo '.$matches[1].'; ?>');
	}
	function parse_template_callback_stripvtags_if123($matches) {
		return $this->stripvtags($matches[1].'<? if('.$matches[2].') { ?>'.$matches[3]);
	}

	function parse_template_callback_stripvtags_elseif123($matches) {
		return $this->stripvtags($matches[1].'<? } elseif('.$matches[2].') { ?>'.$matches[3]);
	}
	function parse_template_callback_stripvtags_loop12($matches) {
		return $this->stripvtags('<? if(is_array('.$matches[1].')) foreach('.$matches[1].' as '.$matches[2].') { ?>');
	}

	function parse_template_callback_stripvtags_loop123($matches) {
		return $this->stripvtags('<? if(is_array('.$matches[1].')) foreach('.$matches[1].' as '.$matches[2].' => '.$matches[3].') { ?>');
	}
	function parse_template_callback_loadcsstemplate($matches) {
		return $this->stripvtags('<? loadcss(); ?>');
	}

	function parse_template_callback_hooktags_13($matches) {
		return $this->hooktags($matches[1], $matches[3]);
	}
	
	function datetags($parameter) {
		$parameter = stripslashes($parameter);
		$i = count($this->replacecode['search']);
		$this->replacecode['search'][$i] = $search = "<!--DATE_TAG_$i-->";
		$this->replacecode['replace'][$i] = "<?php echo smsdate($parameter);?>";
		return $search;
	}
	function avatartags($parameter) {
		$parameter = stripslashes($parameter);
		$i = count($this->replacecode['search']);
		$this->replacecode['search'][$i] = $search = "<!--AVATAR_TAG_$i-->";
		$this->replacecode['replace'][$i] = "<?php echo head($parameter);?>";
		return $search;
	}
	function evaltags($php) {
		$i = count($this->replacecode['search']);
		$this->replacecode['search'][$i] = $search = "<!--EVAL_TAG_$i-->";
		$this->replacecode['replace'][$i] = "<? $php?>";
		return $search;
	}
	function addquote($var) {
		return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
	}
	function stripvtags($expr, $statement = '') {
		$expr = str_replace('\\\"', '\"', preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr));
		$statement = str_replace('\\\"', '\"', $statement);
		return $expr.$statement;
	}
	function hooktags($hookid, $key = '') {
		global $_S;
    $i = count($this->replacecode['search']);
		$this->replacecode['search'][$i] = $search = "<!--HOOK_TAG_$i-->";
		$key = $key != '' ? "[$key]" : '';
		$this->replacecode['replace'][$i] = "<?php if(!empty(\$_S['hacks']['$hookid']$key)) echo \$_S['hacks']['$hookid']$key;?>";
		return $search;
	}
	
	
}
?>