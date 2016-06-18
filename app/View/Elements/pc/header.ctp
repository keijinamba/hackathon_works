<header>
	<a class="no-underbar color-black" href="/"><h1 class="color-black">Memoria</h1></a>
	<ul class="list-none">
		<?php if ($this->name == "Pages" && $this->action == "index") : ?>
		<?php if ($auth->loggedIn()) : ?>
		<li><a class="no-underbar color-black" href="/users/mypage/<?php echo $auth->user('id'); ?>">マイページ</a></li>
		<li><a class="no-underbar color-black" href="/users/logout">ログアウト</a></li>
	    <?php else : ?>
	    <li><a class="no-underbar color-black" href="/users/signup">サインアップ</a></li>
		<li><a class="no-underbar color-black" href="/users/login">ログイン</a></li>
	    <?php endif ; ?>
	    <?php elseif ($this->name == "Users" && $this->action == "mypage") : ?>
	    <li><a class="no-underbar color-black" href="/">TOPへ</a></li>
		<li><a class="no-underbar color-black" href="/users/logout">ログアウト</a></li>
	<?php endif ; ?>
	</ul>
</header>