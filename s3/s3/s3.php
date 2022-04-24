<?php

require('composer/vendor/autoload.php'); 

use Aws\S3\S3Client; 
use Aws\Exception\AwsException; 

$S3Options = 
[
	'version' => 'latest',
	'region'  => 'us-west-1',
	
	'credentials' => 
	[
		'key' => 'AKIAQLVPUZXEKDRLXAGA',
		'secret' => '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'
	]
]; 


$s3 = new S3Client($S3Options); 


// listar archivos

$archivos = $s3->listObjects(
[
	'Bucket' => 'progra3-2022-abril-18-0905-20-11641'
]); 

$archivos = $archivos->toArray();


$fila = ""; 

foreach ($archivos['Contents'] as $archivo) 
{
	$fila .= "<tr><td>{$archivo['Key']}</td>";
	$fila .= "<td>progra3-2022-abril-18-0905-20-11641</td>";
	$fila .= "<td>{$archivo['Size']}</td>";
	$fila .= "<td>{$archivo['LastModified']}</td>";
	$fila .= "<td><button onclick='getFile(&#34;{$archivo['Key']}&#34;)'>Descarga</button></td></tr>"; 
}

echo $fila; 


// carga del archivo

if(isset($_FILES['file']))
{
	$uploadObject = $s3->putObject(
		[
			'Bucket' => 'progra3-2022-abril-18-0905-20-11641',
			'Key' => $_FILES['file']['name'],
			'SourceFile' => $_FILES['file']['tmp_name']
		]); 

	print_r($uploadObject); 
}


// descarga de archivo

if($_POST['key'])
{
	$getFile = $s3->getObject([

		'Key' => $_POST['key'],
		'Bucket' => 'progra3-2022-abril-18-0905-20-11641'
	]);

	$getFile = $getFile->toArray();

	file_put_contents($_POST['key'], $getFile['Body']); 
}





?>