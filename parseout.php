<?php
$tplContent = <<<EOT
{
  "name": "",
  "avatar": ""
}
EOT;

//单条数据
$user  = array('id'=>1,'name' => 'david','pass' => '123456','phone'=>'13888888888','avatar' => 'http://spetacular.github.io/images/favicon.ico');

echo JSONOut::toJSON($user,$tplContent,false);

echo "\n";

//多条数据
$users  = [array('id'=>1,'name' => 'david','pass' => '123456','phone'=>'13888888888','avatar' => 'http://spetacular.github.io/images/favicon.ico'),
array('id'=>2,'name' => 'john','pass' => '654321','phone'=>'13888888889','avatar' => 'http://spetacular.github.io/images/favicon.png')];

echo JSONOut::toJSON($users,$tplContent,true);

class JSONOut
{
	
	/**
	*按照JSON模板输出JSON数据
	*@param data 源数据
	*@param tplContent JSON模板内容
	*@param multi 是否为多条内容，默认单条
	*@return string
	*/
	public static function toJSON($data, $tplContent,$multi = false){
        if(empty($data)){
            return array();
        }
     
        $tplData = json_decode($tplContent,true);
        if(!$tplData){
            return false;
        }

        $array = array();
        if (!$multi) {
            // 一维数组
            $array = self::array_intersect_key_recursive($data,$tplData);
        } else {
            // 多维数组
            foreach($data as $key => $value){
                $array[$key] = self::array_intersect_key_recursive($value,$tplData);
            }
        }

        return json_encode($array);
    }


    private static function array_intersect_key_recursive(array $array1, array $array2) {
        $array1 = array_intersect_key($array1, $array2);

        foreach ($array1 as $key => &$value) {
            if (is_array($value) && is_array($array2[$key])) {
                $value = $this->array_intersect_key_recursive($value, $array2[$key]);
            }
        }
        return $array1;
    }
}

?>
