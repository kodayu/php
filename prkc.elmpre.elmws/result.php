<?php
require("./include/head.php");
?>

<?php
//ȡԭ
$filename=$_FILES["fileinput"]["name"];
//ȡչ
//$file_ext=explode(".",$filename);
//$file_ext=$file_ext[count($file_ext)-1];
//$file_ext=strtolower($file_ext);

//жļС
$tocomp = 0;
if($_FILES["fileinput"]["size"]>20*1024*1024)
{
	echo "<span class=\"citation\">Sorry, the file you uploaded is too large (> 20M), please contact Zexian Liu.</span><p>";
	exit;
}
else if($_FILES['fileinput']['error'] == UPLOAD_ERR_NO_FILE)
{
	echo "<span class=\"citation red\">Note: we'll use the default pdb file.</span><p>";
	$filename = "Default_1AK0.pdb";
	$newname = "1AK0.pdb";
	$tocomp = 1;
}
else if($_FILES['fileinput']['error'] == UPLOAD_ERR_OK)
{
	//һµļ
	$newname=date("YmdHis").".".$filename;
	//ӻаļƵĿַ
	copy($_FILES["fileinput"]["tmp_name"],"upload//".$newname);
	$tocomp = 1;
}
else
{
	echo "<span class=\"citation\">Sorry, error occured when upload the file, please check your file or contact Zexian Liu.</span><p>";
}

if($tocomp == 1)
{
	$chain = $_POST["chain"];
	echo "<span class=\"citation\">Prediction for PDB: ".$filename."&nbsp;&nbsp;&nbsp;&nbsp;Chain: ".$chain."&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href=\"./upload/$newname\">The uploaded pdb file</a><br></span><p><p><p><p>";
	$exe = "/home2/biocucko/bin/java/jre/bin/java -jar ./comp/test.jar -www ./upload/".$newname." ".$chain;
	//echo $exe;
	exec($exe, $array);
	#exec("java -jar ./comp/test.jar -www 1A5T A", $array);
	#exec("./test.sh", $array);
	$resultArray = array();
	foreach ($array as $lineStr)
	{
		echo $lineStr."\n";
	}
}
#require("./comp/comp.php");
#exec("java -jar ./comp/test.jar", $array);
#exec("./test.sh", $array);
#$resultArray = array();
#foreach ($array as $lineStr)
#{
#	echo $lineStr;
#}
?>

<?php
require("./include/view.php");
require("./include/foot.php");
?>