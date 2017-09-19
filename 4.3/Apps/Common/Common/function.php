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