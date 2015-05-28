<?php
namespace tests\Services;

use Jamm\Tester\ClassTest;
use Jamm\MandrillSender\Email;
use Jamm\MandrillSender\EmailAttachment;

class EmailTest extends ClassTest
{
	public function testToArray()
	{
		$Email = new Email('to@example.com', 'subject', 'html');
		$Email->setFromEmail('from@example.com');
		$Email->setFromName('from name');
		$Email->addRecipient('toOneMore@example.com');
		$Email->addAttachment(new EmailAttachment('test', 'attachment', 'test attachment content'));
		$Email->addTag('tag1');
		$Email->addTag('tag2');
		$Email->addCC('cc1@example.com');
		$Email->addCC('cc2@example.com');
		$Email->setText('text version');
		$result = $Email->toArray();
		$this->assertEquals($result,
			['html'        => 'html',
			 'text'        => 'text version',
			 'subject'     => 'subject',
			 'from_email'  => 'from@example.com',
			 'from_name'   => 'from name',
			 'tags'        => ['tag1', 'tag2'],
			 'to'          =>
				 [
					 ['email' => 'to@example.com'],
					 ['email' => 'toOneMore@example.com'],
					 ['email' => 'cc1@example.com', 'type' => 'cc'],
					 ['email' => 'cc2@example.com', 'type' => 'cc']
				 ],
			 'attachments' =>
				 [
					 [
						 'type'    => 'test',
						 'name'    => 'attachment',
						 'content' => base64_encode('test attachment content')
					 ]
				 ]]);
	}

	public function test_emailAttachment()
	{
		$EA = new EmailAttachment('content/type', 'name', 'content');
		$this->assertEquals($EA->getContent(), 'content');
		$this->assertEquals($EA->getName(), 'name');
		$this->assertEquals($EA->getType(), 'content/type');
		$EA->setContent('content with space');
		$this->assertEquals($EA->getContent(), 'content with space');
		$EA->setName('name with space');
		$this->assertEquals($EA->getName(), 'name with space');
		$EA->setType('type with space');
		$this->assertEquals($EA->getType(), 'type with space');
		$this->assertEquals($EA->toArray(), [
			'type' => 'type with space', 'name' => 'name with space', 'content' => base64_encode('content with space')
		]);
	}
}
