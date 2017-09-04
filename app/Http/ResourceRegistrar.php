<?php

namespace App\Http;

use Illuminate\Routing\ResourceRegistrar as OriginalRegistrar;

class ResourceRegistrar extends OriginalRegistrar
{
	// add data to the array
	/**
	 * The default actions for a resourceful controller.
	 *
	 * @var array
	 */
    protected $resourceDefaults = ['export', 'destroyMultiple', 'impress', 'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];

	/**
	 * Add the export method for a resourceful route.
	 *
	 * @param  string  $name
	 * @param  string  $base
	 * @param  string  $controller
	 * @param  array   $options
	 * @return \Illuminate\Routing\Route
	 */
	protected function addResourceExport($name, $base, $controller, $options)
	{
		$uri = $this->getResourceUri($name).'/exportar';

		$action = $this->getResourceAction($name, $controller, 'export', $options);

		return $this->router->match(['GET', 'POST'], $uri, $action);
	}

	/**
	 * Add the delete multiple method for a resourceful route.
	 *
	 * @param  string  $name
	 * @param  string  $base
	 * @param  string  $controller
	 * @param  array   $options
	 * @return \Illuminate\Routing\Route
	 */
	protected function addResourceDestroyMultiple($name, $base, $controller, $options)
	{
		$uri = $this->getResourceUri($name).'/destroy-multiple';

		$action = $this->getResourceAction($name, $controller, 'destroyMultiple', $options);

		return $this->router->delete($uri, $action);
	}

    protected function addResourceImpress($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/exportar';

        $action = $this->getResourceAction($name, $controller, 'export', $options);

        return $this->router->match(['GET', 'POST'], $uri, $action);
    }

}
