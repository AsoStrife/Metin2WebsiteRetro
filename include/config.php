<?php
session_start();
error_reporting (0); 
ini_set('display_error', '0');
/**
|
|	@author	Corriga Andrea  - Webenterprises
|	@copyright 2012 Corriga Andrea - Webenterprises
|	@license   http://opensource.org/licenses/CDDL-1.0 New BSD Licence
|	@version  1.0
|	@link	  http://webenterprises.it
|
|	Per la configurazione del sito seguire modificare semplicemente le variabile presenti 
|	in questo file, e lasciare inalterato il resto del codice. La sbagliata configurazione di
|	questo file e/o la modifica di altri file potrebbe portare il non funzionamento dello
|	script intero.
|
|	$config[base_url]						L'url principale del tuo sito es http://www.tuosito.it oppure http://5.125.11.1000
|	$config['site_name'] 					Il nome del tuo sito o server.
|	$config['site_description'] 			Descrizione del tuo sito web e del server.
|	$config['site_keywords'] 				Parole chiave per indicizzare il sito nei motori di ricerca
|
*/

$config['base_url'] 			= '';
$config['site_name'] 			= '';
$config['site_description'] 	= '';
$config['site_keywords'] 		= '';

/**
|
|	['host'] 		Indirizzo ip hamachi con .100 finale es 4.157.23.100 se il sito è hostato<br />
|					sullo stesso computer che hosta il server, altrimenti indirizzo ip normale es 4.157.23.241
|	['user'] 		Username per accedere al database, solitamente root
|	['pass'] 		Password per accedere al database 
|
*/

$config['host'] 				= '';
$config['user'] 				= '';
$config['pass'] 				= '';

/**
|
|	Inserisci in questa variabile l'email del tuo sito per l'invio corretto delle email
|
*/
$config['email_site'] 			= '';

/**
|
|	Questa variabile accetta solo due valori TRUE o FALSE. In caso di TRUE la registrazione 
|	avverrà con l'autenticazione dell'account via email, altrimenti lasciare FALSE
|
*/

$config['email_registration'] 	= FALSE;

/**
|
|	Le due variabile serviranno per il caricamento delle immagini per la pagina supporto.
|	Nella prima variabile inseriree il nome della cartella. La cartella verrà creata in automatico.
|	La seconda variabile definisce in questo caso il peso massimo dell'immagine da caricare.
|	Di default sono settati 4 MB.
|  	Per chi non conoscesse i valori da inserire: 
|	1048576 -> 1MB
|	2097152 -> 2MB
|	3145728 -> 3MB
|	4194304 -> 4MB
|	5242880 -> 5MB
| 
|	Per motivi di  sicurezza è meglio controllare anche il parametro del php.ini
|	il parametro upload_max_filesize che di default è settato a 128 MegaBytes. 

|
*/
$config['upload_folder'] 	= 'upload';
$config['max_file_size']	= 4194304;

if (!is_dir($config['upload_folder'])) mkdir($config['upload_folder'], 0777);


/**
|
|	Non toccare niente da qui in poi.
|
*/

$config['activaction_key'] = 'UG93ZXJlZCBieSA8YSBocmVmPSJodHRwOi8vd2ViZW50ZXJwcmlzZXMuaXQiIHRhcmdldD0iX2JsYW5rIiB0aXRsZT0iV2ViZW50ZXJwcmlzZXMiPldlYmVudGVycHJpc2VzPC9hPg==';
$conn =	mysql_connect($config['host'], $config['user'], $config['pass']) or die("Impossibile connettersi al server richiesto. Potrebbe essere un problema temporaneo.");
?>