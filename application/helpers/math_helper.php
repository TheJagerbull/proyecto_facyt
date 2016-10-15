<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sqr($x)
{
	return($x*$x);
}
function add_vectors($vec1, $vec2)
{
	if(is_array($vec1))
    {
                if(is_array($vec2) && (count($vec1)==count($vec2)))
                {
                    $result = array();
                    foreach ($vec1 as $key => $value)
                    {
                    	if(is_numeric($vec1[$key])&& is_numeric($vec2[$key]))
                    	{
                        	$result[$key] = $vec1[$key] + $vec2[$key];
                        }
                        else
                        {
                        	$result[$key]=0;
                        }
                    }
                    return($result);
                }
                else
                {
                    print_r('error al sumar:');
                    print_r($vec1);
                    print_r($vec2);
                }
    }
    else
    {
        print_r('error al sumar:');
        print_r($vec1);
        print_r($vec2);
    }
}