<?php
namespace Home\Controller;
use Common\Common\CURDTools;
class AuthController extends BasicController {
	public function login() {

		session ( 'REQUEST_URI', null);
		layout ( false ); // 临时关闭当前模板的布局功能
        $agent=$_SERVER["HTTP_USER_AGENT"];
        $msg = I ( 'get.msg' );
        if(!strpos($agent,"Chrome"))
        {
            $this->assign("download",1);
        }
        $this->assign("msg",$msg);
		$this->display ( 'login' );
	}
	
	public function loginAct() {		
		$username = strtolower( trim(I('post.username')));
		$password = I ( 'post.password' );
        $captcha = I ( 'post.captcha' );
        $username = trim($username);

        if (empty ( $username ) || empty ( $password )) {
			echo json_encode(array("msg"=>message("请输入%1!","用户名和密码","")));
			die;
		}
		
		$user = M ( "user" )->where ( "code='$username'" )->find ();
		if (empty ( $user )) {
			echo json_encode(array("msg"=>message("%1不存在","用户","")));
// 			$this->api_login($username, "fail", "用户不存在");
			die;
		}
        if ($user ['errpwd_count'] >= 10) {
            echo json_encode(array("msg"=>message("%1, 密码错误次数超限!","用户被锁定","")));
// 			$this->api_login($username, "fail", "用户不存在");
            die;
        }

		if ($user ['password'] != md5 ( $password )) {

            $data = array ();
            $data ['errpwd_count'] = $data ['errpwd_count']+1;
            $User = M ( 'user' );
            $User->where('id='.$user['id'])->save($data);

            echo json_encode(array("msg"=>message("%1错误，累计次数超限将被锁定!","密码","")));
			die;
		}	

		if ($user ['status'] != 1) {
			echo json_encode(array("msg"=>message("%1","您的帐户已被禁用!","")));
			die;
		}

//		if(trim(strtolower($username)) =="admin"){
//            $user ['side']=1;
//        }

        switch ($user ['side']) {
            case 1:
                break;
            case 2:
                if (!$user ['org_id']) {
                    echo json_encode(array("msg" => message("%1", "您的账户所属机构不存在或已被禁用!", "")));
                    die;
                }
                $org = M("org")->where("id=" . $user ['org_id'] . " and status=1")->find();
                if (!$org) {
                    echo json_encode(array("msg" => message("%1", "您的账户所属机构不存在或已被禁用!", "")));
                    die;
                }
                break;
            case 3:
                if (!$user ['customer_id']) {
                    echo json_encode(array("msg" => message("%1", "您的账户所属客户不存在或已被禁用!", "")));
                    die;
                }
                $cust = M("customer")->where("id=" . $user ['customer_id'] . " and status=1")->find();
                if (!$cust) {
                    echo json_encode(array("msg" => message("%1", "您的账户所属客户不存在或已被禁用!", "")));
                    die;
                }
                break;
            default:
                echo json_encode(array("msg" => message("%1属性无法判断", "用户", "")));
                die;
                break;
        }

		session ( C ( 'USER_AUTH_KEY' ), $user ['code'] );
        session ( 'USER_ID' , $user ['id'] );
        session ( C ( 'ADMIN_AUTH_KEY' ), $user ['superadmin'] );
        $time=time();
        S (  'USER_AUTH_TIME_'.$user ['code'] , $time );
        S (  'USER_AUTH_TOKEN_'.$user ['code'] , md5($user ['code'].$time) );

		$data = array ();
		//$data["session_id"]=session_id();
        $user['side'] = $user['side'] == null ? 0:$user['side'];
        $user['org_id'] = $user['org_id'] == null ? 0:$user['org_id'];
        $user['customer_id'] = $user['customer_id'] == null ? 0:$user['customer_id'];
        $data["session_id"]= MD5($user['side']."|".$user['org_id']."|".$user['customer_id']);
        $data ['errpwd_count'] = 0;
		$User = M ( 'user' );
		$User->where('id='.$user['id'])->save($data); 
		
		$REQUEST_URI = session ( 'REQUEST_URI' );
		
		//$REQUEST_URI="";
		if (! empty ( $REQUEST_URI ) && $REQUEST_URI != "") {
            $url=$REQUEST_URI;
		} else {
            $url=U("/Home/Index/index");
		}
        $this->ajaxResult("", "","login_redirect","'$url'");


	}
	
	public function logout() {
		layout ( false );
		session (C('USER_AUTH_KEY'), null);
		session ( 'usercode', null );
        session ( 'CUSTOMER_ID', null );
		session ( 'REQUEST_URI', null);
		session (null);
	
		$this->redirect('login');
	}

    public function verify_captcha(){
        $Verify = new \Think\Verify();
        $Verify->fontSize = 16;
        $Verify->useNoise = false;
        $Verify->length   = 4;
        $Verify->imageW = 107;
        $Verify->imageH = 40;
        //$Verify->expire = 600;
        $Verify->entry();
    }

    function check_captcha($code){
        $verify = new \Think\Verify();
        return $verify->check($code);
    }

}