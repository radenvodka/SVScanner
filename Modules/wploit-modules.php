<?php
/**
 * @Author: Eka Syahwan
 * @Date:   2018-09-05 18:48:37
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2018-09-14 17:22:15
 */
class wploit_modules
{
	public function threads( $value = 10){
		$this->threads = $value;
	}
	public function delay( $value = 10 ){
		$this->delay = $value;
	}
	public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}
	public function stuck($msg){
        echo $this->color("green","[SVScanner] ").$this->color("purple",$msg);
        $answer =  rtrim( fgets( STDIN ));
        return $answer;
    }
    public function required(){
		echo $this->color("green","[SVScanner] ".$this->color('bggreen', "Looking for a TargetList file.\r\n"));

		$locdir_list 	= SENDINBOX_PATH.'/TargetList';
		$list_load 		= scandir($locdir_list);
		foreach ($list_load as $key => $value) {
			if(is_file($locdir_list."/".$value)){
				$arrayList[] = $locdir_list."/".$value;
			}
		}
		if(count($arrayList) == 0){
			echo $this->color("green","[SVScanner] ".$this->color('bgred', "Enter the TargetList file in the TargetList folde.r\r\n"));
			echo $this->color("green","[SVScanner] ".$this->color('bgred', "There is no TargetList file found in the TargetList folder.\r\n"));
			die();
		}
		echo $this->color("green","[SVScanner] ".$this->color('bggreen', "There are ".count($arrayList)." files in the TargetList folder.")."\r\n\n");
		echo $this->color("green","====================================\r\n");
		foreach ($arrayList as $key => $value) {
			echo $this->color("nevy","[TargetList] [$key] ".pathinfo($value)[filename]."\r\n");
		}
		echo $this->color("green","====================================\r\n");
		echo "\r\n";
		$pil = $this->stuck("Enter the list number : ");
		$fgt = file_get_contents($arrayList[$pil]);

		$namafile = pathinfo($arrayList[$pil])['filename'];

		if(empty($fgt)){
			echo $this->color("red","[SVScanner] Your choice number is wrong!!!\r\n");
			die();
		}
		
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $fgt = explode("\n", $fgt);
        } else {
            $fgt = explode("\n", $fgt);
        }

		echo $this->color("green","[SVScanner] There are ".$this->color('red',count($fgt))." line in file.\r\n\n");
		$pil = $this->stuck("Delete duplicate data ? 0 = NO , 1 = YES : ");
		if($pil == 1){
			$fgt = array_unique($fgt);
		}
		$threads 		= $this->threads;
		$delay 			= $this->delay;
		$fgt 			= array_chunk($fgt, $threads);
		return array('list' => $fgt,'delay' => $delay,'threads' => $threads , 'namafile' => $namafile);
	}
    public function color($color = "random" , $text){
    	if(true == true){
	    	$arrayColor = array(
				'grey' 		=> '1;30',
				'red' 		=> '1;31',
				'green' 	=> '1;32',
				'yellow' 	=> '1;33',
				'blue' 		=> '1;34',
				'purple' 	=> '1;35',
				'nevy' 		=> '1;36',
				'white' 	=> '1;1',
				'bgred' 	=> '1;41',
				'bggreen' 	=> '1;42',
				'bgyellow' 	=> '1;43',
				'bgblue' 	=> '1;44',
				'bgpurple' 	=> '1;45',
				'bgnavy' 	=> '1;46',
				'bgwhite' 	=> '1;47',
			);	
			if($color == 'random'){
				$arrayColor = array(
					'red' 		=> '1;31',
					'green' 	=> '1;32',
					'yellow' 	=> '1;33',
					'nevy' 		=> '1;36',
					'white' 	=> '1;1',
				);	
				$arrayColor[$color] = $arrayColor[array_rand($arrayColor)];
				$res .=  "\033[".$arrayColor[$color]."m".$text."\033[0m";

			}else if($color == 'string'){
				$arrayColor = array(
					'grey' 		=> '1;30',
					'red' 		=> '1;31',
					'green' 	=> '1;32',
					'yellow' 	=> '1;33',
					'blue' 		=> '1;34',
					'purple' 	=> '1;35',
					'nevy' 		=> '1;36',
					'white' 	=> '1;1',
				);	
				foreach (str_split($text) as $key => $value) {
					$arrayColor[$color] = $arrayColor[array_rand($arrayColor)];
					$res .= "\033[".$arrayColor[$color]."m".$value."\033[0m";
				}

			}else{
				
				$res .=  "\033[".$arrayColor[$color]."m".$text."\033[0m";
			
			}
			return $res;
    	}else{
    		return $text;
    	}
		
	}
}
$wploit_modules = new wploit_modules;