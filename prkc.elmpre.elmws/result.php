<?php

$filename = $_FILES["filebutton"]["name"];

//deal with the file(get $filename,$newname,copy file to upload)
$tocomp = 0;
if($_FILES["filebutton"]["size"]>20*1024*1024)
{
	echo "<span class=\"citation\">Sorry, the file you uploaded is too large (> 20M), please contact Zexian Liu.</span><p>";
	exit;
}
else if($_FILES["filebutton"]['error'] == UPLOAD_ERR_NO_FILE)
{
	echo "<span class=\"citation red\">Note: we'll use the default fasta file.</span><p>";
	$filename = "Default_example.fasta";
	$newname = "example.fasta";
	$tocomp = 1;
}
else if($_FILES["filebutton"]['error'] == UPLOAD_ERR_OK)
{
	$newname=date("YmdHis").".".$filename;
	copy($_FILES["filebutton"]["tmp_name"],"upload//".$newname);
	$tocomp = 1;
}
else
{
	echo "<span class=\"citation\">Sorry, error occured when upload the file, please check your file or contact Zexian Liu.</span><p>";
}


if($tocomp == 1)
{
	$chain = $_POST["radios"];
	echo "<span class=\"citation\">Prediction for fasta file: $filename <br>";
	chdir ('/var/www/html/prkc/libsvm-3.22/python/');
	$exe = "python prkc_predict.py -T ../../upload/".$newname." -j ".$chain." -c 32.0 -g 2.0 ./files/model_peptide.txt ./files/trainscore";
	//echo $exe;
	exec($exe,$output);
	foreach ($output as $value){
		if (preg_match("/^>/",$value)){
			$value = preg_replace("/>/","",$value);
			echo "$value <br>";
		}
	}
	echo $output;
//	$filename = "../../input.txt";
//	$handle = fopen($filename,'w+');
//	fwrite($handle,$output);
//	fclose($handle);
//	chdir ('/var/www/html/prkc/');
	
	
}


echo "<h4>Show all lines with the peptide </h4>";
?>
<br>
<a href="index.php">Return to main page</a>