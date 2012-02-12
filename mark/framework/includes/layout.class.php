<?php


	//zooitje samenvoegen 
	class layout{
		var $file;
		var $vars;
		var $debugmode=false;
		var $url;
		
		static $svars;
		function __construct($file){
			global $url;
			$this->url=$url;
			
			

			$this->file="layout/".$file.".html";
			$cache=new templateCache($this->file);

			if($this->debugmode){
				echo"layout ".$this->file." wordt geladen <br>";
			}
			$cache->buildCache();
		}
		
		function assign($key,$val=false){
			if($val){
				@$this->vars[$key]=$val;
			}else{
				if(is_array($key)){
					foreach($key as $keya=>$vala){
						@$this->vars[$keya]=$vala;
					}
				}
			}
		}

		static function sAssign($key,$val){
			
			if($val){
				
				@self::$svars[$key]=$val;
			
			}else{

				if(is_array($key)){
					foreach($key as $keya=>$vala){
						@self::$svars[$keya]=$vala;
					}
				}
			}
			
		}
		
		function draw(){
			
			if(is_array(self::$svars)){
				foreach(self::$svars as $key=>$val){
					eval('$'.$key.'=$val;');
				}
			}

			if(is_array($this->vars)){
				foreach($this->vars as $key=>$val){
						@eval('$'.$key.'=$val;');
				}
			}
				
			if(file_exists("templateCache/".base64_encode($this->file).".php")){
				ob_start();
					include("templateCache/".base64_encode($this->file).".php");
					$content=ob_get_contents();
				ob_end_clean();
			}
			
			return $content;

			
		}
	}
	
	
	//dit is de cache handler, zodat er niet telkens door de compiler hoeft worden gehaalt
	class templateCache{
		
		var $file;
		
		function __construct($file){
			$this->file=$file;
		}
		
		function buildCache(){
			global $error;
			if($this->checkCache()){
				if(file_exists($this->file)){
					$compiler=new templateCompiler(file_get_contents($this->file));
					$handler=fopen("templateCache/".base64_encode($this->file).".php","w+");
					fwrite($handler,$compiler->getCode());
					fclose($handler);
				}else{
					$error->add("Layout kan niet worden geladen","layout",$this->file);
				}
			}
		}
		
		function checkCache(){
			$tTime= @filemtime($this->file);
			$cTime= @filemtime("templateCache/".base64_encode($this->file).".php");
			if(!file_exists("templateCache/".base64_encode($this->file).".php") || $tTime>$cTime){
	
				return true;
			}else{
				return false;
			}
		}
		
	}
	
	
	//hier alle conversies van taal template taal naar php toevoegen die je wil.
  class templateFunctions{
			
		var $phpClose;
		var $phpOpen;
		var $tempData;
		
		var $globalList;
		
		
		function __construct(){
			$this->phpClose="?";
			$this->phpClose.=">";
			$this->phpOpen="<?php";
			
		}
		

		function getGlobal(){
			
		 	return '			
			$LAYOUTvars=$GLOBALS[\'LayoutVars\'];
			
			if(is_array($LAYOUTvars)){
				$i=0;
				foreach($LAYOUTvars as $key=>$val){
					eval(\'$\'.$key.\'=$val;\');
				}
			}
			
			$LAYOUTvars=$GLOBALS[\'LayoutSVars\'];
			
			if(is_array($LAYOUTvars)){
				$i=0;
				foreach($LAYOUTvars as $key=>$val){
					eval(\'$\'.$key.\'=$val;\');
				}
			}
			$Layoutparser=$GLOBALS[\'LayoutParser\'];
			';
			
			
		}
		
		function php($string){
			return $this->phpOpen." ".$string." ".$this->phpClose;
		}
		
		function variable($text){
			$exp=explode(",",$text);
			if(is_array($exp)){
				foreach($exp as $key=>$val){
					if($key){
						$varname.='["'.$val.'"]';
					}else{
						$varname='$'.$val;
						$mainVar='$'.$val;
					}
				}
			}else{
				$varname='$'.$text;
			}
			
			return $varname;
		}
		
		function uVariable($val){
			if(substr($val,0,1)=="_"){
				return $this->variable(substr($val,1));
			}else{
				return '"'.$val.'"';
			}
		}
		

		function open_fmod($key,$aantal){
			return $this->php("echo fmod(".$this->variable($key).",".$aantal.")");
		}
		
		function open_fmodIf($key,$aantal){
			return $this->php("if(!fmod(".$this->variable($key).",".$aantal.")){");
		}
		
		//pagina nummering expirimentje:
		function open_pagNum($variable){
			$this->tempData['pagnumRnd']=rand(0,100000);
			$this->tempData['pagenumVar']=$variable;
			$this->tempData['pagnumAct']=false;
			$rnd=$this->tempData['pagnumRnd'];
			$output='function showNonActivePageNumbering_'.$rnd.'($number){';
			$output.= $this->getGlobal();
			return $this->php($output);
		}
		
		function open_pagNumAct(){
			$rnd=$this->tempData['pagnumRnd'];
			$output="}";
			$output.='function showActivePageNumbering_'.$rnd.'($number){';
			$output.= $this->getGlobal();
			$this->tempData['pagnumAct']=true;
			return $this->php($output);
		}
		
		function close_pagNum(){
			$var=$this->variable($this->tempData['pagenumVar']);
			$rnd=$this->tempData['pagnumRnd'];
			$act=$this->tempData['pagnumAct'];
			$this->tempData['pagnumAct']="";
			$this->tempData['pagnumRnd']="";
			$this->tempData['pagenumVar']="";
			$output="}";
			
			$output.= 'function buildPageNumbering_'.$rnd.'($pageNumberingTPL){';
			$output.= $this->getGlobal();
			$output.='$now=$pageNumberingTPL->getNow();';
			$output.='while($pageNumberingTPL->next()){';
			if($act){
				$output.='if($now==$pageNumberingTPL->get()){';
					$output.='showActivePageNumbering_'.$rnd.'($pageNumberingTPL->get());';
				$output.='}else{';
					$output.='showNonActivePageNumbering_'.$rnd.'($pageNumberingTPL->get());';
				$output.='}';
			}else{
				$output.='showNonActivePageNumbering_'.$rnd.'($pageNumberingTPL->get());';
			}
			$output.='}$pageNumberingTPL->reset();';
			$output.='}buildPageNumbering_'.$rnd.'('.$var.');';
			return $this->php($output);
			
		}
		
		
		function open_parse($method,$tekst){
			$output='include_once("includes/ubbParser.class.php");';
			$output.='$parse=new ubbParser();';
			$output.='echo $parse->parse('.$this->uVariable($method).','.$this->variable($tekst).');';
			return $this->php($output);
		}
		
		function open_dateFormat($timestamp,$format){
			return $this->php('echo date("'.$format.'",'.$this->variable($timestamp).');');
		}
		
		function open_spaw($naam,$value=""){
			
			
			return $this->php('echo spaw("'.$naam.'",'.$this->variable($value).')');
		}
		
		function open_url(){
			$args=func_get_args();
			$vars="";
			foreach($args as $key=>$val){
				if($key==0){
					$code='echo $this->url->make("","'.$val.'"';
				}else{
					if($key!=1){
						$vars.='.",".';
					}
					$vars.=$this->uVariable($val);
				}
			}
			
			if($vars){
				$code.= ",".$vars;				
			}
			
			$code.=');';
			return $this->php($code);
		}
		
		
		function open_module(){
			$args=func_get_args();
			foreach($args as $key=>$val){
				if($key==0){
					$code='echo $this->url->make("'.$val.'"';
				}elseif($key==1){
					$code.=',"'.$val.'"';
				}else{
					if($key!=2){
						$vars.='.",".';
					}
					$vars.=$this->uVariable($val);
				}
			}
			
			if($vars){
				$code.= ",".$vars;				
			}
			
			$code.=');';
			return $this->php($code);
		}
		
		
		function open_print($string){

			$var=$this->variable($string);
			
			return $this->php("echo ".$var.";");

			
		}
		
		function open_if(){
			$aantArgs=func_num_args();
			if(!fmod($aantArgs,4) and $aantArgs>0 or $aantArgs==3 or $aantArgs==1){
				$args=func_get_args();
				$ifstr="";
				foreach($args as $key=>$val){
						if(fmod($key,4)==0){
							$ifstr.=$this->variable($val);
						}
						if(fmod($key,4)==1){
							if($val=="="){
								$val="==";
							}
							$ifstr.= $val;
						}
						if(fmod($key,4)==2){
							$ifstr.=$this->uVariable($val);
						}
						if(fmod($key,4)==3){
							$ifstr.=" ".$val." ";	
						}
				}
				
				return $this->php("if(".$ifstr."){");
			}
			
		}
		
		
		
	 function open_elseif(){
	   $aantArgs=func_num_args();
	   if(!fmod($aantArgs,4) and $aantArgs>0 or $aantArgs==3 or $aantArgs==1){
		$args=func_get_args();
		$ifstr="";
		foreach($args as $key=>$val){
		  if(fmod($key,4)==0){
			$ifstr.=$this->variable($val);
		  }
		  if(fmod($key,4)==1){
		   if($val=="="){
			$val="==";
		   }
		   $ifstr.= $val;
		  }
		  if(fmod($key,4)==2){
		   $ifstr.="'".$val."'";
		  }
		  if(fmod($key,4)==3){
		   $ifstr.=" ".$val." "; 
		  }
		}
		
		return $this->php("}elseif(".$ifstr."){");
	   }
	   
	  }
	  
	  //else statemaent maken
	  function open_else(){
	   return $this->php("}else{");
	  }
	  


		function open_short($var,$length){
			$var=$this->variable($var);
			$code=$var."=strip_tags(".$var.");";
			$code.='if(strlen('.$var.')>'.$length.'){';
			$code.='echo substr('.$var.',0,'.$length.')."...";';
			$code.='}else{';
			$code.='echo '.$var.';';
			$code.='}';
			return $this->php($code);
		}
		
		function open_foreach($array,$val,$key=false){
			$array=$this->variable($array);
			
			$foreachstr=''.$array.' as ';
			if($key){
				$foreachstr.='$'.$key.'=>$'.$val;
			}else{
				$foreachstr.='$'.$val;
			}
			
			return $this->php('if(is_array('.$array.')){foreach('.$foreachstr.'){');
		}
		
		function close_foreach(){
			return $this->php("}}");
		}
		
		function open_for($counter,$from,$to,$step=1){
			
			if($from<$to){
				return $this->php('for($'.$counter.'='.$from.';$'.$counter.'<='.$to.';$'.$counter.'+='.$step.'){');
			}else{
				return $this->php('for($'.$counter.'='.$from.';$'.$counter.'>='.$to.';$'.$counter.'-='.$step.'){');
			}
		}
		
		function open_selected($ida,$idb,$mode="selected"){
			$code="if(".$this->variable($ida)." == ".$this->variable($idb)."){";
			$code.="echo '".$mode."=\"".$mode."\"';";
			$code.="}";
			return $this->php($code);
		}
	
		
		function open_img($url,$mode=""){
			global $config;
			$url='".'.$this->variable($url).'."';
			$path=$config['path']['http']."userData/";
			$ext=".jpg";
			$code="";
			if(!$mode){
				
				$code.='if(file_exists("'.$path.$url.$ext.'")){';
				$code.=	'echo "'.$path.$url.$ext.'";';
			}else{
				$code.='if(file_exists("'.$path.$url."_".$mode.$ext.'")){';
				$code.= 'echo "'.$path.$url."_".$mode.$ext.'";';
				$code.='}elseif(file_exists("'.$path.$url.$ext.'")){';
				$code.=	'echo "'.$path.$url.$ext.'";';
			}
			
			$code.='}else{';
			$code.='echo "'.$config['path']['http'].'images/unknown.jpg";';
			$code.='}';
			return $this->php($code);
		
		}
		
		
		function open_mkBlock(){
			$args=func_get_args();
			$output="function tpl_block_".$args[0]."(";
			
			foreach($args as $key=>$val){
				if($key>0){
					if($key>1){
						$output.=",";
					}
					$output.='$'.$val;
				}
			}
			$output.="){";
			
			return $this->php($output);
		}
		
		function open_block(){
			$args=func_get_args();
			$output="tpl_block_".$args[0]."(";
			foreach($args as $key=>$val){
				if($key>0){
					if($key>1){
						$output.=",";
					}
					$output.='$'.$val;
				}
			}
			$output.=");";
			return $this->php($output);		
		}
		
		function open_include($file){
			$layout=new layout($file);
			$cFile="templateCache/".base64_encode($layout->file).".php";
			return $this->php('include("'.$cFile.'");');
		}

		
		function close_global(){
			return $this->php("}");
		}

  }
	

	
	//dit is de templatecompiler
	class templateCompiler{
		
		var $tekst;
		var $splitted;
		var $compiled;
		var $functions;

		
		
		function  __construct($tekst){

				$this->functions=new templateFunctions();

				$this->setTekst($tekst);
				$this->rmPHP;
				$this->doCompile();
				$this->splitted[]="";
				
				
		}
		
		
		function  setTekst($tekst){
			$this->tekst=$tekst;
		}
		
		
		function rmPHP(){
			$this->tekst=str_replace("?","&#63;",$this->tekst);
		}
		
		function doCompile(){
			$this->split();
			$this->setPrint();
			$this->toPHP();
			$this->toPHPString();
		}
	
		
		function toPHPString(){
			$phpString="";
			foreach($this->splitted as $key=>$val){
				$phpString.=$val;
			}
			$this->compiled=$phpString;
		}
		
		function toPHP(){
			foreach($this->splitted as $key=>$val){
				if(substr($val,0,1)=="[" and substr($val,-1)=="]"){
					$pipe=strpos($val,"|");
					
					if(substr($val,1,1)=="/"){
						$method=substr($val,2,$pipe-1);
						$type="close";
					}else{
						$method=substr($val,1,$pipe-1);
						$type="open";
					}
					
					
					$sParams=substr($val,$pipe+1,strlen($val)-$pipe-2);
					$aParams=explode(";",$sParams);
					$params="";
					
					foreach($aParams as $keya=>$vala){
						if($keya>0){
							$params.=",";
						}
						$params.='"'.$vala.'"';
					}			
					
					$cmethod=$type."_".$method;
					if(method_exists($this->functions,$cmethod)){
						eval('$this->splitted['.$key.']=$this->functions->'.$cmethod.'('.$params.');');
					}else{
						
						if($type=="close" and method_exists($this->functions,"open_".$method)){
							$this->splitted[$key]=$this->functions->close_global();	
						}
					}
				}
			}
		}
		
		function setPrint(){
			foreach($this->splitted as $key=>$val){
			
				if(substr($val,0,1)=="[" and substr($val,-1)=="]" and !strpos($val,"|") and substr($val,1,1)!="/" ){
					$this->splitted[$key]="[print|".substr($val,1);				   
				}
			}
		}
		
		function split(){
						$tekst=$this->tekst;
			$splitted="";
			while(strlen($tekst)){
				$opener=strpos($tekst,"[");
				$closer=strpos($tekst,"]");		
				if($opener === false || $closer === false)
				{
					$this->splitted[]=$tekst;
					$tekst="";
				}else{
					
					if($opener>$closer){
						$this->splitted[]=substr($tekst,0,$closer);
						$tekst=substr($tekst,$closer);
					}else{
						$this->splitted[]=substr($tekst,0,$opener);
						$this->splitted[]=substr($tekst,$opener,$closer-$opener+1);
						$tekst=substr($tekst,$closer+1);						
					}
					
					
				}
			}
		}
		
		
		function getCode(){
			return $this->compiled;
		}
	}





	
	
	
?>
