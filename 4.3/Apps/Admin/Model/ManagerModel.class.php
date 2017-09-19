<?php
namespace Admin\Model;

use Think\Model;

class ManagerModel extends Model
{
    public function user($username,$pwd)
    {
        $data = $this -> where(array('username' => $username)) -> find();

        if(isset($data))
        {
            if($a = crypt($pwd,$data['pwd'])==$data['pwd'])
            {

                $save['id'] = $data['id'];
                $save['endtime'] = time();
                $this -> save($save);
                return $data;
            }
            else
            {
                return null;
            }
        }
        else
        {
            return null;
        }
    }
}