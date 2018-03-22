<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/2/6
 * Time: 下午4:18
 */

namespace EasySwoole\Core\Component\Cluster\Common;


use EasySwoole\Core\AbstractInterface\Singleton;
use EasySwoole\Core\Component\Cluster\Communicate\SysCommand;
use EasySwoole\Core\Component\Event;
use EasySwoole\Core\Component\Cluster\Communicate\CommandBean;
use EasySwoole\Core\Component\Cluster\Server\ServerManager;

class CommandRegister extends Event
{
    use Singleton;

    function __construct(array $allowKeys = null)
    {
        parent::__construct($allowKeys);
        $this->set(SysCommand::NODE_BROADCAST,function (CommandBean $commandBean,$udpAddress){
            ServerManager::addNode($commandBean);
        });
        $this->set(SysCommand::RPC_NODE_BROADCAST,function (CommandBean $commandBean,$udpAddress){
            ServerManager::addNodeServices($commandBean);
        });
        $this->set(SysCommand::NODE_SHUTDOWN, function (CommandBean $commandBean,$udpAddress) {
            ServerManager::delNode($commandBean);
        });
    }

}