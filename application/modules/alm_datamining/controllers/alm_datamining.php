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

            $this->fcm2();

        // }

    }

    public function fcm2()
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
        $rand_centroids = array(array('x' => 6.00, 'y' => 1379.00),
                                array('x' => 5.00, 'y' => 817.00));//se elijen de forma aleatoria
        // $rand_centroids = array(array('x' => 14.298538741182, 'y' => 2760.5969177144),
        //                         array('x' => 9.9986937825316, 'y' => 3835.5030603179));//se elijen de forma aleatoria
        $iterate = 0;
        while ($iterate < 1)
        {
            // $distanceMatrix = array();//declaracion de areglo de matriz de distancias
            $membershipMatrix = array();
            $auxMatrix = array();
            
            $distanceMatrix = $this->fake_distance();
            for ($i=0; $i < count($objects); $i++)
            {
                // $distanceMatrix[$i] = array();//declaracion de areglo de matriz de distancias
                $membershipMatrix[$i] = array();
                $auxMatrix[$i] = array();
                $sumatoriaMembrecia = 0;
                for ($j=0; $j < $P; $j++)//aqui recorre los centroides para...
                {
                    // $distanceMatrix[$i][$j] = round($this->euclidean_distance($objects[$i], $rand_centroids[$j]), 2);//...construir la matriz de distancia euclideana
                    // $distanceMatrix[$i][$j] = $this->euclidean_distance($objects[$i], $rand_centroids[$j]);
                    // if($distanceMatrix[$i][$j]==0)
                    // {
                    //     $distanceMatrix[$i][$j] = 0.00001;
                    // }
                    // die_pre($distanceMatrix[$i][$j]);
                    $aux = (1/$distanceMatrix[$i][$j]);

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

    public function fake_distance()
    {

        $arrayName = array(array(2125.0, 2687.0), array(2314.0, 2876.0), array(2057.0, 2619.0), array(2054.0, 2616.0), array(2070.0, 2632.0), array(2962.0, 3524.0), array(2975.0, 3537.0), array(2933.0, 3495.0), array(3046.0, 3608.0), array(2471.0, 3033.0),array(2184.0, 2746.0), array(2230.0, 2792.0), array(2382.0, 2269.0), array(1707.0, 1555.0), array(993.0, 815.0), array(1454.0, 2016.0), array(1395.0, 1957.0), array(1208.0, 1770.0));
        // die_pre($arrayName);
        return($arrayName);
    }
    public function add_vectors($val1, $val2)
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
            die_pre('error');
        }

    }
}