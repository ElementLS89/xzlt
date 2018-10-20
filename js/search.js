$(function(){
	var searchBar = $('.currentbody #searchBar'),
			searchResult = $('.currentbody #searchResult'),
			searchText = $('.currentbody #searchText'),
			searchInput = $('.currentbody #searchInput'),
			searchClear = $('.currentbody #searchClear'),
			searchCancel = $('.currentbody #searchCancel');

	function hideSearchResult(){
		searchResult.hide();
		searchInput.val('');
	}
	function cancelSearch(){
		hideSearchResult();
		searchBar.removeClass('weui-search-bar_focusing');
		searchText.show();
	}

	searchText.on('click', function(){
		searchBar.addClass('weui-search-bar_focusing');
		searchInput.focus();
	});
	searchInput
		.on('blur', function () {
			if(!this.value.length) cancelSearch();
		})
		.on('input', function(){
			if(this.value.length) {
				searchResult.show();
			} else {
				searchResult.hide();
			}
		})
	;
	searchClear.on('click', function(){
		hideSearchResult();
		searchInput.focus();
	});
	searchCancel.on('click', function(){
		cancelSearch();
		searchInput.blur();
	});
});