<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<meta charset=utf-8 />


</head>
<body>
</body>
</html>
<?php
	
	
	
	$urlParams = explode('/', $_SERVER['REQUEST_URI']);
	//echo sizeof($urlParams)."<br/>";
	$func_name=$urlParams[sizeof($urlParams)-1];
	$mystring = $func_name;
	$findme   = '?q=';
	$pos = strpos($mystring, $findme);
	//if($pos==false)echo "21321";
	$devide=explode('?q=', $func_name);
	$functionName = $devide[0];
	$functionName($urlParams);
	$data1 = array();
	function greetings(){
		//echo "asdasd<br/>";
		$v=$_GET['q'];
		$v = strtolower($v);
		//echo "<br/>";
		$mystring = $v;
		$findme   = 'how';
		$pos = strpos($mystring, $findme);
		$d="";
		if($pos==true){
			$d="Hello, Kitty! I am Fine.";
		}
		else {
			$mystring = $v;
			$findme   = 'name';
			$pos = strpos($mystring, $findme);
			if($pos==true){
				$d="Hello, Kitty! I am a bot.";
			}
			else {
				$mystring = $v;
				$findme   = 'kitty';
				$pos = strpos($mystring, $findme);
				if($pos==true){
					$d="Hello, Kitty! Same to you.";
				}
				else {
					$d="Hello, Kitty! Its great pleasure to meet you.";
				}
			}
		}
		
		$rows = array( 
					'answer'=>$d 
			); 

		echo json_encode($rows);
		
	}
	function weather(){
		//echo "asdasd<br/>";
		$v=$_GET['q'];
		$v = strtolower($v);
		$aa=explode('in ', $v);
		$html = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$aa[sizeof($aa)-1]);
		$data1=$html;
		//print_r($data);
		$data=json_decode($data1,TRUE);
		//echo "<br/>";
		$mystring = $v;
		$findme   = 'temperature';
		$pos = strpos($mystring, $findme);
		$d="";
		if($pos==true){
			$d=$data['main']['temp']."K";
		}
		else {
			$mystring = $v;
			$findme   = 'humidity';
			$pos = strpos($mystring, $findme);
			if($pos==true){
				$d=$data['main']['humidity']."%";
			}
			else {
				$mystring = $v;
				$findme   = 'rain';
				$pos = strpos($mystring, $findme);
				if($pos==true){
					if($data['weather']['main']=="Rain")$d="Yes";
					else $d="No";
				}
				else {
					$mystring = $v;
					$findme   = 'clouds';
					$pos = strpos($mystring, $findme);
					if($pos==true){
						if($data['weather']['main']=="Clouds")$d="Yes";
						else $d="No";
					}
					else {
						$mystring = $v;
						$findme   = 'clear';
						$pos = strpos($mystring, $findme);
						if($pos==true){
							if($data['weather']['main']=="Clear")$d="Yes";
							else $d="No";
						}
					}
				}
			}
		}
		$rows = array( 
					'answer'=>$d 
			); 

		echo json_encode($rows);
		
	}
	$sparqlQuery="";
	$z=0;
	function qa(){
	
		$url="http://quepy.machinalis.com/engine/get_query";
		$v=$_GET['q'];
		$v = strtolower($v);
		$qu1=$v;
		$qu1=str_replace("%3F","",$qu1);
		$qu=str_replace(" ","+",$qu1);
		$html = file_get_contents($url."?question=".$qu);
		$data1=$html;
		//print_r($data1);
		$data=json_decode($data1,TRUE);
		$q=$data["queries"][0]["query"];
		//echo $q;
		//$q="";
		if($q!="")
		{
			$q = urlencode($q);
			
			//$for = urlencode("application/sparql-results+json");
			
			$url="http://dbpedia.org/sparql?debug=on&timeout=0&query=$q&default-graph-uri=&format=application%2Fsparql-results%2Bjson";
			
			//echo $url;
			
			$html = file_get_contents($url);
			$data1=$html;
			$data=json_decode($data1,TRUE);
			
			//print_r($data);
			$d="";
			for($i=0;$i<sizeof($data['results']['bindings']);$i++){
				if($data['results']['bindings'][$i]['x1']['xml:lang']=="en")
					 $d=$data['results']['bindings'][$i]['x1']['value'];
				
			}
		}
		else {
			$d="Your majesty! Jon Snow knows nothing! So do I!";
		}
		if($d=="")$d="Your majesty! Jon Snow knows nothing! So do I!";
		$rows = array( 
					'answer'=>$d 
			); 

		echo json_encode($rows);
	}
	
/*
	function func1 ($urlParams) {
		echo "In func1";
	}

	function func2 ($urlParams) {
		echo "In func2";
		echo "<br/>Argument 1 -> ".$urlParams[3];
		echo "<br/>Argument 2 -> ".$urlParams[4];
	}*/
	
?>


