<?php
namespace Jamm\MandrillSender;

interface IEmailSender
{
    public function sendEmail(Email $Email);
}
