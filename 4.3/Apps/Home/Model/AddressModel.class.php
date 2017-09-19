<?php
namespace Home\Model;

use  Think\Model;

class AddressModel extends Model
{

	protected $_validate = array(
							array('username','require','收件人姓名不能为空！'),
							array('address','require','详细地址不能为空！'),
							array('mobile','/^1([23578])\d{9}$/','手机号码格式不正确！'),
							);

}