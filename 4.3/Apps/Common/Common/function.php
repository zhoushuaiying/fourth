<?php
//页码(跳转地址，表名，当前页数,每页显示多少条,显示多少页，排序查询条件,当前分类)
 function pg($url,$table,$p,$how,$size='3',$where='',$c_name="",$c = "",$order='goods_id desc')
        {
            $count = M($table) -> where($where)-> field('count(*) as a')
//                -> order($order)
                -> find();
            $start = '';
			$end   = '';
			$step = floor($size/2)+1;
			$more = 0;
            $pg_all = ceil($count['a'] / $how);

			$size = ($pg_all < $size) ? $pg_all : $size;

			$pg = '';
			if($p == 1)
			{
				$pg .="<li class='current'>"."<span>首页</span>"."</li>";
			}
			else
			{
			    if(empty($c))
                {
                    $pg .="<li>"."<a href='".$url."/p/1'>首页</a>"."</li>";
                }
                else
                {
                    $pg .="<li>"."<a href='".$url."/p/1/$c_name/".$c."'>首页</a>"."</li>";
                }
			}
            
			

			
			if($pg_all < $size )
			{
				$start = 2;
				$end   = $pg_all-1;
                $more = 1;
			}
            elseif($p <= $step && $p >= $pg_all - $size + 1)
            {
                $start = 2;
                $more = 1;
				// echo 2;
    //            exit;
            }
            elseif($p <= $step && $p <= $pg_all - $size + 1)
            {
                $start = 2;
               
				// echo 3;
    //            exit;
            }

			elseif($p > $step && $p + $step -1< $pg_all )
			{
				$start = $p - $step +1;
				
               // echo 4;exit;
			}
			elseif($p >= $pg_all - $size + 1)
			{
				$start = $pg_all-$size+1;
				$more   = 1;
//                echo 4;exit;
			}



			for ($i = $start; $i < $start + $size; $i++) {
				
				if($p == $i)
				{	
					
					$pg .="<li class='current'><span>$i</span></li>";
				}
				else
				{
                    if(empty($c))
                    {
                        $pg .="<li ><a href='".$url."/p/{$i}'>$i</a></li>";

                    }
                    else
                    {
                        $pg .="<li ><a href='".$url."/p/{$i}/$c_name/{$c}'>$i</a></li>";

                    }
				}
			}



			if($more == 0)
			{
				$pg .="<li ><a>...</a></li>";
			}
			
			if($p == $pg_all)
			{
				$pg .= "<li class='current'><span>末页</span></li>";
			}
			else
			{
			    if(empty($c))
                {
                    $pg .= "<li><a href='".$url."/p/{$pg_all}'>末页</a></li>";
                }
                else
                {
                    $pg .= "<li><a href='".$url."/p/{$pg_all}/$c_name/{$c}'>末页</a></li>";
                }
			}

            return $pg;
        }


//提示信息
function msg($message,$url='',$time=3)
{
    // 如果$url为空，则给url赋值为来源页面
    if(empty($url)){
        $url = $_SERVER['HTTP_REFERER'];
    }

    $html = <<<EOT
            <div style="width:500px;height:200px;background:white;border:#ccc solid 1px;position:fixed;top:50%;left:50%;margin-left:-250px;margin-top:-100px;z-index:999;">
                <div style="height:45px;line-height:45px;text-align:center;background:white;border-bottom:solid 1px #ccc;font-size:16px;">提示信息</div>
                <div style="padding:20px;position:relative;height:112px;">
                    {$message}
                    <div style="position:absolute;bottom:0px;height:50px;line-height:50px;text-align:center;width:100%;">
                        <span id="timer">{$time}</span>秒后自动跳转 <a href="{$url}">立即跳转</a>
                    </div>
                </div>
            </div>
            <script>
                window.onload = function(){
                    var t = document.getElementById('timer');
                    //
                    timer = t.innerHTML;
                    
                    // 计时器
                    tInt = setInterval(function(){
                        timer--;
                        t.innerHTML = timer;
                        if(timer <= 0) {
                            clearInterval(tInt);
                            window.location.href = '{$url}';
                        }
                        
                    },1000);				
                }
            </script>
EOT;

    die($html);
}





//保存微信服务器推送给我们服务器的数据
    function save_Xml($xml)
    {
        
        if(!empty($xml))
        {   
            $re = M('xml_data') -> add(array('xml' => $xml));
           
        }  
    }
    
    //保存微信服务器产生大错误信息
    
    function writeLog($errcode,$errmsg)
    {
        M('eror_log') -> add(array('errcode' => $errcode,'errmsg' => $errmsg,'createtime' => time()));
        
    }
    
    //get请求

    function getRequest($str_apiurl,$arr_param=array(),$str_returnType='array'){
        if(!$str_apiurl){
            exit('request url is empty 请求地址不正确');
        }

        //url拼装
        if(is_array($arr_param) && count($arr_param)>0){
            $tmp_param = http_build_query($arr_param);
            if(strpos($str_apiurl, '?') !== false){
                $str_apiurl .= "&".$tmp_param;
            }else{
                $str_apiurl .= "?" . $tmp_param;
            }
        }elseif (is_string($arr_param)){
            if(strpos($str_apiurl, '?') !== false){
                $str_apiurl .= "&".$arr_param;
            }else{
                $str_apiurl .= "?" . $arr_param;
            }
        }

        //请求头
        $this_header = array(
            "content-type: application/x-www-form-urlencoded; charset=UTF-8"
        );

        $ch = curl_init();  //初始curl
        curl_setopt($ch,CURLOPT_URL,$str_apiurl);   //需要获取的 URL 地址
        curl_setopt($ch,CURLOPT_HEADER,0);          //启用时会将头文件的信息作为数据流输出, 此处禁止输出头信息
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  //获取的信息以字符串返回，而不是直接输出

        //规避证书验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,30); //连接超时时间
        curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);  //头信息
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); 
        $res = curl_exec($ch);                      //执行curl请求
        $response_code = curl_getinfo($ch);
        if(curl_errno($ch)){
            echo 'Curl error: ' . curl_error($ch)."<br>";
            //echo $res;
            var_dump($response_code);
        }

        //请求成功
        if($response_code['http_code'] == 200){
            if($str_returnType == 'array'){
                //echo $res;
                return json_decode($res,true);
            }else{
                return $res;
            }
        }else{
            $code = $response_code['http_code'];
            switch ($code) {
                case '404':
                    exit('请求的页面不存在');
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }
    
    // post请求
    
    function postRequest($str_apiurl,$arr_param=array(),$str_returnType='array'){
        if(!$str_apiurl){
            exit('request url is empty 请求地址不正确'); 
        }


        $ch = curl_init();  //初始curl

        

        
        curl_setopt($ch,CURLOPT_URL,$str_apiurl);   //需要获取的 URL 地址
        curl_setopt($ch,CURLOPT_HEADER,0);          //启用时会将头文件的信息作为数据流输出, 此处禁止输出头信息
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  //获取的信息以字符串返回，而不是直接输出
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,30); //连接超时时间
        //curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);  //头信息
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip'); 
        curl_setopt($ch, CURLOPT_POST, 1);          //post请求
        //curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false); //  PHP 5.6.0 后必须开启
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr_param);
        $res = curl_exec($ch);                      //执行curl请求
        $response_code = curl_getinfo($ch);

        //请求出错
        if(curl_errno($ch)){
            echo 'Curl error: ' . curl_error($ch)."<br>";
            //echo $res;
            var_dump($response_code);
        }

        //请求成功
        if($response_code['http_code'] == 200){
            if($str_returnType == 'array'){
                return json_decode($res,true);
            }else{
                return $res;
            }
        }else{
            $code = $response_code['http_code'];
            switch ($code) {
                case '404':
                    exit('请求的页面不存在');
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }

    function cutImage($path,$arr=array())
    {

        $image = new \Think\Image();
        $image->open($path);
        
        
        $savepath = './Public/Weixin/cut_image/';
        if(!file_exists($savepath))
        {
            mkdir($savepath,0777,true);
            $savepath=rtrim($savepath,'/').'/';
        }
        $saveName=$savepath.date('YmdHis').mt_rand(99,999).'.jpg';

        $image->crop($arr['width'],$arr['height'],$arr['left'], $arr['top'])->save("$saveName");
        return $saveName;
    }