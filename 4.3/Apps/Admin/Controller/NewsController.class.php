<?php
namespace Admin\Controller;



class NewsController extends CommonController
{
    public function showlist()
    {

        $news_title = trim(I('news_title'));
        $news = M('news as a');
        $map['title|content'] = array('like','%'.$news_title.'%');
        $count = $news->where($map) -> order('news_id desc')->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->parameter = ['news_title'=>$news_title];

        $Page->setConfig('header', '<span class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%HEADER%&nbsp;&nbsp;&nbsp;%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%');
        $Page->lastSuffix = false;//最后一页不显示为总页数
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $news-> where($map) -> field('news_id,title,content,pic,addtime')
                    -> order('news_id desc')
                   ->limit($Page->firstRow.','.$Page->listRows)->select();

        foreach ($list as $k => $v)
        {
            $list[$k]['title'] = mb_substr($v['title'],0,10,'utf-8');
            $list[$k]['content'] = htmlspecialchars_decode($v['content']);
            $list[$k]['content'] = strip_tags($list[$k]['content']);
            $list[$k]['content'] = mb_substr($list[$k]['content'],0,20,'utf-8').'......';
        }

        $this -> assign('count',$count); //数据数量
        $this -> assign('data',$list);// 赋值数据集
        $this -> assign('page',$show);// 赋值分页输出
        $this -> display(); // 输出模板
    }

    public function append()
    {
        if(IS_AJAX)
        {
            $info =['code' => 0,'error' => false,'info' => ''];
            $news = M('news');
            $rule = array(
                array('title','require','标题不能为空'),
                array('pic','require','主图不能为空'),
                array('content','require','新闻内容不能为空'),

            );
            if($news -> validate($rule) -> create())
            {
                $news -> addtime = time();
                $row = $news -> add();
                if($row > 0)
                {
                    $info['code'] = 1;
                    $info['error']= true;
                    $info['info'] = '添加新闻成功!';
                    $this -> ajaxReturn($info);
                }
                else
                {
                    $info['info'] = '添加新闻失败!';
                    $this -> ajaxReturn($info);
                }
            }
            else
            {
                $info['info'] = $news -> getError();
                if(empty($info['info']))
                {
                    $info['info'] = '创建数据失败!';
                }
                $this -> ajaxReturn($info);
            }
            $this -> ajaxReturn(I('post.'));

        }
        else
        {
            $this -> display();

        }

    }

    public function edit()
    {
        if(IS_AJAX)
        {
            $info =['code' => 0,'error' => false,'info' => ''];
            $news = M('news');
            $rule = array(
                array('title','require','标题不能为空'),
                array('pic','require','主图不能为空'),
                array('content','require','新闻内容不能为空'),

            );
            if($news -> validate($rule)-> create())
            {
                $news -> updatetime = time();
                $row  =  $news -> save();
                if($row > 0)
                {
                    $info['code'] = 1;
                    $info['error']= true;
                    $info['info'] = '编辑新闻成功!';
                    $this -> ajaxReturn($info);
                }
                else
                {
                    $info['info'] = '编辑新闻失败!';
                    $this -> ajaxReturn($info);
                }
            }
            else
            {
                $info['info'] = $news -> getError();
                if(empty($info['info']))
                {
                    $info['info'] = '创建数据失败!';
                }
                $this -> ajaxReturn($info);
            }
        }
        else
        {
            $news = M('news');
            $data = $news -> find(I('id'));
            $data['content'] = htmlspecialchars_decode($data['content']);
            $this -> assign('data',$data);
            $this -> display();

        }

    }

    public function del()
    {
        if(is_array(I('news_id')))
        {
            $select = implode(',',I('news_id'));

        }
        else
        {
            $select = I('news_id');

        }
        // file_put_contents('del.txt',$select);
        $news = M('news');
        $result  = $news -> delete($select);
        $info    = ['code' => 0,'error' =>  false,'info' => ''];
        if($result)
        {
            $info['code'] = 1;
            $info['error']=true;
            $info['info'] ='删除成功';

            $this -> ajaxReturn($info);
        }
        else
        {
            $info['info'] = '删除失败';

            $this -> ajaxReturn($info);
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
        $path = './Public/Admin/news/';
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