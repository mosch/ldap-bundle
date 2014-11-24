<?php
namespace Agixo\LdapBundle;

use Symfony\Bridge\Monolog\Logger;
use Toyota\Component\Ldap\API\ConnectionInterface;
use Toyota\Component\Ldap\Core\Manager;
use Toyota\Component\Ldap\Platform\Native\Driver;
use Toyota\Component\Ldap\Exception\BindException;

class Ldap
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(array $config, Logger $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    public function checkPassword($username, $password)
    {
        $manager = $this->createManager();
        $manager->connect();
        try {
            $manager->bind($this->getBindDn($username), $password);
        } catch(BindException $bind) {
            // when bind fails with credentials, login is incorrect.
            // we need to log here, since it MAY help with configuration issues
            $this->logger->addInfo($bind->getMessage());
            return false;
        }

        return true;
    }

    private function getBindDn($username)
    {
        return $this->config['loginAttribute'].'='.$username.','.$this->config['bindDn'];
    }

    private function createManager()
    {
        $config = $this->config;
        $params = array(
            'hostname'  => $config['host'],
            'base_dn'   => $config['baseDn'],
            'bind_dn'   => $config['bindDn'],
            'options'   => [
                ConnectionInterface::OPT_REFERRALS => 0,
                ConnectionInterface::OPT_PROTOCOL_VERSION => 3,
            ]
        );

        return new Manager($params, new Driver());
    }
}