<?php
namespace Jamm\MandrillSender;

class EmailAttachment
{
    private $type;
    private $name;
    private $content;

    public function __construct($type, $name, $content)
    {
        $this->type = $type;
        $this->name = $name;
        $this->content = base64_encode($content);
    }

    public function toArray()
    {
        return ['type' => $this->type, 'name' => $this->name, 'content' => $this->content];
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getContent()
    {
        return base64_decode($this->content);
    }

    public function setContent($content)
    {
        $this->content = base64_encode($content);
    }
}
