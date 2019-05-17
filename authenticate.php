<?php
function authenticate($user, $password) {
	if(empty($user) || empty($password)) return false;
	$ldap_host = "ryanad.local";
	$ldap_dn = "DC=ryanad,DC=local";
	$ldap_user_group = "Users";
	$ldap_manager_group = "Administrators";
	$ldap_usr_dom = '@ryanad.local';
	$ldap = ldap_connect($ldap_host);
	ldap_set_option($ldap,LDAP_OPT_PROTOCOL_VERSION,3);
	ldap_set_option($ldap,LDAP_OPT_REFERRALS,0);
	if($bind = @ldap_bind($ldap, $user.$ldap_usr_dom, $password)) {
		$filter = "(sAMAccountName=".$user.")";
		$attr = array("memberof");
		$result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server");
		$entries = ldap_get_entries($ldap, $result);
		ldap_unbind($ldap);
		$access = 0;
		foreach($entries[0]['memberof'] as $grps) {
			if(strpos($grps, $ldap_manager_group)) { $access = 2; break; }
			if(strpos($grps, $ldap_user_group)) $access = 1;
		}
 
		if($access != 0) {
			$_SESSION['user'] = $user;
			$_SESSION['access'] = $access;
			return true;
		} else {
			return false;
		}
 
	} else {
		return false;
	}
}
?>
