<?php


$dbservertype='mysql';
$servername='localhost';
// username and password to log onto db server
$dbusername='root';
$dbpassword='Dodger01';
// name of database
$dbname='exeslogic';

////////////////////////////////////////
////// DONOT EDIT BELOW  /////////
///////////////////////////////////////
connecttodb($servername,$dbname,$dbusername,$dbpassword);
function connecttodb($servername,$dbname,$dbuser,$dbpassword)
{
global $link;
$link=mysql_connect ("$servername","$dbuser","$dbpassword");
if(!$link){die("Could not connect to MySQL");}
mysql_select_db("$dbname",$link) or die ("could not open db".mysql_error());
}


?>



<!doctype html public "-//w3c//dtd html 3.2//en">

<html>

<head>
<title>Organic Test Logic</title>
<meta name="GENERATOR" content="Arachnophilia 4.0">
<meta name="FORMATTER" content="Arachnophilia 4.0">

<SCRIPT language=JavaScript>

function reload(form)
{
var val=form.cat.options[form.cat.options.selectedIndex].value; 
self.location='testlogic.php?cat=' + val ;
}

function reload3(form)
{
var val=form.cat.options[form.cat.options.selectedIndex].value; 
var val2=form.subcat.options[form.subcat.options.selectedIndex].value; 

self.location='testlogic.php?cat=' + val + '&subcat=' + val2 ;
}

function reloadT(form)
{
var val=form.cat.options[form.cat.options.selectedIndex].value; 
var val2=form.subcat.options[form.subcat.options.selectedIndex].value;
var val3=form.subcat3.options[form.subcat3.options.selectedIndex].value;

self.location='testlogic.php?cat=' + val + '&subcat=' + val2 + '&subcat3=' + val3;
}

function reloadDC(form)
{
var val=form.cat.options[form.cat.options.selectedIndex].value; 
var val2=form.subcat.options[form.subcat.options.selectedIndex].value;
var val3=form.subcat3.options[form.subcat3.options.selectedIndex].value;
var val4=form.subcat4.options[form.subcat4.options.selectedIndex].value;


self.location='testlogic.php?cat=' + val + '&subcat=' + val2 + '&subcat3=' + val3 + '&subcat4=' + val4;
}


function reset(form)
{
self.location='testlogic.php?cat=' + '&subcat=' + '&subcat3=' + '&subcat4=';
}

</script>
</head>

<body background="Background.jpg" bgproperties="fixed">

<?php
include('menu.inc');
error_reporting(0);

///////// Getting the data from Mysql table for first list box//////////
 
$quer2=mysql_query("SELECT DISTINCT concat.strusage
 FROM concat
order by concat.strusage asc");

///////////// End of query for first list box////////////

/////// for second drop down list we will check if category is selected else we will display all the subcategory///// 
$cat = $_GET['cat'];
if(isset($cat) AND strlen($cat) > 0)
{
$quer=mysql_query("SELECT DISTINCT concat.ddbdefectcategory
 FROM concat
 WHERE concat.strusage=\"$cat\"
order by concat.ddbdefectcategory desc"); 
}
else
{
$quer=mysql_query("SELECT DISTINCT concat.ddbdefectcategory
 FROM concat
order by concat.ddbdefectcategory asc"); 
} 
////////// end of query for second subcategory drop down list box ///////////////////////////


/////// for Third drop down list we will check if sub category is selected else we will display all the subcategory3///// 


$subcat=$_GET['subcat'];
if(isset($subcat) and strlen($subcat) > 0)
   {
    if(isset($cat) AND strlen($cat) > 0)
      {
    $quer3=mysql_query("SELECT DISTINCT concat.strtest
     FROM concat
     WHERE concat.ddbdefectcategory=\"$subcat\"
     AND concat.strusage=\"$cat\"
     order by concat.strtest asc");
      }
    else
      {
    $quer3=mysql_query("SELECT DISTINCT concat.strtest
     FROM concat
     WHERE concat.ddbdefectcategory=\"$subcat\"
     order by concat.strtest asc");
      }
   }
else
   {
     if(isset($cat) AND strlen($cat) > 0)
       {
    $quer3=mysql_query("SELECT DISTINCT concat.strtest
     FROM concat
     WHERE concat.strusage=\"$cat\"
     order by concat.strtest asc");
	}
     else
	{
    $quer3=mysql_query("SELECT DISTINCT concat.strtest
     FROM concat
     order by concat.strtest asc");
	}
    }

////////// end of query for third subcategory drop down list box ///////////////////////////


////////// for the drop down that displays the defect codes ////////////////////////

$subcat3=$_GET['subcat3'];
$subcat4=$_GET['subcat4'];

   if (isset($subcat3) and strlen($subcat3) > 0)
	{
	  if (isset($subcat) and strlen($subcat) > 0)
	    {
		if (isset($cat) and strlen($cat) > 0)
		  {
		    $quer4=mysql_query("SELECT DISTINCT concat.strdefectcode, concat.strdefectmessage
	 	     FROM concat
		     WHERE concat.strtest=\"$subcat3\"
		     AND concat.ddbdefectcategory=\"$subcat\"
		     AND concat.strusage=\"$cat\"
		     order by concat.strdefectcode asc");
		    }
		 else
		   {
		    $quer4=mysql_query("SELECT DISTINCT concat.strdefectcode, concat.strdefectmessage
	 	     FROM concat
		     WHERE concat.strtest=\"$subcat3\"
		     AND concat.ddbdefectcategory=\"$subcat\"
		     order by concat.strdefectcode asc");		     
		    }
	     }
	   else
	     {
		if (isset($cat) and strlen($cat) > 0)
		  {
		    $quer4=mysql_query("SELECT DISTINCT concat.strdefectcode, concat.strdefectmessage
	 	     FROM concat
		     WHERE concat.strtest=\"$subcat3\"
		     AND concat.strusage=\"$cat\"
		     order by concat.strdefectcode asc");
		   }
		else
		   {
		    $quer4=mysql_query("SELECT DISTINCT concat.strdefectcode, concat.strdefectmessage
	 	     FROM concat
		     WHERE concat.strtest=\"$subcat3\"
		     order by concat.strdefectcode asc");
		    }
             }

	}

else
	     {
		if (isset($subcat) and strlen($subcat) > 0)
		  {
		    if (isset($cat) and strlen($cat) > 0)
		      {
			$quer4=mysql_query("SELECT DISTINCT concat.strdefectcode, concat.strdefectmessage
	 	         FROM concat
		         WHERE concat.ddbdefectcategory=\"$subcat\"
		         AND concat.strusage=\"$cat\"
		         order by concat.strdefectcode asc");
		       }
		     else
		       {
		         $quer4=mysql_query("SELECT DISTINCT concat.strdefectcode, concat.strdefectmessage
	 	         FROM concat
		         WHERE concat.ddbdefectcategory=\"$subcat\"
		         order by concat.strdefectcode asc");	
			}
		   }
		else
		   {
		     if (isset($cat) and strlen($cat) > 0)
			{
			  $quer4=mysql_query("SELECT DISTINCT concat.strdefectcode, concat.strdefectmessage
	 	           FROM concat
		           WHERE concat.strusage=\"$cat\"
		           order by concat.strdefectcode asc");
			}
		     else
			{
			 $quer4=mysql_query("SELECT DISTINCT concat.strdefectcode, concat.strdefectmessage
	                  FROM concat
			  order by concat.strdefectcode asc");
			}
		    }
	       }


///////////// end of Defect code query ////////////////////////////

//////////////// start of query for Test Condition ////////////////////////////

if(isset($subcat3) AND strlen($subcat3) > 0)
{
 $tcquer=mysql_query("SELECT tbltest.strtestcondition
		       FROM tbltest
		       WHERE tbltest.strtest=\"$subcat3\"
		       order by tbltest.strtestcondition asc");
}

////////////// end of query for Test Condition ///////////////////////////////

///////////// start of applicability query ///////////////////////

if (isset($subcat3) and strlen($subcat3) > 0)
{
  $app=mysql_query("SELECT tblapplicability.numappnumber, tblapplicability.strappcondition
		     FROM tblapplicability
		     WHERE tblapplicability.strtest=\"$subcat3\"
		     order by tblapplicability.numappnumber asc");
}


//////////////// end of applicability query ///////////////////////



///////////// start of defect statement query ////////////////////////


if (isset($subcat4) and strlen($subcat4) > 0)
{
$quer5=mysql_query("SELECT concat.strdefectmessage
 FROM concat
 WHERE concat.strdefectcode=\"$subcat4\"");
}
else
{
$quer5=mysql_query("SELECT concat.strdefectmessage
 FROM concat
 WHERE concat.strdefectcode=\"$subcat4\"");
}


///////////////////end of defect statement query //////////////////////

print "<form method=get name=f1 action=''>";


//////////        Starting of first drop downlist /////////

print "<TABLE width=\"800\" border=\"0\">
	<tr>
	    <td width=\"14\"></td>
	    <td width=\"386\"><b>Usage:</b></td>
	    <td width=\"386\"><b>Category:</b></td>
	    <td width=\"14\"></td>
	</tr>
	</table>";

print "<TABLE width=\"800\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
	<tr>
	    <td><IMG SRC=\"rounded_corner1GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
	    <td bgcolor=\"DDDDDD\" width=\"386\"></td>
	    <td bgcolor=\"DDDDDD\" width=\"386\"></td>
	    <td><IMG SRC=\"rounded_corner2GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
	</tr>
	<tr>
	    <td width=\"14\" bgcolor=\"DDDDDD\"></td>
	    <td width=\"386\" bgcolor=\"DDDDDD\">";
		print "<select name='cat' onchange=\"reload(this.form)\"><option value=''>Select one</option>";
		while($noticia2 = mysql_fetch_array($quer2)) 
		{ 
		if($noticia2['strusage']==$cat)
		{
		print "<B><option selected value='$noticia2[strusage]'";
		print ">$noticia2[strusage]</option></B><BR>"; 
		}
		else
		{
		print "<B><option value='$noticia2[strusage]'";
		print ">$noticia2[strusage]</option></B>";
		}
		
		}
		print "</select>";
//////////////////  This will end the first drop down list ///////////

print "	    </td>
	    <td width=\"386\" bgcolor=\"DDDDDD\">";
		
//////////        Starting of second drop downlist /////////

print "<select name='subcat' onchange=\"reload3(this.form)\"><option value=''>Select one</option>";
while($noticia = mysql_fetch_array($quer)) 
{ 
if($noticia['ddbdefectcategory']==@$subcat)
{
print "<B><option selected value='$noticia[ddbdefectcategory]'";
print ">$noticia[ddbdefectcategory]</option></B><BR>";
}
else
{
print "<B><option value='$noticia[ddbdefectcategory]'";
print ">$noticia[ddbdefectcategory]</option></B>";
}

}
print "</select>";

//////////////////  This will end the second drop down list ///////////

print "	    </td>
	    <td width=\"14\" bgcolor=\"DDDDDD\"></td>
	</tr>
	<tr>
	    <td><IMG SRC=\"rounded_corner4GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
	    <td width=\"386\" bgcolor=\"DDDDDD\"></td>
	    <td width=\"386\" bgcolor=\"DDDDDD\"></td>
	    <td><IMG SRC=\"rounded_corner3GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
	</tr>
</table><br>";


//////////        Starting of the new third drop downlist /////////

echo "<b>Test :</b>";

echo "<TABLE WIDTH=\"150\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\"
>
<TR>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner1GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner2GIMP.png\" WIDTH=\"14\"HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

<TR>
<TD bgcolor=\"DDDDDD\"></TD>
<TD ALIGN=\"CENTER\" bgcolor=\"DDDDDD\">";

echo "<select name='subcat3' onchange=\"reloadT(this.form)\"><option value=''>Select one</option>";





while($noticia3 = mysql_fetch_array($quer3))
{
if($noticia3['strtest']==@$subcat3)
{
print "<B><option selected value='$noticia3[strtest]'";
print ">$noticia3[strtest]</option></B><BR>";
}
else
{
print "<B><option value='$noticia3[strtest]'";
print ">$noticia3[strtest]</option></B>";
}

}

print "</select>";


print "</td><td bgcolor=\"DDDDDD\"></td>";
print "<TD bgcolor=\"DDDDDD\"></TD>
</TR>

<TR>
<TD><IMG SRC=\"rounded_corner4GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD><IMG SRC=\"rounded_corner3GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

</TABLE>";




print "<br><b>Test Condition:</b><br>";

echo "<TABLE WIDTH=\"800\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\">
<TR>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner1GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\" width=\"772\"></TD>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner2GIMP.png\" WIDTH=\"14\"HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

<TR>
<TD bgcolor=\"DDDDDD\" width=\"14\"></TD>
<TD ALIGN=\"left\" bgcolor=\"DDDDDD\">";

while($noticiatc = mysql_fetch_array($tcquer))
{
print "$noticiatc[strtestcondition]";
}

print "</td><td bgcolor=\"DDDDDD\"></td>";
print "<TD bgcolor=\"DDDDDD\"></TD>
</TR>

<TR>
<TD><IMG SRC=\"rounded_corner4GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD><IMG SRC=\"rounded_corner3GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

</TABLE>";

print "<br>";



print "<b>Applicability Conditions:</b><br>";

print "<TABLE WIDTH=\"800\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\">
<TR>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner1GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner2GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

<TR>
<TD bgcolor=\"DDDDDD\"></TD>

<TD ALIGN=\"CENTER\">";

print "<table border=\"0\" STYLE=\"background-color: DDDDDD\" width=\"772\">";

while($noticiaapp = mysql_fetch_array($app))
{
echo "<tr><td valign=\"top\" align=\"right\">$noticiaapp[numappnumber]</td><td valign=\"top\ align=\"center\">-</td><td>$noticiaapp[strappcondition]</td></tr>";
}

print "</table>";

print "</TD>

<TD bgcolor=\"DDDDDD\"></TD>

</TR>
<TR>
<TD><IMG SRC=\"rounded_corner4GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD><IMG SRC=\"rounded_corner3GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

</TABLE>";




print "<br>";

/////////////////////// end of the new third drop down list //////////////////////////



echo "<b>Defect Code:</b><br>";
echo "<TABLE WIDTH=\"150\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\">
<TR>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner1GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner2GIMP.png\" WIDTH=\"14\"HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

<TR>
<TD bgcolor=\"DDDDDD\"></TD>
<TD ALIGN=\"CENTER\" bgcolor=\"DDDDDD\">";

print  "<select name='subcat4' onchange=\"reloadDC(this.form)\"><option value=''>Select one</option>";
while($noticia4 = mysql_fetch_array($quer4))
{
if($noticia4['strdefectcode']==@$subcat4)
{
print "<B><option selected value='$noticia4[strdefectcode]'";
print ">$noticia4[strdefectcode]</option></B><BR>";

}
else
{
print "<B><option value='$noticia4[strdefectcode]'";
print ">$noticia4[strdefectcode]</option></B>";
}

}
print "</select>";
print "</td><td bgcolor=\"DDDDDD\"></td>";
print "<TD bgcolor=\"DDDDDD\"></TD>
</TR>

<TR>
<TD><IMG SRC=\"rounded_corner4GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD><IMG SRC=\"rounded_corner3GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

</TABLE>";

/////////////// end of Defect Code Drop down list //////////////////


////////////// start of defect statement section ////////////////




if (isset($subcat4) and strlen($subcat4) > 0)
{
$noticia5 = mysql_fetch_array($quer5);
$defectstatement = $noticia5['strdefectmessage'];
print "<br><br><b>Defect Statement:</b><br>";

echo "<TABLE WIDTH=\"800\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\">
<TR>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner1GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner2GIMP.png\" WIDTH=\"14\"HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

<TR>
<TD bgcolor=\"DDDDDD\"></TD>
<TD ALIGN=\"left\" bgcolor=\"DDDDDD\">$defectstatement";

}
else
{

print "<br><br><b>Defect Statement:</b><br>";
echo "<TABLE WIDTH=\"800\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\">
<TR>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner1GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD WIDTH=\"14\"><IMG SRC=\"rounded_corner2GIMP.png\" WIDTH=\"14\"HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

<TR>
<TD bgcolor=\"DDDDDD\"></TD>
<TD ALIGN=\"left\" bgcolor=\"DDDDDD\"><font color=red>Please select Defect code and/or criteria.</font>";
}


print "</td><td bgcolor=\"DDDDDD\"></td>";
print "<TD bgcolor=\"DDDDDD\"></TD>
</TR>

<TR>
<TD><IMG SRC=\"rounded_corner4GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
<TD bgcolor=\"DDDDDD\"></TD>
<TD><IMG SRC=\"rounded_corner3GIMP.png\" WIDTH=\"14\" HEIGHT=\"14\" BORDER=\"0\"></TD>
</TR>

</TABLE>";

///////////////// end of defect statement ///////////////






?>

</body>

</html>
