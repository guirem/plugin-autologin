<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */


//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
class autologin extends eqLogic {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */


	/*     * *********************Methode d'instance************************* */

	public function preUpdate() {

        if ( $this->getConfiguration('redirecturl', '') == '' ) {
            $this->setConfiguration('redirecturl', network::getNetworkAccess('internal'));
        }
        if ( !filter_var($this->getConfiguration('redirecturl', ''), FILTER_VALIDATE_URL) ) {
            throw new Exception(__('Le champs Redirect URL n\'est pas au bon format.', __FILE__));
        }
        if ( $this->getConfiguration('ip', '') == '' ) {
            throw new Exception(__('Le champs IP ne peut etre vide.', __FILE__));
        }
        if ( !filter_var($this->getConfiguration('ip', ''), FILTER_VALIDATE_IP) ) {
            throw new Exception(__('Le champs IP n\'est pas au bon format.', __FILE__));
        }
        if ( $this->getConfiguration('user', '') == '' ) {
            throw new Exception(__('Le champs Utilisateur ne peut etre vide.', __FILE__));
        }

        if ($this->getLogicalId()=='') {
            $this->setLogicalId($this->getId());
            $this->setConfiguration('sessionid',uniqid());
        }
        // necessary to show url in config UI
        $this->setConfiguration('urlid',$this->getLogicalId());

        if ($this->getIsEnable()==0) {
            $this->deleteHash();
        }
        else {
            $this->saveHash();
        }
	}

	public function preRemove() {
        $this->deleteHash();
	}

	public function preSave() {
        // first time only
        if ($this->getLogicalId()=='') {
    		if ( $this->getConfiguration('redirecturl', '') == '' ) {
                $this->setConfiguration('redirecturl', network::getNetworkAccess('internal'));
            }
            if ( $this->getConfiguration('ip', '') == '' ) {
                $this->setConfiguration('ip', getClientIp());
            }
            $this->setIsEnable(1);
        }
	}

	public function postSave() {
	}

    public function saveHash() {
        $user = $this->getUser();
        if (!is_object($user)) {
            return false;
        }
        $hashregisterdevice = $this->getHash();
        $registerDevice = $user->getOptions('registerDevice', array());
        if (!is_array($registerDevice)) {
            $registerDevice = array();
        }
        $key = explode('-', $hashregisterdevice);
        $rdk = $key[1];

        if (!isset($registerDevice[sha512($rdk)])) {
            $rdk = config::genKey();
            $hashregisterdevice = $user->getHash() . '-' . $rdk;
            $registerDevice[sha512($rdk)] = array();
        	$registerDevice[sha512($rdk)]['datetime'] = date('Y-m-d H:i:s');
        	$registerDevice[sha512($rdk)]['ip'] = $this->getIP();
        	$registerDevice[sha512($rdk)]['session_id'] = $this->getSessionId();
            $user->setOptions('registerDevice', $registerDevice);
            $user->save();

            $this->setConfiguration('hashregisterdevice', $hashregisterdevice);
        }
        return true;
    }

    public function deleteHash() {
        $user = $this->getUser();
        if (!is_object($user)) {
            return false;
        }
        $hashregisterdevice = $this->getHash();
        $registerDevice = $user->getOptions('registerDevice', array());
        if (!is_array($registerDevice)) {
            $registerDevice = array();
        }
        $key = explode('-', $hashregisterdevice);
        $rdk = $key[1];

        if (isset($registerDevice[sha512($rdk)])) {
            unset($registerDevice[sha512($rdk)]);
            $user->setOptions('registerDevice', $registerDevice);
            $user->save();
        }
        return true;
    }

    public function getHash() {
        return $this->getConfiguration('hashregisterdevice', 'bogus-bogus');
    }

    public function getRedirectUrl() {
        return $this->getConfiguration('redirecturl', '');
    }

    public function getUser() {
        $username = $this->getConfiguration('user', '');
        $user = user::byLogin($username);
        if (!is_object($user) || $user->getEnable() == 0) {
            return null;
        }
        return $user;
    }

    public function getSessionId() {
        return $this->getConfiguration('sessionid', '');
    }

    public function getIP() {
        return $this->getConfiguration('ip', '');
    }

    // ------------------------------

}

class autologinCmd extends cmd {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/*     * *********************Methode d'instance************************* */

	public function execute($_options = null) {
        return true;
	}

	/*     * **********************Getteur Setteur*************************** */
}
