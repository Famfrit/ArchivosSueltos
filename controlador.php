<?php
//var_dump($_POST["algoritmo"]);
$output = array(); //contendrá cada linea salida desde la aplicación en Python

error_reporting(E_ALL);
ini_set('display_errors','on');

/*Utilizando exec y enviando le el comando para ejecutar la aplicación
*solo hará que se ejecute mas no se mostrará nada...
*/
//exec("python /var/www/holamundo.py");

/*Usando exec, pero agregando le como parametro además del comando para  ejecutar la aplicación un arreglo; tendriamos la salida de nuestra aplicación en dicho arreglo; así que recorriendo e imprimiendo cada subindice del arreglo se mostraria la salida de nuestra aplicación en python utilizando php
*/

//$alg = $_POST["algoritmo"];
//$comando = "sudo -u paralela /usr/bin/mpirun -np 95 --hostfile /home/hostfile python /mpi/hola_mundo_mpi.py";
//exec($comando, $result);
switch($_POST["algoritmo"]){
	case "-ppi":
		$output = "p".date("Ymshis");
		$comando = "sudo -u paralela mpirun -np ".$_POST["size"]." --hostfile /home/hostfile python /mpi/Percolacion/perFinal/paralelo.py ".$_POST["tipoArbol"]." ".$_POST["tipoSuelo"]." ".$_POST["distribucion"]." ".$_POST["tamano"]." ".$_POST["email"]." ".$output;
		echo "<br>[".$comando."]<br>";
		exec($comando);
		break;
	case "-ppe":
		$output = "p".date("Ymshis");
		$comando = "sudo -u paralela mpirun -np ".$_POST["size"]." --hostfile /home/hostfile python /mpi/Percolacion/perFinal/paralelo.py ".$_POST["tipoArbol"]." ".$_POST["tipoSuelo"]." ".$_POST["distribucion"]." ".$_POST["tamano"]." ".$_POST["email"]." ".$output;
		echo "<br>[".$comando."]<br>";
		exec($comando);
		break;
	case "-pf":
		$uploaddir = '/var/www/html/webParalela/FASTA/';
		$uploadfile = $uploaddir . basename($_FILES['documento']['name']);

		if (move_uploaded_file($_FILES['documento']['tmp_name'], $uploadfile)) {
			$output = "Fasta".date("Ymshis");
			echo $output."<br>";
		    $archivo = $uploadfile;
		    //Editado desde acá
		    if($_POST['opcion'] == "ADN")
		    {
		    	$comando = "sudo -u paralela /usr/bin/mpirun -np ".$_POST["size"]." --hostfile /home/hostfile python /mpi/FASTA/paralelo.py ".$archivo." matlist.".$_POST['matriz']." ".$_POST['penalizacion']." ".$_POST['resultado']." ".$_POST['email']." ".$output;
			    echo "<br>[".$comando."]<br>";
			    exec($comando);
		    }
		    else
		    {
		    	$comando = "sudo -u paralela /usr/bin/mpirun -np ".$_POST["size"]." --hostfile /home/hostfile python /mpi/FASTA/paralelo_prote.py ".$archivo." matlist.".$_POST['matriz']." ".$_POST['penalizacion']." ".$_POST['resultado']." ".$_POST['email']." ".$output;
			    echo "<br>[".$comando."]<br>";
			    exec($comando);
		    }
		    //Hasta acá
		    /*Acá el original:

		    $comando = "sudo -u paralela /usr/bin/mpirun -np ".$_POST["size"]." --hostfile /home/hostfile python /mpi/FASTA/paralelo.py ".$archivo." matlist.".$_POST['matriz']." ".$_POST['penalizacion']." ".$_POST['resultado']." ".$_POST['email']." ".$output;
			echo "<br>[".$comando."]<br>";
			exec($comando);

			*/
		    
		} else {
		    echo "¡Posible ataque de carga de archivos!\n";
		    exit(0);
		}
		//$comando = "mpirun -np ".$_POST["size"]." --hostfile /home/hostfile python ";
		exec($comando);
		break;
	case "-pbi":
		$uploaddir = '/var/www/html/webParalela/BIBLIA/Serial/';
		$uploadfile = $uploaddir . basename($_FILES['documento']['name']);

		if (move_uploaded_file($_FILES['documento']['tmp_name'], $uploadfile)) {
			$output = "Biblia_".date("Ymshis");
			//echo $output."<br>";
		    $pdf = basename($_FILES['documento']['name']);
		    $archivo = explode(".", $pdf);
		    //echo $archivo[0];
		    $comando = "sudo -u paralela /usr/bin/mpirun -np ".$_POST["size"]." --hostfile /home/hostfile python3 /mpi/BIBLIA/torah-code/web/implicitParalell.py ".$archivo[0]." ".$_POST['saltos']." ".$_POST['email']."";
		    //echo "<br>[".$comando."]<br>";
		   
		} else {
		    echo "¡Posible ataque de carga de archivos!\n";
		    exit(0);
		}
		//var_export(getcwd());
		//var_export($comando);
		exec($comando . ' > /tmp/salida 2> /tmp/salida.errores &');
		echo "<h3> Se ha enviado al correo </h3><b>". $_POST['email']."</b>. <h3>Se adjunta documento pdf con estadisticas encontradas. Saludos.</h3>";
		//
		break;
	case "-pbe":
		$uploaddir = '/var/www/html/webParalela/BIBLIA/Serial/';
		$uploadfile = $uploaddir . basename($_FILES['documento']['name']);

		if (move_uploaded_file($_FILES['documento']['tmp_name'], $uploadfile)) {
			$output = "Biblia_".date("Ymshis");
			//echo $output."<br>";
		    $pdf = basename($_FILES['documento']['name']);
		    $archivo = explode(".", $pdf);
		    //echo $archivo[0];
		    $comando = "sudo -u paralela /usr/bin/mpirun -np ".$_POST["size"]." --hostfile /home/hostfile python3 /mpi/BIBLIA/torah-code/web/explicitParalell.py ".$archivo[0]." \"" .$_POST['patron']. "\" ".$_POST['saltos']." ".$_POST['email']."";
		    //echo "<br>[".$comando."]<br>";
		   
		} else {
		    echo "¡Posible ataque de carga de archivos!\n";
		    exit(0);
		}
		//var_export(getcwd());
		//var_export($comando);
		exec($comando . ' > /tmp/salida 2> /tmp/salida.errores &');
		echo "<h3> Se ha enviado al correo </h3><b>". $_POST['email']."</b>. <h3>Se adjunta documento pdf con estadisticas encontradas. Saludos.</h3>";
		//
		break;

}
//echo $output;
//var_dump($result);
?>
