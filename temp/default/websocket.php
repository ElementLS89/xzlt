<?exit?>

<script language="javascript">
  <!--{if $_S['uid'] && $_S[setting][websocket]}-->
	var ws;
	var lockReconnect = false;
	var uri = '$_S[setting][protocol]://$_S[setting][wsip]:$_S[setting][wsport]';

	function createWebSocket(uri) {
		try {
			ws = new WebSocket(uri);
			initEventHandle();
		} catch (e) {
			reconnect(uri);
		}     
	}

	function initEventHandle() {
		ws.onclose = function () {
			reconnect(uri);
		};
		ws.onerror = function () {
			reconnect(uri);
		};
		ws.onopen = function (event) {
			
			if(ws.readyState==1){
				sendnotice('type=add+uid=$_S[uid]');
			}else{
				createWebSocket(url);
			}
		};
		ws.onmessage = function (event) {
			var msg = event.data;
			if(msg!='rest'){
				eval(msg);
			}
			heartCheck.reset().start();
		}
	}
	
	function reconnect(url) {
		if(lockReconnect) return;
		lockReconnect = true;
		setTimeout(function (){createWebSocket(url);lockReconnect = false;}, 2000);
	}
	
	function sendnotice(msg){
		if(ws){
			ws.send(msg);
		}else{
			reconnect(uri);
		}
	}
	
	var heartCheck = {
		timeout: 30000,
		timeoutObj: null,
		serverTimeoutObj: null,
		reset: function(){
			clearTimeout(this.timeoutObj);
			clearTimeout(this.serverTimeoutObj);
			return this;
		},
		start: function(){
			var self = this;
			this.timeoutObj = setTimeout(function(){
				sendnotice("type=add+uid=$_S[uid]");
				self.serverTimeoutObj = setTimeout(function(){
				  ws.close();
				}, self.timeout)
			}, this.timeout)
		}
	}
	createWebSocket(uri);
	<!--{else}-->
	function sendnotice(msg){
		return true;
	}	
	<!--{/if}-->

</script>

