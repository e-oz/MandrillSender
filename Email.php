<?php
namespace Jamm\MandrillSender;

class Email
{
	/** @var EmailAttachment[] */
	private $attachments;
	private $from_email = '';
	private $from_name = '';
	private $text;
	private $html;
	private $recipients;
	private $cc;
	private $subject;
	/** @var array */
	private $tags;

	public function __construct($recipient = '', $subject = '', $html = '')
	{
		if ($recipient) {
			$this->addRecipient($recipient);
		}
		if ($subject) {
			$this->subject = $subject;
		}
		if ($html) {
			$this->html = $html;
		}
	}

	public function addRecipient($email)
	{
		$this->recipients[] = $email;
	}

	public function addCC($email)
	{
		$this->cc[] = $email;
	}

	/**
	 * @return EmailAttachment[]
	 */
	public function getAttachments()
	{
		return $this->attachments;
	}

	public function getFromEmail()
	{
		return $this->from_email;
	}

	public function setFromEmail($from_email)
	{
		$this->from_email = $from_email;
	}

	public function getFromName()
	{
		return $this->from_name;
	}

	public function setFromName($from_name)
	{
		$this->from_name = $from_name;
	}

	public function getText()
	{
		return $this->text;
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function getHtml()
	{
		return $this->html;
	}

	public function setHtml($html)
	{
		$this->html = $html;
	}

	public function getRecipients()
	{
		return $this->recipients;
	}

	public function getSubject()
	{
		return $this->subject;
	}

	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	public function getTags()
	{
		return $this->tags;
	}

	public function toArray()
	{
		$r = [
			'html'       => $this->html,
			'text'       => $this->text,
			'subject'    => $this->subject,
			'from_email' => $this->from_email,
			'from_name'  => $this->from_name,
			'tags'       => $this->tags
		];
		if (!empty($this->recipients)) {
			$r['to'] = [];
			foreach ($this->recipients as $recipient) {
				$r['to'][] = ['email' => $recipient];
			}
		}
		if (!empty($this->cc)) {
			if (!isset($r['to'])) {
				$r['to'] = [];
			}
			foreach ($this->cc as $cc) {
				$r['to'][] = ['email' => $cc, 'type' => 'cc'];
			}
		}
		if (!empty($this->attachments)) {
			$r['attachments'] = [];
			foreach ($this->attachments as $Attachment) {
				$r['attachments'][] = $Attachment->toArray();
			}
		}
		return $r;
	}

	/**
	 * @param EmailAttachment $Attachment
	 */
	public function addAttachment(EmailAttachment $Attachment)
	{
		$this->attachments[] = $Attachment;
	}

	public function addTag($tag)
	{
		$this->tags[] = $tag;
	}
}
