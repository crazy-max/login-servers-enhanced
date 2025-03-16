<?php

$composerAutoload = __DIR__.'/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

/**
 * Fork of the official login-servers Adminer plugin with enhancements.
 * Display constant list of servers in login form.
 *
 * @link https://github.com/crazy-max/login-servers-enhanced
 *
 * @author Jakub Vrana, http://www.vrana.cz/
 * @author CrazyMax, https://github.com/crazy-max
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerLoginServersEnhanced
{
    private $servers;

    /** Set supported servers
     * @param array array(AdminerLoginServerEnhanced)
     */
    public function __construct($servers)
    {
        $this->servers = $servers;
    }

    public function login($login, $password)
    {
        foreach ($this->servers as $server) {
            if (!$server instanceof AdminerLoginServerEnhanced) {
                continue;
            }
            if ($server->domain == Adminer\SERVER) {
                return true;
            }
        }

        return false;
    }

    public function loginForm()
    {
        $html = '<table cellspacing="0">';
        $html .= $this->getTrServer();
        $html .= $this->getTrUsername();
        $html .= $this->getTrPassword();
        $html .= '</table>';

        $html .= '<p><input type="submit" value="'.Adminer\lang('Login').'">';
        $html .= Adminer\checkbox('auth[permanent]', 1, $_COOKIE['adminer_permanent'], Adminer\lang('Permanent login'))."\n";

        echo $html;

        return true;
    }

    private function getTrServer()
    {
        $html = '<tr><th>'.Adminer\lang('Server').'<td>';

        $html .= '<input type="hidden" name="auth[driver]" value="'.$this->servers[0]->driver.'">';

        $html .= '<select name="auth[server]">';
        foreach ($this->servers as $key => $server) {
            if (!$server instanceof AdminerLoginServerEnhanced) {
                continue;
            }
            $html .= $server->getOptionTag($key == 0);
        }
        $html .= '</select>';

        $html .= '<script type="text/javascript" ' . Adminer\nonce() . '>';
        $html .= 'document.addEventListener("DOMContentLoaded", function () { ';
        $html .= 'document.getElementsByName("auth[server]")[0].addEventListener("change", switchServer); ';
        $html .= '}); ';
        $html .= 'function switchServer() { ';
        $html .= 'var selectServer = document.getElementsByName("auth[server]")[0]; ';
        $html .= 'var driver = selectServer.options[selectServer.selectedIndex].getAttribute("driver"); ';
        $html .= 'document.getElementsByName("auth[driver]")[0].value = driver; ';
        $html .= '}';
        $html .= '</script>';

        return $html;
    }

    private function getTrUsername()
    {
        $html = '<tr><th>'.Adminer\lang('Username').'<td>';
        $html .= '<input id="username" name="auth[username]" value="'.Adminer\h($_GET['username']).'">';

        return $html;
    }

    private function getTrPassword()
    {
        $html = '<tr><th>'.Adminer\lang('Password').'<td>';
        $html .= '<input type="password" name="auth[password]">';

        return $html;
    }
}

class AdminerLoginServerEnhanced
{
    public $domain;
    public $desc;
    public $driver = 'server';

    public function __construct($domain, $desc, $driver)
    {
        $this->domain = $domain;
        $this->desc = empty($desc) ? $domain : $desc;
        $this->driver = $driver;
    }

    public function getOptionTag($selected = false)
    {
        $html = '<option value="'.$this->domain.'" driver="'.$this->driver.'"';
        $html .= ($selected ? ' selected>' : '>');
        $html .= $this->desc.'</option>';

        return $html;
    }
}
