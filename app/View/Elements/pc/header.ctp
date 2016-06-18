<header>
	<h1 class="color-black">Memoria</h1>
	<ul class="list-none">
		<?php if ($auth->loggedIn()) : ?>
		<li><a class="no-underbar color-black" href="/users/mypage/<?php echo $auth->user('id'); ?>">マイページ</a></li>
		<li><a class="no-underbar color-black" href="/users/logout">ログアウト</a></li>
	    <?php else : ?>
	    <li><a class="no-underbar color-black" href="/users/signup">サインアップ</a></li>
		<li><a class="no-underbar color-black" href="/users/login">ログイン</a></li>
	    <?php endif ; ?>
	</ul>
</header>