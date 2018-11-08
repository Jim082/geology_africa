<?php

// src/AppBundle/Controller/GeoController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\search_sampleType;
use AppBundle\Entity\Dsample;
//use AppBundle\Entity\codecollection;
//use AppBundle\Repository\codecollectionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class GeoController extends Controller
{
    public function indexAction(Request $request){
		return $this->render('@App/home.html.twig');
    }
	
	public function addsampleAction(Request $request){
		return $this->render('@App/addsample.html.twig');
    }
	
	public function adddocumentAction(Request $request){
		return $this->render('@App/adddocument.html.twig');
    }
	
	public function addpointsAction(Request $request){
		return $this->render('@App/addpoints.html.twig');
    }
	
	public function addoutcropAction(Request $request){
		return $this->render('@App/addoutcrop.html.twig');
    }
	
	public function adddrillingAction(Request $request){
		return $this->render('@App/adddrilling.html.twig');
    }
	
	public function searchsampleAction(Request $request){
		return $this->render('@App/searchsample.html.twig');  
	}
	
	public function listcodecollectionAction($querygroup,Request $request){
		$em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "SELECT * FROM codecollection where codecollection.zoneutilisation LIKE '".$querygroup."';";
        
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $codescollection = $statement->fetchAll();
        
        return new JsonResponse($codescollection);
    }
	
	public function listmineralsAction($querygroup,Request $request){
		$em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "SELECT * FROM lminerals where lminerals.rank = '".$querygroup."' ORDER BY lminerals.fmname;";
        
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $minclasses = $statement->fetchAll();
        
        return new JsonResponse($minclasses);
    }
	
	public function listlithomineralsAction(Request $request){
		$em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "SELECT DISTINCT mineral FROM dsamheavymin2 ORDER BY mineral;";
        
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $minclasses = $statement->fetchAll();
        
        return new JsonResponse($minclasses);
    }
	
	public function Code_autocompleteAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$coll = $_GET['coll'];
		$num = $_GET['code'];
		if ($coll != "all"){
			$RAW_QUERY = "SELECT fieldnum FROM dsample where fieldnum LIKE '".$num."%' AND idcollection = '".$coll."';"; 
		}else{
			$RAW_QUERY = "SELECT fieldnum FROM dsample where fieldnum LIKE '".$num."%';"; 
		}
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $codes = $statement->fetchAll();
        
        return new JsonResponse($codes);
    }
	
	public function results_searchsampleAction($queryvals,Request $request){
		/*//require_once("@App/debug/PHPDebug.php");
		//$debug = new PHPDebug();
		//$debug->debug("A very simple message");
		 */
		 
		$arrayqueryvals =  explode(",,", $queryvals); 
		$elem =array();
		foreach($arrayqueryvals as $e) {
            $elem1 = explode(":", $e);
			$elem[$elem1[0]]=$elem1[1];
        } 
		
		$querymagnet = "";
								
		switch($elem["lithomagnet"]) {
			 case -3:
				$querymagnet = "m.mesure1 < -10";
				break;
			 case -2:
				$querymagnet = "m.mesure1 < -5.001 AND m.mesure1 > -10";
				break;
			 case -1:
				$querymagnet = "m.mesure1 < -0.001 AND m.mesure1 > -5";
				break;
			case 1:
				$querymagnet = "m.mesure1 > 0 AND m.mesure1 < 50";
				break;
			case 2:
				$querymagnet = "m.mesure1 > 50.001 AND m.mesure1 < 100";
				break;
			case 3:
				$querymagnet = "m.mesure1 > 100.001 AND m.mesure1 < 250";
				break;
			case 4:
				$querymagnet = "m.mesure1 > 250";
				break;
		} 

		$data_array = array(
			array(":collection",	'%'.strtolower($elem["collection"]).'%',	"LOWER(d.idcollection) LIKE ",		"",0),
			array(":searchnum",		$elem["searchnum"],							"d.idsample = ",					"",0),
			array(":code",			'%'.strtolower($elem["code"]).'%',			"LOWER(d.fieldnum) LIKE ",			"",0),
			array(":museumnr",		$elem["museumnr"],							"d.museumnum = ",					"",0),
			array(":museumloc",		'%'.strtolower($elem["museumloc"]).'%',		"LOWER(d.museumlocation) LIKE ",	"",0),
			array(":boxnbr",		'%'.strtolower($elem["boxnbr"]).'%',		"LOWER(d.boxnumber) LIKE ",			"",0),
			array(":descr",			'%'.strtolower($elem["descr"]).'%',			"LOWER(d.sampledescription) LIKE ",	"",0),
			array(":weight",		$elem["weight"],							"d.weight = ",						"",0),
			array(":size",			'%'.strtolower($elem["size"]).'%',			"LOWER(d.size) LIKE ",				"",0),
			array(":dimension",		$elem["dimension"],							"d.dimentioncode = ",				"",0),
			array(":quality",		$elem["quality"],							"d.quality =  ",					"",0),
			array(":radioactivity",	$elem["radioactivity"],						"d.radioactivity = ",				"1",0),
			array(":slimplate",		$elem["slimplate"],							"d.slimplate = ",					"TRUE",0),
			array(":chemanalysis",	$elem["chemanalysis"],						"d.chemicalanalysis = ",			"TRUE",0),
			array(":holotype",		$elem["holotype"],							"d.holotype = ",					"TRUE",0),
			array(":paratype",		$elem["paratype"],							"d.paratype = ",					"TRUE",0),
			array(":loaninfo",		'%'.strtolower($elem["loaninfo"]).'%',		"LOWER(d.loaninformation) LIKE ",	"",0),
			array(":securitylevel",	$elem["securitylevel"],						"d.securitylevel = ",				"",0),
			array(":variousinfo",	strtolower($elem["variousinfo"]),			"LOWER(d.varioussampleinfo) LIKE ",	"",0),
			
			array(":idmineral",		$elem["idmineral"],							"s.idmineral = ",					"",1),
			array(":grademineral",	$elem["grademineral"],						"s.grade = ",						"",1),
			
			array(":classmineral",	'%'.strtolower($elem["classmineral"]).'%',	"LOWER(l.fmparent) IN (SELECT fmname FROM public.lminerals WHERE fmparent LIKE ",			")",1),
			array(":groupmineral",	'%'.strtolower($elem["groupmineral"]).'%',	"LOWER(l.fmparent) LIKE ",			"",1),
			array(":mineral",		'%'.strtolower($elem["mineral"]).'%',		"LOWER(l.FMName) LIKE ",			"",1),
			array(":formulamineral",'%'.strtolower($elem["formulamineral"]).'%',"LOWER(l.mformula) LIKE ",			"",1),
			
			array(":lithomineral",	'%'.strtolower($elem["lithomineral"]).'%',	"LOWER(h2.mineral) LIKE ",			"",2),
			array(":lithominnum_from",$elem["lithominnum_from"],				"h2.minnum >= ",					"",2),
			array(":lithominnum_to",$elem["lithominnum_to"],					"h2.minnum <= ",					"",2),
			array(":lithoweight_from",$elem["lithoweight_from"],				"h1.weightsample >= ",				"",2),
			array(":lithoweight_to",$elem["lithoweight_to"],					"h1.weightsample <= ",				"",2),
			array(":lithoobserv",	'%'.strtolower($elem["lithoobserv"]).'%',	"LOWER(h2.observationhm) LIKE ",	"",2),
			
			array(":lithogranulo",	$elem["lithogranulo"],						"g.weighttot != ",					"0",3),
			array(":lithomagnet",	$elem["lithomagnet"],						$querymagnet,						";",3)
		);
		
		/*$RAW_QUERY = "SELECT * FROM dsample d ";
		$mineralsearch = 0;
		for ($x = 0; $x < sizeof($data_array); $x++) {
			if ($data_array[$x][4] == 1 AND ((	(substr($data_array[$x][1],-1) != "%" AND strlen($data_array[$x][1]) != 0) OR 
												(substr($data_array[$x][1],-1) == "%" AND strlen($data_array[$x][1]) != 2)) AND
												($data_array[$x][1] != '%all%'))){
				$mineralsearch = 1;
			}
		}
		if ($mineralsearch == 1){
			$RAW_QUERY = $RAW_QUERY."LEFT JOIN DSamMinerals s ON s.IDCollection = d.IDCollection AND s.IDSample = d.IDSample LEFT JOIN lminerals l ON l.IDMineral = s.IDMineral";
		}*/
		
		$RAW_QUERY = "SELECT d.idcollection as idcollection, 
							d.idsample as idsample, 
							d.fieldnum as fieldnum, 
							string_agg(l.fmname,',') as mineral,
							d.museumnum as museumnum, 
							d.museumlocation as museumlocation, 
							d.boxnumber as boxnumber, 
							d.sampledescription as sampledescription,              
							d.weight as weight, 
							d.quantity as quantity, 
							d.size as size, 
							d.dimentioncode as dimentioncode, 
							d.quality::integer as quality, 
							d.slimplate as slimplate, 
							d.chemicalanalysis as chemicalanalysis,
							CASE WHEN d.holotype = TRUE THEN 'H' ELSE '' END	||	CASE WHEN d.paratype = TRUE THEN 'P' ELSE '' END AS type,
							d.holotype as holotype, 
							d.paratype as paratype, 
							d.radioactivity as radioactivity, 
							d.loaninformation as loaninformation, 
							d.securitylevel as securitylevel, 
							d.varioussampleinfo as varioussampleinfo,
							string_agg(l.mname,',') as mname, 
							string_agg(l.mformula,' -- ') as mformula, 
							string_agg(l.fmparent,',') as fmparent, 
							string_agg(l.mparent,',') as mparent,
							string_agg(l.fmname,',') as fmname, 
							string_agg(to_char(h1.weightsample, '999.99') ,',') as weightsample,
							string_agg(h2.mineral || '(' || h2.minnum::varchar || ')',', ' order by h2.minnum DESC) as mineral2,
							string_agg(h2.minnum::varchar,',') as minnum ,
							string_agg(h2.observationhm,',') as observationhm,
							string_agg(distinct to_char(g.weighttot, '999.99'),',') as weighttot,
							string_agg(to_char(m.weight, '999.99'),',') as mweight,
							string_agg(distinct to_char(m.mesure1, '9999.999'),',')::double precision as mesure1
						FROM dsample d 
						LEFT JOIN DSamMinerals 	s 	ON s.IDCollection = d.IDCollection AND s.IDSample = d.IDSample 
						LEFT JOIN lminerals 	l 	ON l.IDMineral = s.IDMineral 
						LEFT JOIN dsamheavymin 	h1 	ON h1.IDCollection = d.IDCollection AND h1.IDSample = d.IDSample 
						LEFT JOIN dsamheavymin2 h2 	ON h2.IDCollection = d.IDCollection AND h2.IDSample = d.IDSample 
						LEFT JOIN dsamgranulo 	g 	ON g.IDCollection = d.IDCollection AND g.IDSample = d.IDSample
						LEFT JOIN dsammagsusc 	m 	ON m.IDCollection = d.IDCollection AND m.IDSample = d.IDSample";
	   
		$RAW_QUERY = $RAW_QUERY." WHERE";
		for ($x = 0; $x < sizeof($data_array); $x++) {
			if($data_array[$x][3] == "1" OR $data_array[$x][3] == "TRUE" OR $data_array[$x][3] == "0"){  //Case  of checkboxes with value 1 if chosen --> add only =TRUE
				if (strlen($data_array[$x][1]) != 0 AND $data_array[$x][1] == "1"){
					$andq = " AND ".$data_array[$x][2].$data_array[$x][3];
				}ELSE{
					$andq = '';
				}
			}ELSE{ 
				if($data_array[$x][3] == ";"){  //Case  of combobox with ranges of values --> add only part 1
					if (strlen($data_array[$x][1]) != 0 AND $data_array[$x][1] != 'all'){
						$andq = " AND ".$data_array[$x][2];
					}ELSE{
						$andq = '';
					}
				}ELSE{ 
					//Case  of integers or strings
					if (((substr($data_array[$x][1],-1) != "%" AND strlen($data_array[$x][1]) != 0) OR 
						(substr($data_array[$x][1],-1) == "%" AND strlen($data_array[$x][1]) != 2)) AND
						($data_array[$x][1] != '%all%') AND	($data_array[$x][1] != 'all')){
						
						$andq = " AND ".$data_array[$x][2].$data_array[$x][0].$data_array[$x][3];
					}ELSE{
						$andq = '';
					}
				}
			}
			$RAW_QUERY = $RAW_QUERY.$andq;
		} 
		$RAW_QUERY = $RAW_QUERY." GROUP BY d.idcollection, d.idsample, d.fieldnum, d.museumnum, d.museumlocation, d.boxnumber, d.sampledescription, d.weight, d.quantity, d.size, d.dimentioncode, 
		d.quality, d.slimplate, d.chemicalanalysis, d.holotype, d.paratype, d.radioactivity, d.loaninformation, d.securitylevel, d.varioussampleinfo ";
		
		$orderfield = $elem["sortDirection"]; 
		$RAW_QUERY = $RAW_QUERY."ORDER BY ".$orderfield;    
		$RAW_QUERY = str_replace("WHERE AND", "WHERE", $RAW_QUERY);
		$RAW_QUERY = str_replace("WHERE ORDER", "ORDER", $RAW_QUERY);
		$RAW_QUERY = str_replace("WHERE GROUP", "GROUP", $RAW_QUERY);

		//echo "<script type='text/javascript'>alert('$RAW_QUERY');</script>";

		$em = $this->getDoctrine()->getManager();
		$statement = $em->getConnection()->prepare($RAW_QUERY);
		
		for ($x = 0; $x < sizeof($data_array); $x++) {
			if(strpos($RAW_QUERY, $data_array[$x][0]) !== false){
				$statement->bindValue($data_array[$x][0], $data_array[$x][1]);
			}
		}
		
        $statement->execute();
        $Arrayresult = $statement->fetchAll();
		
		//paginator++++++++++++++++++++++++++++++++++
		$paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $Arrayresult,
            $request->query->getInt('page', 1), 	/*current page number*/ 
			$elem["NbrResByPage"] 					/*images per page*/
        );
	/*	$pagination->setParam('sort','type');
		$pagination->setParam('direction', 'desc');

		$sortParams = array("sort"=>"fieldnum", "direction"=>"asc");
		$v = $sortParams['sort'];
		echo "<script type='text/javascript'>alert('$v');</script>";
		if(!$request->query->get('sort') && !$request->query->get('direction')) {
			$pagination->setParam('sort', $sortParams['sort']);
			$pagination->setParam('direction', $sortParams['direction']);
		}*/


		
		$queryvals = $queryvals.",,nbrres:".sizeof($Arrayresult);
		//$queryvals = $queryvals.",NbrResByPage:".$elem["NbrResByPage"];

		return $this->render('@App/results_searchsample.html.twig', array('queryvals' => $queryvals,'results' => $pagination));  
	}
		
	public function searchdocumentAction(Request $request){
		return $this->render('@App/searchdocument.html.twig');
    }
	
	public function searchpointsAction(Request $request){
		return $this->render('@App/searchpoints.html.twig');
    }
	
	public function searchoutcropAction(Request $request){
		return $this->render('@App/searchoutcrop.html.twig');
    }
	
	public function searchdrillingAction(Request $request){
		return $this->render('@App/searchdrilling.html.twig');
    }
	
	public function adminAction(Request $request){
		return $this->render('@App/admin.html.twig');
    }
	
}
