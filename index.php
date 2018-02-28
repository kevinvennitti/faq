<!doctype>
<html>
	<head>
		<title>FAQ</title>

		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="theme-color" content="#b7a191" />

		<link href="./styles.css?4" rel="stylesheet" type="text/css">
	</head>

	<body>
		<section class="screen screen-home">
			<div class="home-header">
				<h1>FAQ</h1>
				<h2>On répond à vos questions</h2>
			</div>

			<div class="home-messages">
				<div class="home-messages-inner">

				</div>
			</div>
			
		</section>


		<script src="jquery-3.3.1.min.js"></script>
		<script src="jsoneditor.js"></script>
		<script type="text/javascript">
			$(function(){
				
				MinDurationToReadBubble = 2500;
				DurationToReadEachChar = 65;
				DurationToRevealBubble = 1000;

				function loadData(refresh = false) {
					$.ajax({
					  method: "GET",
					  url: "./process.php",
					  data: { type: 'get', data: 'data' }
					})
				  .done(function(r) {
					  var data = JSON.parse(r);
					  
					  console.log(data);

					  for (var i = 0; i < data.questionsandanswers.length; i++) {
							insertQA(data.questionsandanswers[i]);
					  }

					  $(".home-messages").scrollTop($(".home-messages")[0].scrollHeight);
					  
					  $('.bubble-container').hide();
					  
					  showBubble();
						  
				  });
				}
				
				function showBubble() {
					var thisBubbleContainer = $('.bubble-container').eq(0);
					
					thisBubbleContainer.hide().slideDown(DurationToRevealBubble).appendTo($('.home-messages-inner'));
					
					var txt = thisBubbleContainer.find('.bubble').text();
						
					setTimeout(function(){
						showBubble();
					}, Math.max(txt.length * DurationToReadEachChar, MinDurationToReadBubble) );
				}

				function insertQA(qa) {
					var qaDOM = $('<div class="qa"></div>').addClass('qa');
					
					qaDOM.append(getBubble(qa.question, 'question'));
					
					for (var i = 0; i < qa.answers.length; i++) {
						qaDOM.append(getBubble(qa.answers[i].answer, 'answer'));
					}
					
					qaDOM.appendTo(".home-messages-inner");
						
					$(".home-messages").scrollTop($(".home-messages")[0].scrollHeight);
				}
				
				
				function getBubble(text, CSSclass) {
					var containerDOM = $('<div class="bubble-container bubble-container-'+CSSclass+'""></div>');
					var bubbleDOM = $('<div class="bubble bubble-'+CSSclass+'">'+text+'</div>');
					
					containerDOM.append(bubbleDOM);
					
					return containerDOM;
				}


				function init() {
					$(".home-messages").scrollTop($(".home-messages")[0].scrollHeight);

					loadData();
				}

				init();
			});
		</script>
	</body>
</html>
