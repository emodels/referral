<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
        private $_id;   
    
	public function authenticate()
	{
                $user = User::model()->findByAttributes(array('username'=>$this->username));
            
                if ($user == NULL) {
                    $this->errorCode = self::ERROR_USERNAME_INVALID;
                }
                else if($user->password!==$this->password){
                    $this->errorCode=self::ERROR_PASSWORD_INVALID;
                }
                else{
                    $this->_id=$user->id;
                    $this->setState('first_name', $user->first_name);
                    $this->setState('last_name', $user->last_name);
                    $this->setState('user_type', $user->user_type);
                    $this->setState('company', $user->company);
                    $this->setState('email', $user->email);
                    $this->setState('entry', $user->entry);
                    $this->setState('allow_add_referral', $user->allow_add_referral);
                    $this->setState('allow_portal_management', $user->allow_portal_management);
                    $this->setState('user_logo', $user->logo);
                    $this->setState('user_logo_width', $user->logo_width);
                    $this->setState('user_logo_height', $user->logo_height);
                    $this->setState('user_header_title', $user->header_title);
                    $this->errorCode=self::ERROR_NONE;

                    $admin = User::model()->find('user_type = 0');

                    if (isset($admin)) {

                        $this->setState('site_name', $admin->company);
                        $this->setState('site_address', $admin->header_title);
                        $this->setState('site_logo', $admin->logo);
                        $this->setState('site_logo_width', $admin->logo_width);
                        $this->setState('site_logo_height', $admin->logo_height);
                    }

                    if ($user->user_type == 2) {

                        $entry = Entry::model()->findByPk($user->entry);

                        if (isset($entry) && isset($entry->referrelUser->logo)) {

                            $this->setState('user_logo', $entry->referrelUser->logo);
                            $this->setState('user_logo_width', $entry->referrelUser->logo_width);
                            $this->setState('user_logo_height', $entry->referrelUser->logo_height);
                            $this->setState('user_header_title', $entry->referrelUser->header_title);
                        }
                    }
                }
                
                return !$this->errorCode;                
	}
        
        public function getId() {
            return $this->_id;
        }        
}