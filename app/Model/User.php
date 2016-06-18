<?php
class User extends AppModel {
    public $name = 'User';
    public $useTable = 'users';
	public $validate = array(
	    'username' => array(
	        array(
	            'rule' => 'isUnique', //重複禁止
	            'message' => '既に使用されている名前です。'
	        ),
	        array(
		        'rule' => 'alphaNumeric', //半角英数字のみ
		        'message' => '名前は半角英数字にしてください。'
	        ),
	        array(
		        'rule' => array('between', 2, 32), //2～32文字
		        'message' => '名前は2文字以上32文字以内にしてください。'
	        )
	    ),
	    'password' => array(
	        array(
		        'rule' => 'alphaNumeric',
		        'message' => 'パスワードは半角英数字にしてください。'
	        ),
	        array(
		        'rule' => array('between', 8, 32),
		        'message' => 'パスワードは8文字以上32文字以内にしてください。'
	        )
	    )
	);
}