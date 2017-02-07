<?php
/*
*Template Name: PDF Generate
*/
?>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<style>
    input[type="text"]{border:none; border: 1px solid black; width: 182px;}
    .requiredfield{color:red;}
    .error{color:red;}
</style>
<body>
 
<center><h2>
Demo of HTML form to Dynamic PDF Generator - blog.theonlytutorials.com<br>
Script can be download from this link <a href="http://blog.theonlytutorials.com/simple-jquery-validation-custom-error-message/">Go to the Download page</a></h2>
</center>
<form id="myform" method="post" action="redi.php">   
    <table border="0" align="center">
      <tr><td>Name:</td><td><input type="text" name="name" id="name"  /></td></tr>
      <tr><td>Email:</td><td><input type="text" name="email" id="email"  /></td></tr>
      <tr><td>Message:</td><td><textarea name="message" id="message"></textarea></td></tr>
      <tr><td></td><td><input type="submit" id="submitbtn" name='submit'/></td></tr>
    </table>
</form>
</body>
</html>
<?php
if( isset($_REQUEST['submit']) )
{
    echo 'hiii';
include('mpdf/mpdf.php');
$name=$_REQUEST['name'];
$email=$_REQUEST['email'];
$msg=$_REQUEST['message'];
$tabledata="
<html>
<head>
<style>
body {font-family: sans-serif;
    font-size: 10pt;
}
td { vertical-align: top; 
    border-left: 0.6mm solid #000000;
    border-right: 0.6mm solid #000000;
    align: center;
}
table thead td { background-color: #EEEEEE;
    text-align: center;
    border: 0.6mm solid #000000;
}
td.lastrow {
    background-color: #FFFFFF;
    border: 0mm none #000000;
    border-bottom: 0.6mm solid #000000;
    border-left: 0.6mm solid #000000;
    border-right: 0.6mm solid #000000;
}

</style>
</head>
<body>

<!--mpdf
<htmlpagefooter name='myfooter'>
<div style='border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; '>
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name='myheader' value='on' show-this-page='1' />
<sethtmlpagefooter name='myfooter' value='on' />
mpdf-->

<div style='text-align:center;'>HTML Form to PDF - Blog.theonlytutorials.com</div><br>
<table class='items' width='100%' style='font-size: 9pt; border-collapse: collapse;' cellpadding='8'>
<thead>
<tr>
<td width='15%'>FIELDS</td>
<td width='15%'>VALUES</td>
</tr>
</thead>
<tbody>
<tr><td>Name</td><td>".$name."</td></tr>
<tr><td>Email</td><td>".$email."</td></tr>
<tr><td class='lastrow'>Your Message</td><td class='lastrow'>".$msg."</td></tr>
</tbody>
</table>
</body>
</html>";

$mpdf=new mPDF();
$mpdf->WriteHTML($tabledata);
$mpdf->SetDisplayMode('fullpage');
$mpdf->Output();
}
?>