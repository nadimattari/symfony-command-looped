<?php

namespace App\Services;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

class EmailService
{
    private Email $email;

    /**
     * @param ParameterBagInterface $params
     * @param MailerInterface       $mailer
     */
    function __construct(readonly ParameterBagInterface $params, readonly MailerInterface $mailer)
    {
        $address = new Address(
            $this->params->get('email_from.addr'),
            $this->params->get('email_from.name')
        );
        $this->email = (new Email())
            ->from($address)
            ->replyTo($address)
        ;

        $this
            ->email
            ->getHeaders()
            // this non-standard header tells compliant autoresponders ("email
            // holiday mode") to not reply to this message because it's an
            // automated email
            ->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply')
        ;
    }

    /**
     * @param array $emails
     * @return $this
     */
    final public function setTo(array $emails = []): self
    {
        foreach ($emails as $email) {
            $this->email->addTo($email);
        }

        return $this;
    }

    /**
     * @param array $emails
     * @return $this
     */
    final public function setCc(array $emails = []): self
    {
        foreach ($emails as $email) {
            $this->email->addCc($email);
        }

        return $this;
    }

    /**
     * @param array $emails
     * @return $this
     */
    final public function setBcc(array $emails = []): self
    {
        foreach ($emails as $email) {
            $this->email->addBcc($email);
        }

        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    final public function setText(string $text): self
    {
        $this->email->text($text);
        return $this;
    }

    /**
     * @param string $html
     * @return $this
     */
    final public function setHtml(string $html): self
    {
        $this->email->html($html);
        return $this;
    }

    final public function setSubject(string $subject): self
    {
        $this->email->subject($subject);
        return $this;
    }

    /**
     * @param string $file
     * @param string $name
     * @return $this
     */
    final public function addAttachment(string $file, string $name = ''): self
    {
        $this->email->addPart(new DataPart(new File($file), $name));
        return $this;
    }

    /**
     * @return string|null
     */
    final public function send(): null|string
    {
        try {
            $this->mailer->send($this->email);
        }
        catch (Exception|TransportExceptionInterface $e) {
            // todo: log failures
            return $e->getMessage();
        }

        return null;
    }
}
