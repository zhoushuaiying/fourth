<?php
namespace Home\Controller;



class NewsController extends CommonController
{
	public  function  news()
    {

        //获取页码
        $p   = !empty(I('p')) ? I('p') : 1;
        $pageNum  = 4;

        $news = M('news');
        //页码(跳转地址，表名，当前页数,每页显示多少条,显示多少页，查询条件)
        $page['page'] = pg('/Home/News/news','news',$p,$pageNum,3,'','','','news_id desc');

        $page['list'] = $news -> page($p,$pageNum)
            -> order('news_id desc')
            ->select();

        foreach ($page['list'] as $k => $v)
        {
            $page['list'][$k]['title'] = mb_substr($v['title'],0,28,'utf-8');
            $page['list'][$k]['content'] = htmlspecialchars_decode($v['content']);
            $page['list'][$k]['content'] = strip_tags($page['list'][$k]['content']);
            $page['list'][$k]['content'] = mb_substr($page['list'][$k]['content'],0,100,'utf-8').'.....';
        }




//        dump($page);exit;
        $this -> assign('data',$page);
        $this -> display();
//		}
    }


    public function  news_detail()
    {
        $news    = M('news');
        $news_id = I('id');

        $detail = $news -> where(['news_id' => $news_id]) -> find();

        if(empty($detail))
        {
            $detail = $news -> order('addtime desc') -> find();
        }

        $detail['content'] = htmlspecialchars_decode($detail['content']);

        $prev_id = $news_id + 1;
        $next_id = $news_id - 1;
        $prev    = $news -> field('news_id,title') -> where(['news_id' => $prev_id]) -> find();
        $next    = $news -> field('news_id,title') -> where(['news_id' => $next_id]) -> find();
        if(!empty($prev))
        {
            $prev['title'] = mb_substr($prev['title'],0,32,'utf-8');
        }
        if(!empty($next))
        {
            $next['title'] = mb_substr($next['title'],0,32,'utf-8');
        }
        $this -> assign('detail',$detail);
        $this -> assign('prev',$prev);
        $this -> assign('next',$next);
        $this -> display();
    }
}