<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_alm_datamining extends CI_Model
{
	//constructor predeterminado del modelo
	function __construct()
	{
		parent::__construct();
	}

	public function get_featureArticulos()
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
		// echo_pre($query, __LINE__, __FILE__);
		// echo_pre($this->db->last_query(), __LINE__, __FILE__);
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
			// $dataset[$i]['entradas']= $query[$key]['entradas']/$query[$key]['movimientos'];
			$dataset[$i]['entradas']= $query[$key]['entradas'];
			// $dataset[$i]['entradas']= $query[$key]['entradas']/$cantEntry[$key];
			// $dataset[$i]['salidas']= $query[$key]['salidas']/$query[$key]['movimientos'];
			$dataset[$i]['salidas']= $query[$key]['salidas'];
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



	public function create_newVersionTables()//deprecated
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_historial_s` (
				  		    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
				  		    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  		    `nr_solicitud` varchar(10) NOT NULL,
				  		    `fecha_ej` timestamp NOT NULL DEFAULT '2015-01-30 00:00:01',
				  		    `usuario_ej` varchar(9) NOT NULL,
				  		    `status_ej` enum('carrito','en_proceso','aprobado','enviado', 'retirado', 'completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
				  		    PRIMARY KEY (`ID`),
				  		    UNIQUE KEY `historial` (`nr_solicitud`, `status_ej`, `usuario_ej`)
				  		  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `alm_solicitud` (
						    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
						    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
						    `nr_solicitud` varchar(9) NOT NULL,
						    `status` enum('carrito','en_proceso','aprobado','enviado','completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
						    `observacion` text,
						    `motivo` text,
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

	public function rename_oldVersionTables()//deprecated
	{
		$this->load->dbforge();
		$this->dbforge->rename_table('alm_historial_s', 'alm_old_tablehistorial_s');
		$this->dbforge->rename_table('alm_solicitud', 'alm_old_tablesolicitud');
	}

	public function delete_oldVersionTables()//deprecated
	{
		$this->load->dbforge();
		$this->dbforge->drop_table('alm_old_tablehistorial_s');
		$this->dbforge->drop_table('alm_aprueba');
		$this->dbforge->drop_table('alm_genera');
		$this->dbforge->drop_table('alm_retira');
		$this->dbforge->drop_table('alm_contiene');
		$this->dbforge->drop_table('alm_old_tablesolicitud');
	}


	public function migrate_ver1point3()//deprecated
	{
		//creating the new tables
		$this->db->order_by('ID');
		// // $solicitudes=$this->db->get('alm_solicitud')->result_array();
		$solicitudes=$this->db->get('alm_old_tablesolicitud')->result_array();
		// // echo_pre($solicitudes, __LINE__, __FILE__);
		//enum('carrito','en_proceso','aprobado','enviado','completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
		// enum('carrito','en_proceso','aprobada','enviado','completado')
		foreach ($solicitudes as $key => $value)
		{
			unset($solicitudes[$key]['id_usuario']);
			if($value['status']=='aprobada')
			{
				$solicitudes[$key]['status']='aprobado';
			}
			$this->db->insert('alm_solicitud', $solicitudes[$key]);
		}
		$this->db->select('TIME, nr_solicitud, id_usuario');
		$this->db->order_by('ID');
		$genera = $this->db->get('alm_genera')->result_array();
		// echo_pre($genera, __LINE__, __FILE__);
		$this->db->select('nr_solicitud, TIME, id_usuario');
		$this->db->from('alm_aprueba');
		// $this->db->group_by('nr_solicitud DESC');
		$this->db->order_by('nr_solicitud ASC');
		$aprueba = array_reverse($this->db->get()->result_array());
		// die_pre($aprueba, __LINE__, __FILE__);
		$this->db->distinct();
		$this->db->select('TIME, nr_solicitud, id_usuario');
		$this->db->order_by('nr_solicitud');
		$this->db->group_by('nr_solicitud');
		$retira = $this->db->get('alm_retira')->result_array();//hay un nr_solicitud y un id_usuario por cada articulo en la solicitud
		// echo_pre($retira, __LINE__, __FILE__);
		$stop[] = count($genera);
		$stop[] = count($aprueba);
		$stop[] = count($retira);
		for ($i=0; $i < max($stop); $i++)
		{
			if(isset($genera[$i]))
			{
				$aux = array('nr_solicitud'=>$genera[$i]['nr_solicitud'],
							 'fecha_ej'=>$genera[$i]['TIME'],
							 'usuario_ej'=>$genera[$i]['id_usuario'],
							 'status_ej'=> 'carrito');
				$this->db->insert('alm_historial_s', $aux);
				$aux2 = array('TIME'=>$genera[$i]['TIME'],
							  'nr_solicitud'=>$genera[$i]['nr_solicitud'],
							  'id_usuario'=>$genera[$i]['id_usuario'],
							  'id_historial_s'=>$this->db->insert_id());
				$this->db->insert('alm_efectua', $aux2);
				$aux = array('nr_solicitud'=>$genera[$i]['nr_solicitud'],
							 'fecha_ej'=>$genera[$i]['TIME'],
							 'usuario_ej'=>$genera[$i]['id_usuario'],
							 'status_ej'=> 'en_proceso');
				$this->db->insert('alm_historial_s', $aux);
				$aux2 = array('TIME'=>$genera[$i]['TIME'],
							  'nr_solicitud'=>$genera[$i]['nr_solicitud'],
							  'id_usuario'=>$genera[$i]['id_usuario'],
							  'id_historial_s'=>$this->db->insert_id());
				$this->db->insert('alm_efectua', $aux2);
			}
			if(isset($aprueba[$i]))
			{
				$aux = array('nr_solicitud'=>$aprueba[$i]['nr_solicitud'],
							 'fecha_ej'=>$aprueba[$i]['TIME'],
							 'usuario_ej'=>$aprueba[$i]['id_usuario'],
							 'status_ej'=> 'aprobado');
				$this->db->insert('alm_historial_s', $aux);
				$aux2 = array('TIME'=>$aprueba[$i]['TIME'],
							  'nr_solicitud'=>$aprueba[$i]['nr_solicitud'],
							  'id_usuario'=>$aprueba[$i]['id_usuario'],
							  'id_historial_s'=>$this->db->insert_id());
				$this->db->insert('alm_efectua', $aux2);
			}
			if(isset($retira[$i]))
			{
				$aux = array('nr_solicitud'=>$retira[$i]['nr_solicitud'],
							 'fecha_ej'=>$retira[$i]['TIME'],
							 'usuario_ej'=>$retira[$i]['id_usuario'],
							 'status_ej'=> 'completado');
				$this->db->insert('alm_historial_s', $aux);
				$aux2 = array('TIME'=>$retira[$i]['TIME'],
							  'nr_solicitud'=>$retira[$i]['nr_solicitud'],
							  'id_usuario'=>$retira[$i]['id_usuario'],
							  'id_historial_s'=>$this->db->insert_id());
				$this->db->insert('alm_efectua', $aux2);
			}
		}


		//version vieja
		// CREATE TABLE IF NOT EXISTS `alm_contiene` (
		//   `NRS` varchar(9) NOT NULL,
		// ) ENGINE=InnoDB AUTO_INCREMENT=501 DEFAULT CHARSET=utf8;
		$cont_en_sol = $this->db->get('alm_contiene')->result_array();
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
	}

	public function create_new_table()//deprecated
	{
		if(!$this->db->table_exists('alm_datamining_src'))
		{
			/*fecha_solicitado y fecha_retirado serán valores entero numerico de la fecha(cantidad de segundos transcurridos desde el primero de enero de 1970)
			* fecha_solicitado será la fecha en que una solicitud pasa de ser "carrito" a "en_proceso", y fecha_retirado será la fecha en que una solicitud pasa de ser "aprobado" a "retirado".
			* fecha_retirado se toma debido a que en ese momento es cuando un articulo es descontado del inventario.
			* fecha_solicitado se toma en cuenta para los articulos solicitados (los haya en inventario o no, y se hayan aprobado o no)
			* cantidad es el valor entero que representa la cantidad solicitada del articulo
			*/
			$this->db->query("CREATE TABLE IF NOT EXISTS `alm_datamining_src` (
					  		    `ID` bigint(20) NOT NULL AUTO_INCREMENT,
					  		    `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  		    `nr_solicitud` varchar(9) NOT NULL,
					  		    `id_dependencia` bigint(20) NOT NULL,
					  		    `id_articulo` bigint(20) NOT NULL,
					  		    `demanda` int(11) NOT NULL,
					  		    `consumo` int(11) NOT NULL DEFAULT '0',
					  		    `fecha_solicitado` varchar(20) NOT NULL,
					  		    `fecha_retirado` varchar(20) NOT NULL DEFAULT '0',
					  		    PRIMARY KEY (`ID`),
					  		    UNIQUE KEY `FCM` (`nr_solicitud`, `id_articulo`)
					  		  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

		}
	}
	public function fill_table()//deprecated
	{
		if($this->db->table_exists('alm_datamining_src'))
		{
			//cargar las solicitudes con dependencia, articulos, cantidades solicitadas, fecha en que fue solicitada, y en caso que aplique, fecha en que el articulo es desmontado de inventario
			$this->db->select('alm_solicitud.nr_solicitud AS nr_solicitud, dec_usuario.id_dependencia AS id_dependencia, alm_contiene.id_articulo AS id_articulo, alm_contiene.cant_solicitada AS demanda, UNIX_TIMESTAMP(alm_genera.fecha_ej) AS fecha_solicitado');
			$this->db->join('alm_historial_s AS alm_genera', 'alm_genera.nr_solicitud=alm_solicitud.nr_solicitud AND alm_genera.status_ej="carrito"');
			$this->db->join('dec_usuario', 'dec_usuario.id_usuario=alm_genera.usuario_ej');
			// $this->db->join('alm_historial_s AS alm_despacha', 'alm_despacha.nr_solicitud=alm_solicitud.nr_solicitud AND (alm_despacha.status_ej="completado" OR alm_despacha.status_ej="retirado")', 'inner');
			$this->db->join('alm_art_en_solicitud AS alm_contiene', 'alm_contiene.nr_solicitud = alm_solicitud.nr_solicitud AND alm_contiene.estado_articulo="activo"');
			$query = $this->db->get('alm_solicitud')->result_array();
			echo_pre($query);
			// die_pre($this->db->last_query());
			$this->db->insert_batch('alm_datamining_src', $query);

			$this->db->select('alm_despacha.nr_solicitud AS nr_solicitud, UNIX_TIMESTAMP(alm_despacha.fecha_ej) AS fecha_retirado, alm_contiene.cant_aprobada AS consumo');
			$this->db->join('alm_historial_s AS alm_despacha', 'alm_despacha.nr_solicitud=alm_datamining_src.nr_solicitud AND (alm_despacha.status_ej="completado" OR alm_despacha.status_ej="retirado")', 'inner');
			$this->db->join('alm_art_en_solicitud AS alm_contiene', 'alm_contiene.nr_solicitud = alm_despacha.nr_solicitud AND alm_contiene.estado_articulo="activo" AND alm_contiene.cant_aprobada > 0 AND alm_datamining.id_articulo=alm_contiene.id_articulo', 'inner');
			$query2 = $this->db->get('alm_datamining_src')->result_array();
			// $columns= array('nr_solicitud', 'id_articulo');
			// $columns= array('fecha_retirado');
			// echo_pre($query2);
			$this->db->update_batch('alm_datamining_src', $query2, 'nr_solicitud');
		}
		else
		{
			$this->create_new_table();
			$this->fill_table();
		}
	}
	public function update_table()//deprecated
	{
		if(!$this->db->table_exists('alm_datamining_src'))
		{
			$this->fill_table();
		}
	}
	public function delete_table()//deprecated
	{
		$this->dbforge->drop_table('alm_datamining_src');
	}
	// Public function get_data()//cambiar a archivo JSON!!!!
	// {
	// 	$this->update_table();
	// 	$this->db->select('nr_solicitud, id_articulo, id_dependencia, demanda, consumo, fecha_solicitado, fecha_retirado');
	// 	$query = $this->db->get('alm_datamining_src')->result_array();
	// 	$reference = array();
	// 	$data = array();
	// 	$columns = array_keys($query[0]);
	// 	foreach ($query as $key => $value)
	// 	{
	// 		$reference[$key]['nr_solicitud'] = $value['nr_solicitud'];
	// 		$reference[$key]['id_articulo'] = $value['id_articulo'];
	// 		// $data[$key]['demanda'] = $value['demanda'];
	// 		// $data[$key]['consumo'] = $value['consumo'];
	// 		// $data[$key]['fecha_solicitado'] = $value['fecha_solicitado'];
	// 		// $data[$key]['fecha_retirado'] = $value['fecha_retirado'];
	// 	}
	// 	$package['reference'] = $reference;
	// 	$package['columns'] = $columns;
	// 	// $package['data'] = $data;
	// 	$package['data'] = $query;
	// 	return($package);
	// }
	public function get_data()
	{
		$this->load->helper('file');
		$samples = get_filenames('./uploads/testFiles/');
		foreach ($samples as $key => $value)
		{
			//aqui leo cada archivo
		}

	}
	public function write_data($pointer='')
	{
		$this->load->helper('file');
		
	}
	public function read_data($pointer='')
	{
		//Allowed memory size of 134217728 bytes exhausted (tried to allocate 189786412 bytes)
		$this->load->helper('file');
		
		// $myFile = "data.json";
		$myFile = './uploads/testFiles/'.$pointer;
		$arr_data = array(); // create empty array

		try
		{
			//Get form data
			// $formdata = array(
			// 'firstName'=> $_POST['firstName'],
			// 'lastName'=> $_POST['lastName'],
			// 'email'=>$_POST['email'],
			// 'mobile'=> $_POST['mobile']
			// );

			//Get data from existing json file
			// $jsondata = file_get_contents($myFile);
			return file_get_contents($myFile);

			// converts json data into array
			// $arr_data = json_decode($jsondata, true);

			// Push user data to array
			// array_push($arr_data,$formdata);

			//Convert updated array to JSON
			// $jsondata = json_encode($arr_data, JSON_PRETTY_PRINT);
			// echo json_encode($arr_data, JSON_PRETTY_PRINT);

			//write json data into data.json file
			// if(file_put_contents($myFile, $jsondata))
			// {
			// 	echo 'Data successfully saved';
			// }
			// else
			// {
			// 	echo "error";
			// }
		}
		catch (Exception $e)
		{
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
	function build_centroidsTable($array='')
	{
		if(!$this->db->table_exists('alm_datamining_centers'))
		{
			die_pre($array, __LINE__, __FILE__);
		}
	}
	function set_centroids($centers='')
	{
		if(!$this->db->table_exists('alm_datamining_centers'))
		{
			die_pre($centers, __LINE__, __FILE__);
		}
	}
	function build_membershipTable($array='')
	{
		if(!$this->db->table_exists('alm_datamining_MT'))
		{
			die_pre($array, __LINE__, __FILE__);
			$fields = array();
			foreach ($array as $key => $value)
			{
				
			}
		}
		else
		{
			// echo_pre('the table ´alm_datamining_MT´ exists');
		}
	}
	function build_distanceTable($array='')
	{
		if(!$this->db->table_exists('alm_datamining_DT'))
		{
			$fields = array();
			die_pre($array, __LINE__, __FILE__);
			foreach ($array as $key => $value)
			{
				
			}
		}
		else
		{
			echo_pre('the table ´alm_datamining_DT´ exists');
		}
	}
	function distanceMatrixKI($k, $i, $value)
	{
		echo_pre($k, __LINE__, __FILE__);
		echo_pre($i, __LINE__, __FILE__);
		die_pre($value, __LINE__, __FILE__);
		if($this->db->table_exists('alm_datamining_DT'))
		{
			
		}
	}
}