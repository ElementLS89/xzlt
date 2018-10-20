<?php
function stripubbs($content){
	$content=str_replace(array("\n"),array("<br>"),$content);
	$content = preg_replace_callback("/\[h(.+?)](.+?)\[\/h(.+?)]/s", 'ubbtitle', $content);
	$content = preg_replace_callback("/\[b](.+?)\[\/b]/s", 'ubbblod', $content);
	$content = preg_replace_callback("/\[url](.+?)\[\/url]/s", 'ubblink', $content);
	$content = preg_replace_callback("/\[img](.+?)\[\/img]/s", 'ubbimg', $content);
	$content = preg_replace_callback("/\[code](.+?)\[\/code]/s", 'ubbcode', $content);
	$content = preg_replace_callback("/\[HTML](.+?)\[\/HTML]/s", 'ubbhtml', $content);
	return $content;
}

function ubbtitle($matches){
	$title='<h'.$matches[1].'>'.$matches[2].'</h'.$matches[3].'>';
	return $title;
}
function ubbblod($matches){
	$blod='<strong>'.$matches[1].'</strong>';
	return $blod;
}
function ubblink($matches){
	$link='<a href="'.$matches[1].'" class="load c8" target="_blank">'.$matches[1].'</a>';
	return $link;
}
function ubbimg($matches){
	global $_S;
	if($_S['mobile']){
		$img='<img src="ui/sl.png" data-original="'.$_S['atc'].'/'.$matches[1].'" class="viewpic lazyload">';
	}else{
		$img='<img src="'.$_S['atc'].'/'.$matches[1].'">';
	}
	return $img;
}
function ubbcode($matches){
	$matches[1]=str_replace(array("<br>","<",">"),array("\n","&lt;","&gt;"),$matches[1]);
	$matches[1] = preg_replace_callback("/\[c(.+?)](.+?)\[\/c(.+?)]/s", 'codecolor', $matches[1]);
	$code='<code>'.$matches[1].'</code>';
	return $code;
}
function ubbhtml($matches){
	$matches[1]=str_replace(array("<br>"),array("\n"),$matches[1]);
	$html=$matches[1];
	return $html;
}
function codecolor($matches){
	$color='<span class="c'.$matches[1].'">'.$matches[2].'</span>';
	return $color;
}
?>