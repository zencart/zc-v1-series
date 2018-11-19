<?php
/**
 * File contains just the request class
 *
 * @package classes
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: $
 */
namespace ZenCart\Request;

use Aura\Web\WebFactory;
use Aura\Web\Request as WebRequest;

/**
 * Class Request
 * @package ZenCart\Request
 */
class Request extends \base
{
    /**
     * @var \Aura\Web\Request
     */
    protected $request;
    /**
     * @var \Aura\Web\WebFactory
     */
    protected $webFactory;
    /**
     * @var array
     */
    protected $parameterBag;

    /**
     * constructor
     */
    public function __construct(WebRequest $webRequest, Session $session)
    {
        $this->request = $webRequest;
        $this->session  = $session;
        $this->initParameterBag();
    }

    /**
     * create the parameter bags for get/post
     *
     */
    protected function initParameterBag()
    {
        $this->parameterBag ['post'] = $this->request->post->get();
        $this->parameterBag ['get'] = $this->request->query->get();
    }

    /**
     * get a parameter value from the parameter bag
     *
     * @param  string $param
     * @param  mixed  $default
     * @param  string $source
     * @return mixed
     */
    public function get($param, $default = null, $source = 'get')
    {
        if (isset($this->parameterBag[$source][$param])) {
            return $this->parameterBag[$source][$param];
        }
        return $default;
    }

    /**
     * alias to get a parameter bag value from GET
     *
     * @param $param
     * @param mixed $default
     * @return mixed
     */
    public function readGet($param, $default = null)
    {
        return $this->get($param, $default, 'get');
    }

    /**
     * alias to get a parameter bag value from POST
     *
     * @param $param
     * @param mixed $default
     * @return mixed
     */
    public function readPost($param, $default = null)
    {
        return $this->get($param, $default, 'post');
    }

    /**
     * test whether parameter bag has a specific key
     *
     * @param $param
     * @param string $source
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function has($param, $source = 'get')
    {
        if (!isset($this->parameterBag[$source])) {
            throw new \InvalidArgumentException('Exception: invalid source for has operation');
        }
        return ((isset($this->parameterBag[$source][$param])) ? true : false);
    }

    /**
     * get all values from a parameter bag
     *
     * @param string $source
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function all($source = 'get')
    {
        if (!isset($this->parameterBag[$source])) {
            throw new \InvalidArgumentException('Exception: invalid source for all operation');
        }
        return new \ArrayObject($this->parameterBag[$source]);
    }

    /**
     * @param string $param
     * @param $value
     * @param string $source
     */
    public function set($param, $value, $source = 'get')
    {
        $this->parameterBag[$source][$param] = $value;
    }

    /**
     * @return object
     */
    public function getWebFactoryRequest()
    {
        return $this->request;
    }
    /**
     * @return object
     */
    public function getSession()
    {
        return $this->session;
    }
}
