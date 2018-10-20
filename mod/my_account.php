<?php
if(!defined('IN_SMSOT')) {
	exit;
}
$backurl='my.php';
$_S['setting']['withdrawals']=dunserialize($_S['setting']['withdrawals']);
$_S['setting']['banks']=dunserialize($_S['setting']['banks']);

$commission=$_S['setting']['commission'];

if($_GET['action']=='log'){
	$navtitle='收支记录';
	$sql = array();
	$wherearr = array();

	$sql['select'] = 'SELECT * ';
	$sql['from'] ='FROM '.DB::table('common_user_count_log');
  $wherearr[] = "`uid` ='$_S[uid]'";
	//$wherearr[] = "`fild` !='experience'";
  
	$sql['order']='ORDER BY logtime DESC';
  $select=select($sql,$wherearr,10);

	if($select[1]) {
		$query = DB::query($select[0]);
		while($value = DB::fetch($query)) {
			$value['relation']=dunserialize($value['relation']);
			$value['arose_before']=$value['arose']>0?'+':'';
			if($value['fild']=='balance'){
				$value['arose'] =($value['arose']/100).'元';
				if($value['relation']['account']){
					$value['title_after']=$value['state']?'<span class="s12 pl5 c1 fw">[已处理]</span>':'<span class="s12 pl5 c4 fw">[处理中]</span>';
				}
			}elseif($value['fild']=='gold'){
				$value['arose'] =$value['arose'].'代金券';
			}else{
				$value['arose'] =$value['arose'].'经验';
			}
			$list[$value['lid']]=$value;
		}
	}
	$maxpage = @ceil($select[1]/10);
	$nextpage = ($_S['page'] + 1) > $maxpage ? 1 : ($_S['page'] + 1);
	$nexturl = 'my.php?mod=account&action=log&page='.$nextpage;
	
}elseif($_GET['lid']){
	$navtitle='收支详情';
	$backurl='my.php?mod=account';
	$log=DB::fetch_first("SELECT * FROM ".DB::table('common_user_count_log')." WHERE lid='$_GET[lid]'");
	if(!$log){
		showmessage('记录不存在');
	}
	$log['relation']=dunserialize($log['relation']);
	$log['arose_before']=$log['arose']>0?'+':'';
	if($log['fild']=='balance'){
		$log['arose'] =($log['arose']/100).'元';
		$log['type']='余额';
	}elseif($log['fild']=='gold'){
		$log['arose'] =$log['arose'].'元';
		$log['type']='代金券';
	}else{
		$log['arose'] =$log['arose'];
		$log['type']='经验';
	}
	
	
}else{
	$navtitle=$_GET['action']=='account'?'设置提现账号':'我的账户';
	C::chche('credits');
	require_once './include/function_user.php';
	$my=getuser(array('common_user_count'),$_S['uid']);
	
	if(!$_S['member']['weixin'] && !$_S['member']['alipay'] && (!$_S['member']['bank'] || !$_S['member']['bankname'] || !$_S['member']['bankuser'])){
		$withdrawals_form='display:none';
	}else{
		$withdrawals_alert='display:none';
	}
	
	if($_GET['action']=='withdrawals' && !$_S['member']['weixin'] && !$_S['member']['alipay'] && (!$_S['member']['bank'] || !$_S['member']['bankname'] || !$_S['member']['bankuser'])){
		showmessage('请先设置您的提现收款账号','my.php?mod=account&action=account');
	}
	
	if($_S['setting']['recharge']){
		foreach(explode("\n",$_S['setting']['recharge']) as $v){
			list($chong,$song)=explode("=",$v);
			$rule[]=array(trim($chong),trim($song));
		}
	}
	
	getopenid();
	$signature=signature();
	$apilist='chooseWXPay';
	$noshar=true;
	if(checksubmit('submit')){
		if($_GET['action']=='recharge'){
			showmessage('错误的操作');
		}elseif($_GET['action']=='withdrawals'){
			$s['money']=abs(intval($_GET['money']))*100;
			$s['account']=$_GET['account'];
			$s['password']=$_GET['password'];
			
			if($s['money']>($my['balance']*100)){
				showmessage('提现金额不能超过您的账户余额');
			}elseif($_S['member']['password']!=md5(md5($s['password']).$_S['member']['salt'])){
				showmessage('密码输入错误');
			}elseif(!$s['account']){
				showmessage('请选择收款账号');
			}else{
				$relation=array();
				$relation['type']=$s['account'];
				$relation['commission']=$commission;

				if($s['account']=='bank'){
					$relation['bankname']=$_S['member']['bankname'];
					$relation['bankuser']=$_S['member']['bankuser'];
					$relation['account']=$_S['member']['bank'];
				}elseif($s['account']=='alipay'){
					$relation['account']=$_S['member']['alipay'];
				}elseif($s['account']=='weixin'){
					$relation['account']=$_S['member']['weixin'];
				}
				$relation=dserialize($relation);
				$money=($my['balance']*100)-$s['money'];
				$lid=makeid();
				insert('common_user_count_log',array('lid'=>$lid,'uid'=>$_S['uid'],'fild'=>'balance','arose'=>-$s['money'],'title'=>'提现','relation'=>$relation,'state'=>'0','logtime'=>$_S['timestamp']),true);
				update('common_user_count',array('balance'=>$money),"uid='$_S[uid]'");
				showmessage('您的提现申请已经提交，请耐心等待管理人员的处理','my.php?mod=account&lid='.$lid,array('title'=>'提现成功','primary'=>'查看详情','default'=>'关闭','js'=>'smsot.accountchange(\''.($money/100).'\',\'balance\');smsot.withdrawals()'));
			}
		}elseif($_GET['action']=='account'){
			
			$s['weixin']=$_GET['weixin'];
			$s['alipay']=$_GET['alipay'];
	
			$r['bank']=trim($_GET['bank']);
			$r['bankname']=trim($_GET['bankname']);
			$r['bankuser']=trim($_GET['bankuser']);
			if($r['bank'] && $r['bankname'] && $r['bankuser']){
				$r['bankset']='1';
				$s['bank']=$r['bank'];
				$s['bankname']=$r['bankname'];
				$s['bankuser']=$r['bankuser'];
			}
			$r['weixin']=$s['weixin'];
			$r['alipay']=$s['alipay'];
			
			if($r['bankset'] || $r['weixin'] || $r['alipay']){
				$r['res']='1';
			}
			if(!$s['weixin'] && !$s['alipay'] && !$s['bank']){
				showmessage('至少选择或设置一种收款方式');
			}
			require_once ROOT.'include/json.php';
			$return= JSON::encode($r);
					
			if($_S['member']['password']!=md5(md5($_GET['password']).$_S['member']['salt'])){
				showmessage('密码输入错误');
			}else{
				update('common_user_profile',$s,"uid='$_S[uid]'");
				showmessage('设置成功','',array('type'=>'toast','fun'=>'SMS.closepage();setTimeout(function(){smsot.setaccount(\''.$return.'\')},100);'));
			}
		}
	}
}
$title=$navtitle.'-'.$_S['setting']['sitename'];
include temp(PHPSCRIPT.'/'.$_GET['mod']);
?>