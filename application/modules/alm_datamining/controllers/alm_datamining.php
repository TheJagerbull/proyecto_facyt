<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alm_datamining extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('math_helper');
        $this->load->model('model_alm_datamining');
        $this->load->model('alm_articulos/model_alm_articulos');
    }
    //la egne &ntilde;
    //acento &acute;
    public function index()
    {
        // declaracion de biblioteca de estilos para la vista
                    $libs['header'] = '<!-- Bootstrap CSS -->
                    <link href="'.base_url().'assets/css/bootstrap.min.css" rel="stylesheet">
                    <link href="'.base_url().'assets/css/dataTables.bootstrap.css" rel="stylesheet">
                    <link href="'.base_url().'assets/css/responsive.bootstrap.css" rel="stylesheet">
                    <link href="'.base_url().'assets/css/buttons.bootstrap.min.css" rel="stylesheet">
                    <link href= "'.base_url().'assets/css/bootstrap-vertical-tabs.css" rel="stylesheet"/>
                    <!-- Bootstrap selectpicker -->
                    <!-- Select2 CSS -->
                    <link href= "'.base_url().'assets/css/select2.css" rel="stylesheet"/>
                    <link href="'.base_url().'assets/css/bootstrap-select.css" rel="stylesheet">
                    <link href= "'.base_url().'assets/css/select2-bootstrap.css" rel="stylesheet"/>
                    <!-- Sweet-alert 2 css -->
                    <link href="'.base_url().'assets/css/sweet-alert.css" rel="stylesheet">
                    <!-- Modal by jcparra css -->
                    <link href="'.base_url().'assets/css/modal.css" rel="stylesheet">
                    <!-- Animate css -->
                    <link href="'.base_url().'assets/css/animate.min.css" rel="stylesheet">
                    <!-- jQuery UI -->
                    <link href="'.base_url().'assets/css/jquery-ui.css" rel="stylesheet">
                    <!-- prettyPhoto -->
                    <link href="'.base_url().'assets/css/prettyPhoto.css" rel="stylesheet">
                    <!-- Font awesome CSS -->
                    <link href="'.base_url().'assets/css/font-awesome.min.css" rel="stylesheet">
                    <!--DateRangePicker -->
                    <link href="'.base_url().'assets/css/daterangepicker-bs3.css" rel="stylesheet">
                    <!-- FileInput -->
                    <link href= "'.base_url().'assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
                    <!-- Custom CSS -->
                    <link href="'.base_url().'assets/css/style.css" rel="stylesheet">
                    <link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/sweetalert2.min.css">
                    ';
        // Fin de declaracion de biblioteca de estilos para la vista
        // declaracion de biblioteca de scripts de javascripts
                    $libs['footer'] = '<script src="'.base_url().'assets/js/sweetalert2.min.js"></script>
                    <!-- jQuery -->
                    <script src="'.base_url().'assets/js/jquery-1.11.3.js"></script>      
                    <!-- Bootstrap JS -->
                    <script src="'.base_url().'assets/js/bootstrap.min.js"></script>
                    <!-- jQuery UI -->
                    <script src="'.base_url().'assets/js/jquery-ui.js"></script>      
                    <!--File input-->
                    <script src="'.base_url().'assets/js/fileinput.min.js" type="text/javascript"></script>
                    <script src="'.base_url().'assets/js/fileinput_locale_es.js" type="text/javascript"></script>
                    <script src="'.base_url().'assets/js/sweetalert2.min.js"></script>
                    <!-- DataTables -->
                    <script src="'.base_url().'assets/js/jquery.dataTables.min.js"></script>
                    <script src="'.base_url().'assets/js/dataTables.responsive.js"></script>
                    <script src="'.base_url().'assets/js/dataTables.buttons.min.js"></script>
                    <script src="'.base_url().'assets/js/dataTables.select.min.js"></script>
                    <script src="'.base_url().'assets/js/dataTables_altEditor.js"></script>
                    <!-- Bootstrap DataTables -->
                    <script src="'.base_url().'assets/js/dataTables.bootstrap.js"></script>
                    <script src="'.base_url().'assets/js/responsive.bootstrap.js"></script>
                    <script src="'.base_url().'assets/js/buttons.bootstrap.min.js"></script>
                    <script src="'.base_url().'assets/js/buttons.html5.min.js"></script>
                    <!-- prettyPhoto -->
                    <script src="'.base_url().'assets/js/jquery.prettyPhoto.js"></script>
                    <!-- Select2 JS -->
                    <script src="'.base_url().'assets/js/select2.js"></script>
                    <!-- CLEditor -->
                    <script src="'.base_url().'assets/js/jquery.cleditor.min.js"></script> 
                    <!-- Bootstrap select js -->
                    <script src="'.base_url().'assets/js/bootstrap-select.min.js"></script>
                    <!-- Date and Time picker -->
                    <script src="'.base_url().'assets/js/bootstrap-datetimepicker.min.js"></script>
                    <script src="'.base_url().'assets/js/moment.js"></script>
                    <script src="'.base_url().'assets/js/daterangepicker.js"></script>      
                    <!-- Respond JS for IE8 -->
                    <script src="'.base_url().'assets/js/respond.min.js"></script>
                    <!-- HTML5 Support for IE -->
                    <script src="'.base_url().'assets/js/html5shiv.js"></script>
                    <script src="'.base_url().'assets/js/allviews.js"></script>
                          ';
        // $this->load->view('template/header');
        // $this->load->view('DynamicQueryResponse');
        $this->load->view('fuzzyTableView', $libs);
        // $this->load->view('template/footer');
    }

    public function Dunn_PC($u, $K, $N)//de https://ncss-wpengine.netdna-ssl.com/wp-content/themes/ncss/pdf/Procedures/NCSS/Fuzzy_Clustering.pdf pagina 2
    {
        $Fu = 0;
        $sumK=0;
        for ($k=0; $k < $K; $k++)
        {
            $sumN=0;
            for ($i=0; $i < $N; $i++)
            {
                // $u[$i][$k]
                $sumN+=pow($u[$i][$k], 2);
            }
            $sumK+=$sumN;
        }
        $Fu = ($sumK/$N);
        $normalized = (($Fu - (1/$K))/(1-(1/$K)));//rango= de 0(completamente difuzzo) a 1(clusterizado rígido)
        $string = 'Partición de coeficiente: '.$Fu.'<br>\n';
        $string .= 'Partición de coeficiente(Normalizada): '.$normalized.'<br>\n';
        // echo 'Partición de coeficiente: '.$Fu.'<br>\n Partición de coeficiente(Normalizada): '.$normalized.'<br>\n';
        // die();
        return($string);
    }

    public function validation_index($u, $c, $n)//$u matriz de membrecia, $centroids centroides, $n cantidad de puntos de la muestra
    {//extraido de: http://www.engineeringletters.com/issues_v20/issue_1/EL_20_1_08.pdf
    // - http://www2.math.cycu.edu.tw/TEACHER/MSYANG/yang-pdf/yang-n-28-cluster-validity.pdf
        $string='archivo: '.__FILE__.'<br>';
        $string.='Linea: '.__LINE__.'<br>';
        // $c = count($centroids);
        $Impe=0;//primer termino para el indice de validacion de clusters del algoritmo (indice de la entropia de la particion)
        for ($i=0; $i < $c; $i++)
        {
            for ($j=0; $j < $n; $j++)
            {
                $sumAux = pow($u[$j][$i], 2);
                $logAux = log($u[$j][$i], 2);
                $Impe+= ($sumAux*$logAux);
            }
        }
        $Impe = (-1/$n)*$Impe;
        // echo_pre($Impe, __LINE__, __FILE__.'<br>Partition Entropy: ');//termino (13) del articulo EL_20_1_08.pdf pagina 2
        $string.='<br>Partition Entropy: '.$Impe;
        $M = array();//media de las particiones generadas por el algoritmo difuzo

        for ($k=0; $k < $c; $k++)
        {
            $M[$k]=0;
            for ($i=0; $i < $k; $i++)
            {
                for ($j=0; $j < $n; $j++)
                {
                    $M[$k]+=($u[$j][$i]);//termino (15)
                }
            }
            $M[$k]=$M[$k]/$n;
        }
        // echo_pre($M, __LINE__, __FILE__);

        foreach ($M as $key => $value)
        {
            $string.='<pre>['.$key.'] =>'.$value.'<pre>';
        }
        $DM = 0;//segundo termino para el indice de validacion de clusters del algoritmo (la suma de las distancias entre las medias de las particiones difuzas o coeficiente de la particion)
        for ($k=0; $k < $c; $k++)
        {
            // echo '<br><strong>'.$k.'</strong>';
            // $string.= '<br><strong>'.$k.'</strong>';
            for ($i=0; $i <= $k; $i++)
            {
                // echo '<br> i= '.$i;
                // $string.= '<br> i= '.$i;
                for ($j=0; $j < $k; $j++)
                {
                    // echo '<br> j= '.$j;
                    // $string.= '<br> j= '.$j;
                    if($i!=$j)
                    {
                        // echo '<br>'.$DM.'<br>';
                        // $string.= '<br>'.$DM.'<br>';
                        //pow(euclidean_distance($M[$i], $M[$j]), 2);
                        $DM+=pow(($M[$i]-$M[$j]), 2);
                    }
                }
            }
        }
        // echo_pre($DM, __LINE__, __FILE__.'<br>Partition Coefficient: ');//termino (14) del articulo EL_20_1_08.pdf pagina 2
        $string.=('<br>Partition Coefficient: '.$DM);//termino (14) del articulo EL_20_1_08.pdf pagina 2

        $Impe_dmfp = $Impe+$DM;
        // echo_pre($Impe_dmfp, __LINE__, __FILE__.'<br>Validation Index: ');//indice de validacion del algoritmo
        $string.=('<br>Validation Index: '.$Impe_dmfp);//indice de validacion del algoritmo
        // return($Impe_dmfp);
        return($string);
    }

    public function Jm($objects, $u, $centroids, $m)//aqui se evalua la funcion objetivo, suministrando los datos de muestra, la matriz de pertenencia, los centroides, y el nivel de difuzidad
    {
        $n=count($objects);
        $c=count($centroids);
        $SUM=0;
        for ($i=0; $i < $c; $i++)
        {
            for ($j=0; $j < $n; $j++)
            {
                $aux=$this->d($objects[$j], $centroids[$i]);
                $auxmbrsqr=pow($u[$j][$i], $m);
                $SUM+=($aux*$auxmbrsqr);
            }
        }
        // echo "<br>funci&oacute;n objetivo:<br>Jm=";
        // echo_pre($SUM, __LINE__, __FILE__);
        return($SUM);
    }

    public function optimal_test($u, $centroids, $n)
    {

    }

    public function km()
    {
        echo "<h1> Ejemplo de cluster de K-medias: </h1> <br></br>";
        //caracteristicas o puntos
        $Examplepoints = array('X' => array( 5, 6, 4, 7, 8, 10, 12, 4),
                                'Y' =>array( 10, 8, 5, 10, 12, 9, 11, 6));
        echo_pre('('.$Examplepoints['X'][0].', '.$Examplepoints['Y'][0].')');
        //los centros (deben ser elegidos de forma aleatoria)
        $centers = array('X' => array(5, 7, 12),
                        'Y' =>array(10, 10, 11));
        // echo_pre($centers);
        //arreglo auxiliar de los clusters a los que los puntos pertenecen
        $PointClusters = array();
        for ($pi=0; $pi < count($Examplepoints['X']); $pi++)///entre todos los puntos...
        {
            $distance=9999;
            for ($ci=0; $ci < count($centers['X']); $ci++)//y cada uno de los centroides...
            {
                $aux = $this->distance(array('x' => $Examplepoints['X'][$pi], 'y' => $Examplepoints['Y'][$pi]), array('x' => $centers['X'][$ci], 'y' => $centers['Y'][$ci]));//se les mide la distancia...
                if($distance > $aux)//y si es menor...
                {
                    $distance = $aux;//la mas baja
                    $PointClusters[$pi] = $ci;//ubico el punto en ese cluster
                    // echo '<br>'.$ci.'<br>';
                }
                if($pi==5)
                {
                    echo "ci = ".$ci.'<br>';
                    echo "distance = ".$distance.'<br>';
                }
            }
        }
        echo_pre($Examplepoints);
        echo_pre($centers);
        echo_pre($PointClusters);//$PointClusters contiene los clusters a los que los puntos pertenecen formato [punto] => centroide
        $centers = array('X' => array(0, 0, 0),
                        'Y' =>array(0, 0, 0));
        $pIc = array(0, 0, 0);//inicializar por cada centroide
        for ($ci=0; $ci < count($PointClusters); $ci++)//para sumar los X con los X y los Y con los Y de cada cluster
        {
            $centers['X'][$PointClusters[$ci]] += $Examplepoints['X'][$ci];
            $centers['Y'][$PointClusters[$ci]] += $Examplepoints['Y'][$ci];
            $pIc[$PointClusters[$ci]] = $pIc[$PointClusters[$ci]] + 1;
        }
        for($ci=0; $ci < count($pIc); $ci++)//luego se dividen los X y los Y entre la cantidad de puntos en cada cluster
        {
            $centers['X'][$ci] /= $pIc[$ci];
            $centers['Y'][$ci] /= $pIc[$ci];
        }
        echo_pre($centers);
    }

    public function distance($pointA, $pointB)//calcula distancia entre dos puntos
    {
        if(isset($pointA) && isset($pointB))
        {
            $distance = abs($pointB['x'] - $pointA['x']) + abs($pointB['y'] - $pointA['y']);
            // echo_pre($distance);
            return($distance);
        }
    }

    public function test_sql()
    {
        $datastp1=$this->model_alm_datamining->get_featureArticulos();
        die_pre($datastp1, __LINE__, __FILE__);
    }
    public function test_weka()
    {
        $datastp1=$this->model_alm_datamining->get_featureArticulos();
        $string ='';
        $string.= "@relation articulos";
        $string.= "<br><br>";
        $aux = $datastp1[0];
        foreach ($aux as $key => $value)
        {

            $string.= "@attribute ";
            $string.= $key." real<br>";
        }
        $string.= "<br>";
        $string.= "@data";
        foreach ($datastp1 as $key => $value)
        {
            $string.="<br>";
            foreach ($value as $attr => $val)
            {
                $string.= $val.",";
            }
            trim($string, ",");
        }
        echo $string;
    }


    public function dataPrep()//preparacion de los datos (agarra los datos relevantes que ubican los articulos en posiciones en un espacio dimensional cartesiano)
    {
        //datos de las tablas de articulos a considerar...
        //en este caso cada punto en el plano cartesiano, sera la representacion de un articulo en la base de datos...
        //para ello se consideraba que la primera caracteristica usada en el punto fuera 'alm_articulo.nivel_reab', es una funcion:
        //nivel de reabastecimiento = dias de adelanto x uso promedio diario, extraido de : http://accountingexplained.com/managerial/inventory-management/reorder-level
        //los dias de adelanto se puede calcular buscando en la base de datos, sobre la tabla alm_historial_art, apartando la columna del articulo y extrallendo la distancia de tiempo entre las ultimas 2 ocurrencias del atributo 'entrada' : 'alm_historial_a.entrada'
        //el uso promedio diario se puede calcular sumando todas las salidas de un articulo (tambien en la tabla 'alm_historial_art'), y dividiendola entra cada una de ellas, todo filtrado por cada articulo de la tabla : 'alm_historial_a.salida'

        //para la preparacion de los datos en el espacio, se considero los atributos:
        //- movimientos: la cantidad de entradas o salidas que haya en el historial del articulo
        //- entradas: la frecuencia de entradas del articulo sobre el inventario
        //- salidas: la frecuencia de salidas del articulo sobre el inventario
        //- existencia: la cantidad existente del articulo en inventario
        //- solicitado: la cantidad de solicitudes donde el articulo aparece solicitado
        $datastp1=$this->model_alm_datamining->get_featureArticulos();
        foreach ($datastp1 as $key => $value)
        {
            $index[$key]=$value['cod_articulo'];
            unset($datastp1[$key]['cod_articulo']);
        }
        $sample['index']=$index;
        $sample['objects']=$datastp1;
        return($sample);

    }

    public function notSoRandom_centroids($sample)//elige los centroides de acuerdo a cada atributo de la muestra, lo que se traduce a 0 para todos menos el que corresponde a cada centroide diferente, que tendra el valor maximo de la muestra en el atributo correspondiente
    {
        $c=count($sample[0]);
        $keys = array_keys($sample[0]);
        // echo_pre($keys, __LINE__, __FILE__);
        $centroids = array();
        for ($i=0; $i < $c*2; $i++)
        {
            $centroids[$i] = array();
            foreach ($keys as $count => $attr)
            {
                $centroids[$i][$attr] = 0;
            }
        }
        // die_pre($centroids, __LINE__, __FILE__);
        $aux=array();
        for ($i=0; $i < $c; $i++)
        {
            
            foreach ($keys as $count => $attr)
            {
                foreach ($sample as $key => $value)
                {
                    if($value[$attr] > $centroids[$i][$attr])
                    {
                        $centroids[$i][$attr]= $value[$attr];
                        $aux[$attr] = $value[$attr];
                    }
                }

                $i++;
            }
        }
        for($i=$c; $i < $c*2; $i++)
        {
            $pos = $i-9;
            foreach ($keys as $count => $attr)
            {
                if($pos != $count)
                {
                    $centroids[$i][$attr]= $aux[$attr];
                }
            }
            // $centroids[$i]=$sample[rand(0, count($sample)-1)];//elegidos al random
        }
        // die_pre($centroids, __LINE__, __FILE__);
        // $this->print_multidimentional_array($centroids);
        // die_pre('fin');
        return($centroids);
        //extraido de http://www.sersc.org/journals/IJDTA/vol6_no6/1.pdf pagina 9 y 10
    }

    public function pick_average_centroids($sample)
    {
        echo_pre(count($sample[0]));
        $qCentroids = count($sample[0]);
        die_pre(intval(count($sample)/2));


        // foreach ($sample as $key => $value)
        // {
            
        // }
    }
    public function print_multidimentional_array($array, $percent='')
    {
        $MDarray = '';
        $keys = array_keys($array[0]);
        // echo strlen($keys[0]).'<br>';
        // echo '<pre>      ';
        $MDarray .= '<pre>      ';
        foreach ($keys as $key => $value)
        {
            // echo $value.'| ';
            $MDarray .= $value.'| ';
        }
        foreach ($array as $key => $value)
        {
            // echo '<br>'.str_pad($key, 3, ' ', STR_PAD_LEFT).'| ';
            $MDarray .= '<br>'.str_pad($key, 3, ' ', STR_PAD_LEFT).'| ';
            foreach ($value as $column => $data)
            {
                if($percent)
                {
                    // echo str_pad(($data*100).'%', strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                    $MDarray .= str_pad(($data*100).'%', strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                }
                else
                {
                    if($column=='fecha_solicitado' || $column=='fecha_retirado')
                    {
                        // echo str_pad(date("Y-m-d H:i:s", intval($data)), strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                        $MDarray .= str_pad(date("Y-m-d H:i:s", intval($data)), strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                    }
                    else
                    {
                        // echo str_pad(intval($data), strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                        $MDarray .= str_pad(intval($data), strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                    }
                }
                // echo $data.' ';
            }
        }
        // echo "</pre>";
        $MDarray .= "</pre>";
        return ($MDarray);
    }
    public function print_membershipColumns($array, $columns)
    {
        $keys = array_keys($array[0]);
        echo strlen($keys[0]).'<br>';
        echo '<pre>      ';
        foreach ($keys as $key => $value)
        {
            echo $value.'| ';
        }
        foreach ($array as $key => $value)
        {
            echo '<br>'.str_pad($key, 3, ' ', STR_PAD_LEFT).'| ';
            foreach ($value as $column => $data)
            {
                if(($data*100)>10)
                {
                    // echo str_pad($data, strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                    echo str_pad($columns[$column], strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                }
                else
                {
                    // echo str_pad(0, strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                }
                // echo $data.' ';
            }
        }
        echo "</pre>";
    }
    public function print_classify($array, $columns)
    {
        // $keys = array_keys($array[0]);
        // echo strlen($keys[0]).'<br>';
        // echo '<pre>      ';
        // foreach ($keys as $key => $value)
        // {
        //     echo $value.'| ';
        // }
        $class = array();
        foreach ($array as $key => $value)
        {
            // echo '<br>'.str_pad($key, 3, ' ', STR_PAD_LEFT).'| ';
            foreach ($value as $column => $data)
            {
                if(($data*100)>10)
                {
                    if(!isset($class[$columns[$column]]))
                    {
                        $class[$columns[$column]]=array();
                    }
                    array_push($class[$columns[$column]], ($key+1));
                    // echo str_pad($data, strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                    // echo str_pad($columns[$column], strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                }
                else
                {
                    // echo str_pad(0, strlen($column)+1, ' ', STR_PAD_LEFT).'|';
                }
                // echo $data.' ';
            }
        }
        echo_pre($class);
        // echo "</pre>";
    }
    public function buildCentroids($centers)//deprecated
    {
        // die_pre($centers);
        $centroids = array();
        $n = sizeof($centers);
        $i=0;
        foreach ($centers as $key => $value)
        {
            $j=0;
            while ($j<($n*2))
            {
                $centroids[$j][$key] = 0;
                $j++;
            }
            for ($k=0; $k < ($n*2); $k++)
            {
                if($k==$i)
                {
                    $centroids[$k][$key] = $value;
                }
                if($k>=$n && ($i+$n)!=$k)
                {
                    $centroids[$k][$key] = $value;
                }
            }
            $i++;
        }
        return($centroids);
    }
    public function fcmFILEVARS($m='', $P='')//never finishes
    {
        $start = microtime(true);
        ini_set('memory_limit', '254217728');
        // ini_set('memory_limit', '-1');
        set_time_limit ( 360000 );
        // die_pre(time_units(1296.7541699409), __LINE__, __FILE__);
        // $msg = '';
        // $msg .= "<h1> Ejemplo de cluster difuzzo de C-medias: </h1> <br></br>";
        // $msg .= "<h3> Fuzzy C-Means:</h3><br>";
        // $m=1.25;//parametro de fuzzificacion //suministrado al llamar la funcion
        $m=2;//parametro de fuzzificacion //suministrado al llamar la funcion
        $P=2;//numero de clusters suministrado al llamar la funcion
        $e=0.00001;//tolerancia de culminacion(error tolerante). Se puede definir de forma fija sobre el algoritmo
        $dir = "./uploads/engine/fuzzyPatterns/vars/";
        echo "m=".$m."...<br><br>";
        echo "carga de datos:...<br>";
        $start0 = microtime(true);
        if(!$this->model_alm_datamining->var_exist('sample') || !$this->model_alm_datamining->var_exist('centers'))
        {
            $sample = $this->model_alm_datamining->gather_sample();
        }
        echo ('0)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
        echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start0)." => ".time_units(microtime(true)-$start0)."minutes </strong><br>";
        print "<strong>Pico de uso de memoria en la ejecucion: ".memory_units(memory_get_peak_usage())."<br>";
        //objetos deben venir de archivos o base de datos
        $objects = array(array('x' => 12.0, 'y' => 3504.0, 'z'=> 15),
                                        array('x' => 11.5, 'y' => 3693.0, 'z'=> 15),
                                        array('x' => 11.0, 'y' => 3436.0, 'z'=> 15),
                                        array('x' => 12.0, 'y' => 3433.0, 'z'=> 15),
                                        array('x' => 10.5, 'y' => 3449.0, 'z'=> 15),
                                        array('x' => 10.0, 'y' => 4341.0, 'z'=> 15),
                                        array('x' => 9.0, 'y' => 4354.0, 'z'=> 15),
                                        array('x' => 8.5, 'y' => 4312.0, 'z'=> 15),
                                        array('x' => 10.0, 'y' => 4425.0, 'z'=> 15),
                                        array('x' => 8.5, 'y' => 3850.0, 'z'=> 15),
                                        array('x' => 10.0, 'y' => 3563.0, 'z'=> 15),
                                        array('x' => 8.0, 'y' => 3609.0, 'z'=> 15),
                                        array('x' => 9.5, 'y' => 3761.0, 'z'=> 15),
                                        array('x' => 10.0, 'y' => 3086.0, 'z'=> 15),
                                        array('x' => 15.0, 'y' => 2372.0, 'z'=> 15),
                                        array('x' => 15.5, 'y' => 2833.0, 'z'=> 15),
                                        array('x' => 15.5, 'y' => 2774.0, 'z'=> 15),
                                        array('x' => 16.0, 'y' => 2587.0, 'z'=> 15));
        
        //centroides deben venir de archivos o base de datos
        $centroids = array(array('x' => 16.00, 'y' => 0, 'z'=>0),
                                    array('x' => 0, 'y' => 4354.0, 'z'=>0),
                                    array('x' => 0, 'y' => 0, 'z'=> 15),
                                    array('x' => 0, 'y' => 4354.0, 'z'=> 15),
                                    array('x' => 16.00, 'y' => 0, 'z'=> 15),
                                    array('x' => 16.00, 'y' => 4354.0, 'z'=> 0),
                                    array('x' => 16.00, 'y' => 4354.0, 'z'=> 15),
                                    array('x' => 0, 'y' => 0, 'z'=> 0));
        // $sample = $this->model_alm_datamining->get_allData();
        // $objects = $sample['objects'];
        // $centroids = $sample['centroids'];
        // $json['sample'] = $objects;
        // $files[] = $this->writeFile(json_encode(array('sample'=> $objects)), 'sample');

        // $c = count($centroids);//numero de centroides
        // $n = count($objects);

        // $c = $this->model_alm_datamining->varFileLength('sample');//numero de centroides
        // $n = $this->model_alm_datamining->varFileLength('centers');
        // echo $c.'<br><br>';
        // echo $n.'<br><br>';
        $error = 1;
        $tolerance = 0.00001;
        $iterations = 0;
        // $features = array();
        // foreach ($objects[0] as $key => $value)
        // {
        //     $features[]=$key;
        // }
        // $dimentions = array('n' => $n, 'c'=>$c);
        //for file creating and saving as variables purposes
        $start = microtime(true);
        $objects = $this->model_alm_datamining->load_var('sample');
        $centroids = $this->model_alm_datamining->load_var('centers');

        while ($error >= $tolerance)//mientras el error no sea tolerante
        {
//file version PART1
            echo "<br>Iteración: ".($iterations+1)."<br><br>1)-. remplazo de nuevos centros:...<br>";
        $start0 = microtime(true);
            if($this->model_alm_datamining->var_exist('newCenters'))
            {
                // echo 'descomentar en la linea:'.__LINE__.'<br>';
                // $centroids = $newCentroids;//READ-WRITE
                // $this->model_alm_datamining->copy_data('newCenters', 'centers');//READ-WRITE
                $centroids = $this->model_alm_datamining->load_var('newCenters');
            }
        echo ('1)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
        echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start0)." => ".time_units(microtime(true)-$start0)."minutes </strong><br>";
        print "<strong>Pico de uso de memoria en la ejecucion: ".memory_units(memory_get_peak_usage())."</strong><br>";

//FIN de file version PART1

//file version PART2
        echo "<br>2)-. construccion de matriz de distancias entre muestras y centros:...<br>";
        $start0 = microtime(true);
            //antes de construir U, debo construir una matriz de distancias (distancias de cada punto de la muestra, a cada centroide)
            $distanceMatrix = fopen($dir."d", "w") or die("Unable to open file!");
           // $objects = $this->model_alm_datamining->load_var('sample');
            foreach ($objects as $rowNumber => $row)//recorro los puntos de la muestra
            {
                if(isset($row)&& !empty($row))
                {
                    //$centroids = $this->model_alm_datamining->iterateVarFile('centers');
                    $distanceRow = array();
                    foreach ($centroids as $cRowNumber => $cRow)//recorre centroides
                    {
                        if(isset($cRow)&& !empty($cRow))
                        {
                            $aux = $this->d($row, $cRow);
                            $distanceRow[$cRowNumber]=$aux;
                        }
                    }
                    $newLine = json_encode($distanceRow);//JSON_FORCE_OBJECT
                    fwrite($distanceMatrix, $newLine."\n");
                }
            }
            fclose($distanceMatrix);
            /*CPU 6cores 3.3GHz
            *    2)-. Memoria Usada: 4.5 mb
                Tiempo de ciclo de ejecucion:1296.7541699409 => 21:36 minutes
                Pico de uso de memoria en la ejecucion: 4.43 mb
            */
            /*CPU 6Cores 3.21GHz
            *   2)-. Memoria Usada: 4.5 mb
                Tiempo de ciclo de ejecucion: 1173.9271450043 => 19:33 minutes
                Pico de uso de memoria en la ejecucion: 4.45 mb
            */
            /*CPU 2cores 2.53GHz
            *    2)-. Memoria Usada: 768 kb
                Tiempo de ciclo de ejecucion: 853.591845989227 => 14:13 minutes
                Pico de uso de memoria en la ejecucion: 688.58 kb
            */
            /*CPU 2cores 2.53GHz
            *    2)-. Memoria Usada: 768 kb
                Tiempo de ciclo de ejecucion: 813.71073102951 => 13:33 minutes
                Pico de uso de memoria en la ejecucion: 684.66 kb
            */
            /*CPU 6Cores 3.21GHz
            *   2)-. Memoria Usada: 84.5 mb
                Tiempo de ciclo de ejecucion: 1229.9153468609 => 20:29 minutes
                Pico de uso de memoria en la ejecucion: 84.31 mb
            */
        echo ('2)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
        echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start0)." => ".time_units(microtime(true)-$start0)."minutes </strong><br>";
        print "<strong>Pico de uso de memoria en la ejecucion: ".memory_units(memory_get_peak_usage())."</strong><br>";
        // die('<br>line: '.__LINE__.' stop!</strong>');
//FIN de file version PART2

//file version PART3
        echo "<br>3)-. construccion de matriz de membrecia (porcentage representativo de las distancias entre las muestras con respectos a los centros):...<br>";
        $start0 = microtime(true);
            //consturccion de U: $u o matriz de membrecia
            $membershipMatrix = fopen($dir."u", "w") or die("Unable to open file!");
            $distanceMatrix = $this->model_alm_datamining->iterateVarFile('d');
            $exp = 1/($m-1);
            foreach ($distanceMatrix as $sample => $line)//recorro los puntos de la distancias entre muestra-centroide(cada linea del archivo es una muestra)
            {
                if(isset($line)&& !empty($line))
                {
                    $line2 = $line;//copio la linea, para uso de comparacion mas adelante...
                    if(isset($u))
                    {
                        unset($u);
                    }
                    $u=array();
                    foreach ($line as $cluster => $d1)//recorro los centroides(cada columna, o atributo de la linea, es un cluster)
                    {
                        if(isset($d1))
                        {
                            if($d1==0)
                            {
                                $u[$cluster]=1;
                            }
                            else
                            {
                                $aux = 0;
                                $flag = 0;
                                foreach ($line2 as $cluster2 => $d2)//recorro los centroides (otra vez, en paralelo)
                                {
                                    if(($d2==0)&&($cluster!=$cluster2))
                                    {
                                        $flag=1;
                                    }
                                    else
                                    {
                                        $aux+= pow($d1/$d2, $exp);
                                    }
                                }
                                if($flag==1)
                                {
                                    $u[$cluster] = 0;
                                }
                                else
                                {
                                    $u[$cluster] = 1/$aux;
                                }
                            }
                        }
                    }
                    // if(count($u)!= 330)
                    // {
                    //     die('error!!! muestra: '.$sample.' cluster: '.$cluster);
                    // }
                    $newLine = json_encode($u);
                    fwrite($membershipMatrix, $newLine."\n");
                }
            }
            fclose($membershipMatrix);
            /*CPU 6Cores 3.21GHz
            *   3)-. Memoria Usada: 4.5 mb
                Tiempo de ciclo de ejecucion: 578.32707810402 => 9:38 minutes
                Pico de uso de memoria en la ejecucion: 4.45 mb 
            */
            /*CPU 2cores 2.53GHz
            *   3)-. Memoria Usada: 768 kb
                Tiempo de ciclo de ejecucion: 422.4248790741  => 7:2 minutes
                Pico de uso de memoria en la ejecucion: 630.19 kb
            */

            /*CPU 6Cores 3.21GHz
            *   3)-. Memoria Usada: 84.5 mb
                Tiempo de ciclo de ejecucion: 562.67018294334 => 0:9:22.670182943344minutes
                Pico de uso de memoria en la ejecucion: 84.42 mb
            */
        echo ('3)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
        echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start0)." => ".time_units(microtime(true)-$start0)."minutes </strong><br>";
        print "<strong>Pico de uso de memoria en la ejecucion: ".memory_units(memory_get_peak_usage())."</strong><br>";
        // die('line: '.__LINE__.' stop!</strong>');
//FIN de file version PART3

//file version PART4
        echo "<br>4)-. desplazando los centroides a partir de centroides nuevos(creando nuevos centros)...<br>";
        $start0 = microtime(true);
            $newCentroids = fopen($dir."newCenters", "w") or die("Unable to open file!");
            $oneObject = $objects[0];//leo solo la primera linea de las muestras para usar como referencia
            foreach ($centroids as $i => $ignore)//para recorrer los nuevos centroides
            {
                if(isset($ignore))
                {
                    $membSum=0;//inicio la sumatoria total de membresia
                    foreach ($oneObject as $key => $value)//para inicializar el auxiliar de la sumatoria
                    {
                        $membsumX[$key] = 0;
                    }
                    $membershipMatrix = $this->model_alm_datamining->iterateVarFile('u');//generador
                    foreach ($membershipMatrix as $k => $sample)
                    {
                        if(isset($sample))
                        {
                            $aux = pow($sample[$i], $m);
                            // $objectK = $this->model_alm_datamining->getFileLine('sample', $k);
                            // $auxVector = $this->multiply_vectors($objectK, $aux);
                            $auxVector = $this->multiply_vectors($objects[$k], $aux);
                            $membsumX = add_vectors($membsumX, $auxVector);
                            $membSum += $aux;
                        }
                    }
                    $aux = (1/$membSum);
                    $newCentroid = $this->multiply_vectors($membsumX, $aux);
                    $newLine = json_encode($newCentroid);
                    fwrite($newCentroids, $newLine."\n");
                }
            }
            fclose($newCentroids);
            //por cada nuevo centroide...
            /*CPU 2cores 2.53GHz
                1)-. Memoria Usada: 1 mb
                Tiempo de ciclo de ejecucion: 150.97322511673
                Tiempo de ciclo de ejecucion: 0:2:30.973231077194
                Pico de uso de memoria en la ejecucion: 791.64 kb
            */
            /*CPU 6Cores 3.21GHz
            *   4)-. Memoria Usada: 84.75 mb
                Tiempo de ciclo de ejecucion: 1290.0877890587 => 0:21:30.087789058685minutes
                Pico de uso de memoria en la ejecucion: 84.68 mb
            */
        echo ('4)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
        echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start0)." => ".time_units(microtime(true)-$start0)."minutes </strong><br>";
        print "<strong>Pico de uso de memoria en la ejecucion: ".memory_units(memory_get_peak_usage())."</strong><br>";
        // die('line: '.__LINE__.' stop!</strong>');
//FIN de file version PART4

//file version PART5
//////////////////voy por aqui
            if($this->model_alm_datamining->var_exist('uk'))//para calcular el margen de error o desplazamiento de las membrecias con respecto a los centroides
            {
                echo "<br>5)-. calculando la \"distancia\" entre matriz de pertenencia de la iteracion actual, y la anterior ...<br>";
                $start0 = microtime(true);
                $u = $this->model_alm_datamining->iterateVarFile('u');
                // $uk = $this->model_alm_datamining->load_var('uk');
                $uk = $this->model_alm_datamining->load_var('uk');//para pruebas
                $auxsqr=0;
                foreach ($u as $pos => $row)
                {
                    if(isset($row))
                    {
                        foreach ($row as $column => $value)
                        {
                            $aux= ($value-$uk[$pos][$column]);
                            $auxsqr+=pow($aux, 2);
                        }
                    }
                }
                $error= sqrt($auxsqr);
                echo ('5)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
                echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start0)." => ".time_units(microtime(true)-$start0)."minutes </strong><br>";
                print "<strong>Pico de uso de memoria en la ejecucion: ".memory_units(memory_get_peak_usage())."</strong><br>";
            }
            $this->model_alm_datamining->copy_data('u', 'uk');
            $iterations++;
            echo "<br>error = ".$error;
            /*CPU 6Cores 3.21GHz
            *   5)-. Memoria Usada: 144.5 mb
                Tiempo de ciclo de ejecucion: 2.8221609592438 => 0:2 minutes
                Pico de uso de memoria en la ejecucion: 144.28 mb
            */
            // echo ('5)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
            // echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start)." => ".time_units(microtime(true)-$start)."minutes </strong><br>";
            // print "<strong>Pico de uso de memoria en la ejecucion: ".memory_units(memory_get_peak_usage());
            // die('line: '.__LINE__.' stop!</strong>');
//FIN de file version PART5
            /*READ*/
            // $msg.= 'Jm= '.$this->Jm($objects, $u, $centroids, $m).'<br>';
        }
        /*CPU 6Cores 3.21GHz
            6)-. Memoria Usada: 144.75 mb
            Tiempo de ciclo de ejecucion: 5855.4699139595 => 1:44:15.469913959503minutes
            Pico de uso de memoria en la ejecucion: 144.67 mb
        */
        echo "<br><br><br> total de iteraciones: ".$iterations."<br>";
        echo ('6)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
        echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start)." => ".time_units(microtime(true)-$start)."minutes </strong><br>";
        print "<strong>Pico de uso de memoria en la ejecucion: ".memory_units(memory_get_peak_usage())."<br><br>";
        die('line: '.__LINE__.' stop!</strong>');
        echo "finished!";
        return($iterations);

    }
    public function fcmResults($m='')
    {
        $membershipMatrix = $this->model_alm_datamining->load_var('u');
        $centroids = $this->model_alm_datamining->load_var('centers');

        // foreach ($u as $i => $row)
        // {
        //     foreach ($row as $column => $attr)
        //     {
                
        //     }
        // }

        $files[] = $this->writeFile(json_encode(array( 'pattern2' => $this->pattern_story($membershipMatrix, $centroids))), 'pattern2');

        $files[] = $this->writeFile(json_encode(array( 'pattern1' => $this->pattern_results($membershipMatrix, $centroids))), 'pattern1');
        return ($files);
        // $centroides = $this->readFile('centroides', 'json_files');
        // if(!isset($m) || empty($m))
        // {
        //     $result = $this->readFile('msg', 'json_files');
        // }
        // else
        // {
        //     $result = $this->readFile('msg', 'json_files m='.$m);
        // }
        // echo_pre($result);
        // $auxRe = array();
        // $centroides = array();
        // foreach ($result['msg'] as $key => $value)
        // {
        //     foreach ($value as $key2 => $value2)
        //     {
        //         // echo $key2.'<br>';
        //         if(!is_numeric($key2))
        //         {
        //             $centroides[] = $result['msg'][$key][$key2];
        //             unset($result['msg'][$key][$key2]);
        //             arsort($result['msg'][$key]);
        //             // die_pre($result['pattern2'][$key][$key2]);
        //             // $auxRe[$key] = arsort($value);
        //             // die_pre($result['pattern2'][$key]);
        //         }
        //     }
        // }


        // echo_pre($centroides);
        // die_pre($result);
    }
    public function fcm($m='', $P='')//new version para ejecucion del CRON alm_datamining/fcm",[SELECT `id_articulo`, COUNT(`id_articulo`) AS `veces_solicitado`, SUM(`cant_solicitada`) AS `total_demanda`, SUM(`cant_aprobada`) AS `total_consumo` FROM `alm_art_en_solicitud` GROUP BY `id_articulo` ORDER BY `veces_solicitado` DESC LIMIT 10]
    {
        $start = microtime(true);
        ini_set('memory_limit', '511917728');
        // ini_set('memory_limit', '-1');
        //Def del vector caracteristico: ^[i]{n}[c]{3}[f]{3}... donde "i" es un articulo de la tabla de "n" articulos del sistema, "c" es una clasificacion del codigo de las naciones unidas {segmento, familia, categoria}; y "f" corresponde a la fecha de la solicitud realizada, {dia, mes, año}
                                    //para el cuadrante "i", cada valor del vector, es la cantidad solicitada de ese articulo en la solicitud
                                    //para el cuadrante "c", cada valor es el numero del identificador de la categoria(puede cambiar y pasaría a ser mi, mj, mk; donde mi es la cantidad de segmentos, mj es la cantidad de familias, y mk es la cantidad de categorias)
                                    //para el cuadrante "f", cada valor es el dia, mes y año que corresponde con la fecha de solicitud.
        
        // die_pre(time_units(), __LINE__, __FILE__);
        set_time_limit ( 360000 );
        // set_time_limit ( 1800 );//para el limite de tiempo de ejecucion (1500 segundos = 25 minutos)
        // die_pre("HELLO", __LINE__, __FILE__);
        /*Explicacion basica del objetivo de la funcion
        [importante]: Antes que nada, es necesario establecer que centroide y cluster referencian cosas distintas, es decir el cluster es un grupo de datos, y centroide, es el punto centrico de ese cluster, por lo que J es un cluster, y cj es el centroide de ese cluster
        El algoritmo es un metodo de agrupacion, que permite a un Trozo de dato, pertenecer a uno o mas grupos
        [el metodo fue desarrollado por Dunn en 1973 y luego fue mejorado por Bezdek en 1981]
        el algoritmo se centra en agrupamiento difuzzo, lo cual implica que independiente de donde se encuentren agrupados los datos
        estos pueden pertenecer a mas de un grupo
        cabe destacar que el algoritmo es frecuentemente usado para reconosimiento de patrones entre los datos,
        y se basa en la "minimizacion" de la siguiente funcion objetivo:

        J_m = [sumatoria de i=1 hasta N][sumatoria de j=1 hasta C] de: (u_ij ^m) x la distancia euclideana de X_i y c_j al cuadrado.

        Siendo N la cantidad de puntos en el espacio, C la cantidad de centroides que se formaran aleatoriamente, u_ij es la matriz de membrecia de los puntos con respecto a los centroides, m cualquier numero mayor o igual a 1,
        X_i es el iesimo punto del espacio, c_j es el jesimo centroide de los clusters

        otra formulacion de la funcion es:

        V_i* = la [sumatoria de k=1 hasta n] de: (u_ik ^m) x X_k. Dividido entre: la [sumatoria de k=1 hasta n] de: (u_ik ^m),
        donde i va desde 1 hasta la cantidad de centroides entre los clusters, y k va desde 1 hasta la cantidad de puntos en el espacio.

        para la construccion de la matriz de membrecia u_ik se define por partes de la siguiente forma:

        u_ik = 1/[sumatoria de j=1 hasta c] de: (la distancia euclidiana cuadrada entre X_k y v_i)/(la distancia euclidiana cuadrada entre X_k y v_j), elevado a 1/(m-1)
        cuando la distancia euclidiana cuadrada para j, es diferente a 0,
        u_ik = 1
        cuando la distancia euclidiana cuadrada para i, es igual a 0,
        u_ik = 0
        cuando la distancia euclidiana cuadrada para j, es igual a 0, y i es diferente a j


        ahora bien, la explicacion de W. Wei y J.M Mendel, para pruebas de optimalidad del algoritmo y donde proponen reparaciones para la optimizacion
        de la misma implementando una matriz hessiana de cs x cs, donde  c es el numero de clusters y s es la dimension de cada vector muestra.




        /*U se compone de cada iteracion de $distanceMatrix, es decir U[m]= a la m-esimo iteracion de $distance Matrix*/
        // $msg = '';
        // echo "<h1> Ejemplo de cluster difuzzo de C-medias: </h1> <br></br>";
        // $msg .= "<h1> Ejecución de cluster difuzzo de C-medias: </h1> <br>";
        // echo "<h3> Fuzzy C-Means:</h3><br>";
        // $msg .= "<h3> Fuzzy C-Means:</h3><br>";
        // $m=1.25;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=243.7555141449 it=56
        // $m=1.5;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=317.18084597588 it=72
        // $m=1.75;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=378.16534996033 it=83
        $m=2;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=933.02929210663 it=204
        // $m=2.25;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=455.82271695137 it=99
        // $m=2.5;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=665.96932792664 it=119
        // $m=2.75;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=522.48389196396 it=110
        // $m=3;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=496.38486790657 it=110
        // $m=3.25;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=691.79837989807 it=150
        // $m=3.5;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=583.93491005898 it=127
        // $m=3.75;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=737.5228331089 it=161
        // $m=4;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=723.57445001602 it=158
        // $m=4.25;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=596.95481801033 it=130
        // $m=4.5;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=507.72616386414 it=111
        // $m=4.75;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=802.94658899307 it=171
        // $m=5;//parametro de fuzzificacion //suministrado al llamar la funcion //debe ser mayor o igual a 1 t=657.42558193207 it=118
        // $P=2;//numero de clusters suministrado al llamar la funcion
        $e=0.00001;//tolerancia de culminacion(error tolerante). Se puede definir de forma fija sobre el algoritmo
        // $msg.="<br><strong>Parámetro de fuzzificación M:".$m."</strong><br><br>";

        // $objects = array(array( 'x' => 5, 'y' => 10), array('x'=>6, 'y'=>8), array('x'=>4, 'y'=>5), array('x'=>7, 'y'=>10), array('x'=>8, 'y'=>12), array('x'=>10, 'y'=>9), array('x'=>12, 'y'=>11), array('x'=>4, 'y'=>6));
        // $rand_centroids = array(array('x'=>5, 'y'=>10), array('x'=>7, 'y'=>10), array('x'=>12, 'y'=>11));
        $objects = array(array('x' => 12.0, 'y' => 3504.0, 'z'=> 15),
                                array('x' => 11.5, 'y' => 3693.0, 'z'=> 15),
                                array('x' => 11.0, 'y' => 3436.0, 'z'=> 15),
                                array('x' => 12.0, 'y' => 3433.0, 'z'=> 15),
                                array('x' => 10.5, 'y' => 3449.0, 'z'=> 15),
                                array('x' => 10.0, 'y' => 4341.0, 'z'=> 15),
                                array('x' => 9.0, 'y' => 4354.0, 'z'=> 15),
                                array('x' => 8.5, 'y' => 4312.0, 'z'=> 15),
                                array('x' => 10.0, 'y' => 4425.0, 'z'=> 15),
                                array('x' => 8.5, 'y' => 3850.0, 'z'=> 15),
                                array('x' => 10.0, 'y' => 3563.0, 'z'=> 15),
                                array('x' => 8.0, 'y' => 3609.0, 'z'=> 15),
                                array('x' => 9.5, 'y' => 3761.0, 'z'=> 15),
                                array('x' => 10.0, 'y' => 3086.0, 'z'=> 15),
                                array('x' => 15.0, 'y' => 2372.0, 'z'=> 15),
                                array('x' => 15.5, 'y' => 2833.0, 'z'=> 15),
                                array('x' => 15.5, 'y' => 2774.0, 'z'=> 15),
                                array('x' => 16.0, 'y' => 2587.0, 'z'=> 15));
        // $centroids = array(array('x' => 0, 'y' => 4354.0, 'z'=>16),
        //                     array('x' => 16.0, 'y' => 0, 'z'=>16),
        //                     array('x' => 16.0, 'y' => 817.00, 'z'=> 0));
        $centroids = array(array('x' => 16.00, 'y' => 0, 'z'=>0),
                            array('x' => 0, 'y' => 4354.0, 'z'=>0),
                            array('x' => 0, 'y' => 0, 'z'=> 15),
                            array('x' => 0, 'y' => 4354.0, 'z'=> 15),
                            array('x' => 16.00, 'y' => 0, 'z'=> 15),
                            array('x' => 16.00, 'y' => 4354.0, 'z'=> 0),
                            array('x' => 16.00, 'y' => 4354.0, 'z'=> 15),
                            array('x' => 0, 'y' => 0, 'z'=> 0));


        // $pack = $this->model_alm_datamining->get_data();
        // $objects = $pack['data'];
        // $centroids = $this->notSoRandom_centroids($objects);

        // 0.11, 0.44
        // 0.82, 0.11
        // $rand_centroids = array(array('x' =>0.11, 'y'=>0.44),
        //                         array('x' =>0.82, 'y'=>0.11));
        // $centroids = array(array('x' => 6.00, 'y' => 1379.00),
        //                         array('x' => 5.00, 'y' => 817.00));//se elijen de forma aleatoria, termina en 18 iteraciones
        //con estos los ultimos centroides son: [0]['x']=14.398384785182
        //                                      [0]['y']=2731.2334455154
        //                                      [1]['x']=10.035427086687
        //                                      [1]['y']=3826.2524135898
        // $centroids = array(array('x' => 11.00, 'y' => 3430.00),
        //                         array('x' => 15.00, 'y' => 2817.00));//se elijen de forma aleatoria, termina en 4 iteraciones
        // $aux = $this->dataPrep();
        // $objects = $aux['objects'];
        // $index = $aux['index'];

        // $centroids = $this->pick_average_centroids($objects);
        //con estos los ultimos centroides son: [0]['x']=10.035429830515
        //                                      [0]['y']=3826.2515212185
        //                                      [1]['x']=14.398393259876
        //                                      [1]['y']=2731.2319967621
        // $centroids = array(array('x' => 8.0, 'y' => 3609.0),
                                // array('x' => 10.0, 'y' => 4425.0));

        // $centroids = array(array('x' => 14.298538741182, 'y' => 2760.5969177144),
        //                         array('x' => 9.9986937825316, 'y' => 3835.5030603179));//se elijen de forma aleatoria
        /*
            Por motivos de desempeño, hay un problema, al tener una muestra de mas de 1000 registros, el algoritmo se
            bloquea por el tiempo de espera para contrarestar esto, es necesario guardar todas las
            variables en disco-duro, y no en RAM; Entre las opciones para escribir los
            resultados de las operaciones, y luego consultarlas, están: SQ (leer y escribir en BD);
            Y Archivo (I/O en Discoduro), y se ha determinado que lecturas y escrituras
            constantes o exponenciales en la BD es más lento que en archivo, así que se
            elige re-diseñar las operaciones para leer y escribir los resultados en archivo
        */
        if(!$this->model_alm_datamining->var_exist('sample') || !$this->model_alm_datamining->var_exist('centers'))
        {
            echo ($this->model_alm_datamining->get_allData());
        }
            $start = microtime(true);
            
            $objects = $this->model_alm_datamining->load_var('sample');
            $centroids = $this->model_alm_datamining->load_var('centers');
            // $sample = $this->model_alm_datamining->get_allData();
            // die_pre($sample, __LINE__, __FILE__);
            // $objects = $sample['objects'];
            // $centroids = $sample['centroids'];
        // $json['sample'] = $objects;
        // $files[] = $this->writeFile(json_encode(array('sample'=> $objects)), 'sample');
        // die_pre($files);
        $c = count($centroids);//numero de centroides
        $n = count($objects);
        $error = 1;
        $tolerance = 0.00001;
        $iterations = 0;
        // $features = array();
        // foreach ($objects[0] as $key => $value)
        // {
        //     $features[]=$key;
        // }
        //Variable a travez de BD
        $dimentions = array('n' => $n, 'c'=>$c);
        // $this->model_alm_datamining->build_centroidsTable($features);
        // $this->model_alm_datamining->set_centroids($centroids);
        // $this->model_alm_datamining->build_distanceTable($features);
        // $this->model_alm_datamining->build_membershipTable($features);
        // $start = microtime(true);
        echo "Trabajando.";
        while ($error >= $tolerance)//mientras el error esté por arriba del valor tolerante
        {
            // echo ($iterations+1);
            //ORIGINAL
            if(isset($newCentroids) && !empty($newCentroids))
            {
                $centroids = $newCentroids;//READ
            }
            //antes de construir U, debo construir una matriz de distancias (distancias de cada punto de la muestra, a cada centroide)
            //ORIGINAL
            if(isset($d))
            {
                unset($d);
            }
            // echo '..distancia..';
            //ORIGINAL
            $d=array();
            for ($k=0; $k < $n; $k++)//recorro los puntos de la muestra
            {
                $d[$k]=array();
                for ($i=0; $i < $c; $i++)//recorre centroides
                {
                    $d[$k][$i] = $this->d($objects[$k], $centroids[$i]);//WRITE
                    // $this->model_alm_datamining->save_data('d['.$k.']['.$i.']', $this->d($objects[$k], $centroids[$i]));
                }
            }
            // echo '...fin de distancias';
            // die_pre($d, __LINE__, __FILE__);
            //consturccion de U: $u o matriz de membrecia
            //ORIGINAL
            if(isset($u))
            {
                unset($u);
            }
            //ORIGINAL
            $u= array();
            $exp = 1/($m-1);
            for ($k=0; $k < $n; $k++)//recorro los puntos de la muestra
            {
                $u[$k] = array();
                for ($i=0; $i < $c; $i++)//recorro los centroides
                {
                    /*READ*/
                    if($d[$k][$i]==0)//de acuerdo a la funcion definida a trozos
                    {
                        $u[$k][$i] = 1;//WRITE
                        // $this->model_alm_datamining->save_data('u['.$k.']['.$i.']', 1);
                    }
                    else
                    {
                        $aux = 0;
                        // $auxtest = 0;
                        $flag = 0;
                        for ($j=0; $j < $c; $j++)//recorro los centroides (otra vez)
                        {
                        
                            /*READ*/
                            if(($d[$k][$j]==0) && ($j!= $i))//de acuerdo a la funcion definida a trozos
                            {
                                $flag = 1;
                            }
                            else
                            {
                                $aux+= pow($d[$k][$i]/$d[$k][$j], $exp);//READ
                                // $d1 = $this->model_alm_datamining->get_data('d['.$k.']['.$i.']', __LINE__);
                                // $d2 = $this->model_alm_datamining->get_data('d['.$k.']['.$j.']', __LINE__);
                                // $auxtest+= pow($d1/$d2, $exp);
                            }
                        }
                        if($flag==1)
                        {
                            $u[$k][$i] = 0;//WRITE
                            // $this->model_alm_datamining->save_data('u['.$k.']['.$i.']', 0);
                        }
                        else
                        {
                            $u[$k][$i] = 1/$aux;//WRITE
                            // $this->model_alm_datamining->save_data('u['.$k.']['.$i.']', (1/$auxtest));
                        }
                    }
                }
            }
            // echo_pre($u, __LINE__, __FILE__);
            //ORIGINAL
            // $membershipMatrix = $u;
            if(isset($newCentroids))
            {
                unset($newCentroids);
            }
            //ORIGINAL
            $newCentroids = array();
            for ($i=0; $i < $c; $i++)//para los nuevos centroides
            {
                $membSum=0;
                foreach( $objects[0] as $key => $value)//para inicializar el auxiliar de la suma
                {
                    $membsumX[$key]=0;
                }
                for ($k=0; $k < $n; $k++)
                {
                    // echo($u[$k][$i])."<br>";
                    // echo()."<br>";
                    $aux = pow($u[$k][$i], $m);//READ

                    // $uaux = $this->model_alm_datamining->get_data('u['.$k.']['.$i.']', __LINE__);
                    // $aux = pow($uaux, $m);//READ

                    $auxVector = $this->multiply_vectors($objects[$k], $aux);//READ
                    $membsumX = add_vectors($membsumX, $auxVector);
                    $membSum += $aux;
                }
                $aux = (1/$membSum);
                $newCentroids[$i]=$this->multiply_vectors($membsumX, $aux);
            }
            // die(__LINE__);

            /*READ*/
            //ORIGINAL
            if(isset($uk))//para calcular el margen de error o desplazamiento de las membrecias con respecto a los centroides
            {
                $auxsqr=0;
                for ($i=0; $i < $c; $i++)
                {
                    for ($k=0; $k < $n; $k++)
                    {
                        $aux = ($u[$k][$i]-$uk[$k][$i]);//READ
                        $auxsqr+=pow($aux, 2);
                    }
                }
                $error= sqrt($auxsqr);
                // echo_pre($error, __LINE__, __FILE__);
                unset($uk);
            }
            //ORIGINAL
            $uk = $u;
            // $this->model_alm_datamining->copy_data('u', 'uk');
            $iterations++;
            echo $iterations."<br>";
            // $msg.= 'Jm= '.$this->Jm($objects, $u, $centroids, $m).'<br>';
            // echo ".";
            // $msg.= 'Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>';
        }
        $this->model_alm_datamining->save_data('FCM_MembershipMatrix', $u);
        echo_pre($u, __LINE__, __FILE__);
        echo "<br><br><br> total de iteraciones: ".$iterations."<br>";
        echo ('6)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
        echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start)." => ".time_units(microtime(true)-$start)."minutes </strong><br>";
        
        $start = microtime(true);
        echo ($this->Dunn_PC($u, $c, $n));
        echo ($this->validation_index($u, $c, $n));
        echo ('7)-. Memoria Usada: '.memory_units(memory_get_usage(true)).'<br>');
        echo "<strong>Tiempo de ciclo de ejecucion: ".(microtime(true)-$start)." => ".time_units(microtime(true)-$start)."minutes </strong><br>";
        print "<strong>Pico de uso de memoria en la ejecucion: ".memory_units(memory_get_peak_usage())."<br><br>";
        die('line: '.__LINE__.' stop!</strong>');
        $msg.="<br><strong>Tiempo de ciclo de ejecucion:".(microtime(true)-$start)."</strong><br>";
        // $json['iterations'] = $iterations;
        $files[] = $this->writeFile(json_encode(array( 'iterations' => $iterations)), 'iterations');
        // echo "<br><strong>iteraciones: ".$iterations."</strong><br>";
        $msg.="<br><strong>iteraciones: ".$iterations."</strong><br>";
        // echo_pre($centroids, __LINE__, __FILE__);
        $msg.="<br><strong>centroids:</strong><br>";
        // $this->print_multidimentional_array($centroids);
        // $json['centroides'] = $centroids;
        // $aux = json_encode(array( 'centroides' => $centroids));
        $files[] = $this->writeFile(json_encode(array( 'centroides' => $centroids)), 'centroides');
        $msg.=$this->print_multidimentional_array($centroids);
        // echo_pre($sumatoriaCentroidesN);
        // echo_pre($rand_centroids);
        // echo_pre($membershipMatrix, __LINE__, __FILE__);
        // echo "<br><strong>Membership Matrix:</strong><br>";
        $msg.= "<br><strong>Membership Matrix:</strong><br>";
        // $this->print_multidimentional_array($membershipMatrix, TRUE);
        // $json['distanceMatrix'] = $d;
        // $aux = json_encode(array( 'distanceMatrix' => $d));
        $files[] = $this->writeFile(json_encode(array( 'distanceMatrix' => $d)), 'distanceMatrix');
        // $json['membershipMatrix'] = $membershipMatrix;
        // $aux = json_encode(array( 'membershipMatrix' => $membershipMatrix));
        $files[] = $this->writeFile(json_encode(array( 'membershipMatrix' => $membershipMatrix)), 'membershipMatrix');
        $msg.=$this->print_multidimentional_array($membershipMatrix, TRUE);

        // $this->print_multidimentional_array($membershipMatrix);

        // $this->print_membershipColumns($membershipMatrix, $pack['columns']);
        // echo "<br><strong>muestras agrupadas:</strong><br>";
        // $this->print_classify($membershipMatrix, $pack['columns']);
        // $BS=array();
        // for ($i=0; $i < count($membershipMatrix); $i++)
        // {
        //     $aux=0;
        //     for ($j=0; $j < count($membershipMatrix[$i]); $j++)
        //     {
        //         $aux+=$membershipMatrix[$i][$j];
        //     }
        //     $BS[]=$aux;
        // }
        // echo "<strong>Tabla de referencia solicitudes y articulos para los puntos de la muestra</strong><br>";
        // $msg.= "<strong>Tabla de referencia solicitudes y articulos para los puntos de la muestra</strong><br>";
        // echo_pre($pack['reference'], __LINE__, __FILE__);
        // echo"<strong>Probando que las membrecias no excedan el 100%</strong><br>";
        // echo_pre($BS, __LINE__, __FILE__);
        //http://php.net/manual/en/function.log.php para la funcion de indice de prueba de optimalidad   encontrado en "EL_20_1_08.pdf"

        // $Impe_dmfp = $this->validation_index($u, $centroids, $n);
        // $msg.= 'validation index: ';//indice de validacion del algoritmo
        // $json['validation_index'] = $this->validation_index($u, $centroids, $n);
        // $aux = json_encode(array( 'validation_index' => $this->validation_index($u, $centroids, $n)));
        $files[] = $this->writeFile(json_encode(array( 'validation_index' => $this->validation_index($u, $centroids, $n))), 'validation_index');
        // $msg.=$json['validation_index'];
        // die_pre($Impe_dmfp, __LINE__, __FILE__);//indice de validacion del algoritmo
        //para $m=1.25, y $e=0.001 0.080216381201464
        // echo $msg;
        // $json['msg'] = $msg;//.'<br>file variables iterations: '.$this->fcmFILEVARS($m, $P);;
        //.'<br>file variables iterations: '.$this->fcmFILEVARS($m, $P);
        // $aux = json_encode(array( 'msg' => $msg));
        $files[] = $this->writeFile(json_encode(array( 'msg' => $msg)), 'msg');
        // $json['msg'] = $this->model_alm_datamining->get_allData();
        // $json['msg'] = $this->model_alm_datamining->read_data('citylots.json');
        // $json['msg'] = $this->model_alm_datamining->save_data('['.$i.']['.$k.'].json', array('the file has been written' => 'go fuck yourself!'));
        // $json['msg'] = $this->model_alm_datamining->save_data('['.$i.']['.$k.'].json', array('the file has been overwritten' => 'go fuck yourself!'));
        // $json['msg'] = $this->model_alm_datamining->get_data('['.$i.']['.$k.'].json');
        // $json['pattern2'] = $this->pattern_story($membershipMatrix, $centroids);
        // $aux = json_encode(array( 'pattern2' => $this->pattern_story($membershipMatrix, $centroids)));
        $files[] = $this->writeFile(json_encode(array( 'pattern2' => $this->pattern_story($membershipMatrix, $centroids))), 'pattern2');
        // $json['pattern1'] = $this->pattern_results($membershipMatrix, $centroids);
        // $aux = json_encode(array( 'pattern1' => $this->pattern_results($membershipMatrix, $centroids)));
        $files[] = $this->writeFile(json_encode(array( 'pattern1' => $this->pattern_results($membershipMatrix, $centroids))), 'pattern1');
        echo json_encode($files);
        // $data = json_encode($json, JSON_PRETTY_PRINT);
        // $this->writeFile($data);
    }
    public function adjustDB()
    {
        $this->model_alm_datamining->adjust_cod_artNU();
        echo "DONE!";
    }
    private function writeFile($data, $filename='')
    {
        if(!is_dir("./uploads/engine/fuzzyPatterns"))//en caso que el directorio no existe
        {
            if(!is_dir("./uploads/engine"))//en caso que el directorio no existe
            {
                mkdir("./uploads/engine", 0755);//crea el directorio, con el permiso necesario para trabajarlo desde el sistema
            }
            if(!is_dir("./uploads/engine/fuzzyPatterns"))//en caso que el directorio no existe
            {
                mkdir("./uploads/engine/fuzzyPatterns", 0755);
            }
        }
        if(!isset($filename) || empty($filename))
        {
            if(!write_file('./uploads/engine/fuzzyPatterns/results', $data))
            {
                return('error writing file: "./uploads/engine/fuzzyPatterns/results"');
            }
            else
            {
                return('./uploads/engine/fuzzyPatterns/results');
            }
        }
        else
        {
            if(file_exists('./uploads/engine/fuzzyPatterns/json_files/'.$filename))
            {
                delete_files('./uploads/engine/fuzzyPatterns/json_files/');
            }
            if(!is_dir('./uploads/engine/fuzzyPatterns/json_files'))//en caso que el directorio no existe
            {
                mkdir('./uploads/engine/fuzzyPatterns/json_files', 0755);//crea el directorio, con el permiso necesario para trabajarlo desde el sistema
            }
            if(!write_file('./uploads/engine/fuzzyPatterns/json_files/'.$filename, $data))
            {
                return('error writing file: "./uploads/engine/fuzzyPatterns/json_files/'.$filename.'"');
            }
            else
            {
                return('./uploads/engine/fuzzyPatterns/json_files/'.$filename);
            }
        }
    }
    private function readFile($filename='', $dir='')
    {
        $this->load->helper('directory');
        if(!isset($dir) || empty($dir))
        {
            $dir = './uploads/engine/fuzzyPatterns/vars/';
        }
        else
        {
            $dir = './uploads/engine/fuzzyPatterns/'.$dir.'/';
        }
            $folderContent = directory_map($dir, 1);
        $flag = 0;
        foreach ($folderContent as $key => $value)
        {
            if($value==$filename)
            {
                $flag+=1;
            }
            else
            {
                $flag+=0;
            }
        }
        if($flag)
        {
            $myFile = $dir.$filename;
            try
            {
                return json_decode(file_get_contents($myFile), true);
            }
            catch (Exception $e)
            {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
    }
    public function test($array='')
    {
        // die(json_encode($array));
        $json['msg'] = $this->model_alm_datamining->get_allData();
        // $this->buildCentroids($json['msg']['centers']);
        echo json_encode($json);
    }
    public function pattern_translator($patter, $Cntrs)//no es generico, se basa al objeto de muestra del proyecto
    {

    }

    public function pattern_story($memMat, $Cntrs)
    {
        $pattern = array();
        foreach ($Cntrs as $key => $value)
        {
            $pattern[$key]['coords'] = $value;
        }
        foreach ($memMat as $key => $value)
        {
            foreach ($value as $probe => $percent)
            {

                // if(!isset($pattern[$probe]))
                // {
                //     $pattern[$probe] = array();
                // }
                if(($percent*100)>1)
                {
                    $pattern[$probe][$key+1] = ($percent*100);
                    // array_push($pattern[$probe], $key);
                }
            }
        }
        // $message=print_r($pattern, TRUE);
        // $message = '';
        // foreach ($Cntrs as $key => $value)
        // {
            // $message.='<br>'.$key;
            // $pattern[$key]['coords'] = $value;
            // foreach ($value as $data => $score)
            // {
            //     // $message.='<br> '.$data;
            //     // $message.=' = '.$score;
            // }
        // }
        // die_pre($pattern);
        // return $message;
        return $pattern;
    }

    public function pattern_results($memMat, $Cntrs)
    {
        foreach ($memMat as $key => $value)
        {
            foreach ($value as $probe => $percent)
            {
                if(($percent*100)>1)
                {
                    $memMat[$key]['centroide: '.($probe+1)] = ($percent*100);
                    // $pattern[$probe][$key+1] = ($percent*100);
                    // array_push($pattern[$probe], $key);
                }
                unset($memMat[$key][$probe]);
            }
        }
        return $memMat;
    }
    public function fcmbad()
    {
        $m=1.25;//parametro de fuzzificacion
        $P=2;//cantidad de centroides
        $objects = array(array('x' => 12.0, 'y' => 3504.0),
                        array('x' => 11.5, 'y' => 3693.0),
                        array('x' => 11.0, 'y' => 3436.0),
                        array('x' => 12.0, 'y' => 3433.0),
                        array('x' => 10.5, 'y' => 3449.0),
                        array('x' => 10.0, 'y' => 4341.0),
                        array('x' => 9.0, 'y' => 4354.0),
                        array('x' => 8.5, 'y' => 4312.0),
                        array('x' => 10.0, 'y' => 4425.0),
                        array('x' => 8.5, 'y' => 3850.0),
                        array('x' => 10.0, 'y' => 3563.0),
                        array('x' => 8.0, 'y' => 3609.0),
                        array('x' => 9.5, 'y' => 3761.0),
                        array('x' => 10.0, 'y' => 3086.0),
                        array('x' => 15.0, 'y' => 2372.0),
                        array('x' => 15.5, 'y' => 2833.0),
                        array('x' => 15.5, 'y' => 2774.0),
                        array('x' => 16.0, 'y' => 2587.0));//los puntos de ejemplo
        
        $rand_centroids = array(array('x' => 6.00, 'y' => 1379.00),
                                array('x' => 5.00, 'y' => 817.00));//se elijen de forma aleatoria
        // $error = 1;
        // $itAnterior = 0;
        // while($error<0.0005)
        // {
            $membershipMatrix =array();
            for ($i=0; $i < count($objects); $i++)//aqui recorre los puntos
            {
                $distanceE=array();
                $membershipMatrix[$i] = array();
                for ($k=0; $k < $P; $k++)//aqui recorre los centroides
                {
                    $distanceE[$k] = $this->euclidean_distance($objects[$i], $rand_centroids[$k]);
                    if($distanceE[$k]==0)
                    {
                        $distanceE[$k] = 0.000001;
                    }
                }
                $sumKtoC = 0;
                for ($j=0; $j < $P; $j++)
                {
                    $distanceAux = $this->euclidean_distance($objects[$i], $rand_centroids[$j]);
                    $sumKtoC = 0;
                    for ($k=0; $k < $P; $k++)
                    {
                        $expo = 2/($m-1);
                        $aux = $distanceAux/$distanceE[$k];
                        $sumKtoC += pow($aux, $expo);
                    }
                    $membershipMatrix[$i][$j] = (1/$sumKtoC);
                }
            }
            $new_clusters = array();
            for ($j=0; $j < $P; $j++)
            {
                $new_clusters[$j]= array('x'=>0.00, 'y'=>0.00);
                $sumMembership = 0.00;
                for ($i=0; $i < count($objects); $i++)
                {
                    $sumMembership += pow($membershipMatrix[$i][$j], $m);
                    $aux = pow($membershipMatrix[$i][$j], $m);
                    $aux2 = $this->multiply_vectors($objects[$i], $aux);
                    $new_clusters[$j] = $this->add_vectors($aux2, $new_clusters[$j]);
                }
                $aux = 1/$sumMembership;
                $new_clusters[$j] = $this->multiply_vectors($new_clusters[$j], $aux);
                // die_pre($lowSum);
            }
            echo_pre($new_clusters);
            // echo_pre($membershipMatrix);

            $this->fcm1();

        // }

    }

    public function fcm1()
    {
        /*U se compone de $distanceMatrix*/
        echo "<h1> Ejemplo de cluster difuzzo de C-medias: </h1> <br></br>";
        echo "<h3> Fuzzy C-Means:</h3><br>";
        $m=1.25;//parametro de fuzzificacion
        // $m=2;//parametro de fuzzificacion
        $P=2;//numero de clusters
        // $e=;//tolerancia de culminacion
        // $objects = array(array( 'x' => 5, 'y' => 10), array('x'=>6, 'y'=>8), array('x'=>4, 'y'=>5), array('x'=>7, 'y'=>10), array('x'=>8, 'y'=>12), array('x'=>10, 'y'=>9), array('x'=>12, 'y'=>11), array('x'=>4, 'y'=>6));
        // $rand_centroids = array(array('x'=>5, 'y'=>10), array('x'=>7, 'y'=>10), array('x'=>12, 'y'=>11));
        $objects = array(array('x' => 12.0, 'y' => 3504.0, 'z'=> 15),
                        array('x' => 11.5, 'y' => 3693.0, 'z'=> 15),
                        array('x' => 11.0, 'y' => 3436.0, 'z'=> 15),
                        array('x' => 12.0, 'y' => 3433.0, 'z'=> 15),
                        array('x' => 10.5, 'y' => 3449.0, 'z'=> 15),
                        array('x' => 10.0, 'y' => 4341.0, 'z'=> 15),
                        array('x' => 9.0, 'y' => 4354.0, 'z'=> 15),
                        array('x' => 8.5, 'y' => 4312.0, 'z'=> 15),
                        array('x' => 10.0, 'y' => 4425.0, 'z'=> 15),
                        array('x' => 8.5, 'y' => 3850.0, 'z'=> 15),
                        array('x' => 10.0, 'y' => 3563.0, 'z'=> 15),
                        array('x' => 8.0, 'y' => 3609.0, 'z'=> 15),
                        array('x' => 9.5, 'y' => 3761.0, 'z'=> 15),
                        array('x' => 10.0, 'y' => 3086.0, 'z'=> 15),
                        array('x' => 15.0, 'y' => 2372.0, 'z'=> 15),
                        array('x' => 15.5, 'y' => 2833.0, 'z'=> 15),
                        array('x' => 15.5, 'y' => 2774.0, 'z'=> 15),
                        array('x' => 16.0, 'y' => 2587.0, 'z'=> 15));
        // $objects = array(array('x' =>0.58, 'y' =>0.33),
        //                  array('x' =>0.90, 'y' =>0.11),
        //                  array('x' =>0.68, 'y' =>0.17),
        //                  array('x' =>0.11, 'y' =>0.44),
        //                  array('x' =>0.47, 'y' =>0.81),
        //                  array('x' =>0.24, 'y' =>0.83),
        //                  array('x' =>0.09, 'y' =>0.18),
        //                  array('x' =>0.82, 'y' =>0.11),
        //                  array('x' =>0.65, 'y' =>0.50),
        //                  array('x' =>0.09, 'y' =>0.63),
        //                  array('x' =>0.98, 'y' =>0.24));
        // echo_pre($objects);
        // 0.11, 0.44
        // 0.82, 0.11
        // $rand_centroids = array(array('x' =>0.11, 'y'=>0.44),
        //                         array('x' =>0.82, 'y'=>0.11));
        $rand_centroids = array(array('x' => 0, 'y' => 4354.0, 'z'=>16),
                                array('x' => 16.0, 'y' => 0, 'z'=>16),
                                array('x' => 16.0, 'y' => 817.00, 'z'=> 0));//se elijen de forma aleatoria
        // $rand_centroids = array(array('x' => 14.298538741182, 'y' => 2760.5969177144),
        //                         array('x' => 9.9986937825316, 'y' => 3835.5030603179));//se elijen de forma aleatoria
        $iterate = 0;
        while ($iterate < 1)
        {
            // $distanceMatrix = array();//declaracion de areglo de matriz de distancias
            $membershipMatrix = array();
            $auxMatrix = array();
            
            // $distanceMatrix = $this->fake_distance();
            for ($i=0; $i < count($objects); $i++)
            {
                $distanceMatrix[$i] = array();//declaracion de areglo de matriz de distancias
                $membershipMatrix[$i] = array();
                $auxMatrix[$i] = array();
                $sumatoriaMembrecia = 0;
                for ($j=0; $j < $P; $j++)//aqui recorre los centroides para...
                {
                    $distanceMatrix[$i][$j] = round($this->euclidean_distance($objects[$i], $rand_centroids[$j]), 2);//...construir la matriz de distancia euclideana
                    $distanceMatrix[$i][$j] = $this->euclidean_distance($objects[$i], $rand_centroids[$j]);
                    // if($distanceMatrix[$i][$j]==0)
                    // {
                    //     $distanceMatrix[$i][$j] = 0.00001;
                    // }
                    // die_pre($distanceMatrix[$i][$j]);
                    if($distanceMatrix[$i][$j]!=0)
                    {
                        $aux = (1/$distanceMatrix[$i][$j]);
                    }
                    else
                    {
                        if($i!=$j)
                        {
                            $aux = 0;
                        }
                        else
                        {
                            $aux = 1;
                        }
                    }

                    $aux2 = (1/($m-1));
                    $auxMatrix[$i][$j] = pow($aux, $aux2);//...construyo (parcialmente) la matriz de membrecia
                    $sumatoriaMembrecia += $auxMatrix[$i][$j];
                }
                for ($k=0; $k < $P; $k++)//recorre los centroides nuevamente para...
                {
                    // $membershipMatrix[$i][$k] = round(($auxMatrix[$i][$k] / $sumatoriaMembrecia), 2);//...construye oficialmente la matriz de mebrecia
                    $membershipMatrix[$i][$k] = ($auxMatrix[$i][$k] / $sumatoriaMembrecia);
                }
            }
            $sumatoriaCentroidesN = array();//para la definicion de nuevos centroides
            $sumatoriaCentroidesD = array();//para la definicion de nuevos centroides
            // $sumatoriaCentroides = array();//para la definicion de nuevos centroides
            for ($k=0; $k < $P; $k++)
            {
                $sumatoriaCentroidesN[$k]=array('x'=>0, 'y'=>0);
                $sumatoriaCentroidesD[$k]=0;
                // $sumatoriaCentroides[$k]=0;
                for ($i=0; $i < count($objects); $i++)
                {
                    $aux = $this->multiply_vectors($objects[$i], pow($membershipMatrix[$i][$k], $m));
                    // // die_pre($aux, __LINE__, __FILE__);
                    $sumatoriaCentroidesN[$k] = $this->add_vectors($sumatoriaCentroidesN[$k], $aux);
                    // // die_pre($sumatoriaCentroidesN[$k], __LINE__, __FILE__);
                    $sumatoriaCentroidesD[$k] += pow($membershipMatrix[$i][$k], $m);
                    // $sumatoriaCentroides[$k] += pow($membershipMatrix[$i][$k], $m);
                // }
                // $sumatoriaCentroidesN[$k]=array('x'=>1, 'y'=>1);
                // for ($i=0; $i < count($objects); $i++)
                // {

                }
                $rand_centroids[$k] = $this->multiply_vectors($sumatoriaCentroidesN[$k], (1/$sumatoriaCentroidesD[$k]));
            }
            echo '$iterate ='. ($iterate+1).'<br>';
            echo_pre($rand_centroids);
            $iterate += 1;
        }
        // echo_pre($rand_centroids);
        // echo_pre($sumatoriaCentroidesN);
        echo_pre($distanceMatrix);
        die_pre($membershipMatrix);


        // $fuzzyMatrix = array();//declaracion de arreglo de matriz de pertenencia
        // for ($i=0; $i < count($distanceMatrix); $i++)
        // {
        //     $fuzzyMatrix[$i] = array();//declaracion de arreglo de matriz de pertenencia
        //     for ($j=0; $j < count($rand_centroids); $j++)
        //     {
        //         $fuzzyMatrix[$i][$j] = ;
        //     }
        // }

    }
    public function d($pointA, $pointB)// = ||$pointA - $pointB|| ^ 2
    {
        // $X = $pointA['x'] - $pointB['x'];
        // $Y = $pointA['y'] - $pointB['y'];
        // $sum = sqr($X) + sqr($Y);
        // return ($sum);
        //para N dimensions
        $n = count($pointA);
        $sum = 0;
        foreach ($pointA as $key => $value)
        {
            if(is_numeric($value))
            {
                $aux = $pointA[$key] - $pointB[$key];
                $sum+= sqr($aux);
            }
        }
        return ($sum);
    }

    public function euclidean_distance($pointA, $pointB)// = ||$pointA - $pointB||
    {
        // $sqrX = $pointA['x'] - $pointB['x'];
        // $sqrY = $pointA['y'] - $pointB['y'];
        // $sqrt = sqr($sqrX) + sqr($sqrY);
        // return(sqrt($sqrt));
        $n = count($pointA);
        $sum = 0;
        foreach ($pointA as $key => $value)
        {
            if(is_numeric($value))
            {
                $aux = $pointA[$key] - $pointB[$key];
                $sum+= sqr($aux);
            }
        }
        $sqrt=sqrt($sum);
        return ($sqrt);
    }

    public function sqr($x)// X^2
    {
        return ($x * $x);
    }

    public function fake_distance()//delete this after done
    {

        $arrayName = array(array(2125.0, 2687.0), array(2314.0, 2876.0), array(2057.0, 2619.0), array(2054.0, 2616.0), array(2070.0, 2632.0), array(2962.0, 3524.0), array(2975.0, 3537.0), array(2933.0, 3495.0), array(3046.0, 3608.0), array(2471.0, 3033.0),array(2184.0, 2746.0), array(2230.0, 2792.0), array(2382.0, 2269.0), array(1707.0, 1555.0), array(993.0, 815.0), array(1454.0, 2016.0), array(1395.0, 1957.0), array(1208.0, 1770.0));
        // die_pre($arrayName);
        return($arrayName);
    }
    public function add_vectors($val1, $val2)//adds 2 n-dimentional vectors
    {
        if(is_array($val1))
        {
                    if(is_array($val2) && (count($val1)==count($val2)))
                    {
                        $result = array();
                        foreach ($val1 as $key => $value)
                        {
                            $result[$key] = $val1[$key] + $val2[$key];
                        }
                        return($result);
                    }
                    else
                    {
                        echo_pre($val1);
                        echo_pre($val2);
                        die_pre('error');
                    }
        }
        else
        {
            die_pre('error');
        }
    }

    public function multiply_vectors($val1, $val2)
    {
        // echo_pre($val1, __LINE__, __FILE__);
        // echo_pre($val2, __LINE__, __FILE__);
        if(is_array($val1))
        {
            if(is_array($val2) && (count($val1)==count($val2)))
            {
                $result = array();
                foreach ($val1 as $key => $value)
                {
                    $result[$key]=0;
                    foreach ($val2 as $key2 => $value2)
                    {
                        $result[$key] += $val1[$key] * $val2[$key2];
                    }
                }
                return($result);
            }
            else
            {
                $result = array();
                foreach ($val1 as $key => $value)
                {
                    // $result[$key] = round($val1[$key] * $val2, 2);
                    $result[$key] = $val1[$key] * $val2;
                }
                return($result);
            }
        }
        else
        {
            die_pre('error', __LINE__, __FILE__);
        }

    }
/////////////////////////////////////////////////Parte del motor inteligente
    public function datamining_DB()
    {
        if($this->session->userdata('user')['id_usuario']=='18781981')
        {
            // $this->model_alm_datamining->create_new_table();
            $this->model_alm_datamining->fill_table();
            // $this->model_alm_datamining->update_table();
        }
        else
        {
            redirect('inicio');
        }
    }
    public function reset()
    {
        $this->model_alm_datamining->delete_table();
    }

/////////////////////////////////////////////////FIN de Parte del motor inteligente

/////////////////////////////////////////////////for future query consultation in the system.
    public function query_normalization($query='')//para la expancion de la consulta (query)
    {
        // $this->load->helper('text');
        if($this->input->post('query'))
        {
            $query = $this->input->post('query');
        }
        if($query!='')
        {
            $tokens=preg_split("/[\s,]+/", $query);
            // $rule = 'NFD; [:Nonspacing Mark:] Remove; NFC';
            // $myTrans = Transliterator::create($rule);
            $query='';
            foreach ($tokens as $position => $word)
            {
                if($position!=0)
                {
                    $query.=' ';
                }
                $newWord='';
                ////primer paso: remover plurales, puntuaciones, caracteres especiales, y mayusculas
                $newWord = $this->stripText($word);//quito y cambio letras especiales
                $newWord = strtolower($newWord);//paso todas las letras a minusculas
                $query.=$newWord;//Borrable, esto es para mostrar el query resultante, 

                ////segundo paso: encontrar patrones de sub-terminos


                ////tercer paso: "herramienta de ubicacion de sinonimos", reemplaza los subterminos con sinonimos encontrados en el "corpus de sinonimo"
            }
        }

        echo($query);
        // echo phpversion();
    }

    public function stripText($word)
    {
        // $word = transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $word);
        // $word = preg_replace('/[-\s]+/', '-', $word);
        $bad = array(
            'À','à','Á','á','Â','â','Ã','ã','Ä','ä','Å','å','Ă','ă','Ą','ą',
            'Ć','ć','Č','č','Ç','ç',
            'Ď','ď','Đ','đ',
            'È','è','É','é','Ê','ê','Ë','ë','Ě','ě','Ę','ę',
            'Ğ','ğ',
            'Ì','ì','Í','í','Î','î','Ï','ï',
            'Ĺ','ĺ','Ľ','ľ','Ł','ł',
            'Ñ','ñ','Ň','ň','Ń','ń',
            'Ò','ò','Ó','ó','Ô','ô','Õ','õ','Ö','ö','Ø','ø','ő',
            'Ř','ř','Ŕ','ŕ',
            'Š','š','Ş','ş','Ś','ś',
            'Ť','ť','Ť','ť','Ţ','ţ',
            'Ù','ù','Ú','ú','Û','û','Ü','ü','Ů','ů',
            'Ÿ','ÿ','ý','Ý',
            'Ž','ž','Ź','ź','Ż','ż',
            'Þ','þ','Ð','ð','ß','Œ','œ','Æ','æ','µ',
            '”','“','‘','’',"'","\n","\r",'_','\\','"','\'');
        $good = array(
            'A','a','A','a','A','a','A','a','Ae','ae','A','a','A','a','A','a',
            'C','c','C','c','C','c',
            'D','d','D','d',
            'E','e','E','e','E','e','E','e','E','e','E','e',
            'G','g',
            'I','i','I','i','I','i','I','i',
            'L','l','L','l','L','l',
            'N','n','N','n','N','n',
            'O','o','O','o','O','o','O','o','Oe','oe','O','o','o',
            'R','r','R','r',
            'S','s','S','s','S','s',
            'T','t','T','t','T','t',
            'U','u','U','u','U','u','Ue','ue','U','u',
            'Y','y','Y','y',
            'Z','z','Z','z','Z','z',
            'TH','th','DH','dh','ss','OE','oe','AE','ae','u',
            '','','','','','','','','','','');
        $word = str_replace($bad, $good, $word);
        $word = utf8_decode($word);
        $word = htmlentities($word);
        $word = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/', '$1', $word);
        $word = html_entity_decode($word);
        $word = preg_replace("/^[^\w]*/", '', $word);
        return $word;
    }

    public function extract_excel($table='', $columns='')
    {
        if($table=='')
        {
            $table='alm_articulo';
            $this->db->join('alm_genera_hist_a', 'alm_genera_hist_a.id_articulo=alm_articulo.cod_articulo');
            $this->db->join('alm_historial_a', 'alm_historial_a.id_historial_a=alm_genera_hist_a.id_historial_a');
        }
        if($columns!='')
        {
            $select ='';
            foreach ($columns as $key => $value)
            {
                $select+=$value;
                if($key<count($columns)-1)
                {
                    $select+=', ';
                }
            }
            $this->db->select($select);
        }
        //load our new PHPExcel library
        $this->load->library('excel');
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($table);
 
        // get all table data in array formate
        $query = $this->db->get($table)->result_array();

        // Instantiate a new PHPExcel object
        // $objPHPExcel = new PHPExcel();
        $this->excel->setActiveSheetIndex(0);
        // Set the active Excel worksheet to sheet 0
        // $objPHPExcel->setActiveSheetIndex(0);
        //cell A1 value
        // $this->excel->getActiveSheet()->setCellValue('A1', $table);
        $this->excel->getActiveSheet()->setCellValue('A1', $table);
        // Initialise the Excel row number
        $rowCount = 0;
        // Iterate through each result from the SQL query in turn
        // We fetch each database result row into $row in turn
        $letterCol = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        while(count($query)!=0)
        { 
            // Set cell An to the "name" column from the database (assuming you have a column called name)
            //    where n is the Excel row number (ie cell A1 in the first row)
            $i=0;
            foreach ($query[$rowCount] as $key => $value)
            {
                if($rowCount==0)
                {
                    $this->excel->getActiveSheet()->SetCellValue($letterCol[$i].($rowCount+2), $key);
                }
                $this->excel->getActiveSheet()->SetCellValue($letterCol[$i].($rowCount+3), $value);
                $i++;
            }
            // $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['name']); 
            // Set cell Bn to the "age" column from the database (assuming you have a column called age)
            //    where n is the Excel row number (ie cell A1 in the first row)
            // $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['age']);
            //remove first query row
            unset($query[$rowCount]);
            // Increment the Excel row counter
            $rowCount++;
        }
        $filename='alm_articulos.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'HTML'); 
        $objWriter->writeAllSheets();
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function DQR()
    {
        $json='{
                "columns": [
                    [ "Name" ],
                    [ "Position" ],
                    [ "Office" ],
                    [ "Extn." ],
                    [ "Start date" ],
                    [ "Salary" ]
                ],
                "data": [
                [
                  "Tiger Nixon",
                  "System Architect",
                  "Edinburgh",
                  "5421",
                  "2011/04/25",
                  "$320,800"
                ],
                [
                  "Garrett Winters",
                  "Accountant",
                  "Tokyo",
                  "8422",
                  "2011/07/25",
                  "$170,750"
                ],
                [
                  "Ashton Cox",
                  "Junior Technical Author",
                  "San Francisco",
                  "1562",
                  "2009/01/12",
                  "$86,000"
                ],
                [
                  "Cedric Kelly",
                  "Senior Javascript Developer",
                  "Edinburgh",
                  "6224",
                  "2012/03/29",
                  "$433,060"
                ],
                [
                  "Airi Satou",
                  "Accountant",
                  "Tokyo",
                  "5407",
                  "2008/11/28",
                  "$162,700"
                ]
              ]
            }';
            echo($json);
    }
}