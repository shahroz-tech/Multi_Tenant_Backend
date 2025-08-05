<?php

namespace App\Http\Controllers\Api\V1\Team;

use App\Actions\Team\StoreTeamAction;
use App\Actions\Team\DeleteTeamAction;
use App\Actions\Team\RestoreTeamAction;
use App\Actions\Team\UpdateTeamAction;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function index()
    {
        return auth()->user()->teams;
    }

    public function store(Request $request, StoreTeamAction $action)
    {
        $validator = Validator::make($request->all(), [
            'team_name' => 'required|string|max:255',
            'team_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $team = $action->execute($validator->validated());

        return response()->json([
            'message' => 'Team created successfully.',
            'team' => $team
        ], 201);
    }

    public function show(string $id)
    {
        return Team::with('users', 'owner')->findOrFail($id);
    }

    public function update(Request $request, string $id, UpdateTeamAction $action)
    {
        $validator = Validator::make($request->all(), [
            'team_name' => 'required|string|max:255',
            'team_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $team = $action->execute((int) $id, $validator->validated());

        return response()->json([
            'message' => 'Team updated successfully.',
            'team' => $team
        ]);
    }

    public function destroy(string $id, DeleteTeamAction $action)
    {
        $action->execute((int) $id);

        return response()->json([
            'message' => 'Team deleted successfully.'
        ]);
    }

    public function restore(string $id, RestoreTeamAction $action)
    {
        $team = $action->execute((int) $id);

        return response()->json([
            'message' => 'Team restored successfully.',
            'team' => $team
        ]);
    }

}
