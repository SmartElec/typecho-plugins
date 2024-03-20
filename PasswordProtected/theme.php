<?php
use Typecho\Cookie;

$setting=Helper::options()->plugin('PasswordProtected');//获取插件设置
$passworda=md5($setting->password);//获取设置的密码
$passwordb = Cookie::get('PasswordProtected');//获取用户已输入的密码

$notice='';//提示文字
$code=0;//状态码，0为需要密码，1为密码正确或本次免密码

if(!empty($passwordb)&&$passworda==$passwordb){//如果cookie中有密码并且正确，code赋值1
    $code=1;
}
elseif(!empty($_POST['password'])){//用户输入密码
   $password = md5($_POST['password']);//获取用户输入的密码
   if($passworda==$password){//密码正确code赋值1,并将密码存入cookie
       $code=1;
       Cookie::set('PasswordProtected', $password, 3600*24*7);//密码存入cookie，一周内有效
   }else{
       $notice='密码错误，请重新输入！';//密码错误提示
   }
}

if($code==0){//如果code为0则显示密码输入界面
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN" class="h-full">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php Helper::options()->title(); ?></title>
<meta name='robots' content='max-image-preview:large, noindex, follow' />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" href="<?php Helper::options()->pluginUrl('/PasswordProtected/style.css?2024'); ?>">
</head>
<body class="h-full bg-blue-50" style="padding-top:10%">
    
<div class="bg-white rounded-lg shdow-lg p-5 w-80 max-w-full mx-auto">
    <form method="post">
<div>
    <label for="password" class="block text-sm text-gray-500">请输入访问密码</label>

    <input name="password" type="text" placeholder="密码" class="block mt-3 w-full placeholder-gray-400/70 rounded-lg border border-red-400 bg-white px-5 py-2 text-gray-700 focus:border-red-400 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-40">
    <p class="mt-3 text-xs text-red-400"><?php echo $notice; ?></p>
    <div class="mt-3">
    <button class="w-full px-2 py-2 text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 hover:bg-blue-600">
                    提交
                </button>
    </div>
</div>
    </form>
</div>
    
</body>
</html>
<?php
exit;
    
}
?>