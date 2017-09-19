<?php
namespace Admin\Controller;


class ConfigController extends CommonController
{
    public function showlist()
    {
        if(IS_AJAX)
        {

//            $this -> ajaxReturn(I('post.'));exit;
            $info   = ['code' => 0,'error' => false,'info' => ''];
            $data = I('post.');
            $config = M('config');

//            dump($data);exit;

            if(!empty($data['id']))
            {
                $data['time'] = time();
                $res = $config -> save($data);
                if($res > 0)
                {
                    $info['code'] = 1;
                    $info['error']= true;
                    $info['info'] = '配置更新成功!';
                    $this -> ajaxReturn($info);

                }
                else
                {
                   $info['info'] = '配置更新失败!';
                   $this -> ajaxReturn($info);
                }
            }
            else
            {
                $data['time'] = time();
                $res = $config -> add($data);
                if($res > 0)
                {
                    $info['code'] = 1;
                    $info['error']= true;
                    $info['info'] = '配置添加成功!';
                    $this -> ajaxReturn($info);
                }
                else
                {
                    $info['info'] = '配置添加失败!';
                    $this -> ajaxReturn($info);
                }
            }

//            dump($info);

        }
        else
        {
            $config = M('config');
            $data   = $config -> find();
            $this -> assign('data',$data);
            $this -> display();
        }
    }



    public function uploader()
    {
        $path = $this -> get_upload();

        if($path['code'] == 1)
        {
            $info = [
                     'code' => 1,
                     'info' => $path['info'],
                    ];

        }
        else
        {
            $info = [
                     'code' => 0,
                     'info' => null,
                    ];
        }
        die(json_encode($info));
    }

    protected function get_upload()
    {
        $path = './Public/Admin/banner/';
        if(!file_exists($path))
        {
            mkdir($path,0777,true);
            $path=rtrim($path,'/').'/';
        }
        $config = array(
            //限制文件上传大小
            'maxSize'  => 3145728,
            //设置保存目录
            'rootPath' => $path,
            //设置上传文件的保存名称
            'saveName' => array('uniqid',''),
            //设置上传图片大格式
            'exts'     => array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub'  => true,
            'subName'  => array('date','Ymd'),
        );

        $upload = new \Think\Upload($config);// 实例化上传类
        $info = $upload -> upload();
        $inf=['code' => 0,'info' => ''];
        if(!$info)
        {
            $inf['info'] = $upload -> getError();
            return $inf;
        }
        else
        {
            $result = [];
            foreach($info as $val)
            {

                $result[]=ltrim($path.$val['savepath'].$val['savename'],'.');
            }

            $inf['code'] = 1;
            $inf['info'] = $result;

            return  $inf;
        }
    }
}