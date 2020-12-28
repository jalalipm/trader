برای بازیابی کلمه عبور بر روی لینک زیر کلیک کنید
<br>
<a href="{{$link = url('password/reset',$token).'?email='.urlencode($user->getEmailForPasswordReset())}}">{{$link}}</a>