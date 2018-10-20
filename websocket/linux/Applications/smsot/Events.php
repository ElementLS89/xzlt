<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events{

  /**
	* 当客户端发来消息时触发
	* @param int $client_id 连接id
	* @param mixed $message 具体消息
	*/
  public static function onMessage($client_id, $message){
    
    
		if($message){
			foreach(explode('+',$message) as $i){
				list($k,$v)=explode('=',$i);
				$rec[$k]=$v;
			}
			if(!$rec){
        return;
      }
      if(@$rec['call']){
				Gateway::sendToUid($rec['touid'], $rec['call']);
			}elseif(@$rec['type']=='add'){
				Gateway::bindUid($client_id, $rec['uid']);
				Gateway::sendToClient($client_id, "rest");						
			}else{
				return;
			}
		}else{
			return;
		}
	
  }
 
 /**
	* 当用户断开连接时触发
	* @param int $client_id 连接id
	*/
  public static function onClose($client_id){
		Gateway::closeClient($client_id);
  }
}
