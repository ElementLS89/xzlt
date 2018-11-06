<?php include temp('header'); ?><div id="view">
  <div id="header">
    <div class="header <?php echo $topicskin['topbg'];?> flexbox c3">
      <div class="header-l"><?php back('back')?></div>
      <div class="header-m flex"><?php echo $navtitle;?></div>
      <div class="header-r">
      <?php if($ismember) { ?>
      <a href="javascript:SMS.opensheet('#topicsheet')" class="icon icon-more" id="topicbtn_<?php echo $topic['tid'];?>"></a>
      <?php } else { ?>
      <?php if($canmanage) { ?>
      <a href="topic.php?mod=manage&tid=<?php echo $topic['tid'];?>" class="icon icon-set load"></a>
      <?php } else { ?>
      <a href="topic.php?mod=action&ac=join&tid=<?php echo $topic['tid'];?>" class="weui-btn weui-btn_mini load" id="topicbtn_<?php echo $topic['tid'];?>" loading="tab">加入</a>
      <?php } ?>
      
      <?php } ?>
      </div>
    </div>
  </div>
  <div id="main">
    <div class="smsbody <?php echo $topicskin['body'];?> <?php echo $outback;?>">

      <?php if($topic['banner']) { ?>
      <div class="topic_banner" style="background-image:url(<?php echo $_S['atc'];?>/<?php echo $topic['banner'];?>)">
      <?php } ?>
        <div class="topicinfo <?php echo $topicskin['info'];?>">
          <div class="flexbox p15">
            
            <img src="<?php echo $topic['cover'];?>">
            <div class="flex">
              <h3 class="s18 ellipsis"><?php echo $topic['name'];?></h3>
              <?php if($topic['price'] && !$topic['level'] && !$canmanage) { ?>
              <p class="s13 <?php echo $topicskin['info_p'];?>">话题数<em><?php echo $topic['themes'];?></em></p> 
              <p class="s13 <?php echo $topicskin['info_p'];?>">成员数<em><?php echo $topic['users'];?></em></p> 
              <?php } else { ?>
              <p class="s13 <?php echo $topicskin['info_p'];?> ellipsis">话题数<em id="themes_<?php echo $topic['tid'];?>"><?php echo $topic['themes'];?></em>成员数<a href="topic.php?tid=<?php echo $_GET['tid'];?>&show=member" id="users_<?php echo $topic['tid'];?>" class="load pl5"><?php echo $topic['users'];?></a></p>
              <p class="s13 <?php echo $topicskin['info_p'];?>"><?php echo $topic['about'];?></p>                 
              <?php } ?>
         
            </div>
            <?php if($_S['app']['hideheader']) { ?>
            <?php if($ismember) { ?>
              <a href="javascript:SMS.opensheet('#topicsheet')" class="icon icon-more" id="topicbot_<?php echo $topic['tid'];?>"></a>
            <?php } else { ?>
              <?php if($canmanage) { ?>
              <a href="topic.php?mod=manage&tid=<?php echo $topic['tid'];?>" class="icon icon-set load"></a>
              <?php } else { ?>
              <a href="topic.php?mod=action&ac=join&tid=<?php echo $topic['tid'];?>" class="weui-btn weui-btn_mini <?php if($topic['banner']) { ?>weui-btn_warn<?php } else { ?>weui-btn_default<?php } ?> load" id="topicbot_<?php echo $topic['tid'];?>" loading="tab">加入</a>
              <?php } ?>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
      <?php if($topic['banner']) { ?>
      </div>
      <?php } ?>
      <?php if($topic['price'] && !$topic['level'] && !$canmanage) { ?>
      <?php include temp('topic/buytopic'); ?>      <?php } else { ?>      
      <?php if($_GET['show']=='member') { ?>
      <div class="box b_c3 mb10 mt10">
        <h3 class="box_title cl"><span>管理团队</span></h3>
        <?php if($manager) { ?>
        <div class="users">
          <?php if(is_array($manager)) foreach($manager as $value) { ?>          <a href="user.php?uid=<?php echo $value['uid'];?>" class="weui-cell weui-cell_link load">
            <div class="weui-cell__hd"><?php echo head($value,2);?></div>
            <div class="weui-cell__bd">
              <h4><?php echo $value['username'];?></h4>
              <p class="c4"><?php echo $value['bio'];?></p>
            </div>
            <div class="weui-cell__ft">
            <?php if($value['level']=='127') { ?><?php echo $topicgroup['127']['name'];?><?php } else { ?><?php echo $topicgroup['126']['name'];?><?php } ?>
            </div>
          </a>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if($topic['maxleaders']) { ?>
        <a class="weui-cell weui-cell_access load" href="topic.php?mod=action&ac=apply&tid=<?php echo $_GET['tid'];?>&level=127">
          <div class="weui-cell__bd"><p>申请<?php echo $topicgroup['127']['name'];?></p></div>
          <div class="weui-cell__ft s12">还有<?php echo $topic['maxleaders'];?>个名额</div>
        </a>
        <?php } ?>
        <?php if($topic['maxmanagers']) { ?>
        <a class="weui-cell weui-cell_access load" href="topic.php?mod=action&ac=apply&tid=<?php echo $_GET['tid'];?>&level=126">
          <div class="weui-cell__bd"><p>申请<?php echo $topicgroup['126']['name'];?></p></div>
          <div class="weui-cell__ft s12">还有<?php echo $topic['maxmanagers'];?>个名额</div>
        </a>
        <?php } ?>
      </div>
      <div class="box b_c3 mb10 mt10">
        <h3 class="box_title cl"><span>成员列表</span></h3>
        <div class="users">
          <div class="autolist">
          <?php include temp('topic/viewtopic_ajax'); ?>          </div>

        </div>
      </div> 
      <?php if($maxpage>1) { ?>
      <div id="page">
      <a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>"><span class="weui-loadmore__tips">下一页</span></a>
      </div>
      <?php } ?>
      
      
      <?php } else { ?>
      <div class="scrollx topnv navs b_c3 bob o_c3 mb10">
        <div class="scrollx_area">
          <ul class="c">
            <li<?php if($_GET['order']=='new') { ?> class="c1 o_c1"<?php } ?> id="type_<?php echo $_GET['tid'];?>_new">
              <a href="topic.php?tid=<?php echo $_GET['tid'];?>&order=new" class="get" box="vt_<?php echo $_GET['tid'];?>_new" btn="type_<?php echo $_GET['tid'];?>_new">最新</a>
            </li>
            <li<?php if($_GET['order']=='hot' && !$_GET['typeid']) { ?> class="c1 o_c1"<?php } ?> id="type_<?php echo $_GET['tid'];?>">
              <a href="topic.php?tid=<?php echo $_GET['tid'];?>&order=hot" class="get" box="vt_<?php echo $_GET['tid'];?>_hot" btn="type_<?php echo $_GET['tid'];?>">最热</a>
            </li>
            <li<?php if($_GET['order']=='searchcall') { ?> class="c1 o_c1"<?php } ?> id="type_searchcall">
              <a href="topic.php?show=searchcall" class="get" box="vt_searchcall" btn="type_searchcall">小号</a>
            </li>
  
<li<?php if($_GET['order']=='tips' && !$_GET['typeid']) { ?> class="c1 o_c1"<?php } ?> id="type_tips">
              <a href="topic.php?tid=<?php echo $_GET['tid'];?>&show=tips" class="get" box="vt_tips" btn="type_tips">攻略</a>
            </li>
  
<li<?php if($_GET['order']=='XXX' && !$_GET['typeid']) { ?> class="c1 o_c1"<?php } ?> id="type_XXX">
              <a href="topic.php?tid=<?php echo $_GET['tid'];?>&show=XXX" class="get" box="vt_XXX" btn="type_XXX">发票查询</a>
            </li>

            <?php if(is_array($topic['types'])) foreach($topic['types'] as $id => $name) { ?>            <li<?php if($_GET['typeid']==$id) { ?> class="c1 o_c1"<?php } ?> id="type_<?php echo $_GET['tid'];?>_<?php echo $id;?>">
              <a href="topic.php?tid=<?php echo $_GET['tid'];?>&typeid=<?php echo $id;?>" class="get" box="vt_<?php echo $_GET['tid'];?>_new<?php echo $id;?>" btn="type_<?php echo $_GET['tid'];?>_<?php echo $id;?>"><?php echo $name;?></a>
            </li>
            <?php } ?>          
          </ul>  
        
        </div>
      </div>
       
      <?php if($tops) { ?>
      <ul class="toplist b_c3 o_c3<?php if(count($tops)<4) { ?> mb10<?php } ?>" <?php if(count($tops)>3) { ?>style="height:122px;"<?php } ?>>
        <?php if(is_array($tops)) foreach($tops as $value) { ?>        <li class="bob o_c3 ellipsis"><a href="topic.php?vid=<?php echo $value['vid'];?>" class="load"><span class="b_c8 c3">顶</span><?php echo $value['subject'];?></a></li>
        <?php } ?>
      </ul>
      <?php if(count($tops)>3) { ?>
      <a href="javascript:SMS.unfold('unfoldtoplist','.toplist',122)" class="icon icon-expanding bot o_c3 b_c3" id="unfoldtoplist"></a><?php } ?>
      <?php } ?>
      
      <div class="ready current themeslist" id="vt_<?php echo $_GET['tid'];?>_new"><?php include temp('topic/viewtopic_ajax'); ?></div>
      <div class="themeslist" id="vt_<?php echo $_GET['tid'];?>_hot" style="display:none"></div>
      
      <?php if(is_array($topic['types'])) foreach($topic['types'] as $id => $name) { ?>      <div class="themeslist" id="vt_<?php echo $_GET['tid'];?>_new<?php echo $id;?>" style="display:none"></div>
      <?php } ?>      
      
      <div id="page">
      <?php if($maxpage>1) { ?>
      <a href="<?php echo $nexturl;?>" id="autoload" class="weui-loadmore block auto" curpage="<?php echo $_S['page'];?>" total="<?php echo $maxpage;?>" area="#vt_<?php echo $_GET['tid'];?>_new" <?php if($topic['liststype']=='5') { ?>type="water"<?php } ?>><span class="weui-loadmore__tips">下一页</span></a>
      <?php } ?>   
      </div>
      <?php } ?>
      <?php } ?>
      <div class="weui-actionsheet" id="topicsheet">
        <div class="weui-actionsheet__menu">
          <a href="topic.php?mod=action&ac=out&tid=<?php echo $topic['tid'];?>" class="weui-actionsheet__cell c6 load" loading="tab">退出</a>
          <?php if($canmanage) { ?>
          <a href="topic.php?mod=manage&tid=<?php echo $topic['tid'];?>" class="weui-actionsheet__cell c6 load">管理</a>
          <?php } ?>
          <?php if($_S['uid']) { ?>
          <a href="index.php?mod=feed&type=3&ref=topic.php?tid=<?php echo $_GET['tid'];?>" class="weui-actionsheet__cell c6 load">举报</a>
          <?php } ?>
        </div>
        <div class="weui-actionsheet__action">
          <a href="javascript:" class="weui-actionsheet__cell c1">取消</a>
        </div>
      </div>      
    </div>
  </div>
  <div id="footer"> 
    <?php if($topic['price'] && !$topic['level'] && !$canmanage) { ?>
    <a href="topic.php?mod=action&ac=join&tid=<?php echo $topic['tid'];?>" class="load buytopic c3 b_c1" loading="tab">加入小组</a>
    <?php } else { ?>
    <?php if(!$_S['setting']['closebbs']) { ?>
    <a href="topic.php?mod=post&tid=<?php echo $topic['tid'];?>" class="icon icon-write addtopic b_c8 load" loading="tab"></a>
    <?php } ?>
    <?php } ?>
  </div>
</div>
<div id="smsscript">
  <?php if($topic['liststype']=='5') { ?>
  <script language="javascript" reload="1">
    var wf = {};
$('.currentbody').ready(function(){
if($('.currentbody #waterfall').length >0) {
wf = waterfall();
}
});
  </script>
  <?php } ?>
  <?php include temp('wechat'); ?>  <?php include temp('wechat_shar'); ?></div><?php include temp('footer'); ?>