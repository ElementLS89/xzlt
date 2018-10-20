<?php

require_once './config.php';
require_once './include/core.php';
require_once './include/function.php';

$S = new S();
$S -> star();

/**INSERT INTO `sms_phone_number_cetc53` (`id`, `name`, `snumber`, `lnumber`) VALUES ('1', '蒲金龙', '65906', '12345678901');
 * 
 */
// 从 URL 中获取参数 q 的值
$q=$_GET["q"];

if (strlen($q)>0)
{
    $sql['select'] = 'SELECT p.*';
    $sql['from'] =' FROM '.DB::table('phone_number_cetc53').' p';

    $wherearr[] = 'p.name LIKE'."'%$q%'".' or p.ename LIKE'."'%$q%'".' or p.snumber LIKE'."'%$q'";

    $sql['order']='ORDER BY p.id DESC';

    $select=select($sql,$wherearr,10);

    if($select[1])
    {
        $query = DB::query($select[0]);
        $value = DB::fetch($query);
    }
}

// 输出结果
echo $value['snumber'];
?>
