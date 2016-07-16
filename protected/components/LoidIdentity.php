<?php
/**
 * EmailIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class LoidIdentity extends CUserIdentity
{	
	public $openid_identifier = null;
	
	protected $_id = null;
	
	/**
	 * override to support that user id from inside database is stored
	 * @see CUserIdentity::getId()
	 */
	public function getId() {
		return $this->_id;
	}
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		if($this->isAuthenticated) {	//to profuse call of authenticate
			return true;
		}
		
		if($this->openid_identifier === null) {
			//messages concerning debugging are only in english
			$message = 'Please define openid_identifier before calling authenticate';
			throw new CException($message);
		}

		$loid = Yii::app()->loid->load();
		
		if (!empty($_GET['openid_mode'])) {
			if ($_GET['openid_mode'] == 'cancel') {
				$err = Yii::t('core', 'Authorization cancelled');
			}
			else {
				try {
					if($loid->validate()) {
						//Kint::dump($_GET);	//we get more than 20 pieces of information
						//The most important of them are:
						//openid_identity			identification
						//openid_ax_value_nickname	nickname
						//openid_ax_value_email		email
						
						$this->_id = $_GET['openid_identity'];
						
						//@todo correct this
						$this->username = $_GET['openid_ax_value_nickname'];
						//$this->username = 'admin';
						
						$this->setState('email', $_GET['openid_ax_value_email']);
						
						$this->errorCode=self::ERROR_NONE;
					}
					else {
						$err = 'Validation has failed';
					}
				}
				catch (Exception $e) {
					$err = Yii::t('core', $e->getMessage());
				}
			}
			
			if(!empty($err)) {
				throw new CException($err);
			}
		}
		else {
			// this openid_identifier is need after you click the openselector
			$loid->identity = $this->openid_identifier;	//Setting identifier e.g. "http://my.openid.identifier"
			
			$loid->required = array('namePerson/friendly', 'contact/email'); //Try to get info from openid provider

			//$loid->realm = (Yii::app()->getRequest()->getIsSecureConnection() ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']; 
			$loid->realm = Yii::app()->getRequest()->getHostInfo();
			
			$loid->returnUrl = $loid->realm . Yii::app()->getRequest()->getRequestUri();	//$_SERVER['REQUEST_URI']
			
			if(empty($err)) {
				try {
					$url = $loid->authUrl();
					Yii::app()->getRequest()->redirect($url);
				}
				catch (Exception $e) {
					$err = Yii::t('core', $e->getMessage());
					throw new CException($err);
				}
			}
		}
		return $this->isAuthenticated;
	}
}
