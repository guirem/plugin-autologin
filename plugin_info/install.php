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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

function get_plugin_version() {
	$data = json_decode(file_get_contents(dirname(__FILE__) . '/info.json'), true);
    if (!is_array($data)) {
        $core_version = 0;
    }
    try {
        $core_version = $data['version'];
    } catch (\Exception $e) {
        $core_version = 0;
    }
	return $core_version;
}

function autologin_update() {

	$core_version = get_plugin_version();
	config::save('plugin_version', $core_version, 'autologin');

	foreach (autologin::byType('autologin') as $autologin) {
		try {
			$autologin->save();
		} catch (Exception $e) {}
	}
	message::add('autologin', 'Mise à jour du plugin AutoLogin terminé (version ' . $core_version . ').', null, null);
}

function autologin_install() {
	$core_version = get_plugin_version();
	config::save('plugin_version', $core_version, 'autologin');

	message::removeAll('autologin');
    message::add('autologin', 'Installation du plugin AutoLogin terminé (version ' . $core_version . ').', null, null);
}

function autologin_remove() {
    message::add('autologin', 'Désinstallation du plugin AutoLogin terminé.', null, null);
}

?>
