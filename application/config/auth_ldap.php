<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * This file is part of Auth_Ldap.

    Auth_Ldap is free software: you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Auth_Ldap is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Auth_Ldap.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 * @author      Greg Wojtak <gwojtak@techrockdo.com>
 * @copyright   Copyright Â© 2010,2011 by Greg Wojtak <gwojtak@techrockdo.com>
 * @package     Auth_Ldap
 * @subpackage  configuration
 * @license     GNU Lesser General Public License
 */

/**
 * Array Index      - Usage
 * hosts            - Array of ldap servers to try to authenticate against
 * ports            - The remote port on the ldap server to connect to
 * basedn           - The base dn of your ldap data store
 * login_attribute  - LDAP attribute used to check usernames against
 * proxy_user       - Distinguised name of a proxy user if your LDAP server does not allow anonymous binds
 * proxy pass       - Password to use with above
 * roles            - An array of role names to use within your app.  The values are arbitrary.  
 *                      The keys themselves represent the
 *          "security level," ie
 *          if( $security_level >= 3 ) {
 *              // Is a power user
 *              echo display_info_for_power_users_or_admins();
 *          }
 * member_attribute - Attribute to search to determine allowance after successful authentication
 * auditlog         - Location to log auditable events.  Needs to be writeable
 *                      by the web server
 */
/* if non SSL 
*$config['hosts'] = array('119.92.187.35');
*$config['ports'] = array(389);
*/
$config['hosts'] = array('ldaps://hera.infinit-o.com');
$config['ports'] = 636;
$config['basedn'] = 'ou=EndUsers,dc=Infinit-O,dc=com';
$config['login_attribute'] = 'sAMAccountName';
$config['proxy_user'] = 'CN=ldap service,OU=ServiceAccounts,OU=IT,OU=ADMIN,OU=EndUsers,DC=infinit-o,DC=com';
$config['proxy_pass'] = '!nfinit0n1nj@';
$config['roles'] = array(1 => 'EndUsers', 
    3 => 'ADMIN',
    5 => 'IT');
$config['member_attribute'] = 'sAMAccountName';
$config['auditlog'] = '/ebs-volume/apps/ssg/application/logs';  // Some place to log attempted logins (separate from message log)
$config['use_tls'] = false;

$config['allowed_country'] = array('PH','MY');
$config['allowed_ip'] = array('63.117.218.80','63.117.218.100','203.177.15.170','119.92.190.230');

$config['enable_geoip'] = 0;
$config['enable_emp_id'] = 0;
?>
