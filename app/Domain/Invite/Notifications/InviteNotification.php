<?php

namespace Domain\Invite\Notifications;

use Domain\Invite\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Invite $invite,
    ) {}

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        $this->invite->loadMissing('clinic');

        return (new MailMessage)
            ->subject("You've been invited to collaborate with Hollistic Beauty")
            ->greeting("Hello {$this->invite->name},")
            ->line("Hollistic Beauty has invited you to collaborate with the clinic **{$this->invite->clinic->name}**.")
            ->line("You'll be able to view commissions, referrals, and performance for this clinic.")
            ->line("Click the button below to accept the invitation and get started.")
            ->action(
                'Accept Invitation',
                route('invites.accept', $this->invite->token)
            )
            ->line("If you weren't expecting this invitation, you can safely ignore this email.")
            ->salutation('— ' . config('app.name'));
    }

    public function toArray(): array
    {
        return [
            'invite_id' => $this->invite->id,
            'email' => $this->invite->email,
        ];
    }
}
