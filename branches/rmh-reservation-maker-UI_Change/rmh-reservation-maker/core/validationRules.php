<?php 
$addUserValidationRules = array(
						'userGroup'=>array('notempty'),
						'title'=>array('alpha','allow'=>array('.')),
						'fname'=>array('alpha'),
						'lname'=>array('alpha'),
						'phone'=>array('number','allow'=>array('-','(',')','.')),
						'username'=>array('alphanumeric'),
						'email'=>array('email'),
						'hospital'=>array('notempty'),//this might not be available for admin, how to check that?
						'notify'=>array('notempty'),
						'submit'=>array('ignore')
				);

?>