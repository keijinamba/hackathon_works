<h1>新規登録</h1>
<?php print(
  $this->Form->create('User') .
  $this->Form->input('username') .
  $this->Form->input('password') .
  $this->Form->end('Submit')
); ?>