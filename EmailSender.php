<?php
namespace Jamm\MandrillSender;

use Jamm\HTTP\Request;
use Jamm\HTTP\Response;
use Jamm\HTTP\SerializerJSON;

class EmailSender implements IEmailSender
{
	private $key;
	private $url = 'https://mandrillapp.com/api/1.0';

	/**
	 * @param string $key App key
	 * @param string $url Mandrill API endpoint
	 */
	public function __construct($key, $url = '')
	{
		$this->key = $key;
		if (!empty($url)) {
			$this->url = $url;
		}
	}

	/**
	 * @param Email $Email
	 * @return bool
	 */
	public function sendEmail(Email $Email)
	{
		$Request = new Request();
		$Response = new Response();
		$Response->setSerializer(new SerializerJSON());
		$Request->setMethod('POST');
		$Request->setDataKey('key', $this->key);
		$Request->setDataKey('message', $Email->toArray());
		$Request->Send($this->url.'/messages/send.json', $Response);
		if ($Response->isStatusError()) {
			return false;
		}
		$body = $Response->getBody();
		if (isset($body[0]['return']) && ($body[0]['return']['status'] === 'rejected' && $body[0]['return']['status'] === 'invalid')) {
			return false;
		}
		return true;
	}

	/**
	 * @param string $key
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}
}
