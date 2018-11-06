<?exit?>
 <div class="weui-search-bar" id="liveSearchBar">
   <form class="weui-search-bar__form">
     <div class="weui-search-bar__box"> <i class="weui-icon-search"></i>
       <input type="search" class="weui-search-bar__input" id="liveSearchInput" onkeyup="showLiveSearchResult(this.value)" name="k" placeholder="搜索" required>
       <a href="javascript:" class="weui-icon-clear" id="liveSearchClear"></a>
     </div>
     <label class="weui-search-bar__label" id="liveSearchText"> <i class="weui-icon-search"></i> <span>搜索</span> </label>
   </form>
   <a href="javascript:" class="weui-search-bar__cancel-btn" id="liveSearchCancel">取消</a>
 </div>
 <div id="liveSearch" class="weui-cells searchbar-result"></div>
