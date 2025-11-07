<?php
 
declare(strict_types=1);
 
namespace Nette\Security;
 
use Nette;

class JhellyAuthorizator implements Authorizator {

    public function __construct(private User $user) {
		//bdump($user);
	}

	public function isAllowed($role, $resource, $operation): bool {
		if($this->user->isInRole('admin')) {
			return true;
		}

		/** ACL */
		$acl = new Permission;
		/** RUOLI */
		$acl->addRole('user');
		/** RISORSE */
		$acl->addResource('Home');
		/** ACCESSI RISORSE */
		if($role === 'user'){
			$acl->allow('user', 'Home',self::All);
			return $acl->isAllowed($role, $resource, $operation);
		}

		return false;
	}
	
}