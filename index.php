<?
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$bd = array(
		"sss" => array("c"=>1,"o"=>40,"q"=>350),
		"ssps" => array("c"=>1,"o"=>15,"q"=>200),
		"sbsps" => array("c"=>2,"o"=>50,"q"=>200),
		
		"ass" => array("c"=>1,"o"=>36,"q"=>300),
		"asps" => array("c"=>1,"o"=>22,"q"=>200),
		"absps" => array("c"=>2,"o"=>70,"q"=>200),
		
		"bss" => array("c"=>1,"o"=>54,"q"=>450),
		"bsps" => array("c"=>1,"o"=>15,"q"=>150),
		"bbsps" => array("c"=>2,"o"=>16,"q"=>100),
		
		"css" => array("c"=>2,"o"=>30,"q"=>952),
		"csps" => array("c"=>1,"o"=>10,"q"=>200),
		"cbsps" => array("c"=>2,"o"=>30,"q"=>200),
		
		"dss" => array("c"=>3,"o"=>9,"q"=>468),
		"dsps" => array("c"=>1,"o"=>3,"q"=>100),
		"dbsps" => array("c"=>2,"o"=>8,"q"=>100),
	);	

	$type = $_POST["type"];
	$grade = $_POST["grade"];
	$cprice = $_POST["cprice"];
	$oprice = $_POST["oprice"];
	$howmanywhat = $_POST["howmanywhat"];
	$howmany = $_POST["howmany"];
	$sprice = $_POST["sprice"];

	if (!is_numeric($cprice))
	{
		echo "{type:0, text:\"Please type the field 'Crystal price'\",package:\"cprice\"}";
		die();
	}
	
	if (!is_numeric($oprice))
	{
		echo "{type:0, text:\"Please type the field 'Soul/spirit ore price'\",package:\"oprice\"}";
		die();
	}
	if ((strlen($howmany) != 0) && (!is_numeric($howmany))) //Se tiver algo escrito e não for número
	{
		echo "{type:0, text:\"Please type correctly the field 'How many...'\",package:\"howmany\"}";
		die();
	}
	
	$index = $grade.$type;
	$line = $bd[$index];
	$c = $line["c"];
	$o = $line["o"];
	$q = $line["q"];
	
	$pcost = ($cprice * $c) + ($oprice * $o); //custo por pacote
	$ucost = $pcost/$q; //custo por item
	
	if ($howmanywhat == "s") { $packages = $howmany/$q;	}
	else if ($howmanywhat == "c") { $packages = $howmany/$c; }
	else { $packages = $howmany/$o; }
	
	$packages = ceil($packages); //arredonda para cima a quantidade de pacotes necessários	
	$tc = $c*$packages;
	$to = $o*$packages;
	$tq = $q*$packages;
	$tcost = $pcost*$packages; //custo todos os pacotes
	$lgross = 0;
	$lnet = 0;
	if ($sprice > 0){
		$lgross = $tq * $sprice;
		$lnet = $lgross - $tcost;
	}
	
	$ucost = number_format($ucost,2,",",".");
	$tcost = number_format($tcost,0,",",".");
	$pcost = number_format($pcost,0,",",".");
	$lgross = number_format($lgross,0,",",".");
	$lnet = number_format($lnet,0,",",".");
	
	echo "{type:1,text:'Ok',package:{c:$c, o:$o, q:$q, lnet: \"$lnet\", lgross: \"$lgross\", pcost:\"$pcost\", ucost:\"$ucost\", packages:$packages,  tcost:\"$tcost\",  tc:$tc, to:$to, tq:$tq }}";
	die();
}
?>
<html>
	<head>
		<title>Lineage II - Soulshot/Spiritshot calculator</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="Tool to calculate Soulshots/Spiritshots/Blessed Spirishots costs in Lineage II" />
		<meta name="keywords" content="Lineage II, Lineage 2, Adena, Soul Ore, Spirit Ore, Crystal, Soulshot, Spirishot, Blessed Spirishot, Grade D, Grade C, Grade B, Grade A, Grade S, Calculator,sss,ssps,sbsps,ass,asps,absps,bss,bsps,bbsps,css,csps,cbsps,dss,dsps,dbsps" />
		<link rel="stylesheet" type="text/css" href="screen.css" media="screen" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
		<script type="text/javascript" src="scripts.js"></script>
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try {
			var pageTracker = _gat._getTracker("UA-683660-11");
			pageTracker._trackPageview();
			} catch(err) {}
		</script>
	</head>
	<body>
		<div id="container">
			<h1>Lineage II - Soulshot/Spiritshot calculator</h1>


			<p>
				This tool will help you to calculate how much
				Crystals, Soul Ore / Spirit Ore 
				and Adena you need to Craft Soulshots / Spiritshots and Blessed Spiritshots 
				in Lineage II.
			</p>
			<p>
				You can calculate how much Adena you need to Craft Shots Grade D, Grade C, Grade B, Grade A and Grade S.
			</p>
			<p>
				Save your Adena in Lineage II, resell Shots and become rich, lol!
			</p>
			<form action="./" method="post" id="sscalc">
				<ul>
					<li>
						<label for="type">Type:</label>
						<select id="type" name="type" id="type">
							<option value="ss">Soulshot</option>
							<option value="sps">Spirit Shot</option>
							<option value="bsps">Blessed Spirit Shot</option>
						</select>
					</li>
					<li>
						<label for="grade">Grade:</label>
						<select id="grade" name="grade">
							<option value="s" selected="selected">S grade</option>
							<option value="a">A grade</option>
							<option value="b">B grade</option>
							<option value="c">C grade</option>
							<option value="d">D grade</option>
						</select>
					</li>
					<li>
						<label for="cprice">Crystal price:</label>
						<input type="text" name="cprice" id="cprice" />
					</li>
					<li>
						<label for="oprice"><span class="ore">Soul</span> ore price:</label>
						<input type="text" name="oprice" id="oprice" />
					</li>
					<li>
						<label for="sprice">Sell price:</label>
						<input type="text" name="sprice" id="sprice" value="0" />
					</li>
					<li>
						<select name="howmanywhat" onchange="clearResult();" class="label">
							<option value="s">How many SS do you want?</option>
							<option value="c">How many Crystals do you have?</option>
							<option value="o">How many Ores do you have?</option>
						</select>
						<input type="text" name="howmany" id="howmany" value="" /><span>(Optional)</span>
					</li>
					<li>
						<input class="submit" type="submit" value="Show me!"" />
					</li>
				</ul>
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-2268587471230937";
				/* SSCalc */
				google_ad_slot = "4353504306";
				google_ad_width = 468;
				google_ad_height = 60;
				//-->
				</script>
				<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
				<div id="result">
					<ul>
						<li>
							<label for="c">Crystal per package:</label>
							<div class="result" id="c"></div>
						</li>
						<li>
							<label for="o"><span class="ore">Soul</span> ore per package:</label>
							<div class="result" id="o"></div>
						</li>
						<li>
							<label for="q">SS Quantity per package:</label>
							<div class="result" id="q"></div>
						</li>
						<li>
							<label for="pcost">Cost per package:</label>
							<div class="result" id="pcost"></div>
						</li>
						<li>
							<label for="ucost">Cost unique item:</label>
							<div class="result" id="ucost"></div>
						</li>
					</ul>
					<ul id="totals">		
						<li>
							<label for="packages">Packages:</label>
							<div class="result" id="packages"></div>
						</li>	
						<li>
							<label for="tc">Total crystals:</label>
							<div class="result" id="tc"></div>
						</li>
						<li>
							<label for="to">Total <span class="ore">Soul</span> ores:</label>
							<div class="result" id="to"></div>
						</li>
						<li>
							<label for="tq">Total SS quantity:</label>
							<div class="result" id="tq"></div>
						</li>
						<li>
							<label for="tcost">Total cost:</label>
							<div class="result" id="tcost"></div>
						</li>
						<li>
							<label for="lgross">Gross profit:</label>
							<div class="result" id="lgross"></div>
						</li>
						<li>
							<label for="lnet">Net profit:</label>
							<div class="result" id="lnet"></div>
						</li>	
					</ul>
				</div>
				<address>Created by Lucyus and Safado from Chronos</address>
			</form>
		</div>
	</body>
</html>
