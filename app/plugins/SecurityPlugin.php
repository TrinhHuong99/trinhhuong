
<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Events\Event;
class SecurityPlugin extends Plugin
{

	public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
	{
		// Check whether the 'auth' variable exists in session to define the active role

		if ($dispatcher->getControllerName() != 'login') {
			$auth = $this->session->get('user_name');
			if (!$auth) {
				$dispatcher->forward(
					[
						'controller' => 'login',
						'action' => 'index',
					]
				);
			}
		}
		return true;
	}
}