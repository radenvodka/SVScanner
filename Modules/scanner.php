<?php
/**
 * @Author: Eka Syahwan
 * @Date:   2018-09-05 18:29:21
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2018-09-07 01:00:41
*/
class Scanner
{
	function __construct()
	{
		$this->wploit_modules 	= new wploit_modules;
		$this->sdata 			= new Sdata;
		$this->database 		= new Database;
	}
	public function cms_detector($array_url){
		##########################################################################
		mkdir("result");
		mkdir("result/cms-detector");
		##########################################################################

		echo "\r\n".$this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","Checking cms ... [ ".count($array_url)." Request ]\r\n");
		foreach ($array_url as $key => $dataURL) {
			$url[] =  array('url' => $dataURL['url'] , 'note' =>  $dataURL['plugin']);
			$hea[] =  array('follow' => true);
		}
		$respons = $this->sdata->sdata($url , $hea); $this->sdata->session_remove($respons);
		foreach ($respons as $key => $value) {

			$_SESSION['total_size'] = ($_SESSION['total_size']+$value['info']['http_code']);
			$_SESSION['temp_size']  = ($_SESSION['temp_size']+$value['info']['http_code']);

			foreach ($this->database->cms_detector() as $cms_name => $regex) {
				if(preg_match("/".$regex."/", $value['respons'])){
					$cms_ = $cms_name;
				}
				if(!empty($cms_)){
					break;
				}
			}
			if( $value['info']['http_code'] == 200 && $value['info']['http_code'] != 0 && $value['info']['http_code'] != 500 && $value['info']['http_code'] != 302){
				if(empty($cms_)){

					$fopn = fopen("result/cms-detector/any-cms.txt", "a+");

					echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("green","[".$value['info']['http_code']."] ".$value['info']['url'])." => ".$this->wploit_modules->color("nevy","Any CMS")."\r\n";

					fwrite($fopn, $value['info']['url']."\r\n");

					$_SESSION['ANY_CMS'] = ($_SESSION['ANY_CMS']+1);

				}else{
					
					$fopn = fopen("result/cms-detector/".$cms_.".txt", "a+");

					echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("green","[".$value['info']['http_code']."] ".$value['info']['url'])." => ".$this->wploit_modules->color("nevy",$cms_)."\r\n";

					fwrite($fopn, $value['info']['url']."\r\n");

					$_SESSION['LIVE_CMS'] = ($_SESSION['LIVE_CMS']+1);
				}
			}else{
				echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("red","[".$value['info']['http_code']."] ".$value['info']['url']."\r\n");
				$_SESSION['SITE_DIE'] = ($_SESSION['SITE_DIE']+1);
			}
		}

		fclose($fopn);
		echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","Check cms ... done ( Download Size : ".$this->wploit_modules->formatSizeUnits($_SESSION['temp_size'])." | Total Download : ".$this->wploit_modules->formatSizeUnits($_SESSION['total_size']).")\r\n");
		echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","[Detected CMS : ".$_SESSION['LIVE_CMS']."]\r\n");
		echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","[ANY CMS      : ".$_SESSION['ANY_CMS']."]\r\n");
		echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","[Site No Live : ".$_SESSION['SITE_DIE']."]\r\n");

		unset($_SESSION['temp_size']);

	}
	public function wordpress_plugins($array_url){
		echo "\r\n".$this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","Checking for plugins ... [ ".count($array_url)." request ]\r\n");
		foreach ($array_url as $key => $dataURL) {
			$url[] =  array('url' => $dataURL['url'] , 'note' =>  $dataURL['plugin']);
			$hea[] =  array('follow' => false);
		}
		$respons = $this->sdata->sdata($url , $hea);  $this->sdata->session_remove($respons);
		foreach ($respons as $key => $value) {
			
			$_SESSION['total_size'] = ($_SESSION['total_size']+$value['info']['http_code']);
			$_SESSION['temp_size']  = ($_SESSION['temp_size']+$value['info']['http_code']);


			if( $value['info']['http_code'] == 200 && !preg_match("/<body>/", $value['respons'])){
				
				##########################################################################
				mkdir("result");
				mkdir("result/wordpress-scanner");
				$fopn = fopen("result/wordpress-scanner/".$value['data']['note'].".txt", "a+");
				##########################################################################


				fwrite($fopn, $value['data']['url']."\r\n");
				echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("green","[".$value['info']['http_code']."] ".$value['data']['url']."\r\n");
				$_SESSION['200'] = ($_SESSION['200']+1);
			}else if( $value['info']['http_code'] == 403 ){
				echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("yellow","[".$value['info']['http_code']."] ".$value['data']['url']."\r\n");
				$_SESSION['403'] = ($_SESSION['403']+1);
			}else{
				$_SESSION['ANY'] = ($_SESSION['ANY']+1);
				echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("red","[".$value['info']['http_code']."] ".$value['data']['url']."\r\n");
			}
		}
		fclose($fopn);
		echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","Check plugins ... finished ( Download Size : ".$this->wploit_modules->formatSizeUnits($_SESSION['temp_size'])." | Total Download : ".$this->wploit_modules->formatSizeUnits($_SESSION['total_size']).")\r\n");
		echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","[Http Code 200 : ".$_SESSION['200']."]\r\n");
		echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","[Http Code 403 : ".$_SESSION['403']."]\r\n");
		echo $this->wploit_modules->color("green","[SVScanner] ").$this->wploit_modules->color("navy","[Http Code -   : ".$_SESSION['ANY']."]\r\n");

		unset($_SESSION['temp_size']);
	}
}