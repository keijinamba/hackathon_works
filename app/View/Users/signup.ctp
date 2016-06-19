<h1 style="margin:0 auto; width: 30%; height: 20%;text-align:center;padding-top: 10%;">新規登録</h1>
<?php print(
 $this->Form->create('User') .
 $this->Form->input('username') .
 $this->Form->input('password') .
 $this->Form->end('Submit')
); ?>