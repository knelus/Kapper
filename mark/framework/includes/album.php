<?php
	
	class M_album extends controller{
		
		//overzicht van alle foto's maken
		function index($pageNumber=0){
			
			//pagina nummering initialiseren
			$pageNumbering=new pageNumbering(10);
			$pageNumbering->setNow($pageNumber);
			$pageNumbering->setWhere("menuId='".$this->getMenuId()."'");
			$pageNumbering->loadOnTable("foto");
			
			
			//database items ophalen
			$this->db->limit($pageNumbering->getLimit());
			$this->db->where("menuId='".$this->getMenuId()."'");
			$query= $this->db->getTable("foto");
			
			//items op beeld zetten
			while($query->fetch()){
				$foto=new layout("admin/albumFoto");
				if(file_exists("userData/album/".$this->getMenuId()."/".$query->get("file")."_tumb.jpg")){
					$foto->assign("url","userData/album/".$this->getMenuId()."/".$query->get("file")."_tumb.jpg");
				}else{
					$foto->assign("url","userData/album/".$this->getMenuId()."/".$query->get("file").".jpg");
				}
				$foto->assign("rmURL",$this->url->make("","remove",$query->get("fotoId")));
				$foto->assign("naam",$query->get("titel"));
				$this->out($foto->draw(),"page");
			}
			
			//paginaNummering genereren
			$now=$pageNumbering->getNow();
			while($pageNumbering->next()){
				if($now==$pageNumbering->get()){
					$this->out(gButton($pageNumbering->get()),"pageNumbers");
				}else{
					$this->out(button($this->url->make("","index",$pageNumbering->get()),$pageNumbering->get()),"pageNumbers");
				}
			}
			
			//toevoegen knop maken
			$this->out(button($this->url->make("","toevoegen"),"Toevoegen"),"pageNumbers");
			
			//boeletje op het scherm pleren
			$layout=new layout("admin/albumAlbum");
			$layout->assign("page",$this->output->draw("page"));
			$layout->assign("pageNumbers",$this->output->draw("pageNumbers"));
			$this->out($layout->draw());
		}
		
		//foto toevoegen
		function toevoegen(){
			$form=new layout("admin/albumToevoegen");
			$form->assign("action",$this->url->make("","toevoegenSubmit"));
			out($form->draw());
		}
		
		
		//verwerken van toevoeging
		function toevoegenSubmit(){
			if(isset($_FILES['bestand']['name'])){
				//bestand opslaan
				$newFileName=time()."_".rand(0,100);
				$newFileUrl="album/".$this->getMenuId()."/".$newFileName.".jpg";
				$newTumbUrl="album/".$this->getMenuId()."/".$newFileName."_tumb.jpg";
				
				
				//plaatjes resizen en opslaan
				$image=new image($_FILES['bestand']["tmp_name"]);
				$image->action("resize","400x400","size");
				$image->save($newFileUrl);
				$image->action("resize","100x100!","size");
				$image->save($newTumbUrl);
				

	
				//in database opslaan
				$query=$this->db->getOne("foto");
				$query->set("titel",$_POST['titel']);
				$query->set("omschrijving",$_POST['omschrijving']);
				$query->set("menuId",$this->getMenuId());
				$query->set("file",$newFileName);
				$query->insert();
				
			
				$this->url->go("","index");
			}else{
				//als bestand niet is geupload:
				$error->add("bestand niet goed geupload");
				$this->toevoegen();
			}
		}
		
		//bevestiging vragen
		function remove($image=0){
			if($image){
				//weet je het zeker melding
				$this->out(venster("weet u het zeker?",
				button($this->url->make("","removeSubmit",$image),"ja")." ".
				button($this->url->make("","index"),"Nee")));
				
			}else{
				//als er geen plaatje is ingevult
				$this->url->go("","index");
			}
		}
		
		
		
		//foto werkelijk weg gooien
		function removeSubmit($image=0){
			$this->db->where("fotoId='".$image."'");
			$query=$this->db->getOne("foto");
			$fileName="userData/album/".$this->getMenuId()."/".$query->get("file").".jpg";
			$tumbName="userData/album/".$this->getMenuId()."/".$query->get("file")."_tumb.jpg";
			
			//tumbnail verwijderen
			if(file_exists($tumbName)){
				unlink($tumbName);
			}
			
			//origineel verwijderen
			if(file_exists($fileName)){
				unlink($fileName);
			}
			
			//uit database verwijderen
			$query->remove();
			
			$this->url->go("","index");
		}
		
		
		//builden van de module
		function __build(){
			mkdir("userData/album/".$this->getMenuId());
		}
		
		
		//weer weg gooien van de module
		function __kill(){
			
			//database doorlopen
			$this->db->where("menuId=".$this->getMenuId());
			$query=$this->db->getTable("foto");
			while($query->fetch()){
				//file names bepalen
				$fileName= "userData/album/".$this->getMenuId()."/".$query->get("file").".jpg";
				$tumbName= "userData/album/".$this->getMenuId()."/".$query->get("file")."_tumb.jpg";
	
				//tumbnail verwijderen
				if(file_exists($tumbName)){
					unlink($tumbName);
				}
				
				//origineel verwijderen
				if(file_exists($fileName)){
					unlink($fileName);
				}
					
				//item uit database gooien
				$query->remove();
			}
			
			//mapje verwijderen
			rmdir("userData/album/".$this->getMenuId());

		}
		
		
		
	}

?>
