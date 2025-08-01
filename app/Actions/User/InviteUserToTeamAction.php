<?php

namespace App\Actions\User;

use App\Models\Team;
use App\Models\User;
use App\Services\TeamInvitationService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InviteUserToTeamAction
{
    protected TeamInvitationService $invitationService;

    public function __construct(TeamInvitationService $invitationService)
    {
        $this->invitationService = $invitationService;
    }

    public function execute(array $data, Team $team, int $authId): array
    {
        if ($team->owner_id !== $authId) {
            throw ValidationException::withMessages([
                'unauthorized' => ['Only team owner can send invites.']
            ]);
        }

        Validator::make($data, [
            'email' => 'required|email',
        ])->validate();

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['name' => 'Stub Name', 'password' => bcrypt('password')]
        );

        $team->users()->syncWithoutDetaching([
            $user->id => ['role' => 'member']
        ]);

        // Send stubbed email via service
        $this->invitationService->sendInviteEmail($user, $team);

        return [
            'message' => 'User invited (email logic stubbed)',
            'user_id' => $user->id
        ];
    }
}
