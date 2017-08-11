<?php
require("./include/head.php");
?>
</td>
</tr>

<tr>
<td valign="middle" align="left" width="800">
<span class="title">Introduction</span><p>
<span class="citation">&nbsp;&nbsp;&nbsp;&nbsp;As one of the most essential metals utilized by organisms, zinc is critical for structural, catalytic and regulatory functions of proteins. Zinc-binding proteins play an important role in a variety of biological processes such as transcription regulation, cell metabolism and apoptosis. Characterizing the precise zinc-binding sites is fundamental for dissecting the biological functions and molecular mechanisms of zinc-binding proteins. Since experimental identification of <em>bona fide</em> zinc-binding sites is time-consuming and labor-intensive, a number of computational algorithms were adopted for training on known data set	.<br>
&nbsp;&nbsp;&nbsp;&nbsp;In this study, through careful analyses of zinc-binding sites in structurally characterized proteins, we proposed a training-free approach to characterize the zinc-binding sites from the protein structure, by simply limiting the range of distances among zinc and coordinating atoms. Based on this method, we developed a novel software of GRE4Zn (Geometric REstriction for Zinc-binding) for the prediction of zinc-binding sites, with a superior performance than other existed predictors.</span>
<p>
</td>
</tr>

<table width="800" height="343" border="1" align="center">
  <tr>
    <td><img src="./include/gre.png" width="400" height="343"></td>
    <td align="left">
<form method="POST" enctype="multipart/form-data" action="result.php">
&nbsp;&nbsp;<span class="title">Please upload a pdb file: </span><br>
&nbsp;&nbsp;<span class="citation">If you <span class="red">DON'T</span> upload file,<br>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="red">1AK0.pdb</span> will be calculated as default.
</span>
<br>
&nbsp;&nbsp;<input type="file" name="fileinput" size="20">
<p>
&nbsp;&nbsp;<span class="title">Please specify the chain codes: </span><br>
&nbsp;&nbsp;<span class="citation">All: All chains will be considered<br>
&nbsp;&nbsp;&nbsp;&nbsp;AB: Chain A and Chain B
</span>
<br>
&nbsp;&nbsp;<input name="chain" type="text" id="chain" value="All" style="width:200">
<p>
&nbsp;&nbsp;<input type="submit" value="Submit">
</form>
</td>
  </tr>
</table>

<?php
require("./include/foot.php");
?>