<?php
error_reporting(0);
session_start();
define('SENDINBOX_PATH', realpath(dirname(__FILE__)));
require_once("Modules/database.php");
require_once("Modules/wploit-modules.php");
require_once("Modules/sdata-modules.php");
require_once("Modules/scanner.php");

require_once("Exploit/default-admin.php");
/**
 * @Author: Eka Syahwan
 * @Date:   2017-12-11 17:01:26
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2018-09-07 10:14:53
*/
class wploit
{
	function __construct()
	{

		mkdir("log");

		$this->wploit_modules 		= new wploit_modules;
		$this->database 			= new Database;
		$this->scanner 				= new Scanner;
		$this->ExploitDefaultAdmin 	= new ExploitDefaultAdmin;

	  	echo $this->wploit_modules->color("green","\n========================================================\r\n\n");
        echo $this->wploit_modules->color("green","┌─┐┬  ┬┌─┐┌─┐┌─┐┌┐┌┌┐┌┌─┐┬─┐ Version : 1.0\r\n");
		echo $this->wploit_modules->color("green","└─┐└┐┌┘└─┐│  ├─┤││││││├┤ ├┬┘ Author  : Eka Syahwan\r\n");
		echo $this->wploit_modules->color("green","└─┘ └┘ └─┘└─┘┴ ┴┘└┘┘└┘└─┘┴└─\r\n");
       	echo $this->wploit_modules->color("random","\r\n-= Scanner Vulnerability And MaSsive Exploit =-\r\n");
       	echo $this->wploit_modules->color("green","\n========================================================\r\n\n");

    

		#########################################
		$this->wploit_modules->delay 	= 0;
		$this->menu 					= $this->database->menu();
		#########################################
		foreach ($this->menu as $key => $value) {
			echo $this->wploit_modules->color("nevy","[SVScanner] [".$key."] ".$value['title']."\r\n");
		}
		echo $this->wploit_modules->color("random","\n========================================================\r\n\n");
		$select = $this->wploit_modules->stuck("Select Number : ");
		
		$threads = $this->wploit_modules->stuck("Threads : ");
		$this->wploit_modules->threads 	= $threads;
		
		switch ($this->menu[$select]['action']) {
			case 'wordpress_scanner_plugin':
				$this->scanner_plugins();echo "\r\n";
			break;
			case 'scanner_cms_detector':
				$this->scanner_cms();echo "\r\n";
			break;
			case 'wordpress_exploit_defaultadmin':
				$this->exploit_defaultadmin();echo "\r\n";
			break;
			default:
				die('!error!');
			break;
		}
	}
	function filter_domain($url){
		$url = parse_url($url);
		return $url['scheme']."://".$url['host'];
	}
	function scanner_plugins(){
		$dataConfig = $this->wploit_modules->required();
		$xselc  = $this->wploit_modules->stuck("Total Request : ".(count($dataConfig['list'])*$dataConfig['threads'])." ( ".(count($this->database->wordpress_plugins())*$dataConfig['threads'])." / Request ), Keep going ? [0 = NO , 1 = YES] : ");echo "\r\n";
		if($xselc == 0){
			die('!error!');
		}
		foreach ($dataConfig['list'] as $keys => $dataurl) {
			$fopn = fopen("log/log-scannerPlugins.txt", "w");
			foreach ($dataurl as $ukey => $url) {
				foreach ($this->database->wordpress_plugins() as $key => $dbPlugins) {
					$config_url[] =  array('url' => $this->filter_domain($url)."/".$dbPlugins , 'plugin' => $key);
				}
				fwrite($fopn, $ukey."|".$url."\r\n");
			}
			fclose($fopn);
			$this->scanner->wordpress_plugins($config_url); unset($config_url);
			sleep($dataConfig['delay']);
		}
	}
	function scanner_cms(){
		$dataConfig = $this->wploit_modules->required();
		$xselc  	= $this->wploit_modules->stuck("Total Request : ".(count($dataConfig['list'])*$dataConfig['threads'])." , Keep going ? [0 = NO , 1 = YES] : ");echo "\r\n";
		if($xselc == 0){
			die('!error!');
		}
		foreach ($dataConfig['list'] as $keys => $dataurl) {
			$fopn = fopen("log/log-cmsdetector.txt", "w");
			foreach ($dataurl as $ukey => $url) {
				$config_url[] =  array('url' => $this->filter_domain($url) );
				fwrite($fopn, $ukey."|".$url."\r\n");
			}
			fclose($fopn);
			$this->scanner->cms_detector($config_url); unset($config_url);
			sleep($dataConfig['delay']);
		}
	}
	function exploit_defaultadmin(){
		$dataConfig = $this->wploit_modules->required();
		$xselc  	= $this->wploit_modules->stuck("Total Request : ".(count($dataConfig['list'])*$dataConfig['threads'])." , Keep going ? [0 = NO , 1 = YES] : ");echo "\r\n";
		if($xselc == 0){
			die('!error!');
		}
		foreach ($dataConfig['list'] as $keys => $dataurl) {
			$fopn = fopen("log/log-defaultadmin.txt", "w");
			foreach ($dataurl as $ukey => $url) {
				$config_url[] =  array('url' => $this->filter_domain($url));
				fwrite($fopn, $ukey."|".$url."\r\n");
			}
			fclose($fopn);
			$this->ExploitDefaultAdmin->scanner($config_url); unset($config_url);
			sleep($dataConfig['delay']);
		}
	}
}
$wploit = new wploit;
$wploit->run();