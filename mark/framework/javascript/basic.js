//basis variabelen
var midden_selected;
var XMLobjects=new Array();
var XMLobject_tab;

function style_fixes(){
	
}

function selectbox_change_to_val(objn,valu){

     obj=document.getElementById(objn);
    opties=obj.options;
    selectedvar=-1;
    for ( keyVar in opties ) {

        if(is_numeric( keyVar )){
            if(opties[keyVar].value==valu){
                obj.selectedIndex=keyVar;

               selectedvar=keyVar;
            }
        }
    }
    
    if(selectedvar>-1){
        return true;
    }else{
        return false;
    }
  


}

function is_numeric( vari) {

    return !isNaN( vari );
}


function get_radio_value(oname)
{
	var objs=document.getElementsByName(oname);
	var rad_val=0;
	for (var i=0; i < objs.length; i++)
	   {
	   if (objs[i].checked)
		  {
			rad_val = objs[i].value;
		  }
	   }
	return rad_val;
}



function ajax_tab_init(){
  var browser  = navigator.appName;
  if( browser == "Microsoft Internet Explorer" )
  {   
	  XMLobject_tab = new ActiveXObject( "Microsoft.XMLHTTP" );	  
  }
  else
  {
  	XMLobject_tab = new XMLHttpRequest();
  }
}

function ajax_init(key){
  
  var browser  = navigator.appName;
  if( browser == "Microsoft Internet Explorer" )
  {   
	  XMLobjects[key] = new ActiveXObject( "Microsoft.XMLHTTP" );	  
  }
  else
  {
  	XMLobjects[key] = new XMLHttpRequest();
  }

}

//goto functie
function goto(url){
	document.location=url;
}



function ajax(url,object){
		var XMLobject;
		ga_door=true
		i=1;
		while(ga_door){
			if(!XMLobjects[i] || XMLobjects[i].readyState==4){
				if(!XMLobjects[i]){
					ajax_init(i);
				}
				XMLobject=XMLobjects[i];
				ga_door=false;
			}

			i++;
		}
		
		if( XMLobject){  
		//   document.getElementById(object).innerHTML="";
		   
		   file="ajax.php" + url + "&sid=" + Math.random() ;
		   XMLobject.open( "GET", file );  
					  
		   XMLobject.onreadystatechange = function()
		   { 
		   	
				if( XMLobject.readyState == 4 )
				{
					document.getElementById(object).innerHTML=XMLobject.responseText;

				}
		   }
		   
		   XMLobject.send( null );
		 }
}


function tabajax(url,id,moet_reloaden){
	//als tab nog niet geselecteerd is
	if(id!=midden_selected){
		
		//ontkleur devorige tab indien mogelijk
		try{
			document.getElementById("midden_" + midden_selected).className="midden_button";
			document.getElementById("venster_" + midden_selected).className="onder_venster_closed";
		}catch(error){
			dummy=0;
		}
		
		//selecteer de voglende tab
		try{
			document.getElementById("midden_" + id).className="midden_button_selected";
		}catch(error){
			dummy=0;	
		}
		
		//laat laadvenster zien:
		try{
			document.getElementById("venster_loading").className="onder_venster";
		}catch(error){
			laadscherm=document.createElement("div");
			laadscherm.className="onder_venster";
			laadscherm.id="venster_loading";
			laadscherm.align="center";
			document.getElementById("content_onder").appendChild(laadscherm);	
			loadimage=document.createElement("img");
			loadimage.src="images/loading.gif";
			loadimage.style.width="100px";
			loadimage.style.height="100px";
			laadscherm.appendChild(loadimage);	
			laadscherm.innerHTML=laadscherm.innerHTML+"<br>De pagina word geladen";
		}
		
		//bepalen of venster al bestat en zo neit hem maken
		built=true;
		try{
			document.getElementById("venster_" + id).className="onder_venster_closed";
		}catch(error){
			scherm=document.createElement("div");
			scherm.className="onder_venster_closed";
			scherm.id="venster_" + id;
			scherm.innerHTML="test";
			document.getElementById("content_onder").appendChild(scherm);	
			built=false;
		}
		
		
		//inhoud ophalen en laten zien
		if( !built || moet_reloaden=='1' ){  
			   document.getElementById("venster_" + id).innerHTML="";
			   
			   file=url + "&vid=" + id + "&sid=" + Math.random() ;
			   XMLobject_tab.open( "GET", file );  
			   			  
			   XMLobject_tab.onreadystatechange = function()
			   { 
					if( XMLobject_tab.readyState == 4 )
					{
						document.getElementById("venster_" + id).innerHTML=XMLobject_tab.responseText;
						show_venster(id);
					}
			   }
			   
			   XMLobject_tab.send( null );
		  }else{
		 	 show_venster(id);
		  }
		
		
		//set midden selected
		midden_selected=id;
		
	}
}

function show_venster(id){
	document.getElementById("venster_" + id).className="onder_venster";
	document.getElementById("venster_loading").className="onder_venster_closed";
}
