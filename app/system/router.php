<?php 
namespace coding\app\system;

use coding\app\controllers\CustomPagesController;

class Router{

    public $request;
    public $response;
    public function __construct($request)
    {
        $this->request=$request;
        
    }



    protected  static $routes=array(); 

    public static function get($url,$callback){
        self::$routes['GET'][$url]=$callback;



    }
    public static function post($url,$callback){
        self::$routes['POST'][$url]=$callback;


    }
    public function put(){

    }
    public function delete(){

    }


   
    function resolveRoute(){
        $route_parameters=array();
        $route=$this->request->getRoute();
        $method=$this->request->getRequestMethod();
      
       if(in_array($route,array_keys(self::$routes[$method])))
       return array(self::$routes[$method][$route],$route_parameters);
       
       foreach(self::$routes[$method] as $key=>$value){
            //print($key)."<br>" ;
            //print_r($value);
            $paramsCount=preg_match_all('/{(.*?)}/', $key,$params);
            
            if($paramsCount>0){
                //print($params[1][1]) ;
                
                $route_parts=explode('/', $route);
                //print_r($route_parts);
               $route_path="";
               $values=array();
               //print (sizeof($route_parts)) ;
               for($i=0;$i<sizeof($route_parts);$i++){
                if($i<sizeof($route_parts)-$paramsCount){
                    //print($route_parts[$i]."/") ;
                 $route_path.=$route_parts[$i]."/";
                }
                else{
                    //print($route_parts[$i]."/") ;
                 $values[]=$route_parts[$i];
                }
             }
             //print ($route_path);
             //print ($params[1]);
             //print_r($values);

             if($route_path.implode('/',$params[0])!=$key)
             //print_r($values); //                        continue;   

             $route_parameters=array_combine($params[1],$values);
              //print_r( $route_parameters);
              //print_r($value);
             return array($value,$route_parameters);
             
              

        }

    }
}

   


    public  function executeRoute(){
        $routsResolved=$this->resolveRoute();

        $routsResolved[0][1] = "create";
        print_r($routsResolved[0][1]);
        $callback=$routsResolved[0]?? null;
       // print_r( $callback) ;
        $parameters=$routsResolved[1]??null;
        //$parameters = 'create';
            if(isset($callback) && $callback!=null)
            {
                if(is_array($callback))
                {
                    //print_r( $callback[0]) ;
                    //print("<br>");
                    $callback[0]=new $callback[0];
                   // print_r( $parameters) ;
                }

                call_user_func($callback,$parameters);
            }
            else {
                $error=new CustomPagesController();
                call_user_func([$error,'notFound']);
                
            }


    }

    public function view($v,$params){

        require_once __DIR__."/../views/$v.php";

    }
 

}
