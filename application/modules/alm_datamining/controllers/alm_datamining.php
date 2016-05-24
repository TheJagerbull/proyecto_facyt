<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alm_datamining extends MX_Controller
{
	function __construct() //constructor predeterminado del controlador
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('model_alm_datamining');
    }
    //la egne &ntilde;
    //acento &acute;
    public function index()
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

    public function fcm()
    {
        /*U se compone de $distanceMatrix*/
        echo "<h1> Ejemplo de cluster difuzzo de C-medias: </h1> <br></br>";
        echo "<h3> Fuzzy C-Means:</h3><br>";
        $m=1.25;//parametro de fuzzificacion
        $P=2;//numero de clusters
        // $e=;//tolerancia de culminacion
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
                        array('x' => 16.0, 'y' => 2587.0));
        echo_pre($objects);
        $rand_centroids = array(array('x' => 6.00, 'y' => 1379.00),
                                array('x' => 5.00, 'y' => 817.00));//se elijen de forma aleatoria
        $distanceMatrix = array();//declaracion de areglo de matriz de distancias
        $membershipMatrix = array();
        $auxMatrix = array();
        
        $sumatoriaCentroidesN = array();//para la definicion de nuevos centroides
        $sumatoriaCentroidesD = array();//para la definicion de nuevos centroides
        for ($i=0; $i < count($objects); $i++)
        {
            $distanceMatrix[$i] = array();//declaracion de areglo de matriz de distancias
            $membershipMatrix[$i] = array();
            $auxMatrix[$i] = array();
            $sumatoriaMembrecia = 0;
            for ($j=0; $j < $P; $j++)//aqui recorre los centroides para...
            {
                $distanceMatrix[$i][$j] = round($this->euclidean_distance($objects[$i], $rand_centroids[$j]), 3);//...construir la matriz de distancia euclideana

                $aux = (1/$distanceMatrix[$i][$j]);
                $aux2 = (1/($m-1));
                $auxMatrix[$i][$j] = pow($aux, $aux2);//...construyo (parcialmente) la matriz de membrecia
                $sumatoriaMembrecia += $auxMatrix[$i][$j];
            }
            for ($k=0; $k < $P; $k++)//recorre los centroides nuevamente para...
            {
                $membershipMatrix[$i][$k] = round(($auxMatrix[$i][$k] / $sumatoriaMembrecia), 2);//...construye oficialmente la matriz de mebrecia
            }
        }

        for ($k=0; $k < $P; $k++)
        {
            for ($i=0; $i < count($objects); $i++)
            {
                $sumatoriaCentroidesN[$k] = pow($membershipMatrix[$i][$k], $m);
            }
        }
        echo_pre($sumatoriaCentroidesN);
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

    public function euclidean_distance($pointA, $pointB)
    {
        $sqrX = $pointA['x'] - $pointB['x'];
        $sqrY = $pointA['y'] - $pointB['y'];
        $sqrt = $this->sqr($sqrX) + $this->sqr($sqrY);
        return(sqrt($sqrt));
    }

    public function sqr($x)
    {
        return ($x * $x);
    }

    public function multiply_vectors($val1, $val2)
    {
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
                    $result[$key] = $val1[$key] * $val2;
                }
                return($result);
            }
        }
        else
        {
            die_pre('error');
        }

    }
}