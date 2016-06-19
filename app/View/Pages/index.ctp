<content>
    <a class="no-underbar color-black" href="/"><h1 class="color-black" style="margin:0 auto; text-align:center; width:60%; height:35%; font-size:80px; padding-top:15%;">Memoria</h1></a>
    <ul class="list-none" style="text-align:center; margin:0 auto;">
        <?php if ($this->name == "Pages" && $this->action == "index") : ?>
        <?php if ($auth->loggedIn()) : ?>
        <li style="float:left; width:10% ;height:15%; text-align:center; padding-left: 39%; font-size:20px;"><a class="no-underbar color-black" href="/users/mypage/<?php echo $auth->user('id'); ?>">マイページ</a></li>
        <li style="float:left; width: 10%; height:15%; text-align:center; font-size:20px;"><a class="no-underbar color-black" href="/users/logout">ログアウト</a></li>
        <?php else : ?>
        <li style="float:left; width:10% ;height:15%; text-align:center; padding-left: 39%; font-size:20px;"><a class="no-underbar color-black" href="/users/signup">サインアップ</a></li>
        <li style="float:left; width: 10%; height:15%; text-align:center; font-size:20px;"><a class="no-underbar color-black" href="/users/login">ログイン</a></li>
        <?php endif ; ?>
        <?php elseif ($this->name == "Users" && $this->action == "mypage") : ?>
        <li><a class="no-underbar color-black" href="/">TOPへ</a></li>
        <li><a class="no-underbar color-black" href="/users/logout">ログアウト</a></li>
    <?php endif ; ?>
    </ul>
</content>