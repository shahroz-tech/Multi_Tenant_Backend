<?php

namespace App\Services;

use App\Mail\TeamInviteMail;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class TeamInvitationService
{
    public function sendInviteEmail(User $user, Team $team): void
    {
        // You can later replace this stub with real email sending
        // Mail::to($user->email)->send(new TeamInviteMail($team));

        logger("Stub: Invite email would be sent to {$user->email} for team {$team->id}");
    }
}
