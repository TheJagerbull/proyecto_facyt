<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_datamining extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function get_allArticulos()
	{
		$this->load->helper('date');
		// $this->db->select('alm_genera_hist_a.TIME AS TIME, cod_articulo, entrada, salida, nuevos + usados AS exist, descripcion');
		// $this->db->select('alm_genera_hist_a.TIME AS TIME, cod_articulo, entrada, salida, nuevos + usados AS exist');
		$this->db->select('cod_articulo, entrada, salida, nuevos + usados AS exist');
		$this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo=alm_articulo.cod_articulo');
		$this->db->join('alm_historial_a', 'alm_historial_a.id_historial_a=alm_genera_hist_a.id_historial_a');
		$this->db->group_by(array('id_articulo', 'alm_genera_hist_a.ID', 'alm_historial_a.ID'));
		$query = $this->db->get('alm_articulo')->result_array();
		$aux=$query;
		echo_pre($query, __LINE__, __FILE__);

		$query = array();
		$cantExit=array();
		$cantEntry=array();
		foreach ($aux as $key => $value)
		{
			if(!isset($query[$value['cod_articulo']]))
			{
				$query[$value['cod_articulo']]['movimientos']=0;
				// $query[$value['cod_articulo']]['TIME']=0;
				$query[$value['cod_articulo']]['entradas']=0;
				$query[$value['cod_articulo']]['salidas']=0;
				$query[$value['cod_articulo']]['existencia']=$value['exist'];
				$cantExit[$value['cod_articulo']]=0;
				$cantEntry[$value['cod_articulo']]=0;
			}
		}
		foreach ($aux as $key => $value)
		{
			// $inttime=strtotime($value['TIME']);
			$query[$value['cod_articulo']]['movimientos']++;
			// $query[$value['cod_articulo']]['TIME']+=$inttime;
			$query[$value['cod_articulo']]['entradas']+=$value['entrada'];
			$query[$value['cod_articulo']]['salidas']+=$value['salida'];
			$query[$value['cod_articulo']]['existencia']=$value['exist'];
			if(isset($aux[$key]['entrada']))
			{
				$cantEntry[$value['cod_articulo']]++;
			}
			if(isset($aux[$key]['salida']))
			{
				$cantExit[$value['cod_articulo']]++;
			}
			// $query[$value['cod_articulo']]['descripcion']=$value['descripcion'];
		}
		$datestring = "%Y-%m-%d %H:%i:%s";
		$i=0;
		$dataset=array();
		foreach ($query as $key => $value)
		{
			// $aux = $query[$key]['TIME']/$query[$key]['movimientos'];
			$dataset[$i]['cod_articulo'] = $key;
			$dataset[$i]['movimientos']= $query[$key]['movimientos'];
			// $dataset[$i]['TIME']=mdate($datestring, round($aux));
			// $dataset[$i]['TIME']= $query[$key]['TIME'];
			$dataset[$i]['entradas']= $query[$key]['entradas']/$query[$key]['movimientos'];
			// $dataset[$i]['entradas']= $query[$key]['entradas']/$cantEntry[$key];
			$dataset[$i]['salidas']= $query[$key]['salidas']/$query[$key]['movimientos'];
			// $dataset[$i]['salidas']= $query[$key]['salidas']/$cantExit[$key];
			$dataset[$i]['existencia']= $query[$key]['existencia'];
			// $dataset[$i]['descripcion']= $query[$key]['descripcion'];
			$dataset[$i]['solicitado']= $this->count_solicitado($key);
			// $dataset[$i]['TIME']= $query[$key]['TIME']/$query[$key]['movimientos'];
			// $query[$key]['other']= round($query[$key]['TIME']);
			// $query[$key]['time_format']=mdate($datestring, round($query[$key]['TIME']));
			$i++;
		}
		return($dataset);
	}

	public function count_solicitado($cod_articulo)
	{
		$this->db->select('ID');
		$this->db->where('cod_articulo', $cod_articulo);
		$aux = $this->db->get('alm_articulo')->row_array();
		$this->db->where('id_articulo', $aux['ID']);
		return(count($this->db->get('alm_art_en_solicitud')->result_array()));
	}

	public function create_newVersionTables()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_historial_s` (
				  		    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
				  		    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  		    `nr_solicitud` varchar(10) NOT NULL,
				  		    `fecha_ej` timestamp NOT NULL DEFAULT '2015-01-30 00:00:01',
				  		    `usuario_ej` varchar(9) NOT NULL,
				  		    `status_ej` enum('carrito','en_proceso','aprobado','enviado', 'retirado', 'completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
				  		    PRIMARY KEY (`ID`),
				  		    UNIQUE KEY `historial` (`nr_solicitud`, `status_ej`)
				  		  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_solicitud` (
						    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
						    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						    `nr_solicitud` varchar(9) NOT NULL,
						    `status` enum('carrito','en_proceso','aprobado','enviado','completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
						    `observacion` text,
						    `fecha_gen` timestamp NOT NULL DEFAULT '2015-01-30 00:00:01',
						    `fecha_comp` timestamp NULL DEFAULT NULL,
						    PRIMARY KEY (`nr_solicitud`),
						    UNIQUE KEY `ID` (`ID`)
						  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_efectua` (
		  		  		    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
		  		  		    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  		  		    `id_usuario` varchar(9) NOT NULL,
		  		  		    `nr_solicitud` varchar(9) NOT NULL,
		  		  		    `id_historial_s` bigint(20) NOT NULL,
		  		  		    PRIMARY KEY (`ID`),
		  		  		    UNIQUE KEY `procesa` (`id_usuario`,`nr_solicitud`, `id_historial_s`),
		  		  		    UNIQUE KEY `ID` (`ID`),
		  		  		    KEY `nr_solicitud` (`nr_solicitud`)
		  		  		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_art_en_solicitud` (
		  		  		    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
		  		  		    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  		  		    `id_articulo` bigint(20) NOT NULL,
		  		  		    `id_usuario` varchar(9) DEFAULT NULL,
		  		  		    `nr_solicitud` varchar(9) NOT NULL,
		  		  		    `cant_solicitada` int(11) NOT NULL,
		  		  		    `cant_aprobada` int(11) DEFAULT NULL,
		  		  		    `cant_usados` int(11) DEFAULT '0',
		  		  		    `cant_nuevos` int(11) DEFAULT '0',
		  		  		    `estado_articulo` enum('activo', 'anulado') NOT NULL DEFAULT 'activo',
		  		  		    `motivo` text CHARACTER SET utf8 DEFAULT NULL,
		  		  		    UNIQUE KEY `ID` (`ID`),
		  		  		    UNIQUE KEY `cont_art_solicitud` (`id_articulo`,`nr_solicitud`),
		  		  		    KEY `nr_solicitud` (`nr_solicitud`)
		  		  		  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
	}

	public function rename_oldVersionTables()
	{
		$this->load->dbforge();
		$this->dbforge->rename_table('alm_historial_s', 'alm_old_tablehistorial_s');
		$this->dbforge->rename_table('alm_solicitud', 'alm_old_tablesolicitud');
	}

	public function delete_oldVersionTables()
	{
		$this->load->dbforge();
		$this->dbforge->drop_table('alm_old_tablehistorial_s');
		$this->dbforge->drop_table('alm_aprueba');
		$this->dbforge->drop_table('alm_genera');
		$this->dbforge->drop_table('alm_retira');
		$this->dbforge->drop_table('alm_contiene');
		$this->dbforge->drop_table('alm_old_tablesolicitud');
	}


	public function migrate_ver1point3()
	{
		//creating the new tables
		$this->db->order_by('ID');
		// $solicitudes=$this->db->get('alm_solicitud')->result_array();
		$solicitudes=$this->db->get('alm_old_tablesolicitud')->result_array();
		echo_pre($solicitudes, __LINE__, __FILE__);
		foreach ($solicitudes as $key => $value)
		{
			unset($solicitudes[$key]['id_usuario']);
			$this->db->insert('alm_solicitud', $solicitudes[$key]);
		}
		$this->db->select('TIME, nr_solicitud, id_usuario');
		$this->db->order_by('ID');
		$genera = $this->db->get('alm_genera')->result_array();
		echo_pre($genera, __LINE__, __FILE__);
		
		// foreach ($genera as $key => $value)
		// {
		// 	$aux = array('nr_solicitud'=>$value['nr_solicitud'],
		// 				 'fecha_ej'=>$value['TIME'],
		// 				 'usuario_ej'=>$value['id_usuario'],
		// 				 'status_ej'=> 'carrito');
		// 	$this->db->insert('alm_historial_s', $aux);
		// 	$aux2 = array('TIME'=>$value['TIME'],
		// 				  'nr_solicitud'=>$value['nr_solicitud'],
		// 				  'id_usuario'=>$value['id_usuario'],
		// 				  'id_historial_s'=>$this->db->insert_id());
		// }
		$this->db->select('TIME, nr_solicitud, id_usuario');
		$this->db->order_by('ID');
		$aprueba = $this->db->get('alm_aprueba')->result_array();
		echo_pre($aprueba, __LINE__, __FILE__);
		// foreach ($aprueba as $key => $value)
		// {
		// 	$aux = array('nr_solicitud'=>$value['nr_solicitud'],
		// 				 'fecha_ej'=>$value['TIME'],
		// 				 'usuario_ej'=>$value['id_usuario'],
		// 				 'status_ej'=> 'en_proceso');
		// 	$this->db->insert('alm_historial_s', $aux);
		// }
		$this->db->distinct();
		$this->db->select('TIME, nr_solicitud, id_usuario');
		$this->db->order_by('nr_solicitud');
		$retira = $this->db->get('alm_retira')->result_array();//hay un nr_solicitud y un id_usuario por cada articulo en la solicitud
		echo_pre($retira, __LINE__, __FILE__);
		// foreach ($retira as $key => $value)
		// {
		// 	$aux = array('nr_solicitud'=>$value['nr_solicitud'],
		// 				 'fecha_ej'=>$value['TIME'],
		// 				 'usuario_ej'=>$value['id_usuario'],
		// 				 'status_ej'=> 'completado');
		// 	$this->db->insert('alm_historial_s', $aux);
		// }

		$aux = array('nr_solicitud'=>$value['nr_solicitud'],
					 'fecha_ej'=>$value['TIME'],
					 'usuario_ej'=>$value['id_usuario'],
					 'status_ej'=> 'carrito');
		$this->db->insert('alm_historial_s', $aux);
		$aux2 = array('TIME'=>$value['TIME'],
					  'nr_solicitud'=>$value['nr_solicitud'],
					  'id_usuario'=>$value['id_usuario'],
					  'id_historial_s'=>$this->db->insert_id());


		
		//version vieja
		// CREATE TABLE IF NOT EXISTS `alm_contiene` (
		//   `NRS` varchar(9) NOT NULL,
		// ) ENGINE=InnoDB AUTO_INCREMENT=501 DEFAULT CHARSET=utf8;
		$cont_en_sol = $this->db->get('alm_contiene')->result_array();
		echo_pre($cont_en_sol, __LINE__, __FILE__);
		foreach ($cont_en_sol as $key => $value)
		{
			unset($cont_en_sol[$key]['NRS']);
			$cont_en_sol[$key]['id_usuario']=NULL;
			$cont_en_sol[$key]['estado_articulo']='activo';
			$cont_en_sol[$key]['motivo']='';
			$this->db->insert('alm_art_en_solicitud', $cont_en_sol[$key]);
		}
		//version nueva
		// CREATE TABLE `alm_art_en_solicitud` (
		//   `id_usuario` varchar(9) DEFAULT NULL,
		//   `estado_articulo` enum('activo','anulado') NOT NULL DEFAULT 'activo',
		//   `motivo` text
		// ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		$hist = $this->db->get('alm_old_tablehistorial_s')->result_array();
		die_pre($retira, __LINE__, __FILE__);


	}

}