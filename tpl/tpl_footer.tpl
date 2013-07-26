			<!-- Yandex.Metrika informer -->
			<a href="http://metrika.yandex.ru/stat/?id=10127455&amp;from=informer"
			target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/10127455/1_0_FFFFFFFF_EFEFEFFF_0_visits"
			style="width:80px; height:15px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (визиты)" onclick="try{Ya.Metrika.informer({i:this,id:10127455,type:0,lang:'ru'});return false}catch(e){}"/></a>
			<!-- /Yandex.Metrika informer -->

			<!-- Yandex.Metrika counter -->
			<div style="display:none;"><script type="text/javascript">
			(function(w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter10127455 = new Ya.Metrika({id:10127455, enableAll: true, ut:"noindex"});
					}
					catch(e) { }
				});
			})(window, "yandex_metrika_callbacks");
			</script></div>
			<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
			<noscript><div><img src="//mc.yandex.ru/watch/10127455?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
			<!-- /Yandex.Metrika counter -->
			<?
			//$loadTime = number_format(microtime(true) - $t1,5);
			$seconds = ($oEngine->timer() - $tstart);
			$phptime = 		$seconds - $querytime;
			$query_time = 	$querytime;
			$percentphp = 	number_format(($phptime/$seconds) * 100, 2);
			$percentsql = 	number_format(($query_time/$seconds) * 100, 2);
			$seconds = 		substr($seconds, 0, 8);
			?>
			
			<!--<br /><?=$seconds?> сек.<br />-->
		</div>
	</body>
</html>