<html>
<head>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
</head>
<body bgcolor="orange">
<?php
$_SESSION['hide']=0; //problema attiva/disattiva
$_SESSION['des']=0;
$_SESSION['local']=0;
$_SESSION['g']=0;
$_SESSION['date']=0;
$_SESSION['lati']=0;
$_SESSION['longi']=0;
$_SESSION['attiva']=0;
$_SESSION['mod']=0;
session_start();
$servername="localhost";
$username="protezionec";
$password="sBab9dfJXhKD";
$dbname="my_protezionec";
$data=date("d/m/Y");
$local=0;
$des=0;
$g=0;
$date=0;
$attiva=0;
$lat;
$long;
$cont=0;
$token;
$cc=0;
$o;
$cont=0;
$id_caposquadra=14;
if($_POST)
{
	if($_POST['pagina']==1)
	{
		echo "<DIV style='color: orange; font-size: 30px; font-family: cursive;' ALIGN=center>Completamento campi</DIV><BR><BR>";
		echo "<DIV ALIGN=center>Completa tutti i campi per avere un buon responso:</DIV><BR><BR>";
		echo "<FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
    echo "<INPUT TYPE='hidden' NAME='pagina' VALUE='3'>";
    echo "<TABLE BORDER=1 ALIGN=center>";
    echo "<TR>";
    echo "<TD>Descrizione";
    echo "<TD><INPUT TYPE='textarea' NAME='descr'>";
    echo "</TR>";
    echo "<TR><TD>Località";
		echo "<TD><INPUT TYPE='textarea' NAME='loc'>";
		echo "</TR>";
    echo "<TR>";
    echo "<TD>Latitudine";
    echo "<TD><INPUT TYPE='textarea' NAME='lat'>";
    echo "</TR>";
    echo "<TR>";
    echo "<TD>Longitudine";
    echo "<TD><INPUT TYPE='textarea' NAME='long'>";
    echo "</TR>";
    echo "<TR><TD>Gravità";
    echo "<TD><SELECT NAME='grav'>";
    echo "<OPTION>1</OPTION>";
    echo "<OPTION>2</OPTION>";
    echo "<OPTION>3</OPTION>";
    echo "<OPTION>4</OPTION>";
    echo "<OPTION>5</OPTION>";
    echo "</SELECT></TR>";
		echo "<TR>";
		echo "<TD>Data";
		echo "<TD><INPUT TYPE='text' READONLY='true' NAME='data' VALUE=".$data.">";
		echo "</TR>";
		echo "<TR>";
		echo "<TD>Attiva";
		echo "<TD><INPUT TYPE='checkbox' NAME='attiva' CHECKED='checked'>";
		echo "</TR>";
    echo "</TABLE>";
    echo "<BR><INPUT TYPE='submit' VALUE='Crea intervento'>";
    echo "</FORM>";
    echo "<FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN='center'>";
    echo "<INPUT TYPE='hidden' VALUE=".NULL." NAME='pagina'>";
  	echo "<INPUT TYPE='submit' VALUE='Indietro'>";
  	echo "</FORM>";
	}
	if($_POST['pagina']==3)
  {
    $_SESSION['des']=$_POST['descr'];
  	$_SESSION['local']=$_POST['loc'];
  	$_SESSION['g']=$_POST['grav'];
		$_SESSION['date']=$_POST['data'];
    $_SESSION['lati']=$_POST['lat'];
    $_SESSION['longi']=$_POST['long'];
		if($_POST['attiva']==true)
		{
			$_SESSION['attiva']=1;
		}
		else
		{
			$_SESSION['attiva']=0;
    }
		//qua c'era una graffa chiusa e funzionava tutto (magiaaaa)
  	echo "<DIV style='color: red; font-size: 30px; font-family: cursive;' ALIGN=center>RIEPILOGO DEI CAMPI COMPILATI:</DIV><BR><BR>";
  	echo "<TABLE BORDER=0 ALIGN=center>";
  	echo "<TR>";
  	echo "<TD>Descrizione";
  	echo "<TD>".$_SESSION['des'];
  	echo "</TR>";
  	echo "<TR>";
  	echo "<TD>Località";
  	echo "<TD>".$_SESSION['local'];
  	echo "</TR>";
    echo "<TR>";
    echo "<TD>Latitudine";
    echo "<TD>".$_SESSION['lati'];
    echo "</TR>";
    echo "<TR>";
    echo "<TD>Longitudine";
    echo "<TD>".$_SESSION['longi'];
    echo "</TR>";
  	echo "<TR>";
  	echo "<TD>Gravità";
  	echo "<TD>".$_SESSION['g'];
  	echo "</TR>";
		echo "<TR><TD>Data";
		echo "<TD>".$_SESSION['date'];
		echo "</TR>";
		echo "<TR><TD>Attiva/Disattiva";
		echo "<TD>".$_SESSION['attiva'];
  	echo "<TR>";
  	echo "<TD><FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
    echo "<INPUT TYPE='hidden' VALUE='4' NAME='pagina'>";
    echo "<INPUT TYPE='submit' VALUE='Conferma ed invia'>";
    echo "</FORM>";
    echo "<TD><FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
    echo "<INPUT TYPE='hidden' VALUE='1' NAME='pagina'>";
    echo "<INPUT TYPE='submit' VALUE='Annulla'>";
    echo "</FORM>";
    echo "</TR>";
  	echo "</TABLE>";
  	echo "<DIV ALIGN=center><A HREF=".$_SERVER['PHP_SELF'].">Annulla tutto e torna al menù iniziale</A></DIV>";
  }
  if($_POST['pagina']==4)
  {
  	echo "Invio effettuato con successo";
		$local=$_SESSION['local'];
		$des=$_SESSION['des'];
		$g=$_SESSION['g'];
		$date=$_SESSION['date'];
    $lat=$_SESSION['lati'];
    $long=$_SESSION['longi'];
    $attiva=$_SESSION['attiva'];
    $conn=new mysqli($servername,$username,$password,$dbname);
		$sql = "INSERT INTO Emergenze (Localita, Latitudine, Longitudine, Tipo, Grado, Attiva)
		VALUES ('$local', '$lat', '$long', '$des', '$g', '$attiva')";
		$result = mysqli_query($conn,$sql);
    $conn->close();



    $con = mysqli_connect($server,$username,$password,$dbname);
    //INIZIO AGGIUNTA
    $sql="SELECT * FROM Emergenze E ORDER BY E.ID DESC LIMIT 1";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $aa=$row['ID'];
    $con->close();

    $con = new mysqli($server,$username,$password,$dbname);
    if($con->connect_error)
    {
      die("Connection Failed"); 
    }
    $sql = "INSERT INTO Interventi(ID_emergenza, ID_caposquadra)
    VALUES ('$aa', '$id_caposquadra')";
    $result = $con->query($sql);
    $con->close();
    //FINE AGGIUNTA


    $con = mysqli_connect($server,$username,$password,$dbname);
    if($con->connect_error)
    {
      die("Connection Failed"); 
    }
    $sql="SELECT * FROM Volontari";
    $result = $con->query($sql);
    if ($result->num_rows > 0) 
    {
      $i=0;
      while($row = $result->fetch_assoc())
      {
        ${'token'.$i}=$row['Token'];
        ${'dispo'.$i}=$row['Disponibilita'];
        $i=$i+1;
      }
    }
    $con->close();
    while($cc<$i)
    {
      if(${'dispo'.$cc}==1)
      {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\n\t\"to\" : \"${'token'.$cc}\",\n\t\"notification\" : {\n\t\t\"body\" : \"Luogo:$local Descrizione:$des Gravità:$g\",\n\t\t\"title\" : \"Emergenza\"\n\t}\n}",
        CURLOPT_HTTPHEADER => array(
          "Authorization: key=AAAAftAB2zY:APA91bEEGkoeeyHY31bqkoYw5EnPFgQl4SFKdtjxmaLYzc6RVOmooDw6pTpuzCoSzmHauxx3jdsprSdQ6Vzf8q9kpV7Zo02P0ykphPsquyqD-H-1cK4gZIWWscaJrn2pyM9dXpFiSiyf",
          "Content-Type: application/json",
          "Postman-Token: ba075513-b770-4c3d-817a-e72added4f3f",
          "cache-control: no-cache"
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
      }
      $cc=$cc+1;
    }
		if($err)
		{
  		echo "cURL Error #:" . $err;
		}
		else
		{
  		echo $response;
		}
		echo "<BR><A HREF=".$_SERVER['PHP_SELF']." >Menu</A>";
	}
  if($_POST['pagina']==2)
  {
    echo "<DIV style='color: red; font-size: 30px; font-family: cursive;' ALIGN=center>INTERVENTI CREATI</DIV><BR><BR><BR>";
    echo "<FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
    echo "<INPUT TYPE='hidden' VALUE='5' NAME='pagina'>";
    echo "<INPUT TYPE='submit' VALUE='Interventi attivi'>";
    echo "</FORM>";
    echo "<FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
    echo "<INPUT TYPE='hidden' VALUE='6' NAME='pagina'>";
    echo "<INPUT TYPE='submit' VALUE='Storico interventi'>";
    echo "</FORM>"; 
    echo "<DIV ALIGN=center><A HREF=".$_SERVER['PHP_SELF'].">Torna al menù iniziale</A></DIV>";
  }
  if($_POST['pagina']==5)
  {
    /*if($_POST['mod']==2)
    {
      $con = mysqli_connect($server,$username,$password,$dbname);
      while($cont<$_SESSION['mod'])
      {
        $var=$_POST[${'id'.$cont}];
        if($_POST['stato'.$cont]==false)
        {
          $ff=1;
          $up="UPDATE Emergenze SET Attiva=0 WHERE ID=$var";
          $result = $con->query($con,$up);
        }
        $cont=$cont+1;
      }
      $con->close();
    }*/
    echo "<DIV style='color: blue; font-size: 30px; font-family: cursive;' ALIGN=center>Elenco interventi attivi</DIV><BR><BR>";
    $con = mysqli_connect($server,$username,$password,$dbname);
    if($con->connect_error)
    {
      die("Connection Failed");
    }   
    $sql="SELECT * FROM Emergenze";
    $result = $con->query($sql);
    if ($result->num_rows > 0) 
    {    
      echo "<FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
      echo "<TABLE BORDER=1 ALIGN=center>";
      echo "<TR>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>LOCALITA</font>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>TIPO</font>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>GRADO</font>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>DATA</font>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>STATO</font>";
      echo "</TR>";
 
      while($row = $result->fetch_assoc())
      {
          if($row['Attiva']==1)
          {
            echo "<TR>";
            ${'id'.$o}=$row['ID'];
            echo "<TD ALIGN='center'>".$row['Localita'];
            echo "<TD ALIGN='center'>".$row['Tipo'];
            echo "<TD ALIGN='center'>".$row['Grado'];
            echo "<TD ALIGN='center'>".$row['Data'];
            echo "<TD ALIGN='center'><INPUT TYPE='checkbox' NAME='stato".$o."' checked='checked'>";
            echo "</TR>";
            $o=$o+1;
          }
      }
      $_SESSION['mod']=$o;
      echo "</TABLE><BR>";
      $con->close();
      echo "<INPUT TYPE='hidden' VALUE='5' NAME='pagina'>";
      echo "<INPUT TYPE='hidden' VALUE='2' NAME='mod'>";
      echo "<INPUT TYPE='submit' VALUE='Conferma modifiche'>";
      echo "</FORM>";
      echo "<FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
      echo "<INPUT TYPE='hidden' VALUE='2' NAME='pagina'>";
      echo "<INPUT TYPE='submit' VALUE='Torna indietro'>";
      echo "</FORM>";
      echo "<FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
      echo "<INPUT TYPE='hidden' VALUE=".NULL." NAME='pagina'>";
      echo "<INPUT TYPE='submit' VALUE='Torna al menù'>";
      echo "</FORM>"; 
    }
  }
  if($_POST['pagina']==6)
  {
    echo "<DIV style='color: blue; font-size: 30px; font-family: cursive;' ALIGN=center>Storico interventi</DIV><BR><BR>";
    $con = mysqli_connect($server,$username,$password,$dbname);
    if($con->connect_error)
    {
      die("Connection Failed");
    }   
    $sql="SELECT * FROM Emergenze";
    $result = $con->query($sql);
    if ($result->num_rows > 0) 
    {
      echo "<TABLE BORDER=1 ALIGN=center>";
      echo "<TR>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>LOCALITA</font>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>TIPO</font>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>GRADO</font>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>DATA</font>";
      echo "<TD ALIGN='center'><font face='comic sans' color='brown'>STATO</font>";
      echo "</TR>";
      while($row = $result->fetch_assoc())
      {
          if($row['Attiva']==0)
          {
            echo "<TR>";
            echo "<TD ALIGN='center'>".$row['Localita'];
            echo "<TD ALIGN='center'>".$row['Tipo'];
            echo "<TD ALIGN='center'>".$row['Grado'];
            echo "<TD ALIGN='center'>".$row['Data'];
            echo "<TD ALIGN='center'><INPUT TYPE='checkbox'>";
            echo "</TR>";
          }
      }
      echo "</TABLE><BR>";
      $con->close();
      echo "<FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
      echo "<INPUT TYPE='hidden' VALUE='2' NAME='pagina'>";
      echo "<INPUT TYPE='submit' VALUE='Torna indietro'>";
      echo "</FORM>";
      echo "<FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
      echo "<INPUT TYPE='hidden' VALUE=".NULL." NAME='pagina'>";
      echo "<INPUT TYPE='submit' VALUE='Torna al menù'>";
      echo "</FORM>"; 
    }
  }
}
else
{
	echo "<DIV style='color: green; font-size: 30px; font-family: cursive;' ALIGN=center>Benvenuto nel sito gestionale della protezione civile</DIV>";
	echo "<BR><BR><BR><BR><DIV ALIGN=center>Seleziona l'opzione desiderata:</DIV><BR>";
	echo "<TABLE BORDER=1 ALIGN=center STYLE='top: 15%; left:90%;' BGCOLOR=yellow>";
  echo "<TR>";
	echo "<TD><FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
  echo "<INPUT TYPE='hidden' VALUE='1' NAME='pagina'>";
  echo "<INPUT TYPE='submit' VALUE='Crea intervento'>";
  echo "</FORM>";
  echo "<TD><FORM ACTION=".$_SERVER['PHP_SELF']." METHOD='POST' ALIGN=center>";
  echo "<INPUT TYPE='hidden' VALUE='2' NAME='pagina'>";
  echo "<INPUT TYPE='submit' VALUE='Visualizza interventi'>";
  echo "</FORM>";
  echo "</TR>";
  echo "<TR>";
  echo "<TD>Creare un intervento<BR>con relativi dati<BR> informativi che<BR>verranno salvati e<BR>resi poi visibili ai<BR>gestionari delle<BR>squadre";
  echo "<TD>Visualizza gli<BR>interventi già<BR>creati<BR>con la possibilità<BR>di attivareli o<BR>disattivarli";
  echo "</TR>";
  echo "</TABLE>";
}
?>
</body>
</html>