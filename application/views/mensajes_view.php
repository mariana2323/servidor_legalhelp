<?php
$html = "<style>
*{
	margin:0;
	padding:0;
	font-family: tahoma, sans-serif;
	box-sizing: border-box;
}
body {
	background: #1ddced;
	width: 100%;
	box-sizing: border-box;
}
.chatbox {
	width: fit-content;
	min-width: 100%;
	height: 100%;
	background: #fff;
	padding: 25px;
	margin: 10px auto;
	box-shadow: 0 3px #ccc;
}
.chatlogs {
	width: 100%;
	height: 100%;
	overflow-x: hidden;
	overflow-y: scroll;
}
.chatlogs::-webkit-scrollbar {
	width: 10px;
}
.chatlogs::-webkit-scrollbar-thumb {
	border-radius: 5px;
	background: rgba(0,0,0,0.1);
}
.chat {
	display: flex;
	flex-flow: row wrap;
	align-items: flex-start;
	margin-bottom: 10px;
}
.chat .user-photo {
	width: 60px;
	height: 60px;
	background: #ccc;
	border-radius: 50%;
	overflow: hidden;
}
.chat .user-photo img{
	width: 100%;
}
.chat .chat-message {
	width: 70%;
	padding: 15px;
	margin: 5px 10px 0;
	border-radius: 10px;
	color: #fff;
	font-size: 15px;
}
.friend .chat-message {
	background: #ff5b33;
}
.self .chat-message {
	background: #ffb233;
	order: -1;
}
.chat-form {
	margin-top: 20px;
	display: flex;
	align-items: flex-start;
}
.chat-form textarea {
	background: #fbfbfb;
	width: 75%;
	height: 50px;
	border: 2px solid #eee;
	border-radius: 3px;
	resize: none;
	padding: 10px;
	font-size: 15px;
	color: #999;
}
.chat-form textarea:focus {
	background: #fff;
}
.chat-form textarea::-webkit-scrollbar {
	width: 10px;
}
.chat-form textarea::-webkit-scrollbar-thumb {
	border-radius: 5px;
	background: rgba(0,0,0,0.1);
}
.chat-form button {
	background: #1adda4;
	padding: 5px 15px;
	font-size: 30px;
	color: #fff;
	border:none;
	margin: 0 10px;
	border-radius: 3px;
	box-shadow: 0 3px 0 #0eb2c1;
	cursor: pointer;
	
	-webkit-transition: background .2s ease;
	-moz-transition: background .2s ease;
	-o-transition: background .2s ease;
}
.chat-form button:hover {
	background: #13c8d9;
}</style>";

if (!empty($data)):
  $html .= '<div class="chatbox" id="messageBody">
		<div class="chatlogs">';
  foreach ($data as $d):
    $html .= '<div class="' . $d["class"] . '">
				<div class="user-photo"><img src="../servidor_legalhelp/img/'.$d["imagen"].'" width="50px"></div>
				<p class="chat-message">' . $d["mensaje"] . '</p>
			</div>';
  endforeach;
  $html .= '</div>
	</div>';
endif;
echo $html;
/*<div class="chat self">
				<div class="user-photo"><img src="../servidor_legalhelp/img/usr2.jpg" width="50px"></div>
				<p class="chat-message">Hola como estas? Soy Juan</p>
			</div>*/