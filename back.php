<!doctype>
<html>
	<head>
		<title>FAQ (back)</title>

		<meta charset="utf-8">
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="theme-color" content="#b7a191" />

		<link href="./styles.css?4" rel="stylesheet" type="text/css">
<!-- 		<link href="./bootstrap3.min.css" rel="stylesheet" type="text/css"> -->
	</head>

	<body>
	
		<div id="editor"></div>

		<script src="jquery-3.3.1.min.js"></script>
		<script src="jsoneditor.js"></script>
		<script type="text/javascript">
			$(function(){
				
				$.ajax({
					  method: "GET",
					  url: "./process.php",
					  data: { type: 'get', data: 'data' }
					})
				  .done(function(r) {
					  console.log(r);
					  var startval = JSON.parse(r);
//					  var startval = null;
				
						var schema = {
						  "title": "FAQ",
						  "type": "object",
						  "properties": {
							  "mindurationtoreadbubble": {
								  "title": "Min Duration To Read Bubble",
								  "type":"string",
							  },
						    "questionsandanswers": {
						      "title": "Questions & réponses",
						      "type": "array",
						      "items": {
						        "type": "object",
						        "title": "Question/réponse",
						        "properties": {
						          "question": {
						            "type": "string",
								        "title": "Question",
						            "format":"textarea",
												"class": "bubble-question",
						          },
						          "answers": {
							          "type": "array",
								        "title": "Réponse(s)",
								        "items": {
									        "type": "object",
									        "title": "Réponse",
									        "properties": {
										        "answer": {
															"title": "Réponse",
									            "type": "string",
									            "format":"textarea",
									            "links": {
																"class": "bubble-answer",
															}
									          }
													}
								        }   
						          }
						        }
						      },
						      "default": [
						        {
						          "question": "Question ?",
						          "answers": [
							          {
								          "answer": "Réponse en…"
								        },
							          {
								          "answer": "…deux temps"
								        }
						          ]
						        }
						      ]
						    }
						  }
						};
						
						var editorDOM = $("#editor")[0];
						  
						var editor = new JSONEditor(editorDOM, {
					    schema: schema,
					    theme: 'bootstrap3',
					    startval:startval,
					    disable_collapse: true,
							disable_edit_json: true,
							disable_properties: true,
							disable_array_delete_all_rows: true,
							disable_array_delete_last_row: true,
					  });
					  
					  editor.on('ready', function(){
						  updateFormCSS();
					  });
						  
						editor.on('change',function() {
						  updateFormCSS();
						  
						  var errors = editor.validate();
			
							if(errors.length) {
							  console.log(errors);
							}
							
							else {
								console.log(editor.getValue());
								
							  $.ajax({
								  method: "GET",
								  url: "./process.php",
								  data: { type: 'post', data: 'data', fields: {
									  'data': JSON.stringify((editor.getValue()))
									} }
								})
							}
						});
						
						function updateFormCSS() {
							
						  $('[data-schemapath]').each(function(){
							  var structure = $(this).data('schemapath');
							  var CSSclass = structure.replace(/\d+/g,'i');
							  CSSclass = CSSclass.replace(/\.+/g,'-');
								$(this).addClass(CSSclass);
							});
							
							$('textarea').off('keyup').on('keyup', function(){
								autoHeight($(this));
							}).trigger('keyup');
						}
						
						function autoHeight(elem) {							
							elem.css('height','5px');
							elem.css('height', elem[0].scrollHeight + 'px');
						}
					});
			});
		</script>
		
		<style type="text/css">
			* {
				text-align:left;
			}
			
			html, body {
				background:#efefef;
			}
			
			h3 {
				font-size:16px;
				font-weight:bold;
			}
			
			.root {
				max-width:700px;
				margin:0 auto;
			}
			
			button {
				background:transparent;
				color:#333;
				padding:3px 5px;
				border:none;
				font-size:12px;
			}
			
			.json-editor-btn-delete, .json-editor-btn-movedown, .json-editor-btn-moveup
			{
				width:30px;
				height:30px;
				border-radius:100px;
				font-size:0;
				border:solid 2px #333;
				background: no-repeat center center / 70% auto;
				margin:0 1px;
			}
			
			.json-editor-btn-add {
				height:30px;
				border-radius:100px;
				font-size:12px;
				color:#333;
				border:solid 2px #333;
				padding:0 8px;
				margin:0 1px;	
			}
			
			.json-editor-btn-delete {
				background-image:url(img/delete_black.svg);
			}
			
			.json-editor-btn-moveup {
				background-image:url(img/up_black.svg);
			}
			
			.json-editor-btn-movedown {
				background-image:url(img/down_black.svg);
			}
			
			.root-questionsandanswers-i-answers > .well > .btn-group {
				text-align:right;
				display:block !important;
				margin-top:5px;
			}
			
			.root-questionsandanswers-i {
				border-top:dotted 1px #aaa;
				padding:20px;
				margin-bottom:10px;
				position:relative;
			}			
			
			.root-questionsandanswers-i h3 {
				margin:0;
			}
			
			.root-questionsandanswers-i > h3 {
				display: inline-block;
				width:110px;
				padding-right:10px;
		    vertical-align: top;
		    margin-top: 25px;
			}
			
			.root-questionsandanswers-i > h3 > .btn-group {
				margin:0 !important;
				text-align: left;
			}
			
			.root-questionsandanswers-i > .well {
				display: inline-block;
				width:520px;	
			}
			
			.root-questionsandanswers-i-answers-i {
				text-align:right;
			}
			
			.root-questionsandanswers-i-answers-i h3 {
				display: inline-block;
			}
			
			.root-questionsandanswers-i-answers-i > .well {
				display: inline-block;
				vertical-align: middle;
				width:75%;
			}
			
			.root-questionsandanswers-i-answers-i .btn-group {margin-right:15px;}
			
			.root-questionsandanswers-i-question {
				width:75%;
			}
			
			.root-questionsandanswers-i-question-i h3 {
				position:absolute;
				top:0;
				right:0;
			}
			
			.root-questionsandanswers-i-answers-i h3 > span,
			.root-questionsandanswers-i-question-i h3 > span {
				display: none;
			}
			
			.root-questionsandanswers-i > h3 > span,
			.root-questionsandanswers-i-answers-i > h3 > span {
				display:none; 
			}
			
			.root-questionsandanswers-i-answers > h3 {
				display:none;
			}
			
			.root-questionsandanswers-i textarea {
				border:none;
				min-height:60px;
				
			  margin: 10px 0 0;
			  background:  white;
			  padding: 12px 16px;
			  border-radius: 23px;
			  font-size: 16px;
			  color: #182944;
			  line-height: 1.15;
			  text-align:  left;
				
				width:100% !important;
			}
			
			.root-questionsandanswers-i .well {
				background:transparent;
			}
			
			.root-questionsandanswers-i-question .control-label,
			.root-questionsandanswers-i-answers-i-answer .control-label {
				display:none;
			}
			
			.root-questionsandanswers-i-question {}
			
			.root-questionsandanswers-i-question textarea {
				background:#111;
				color:white;
			}
			
			.root-questionsandanswers-i-answers-i-answer .form-group {
				text-align:right;
			}
		</style>
	</body>
</html>
