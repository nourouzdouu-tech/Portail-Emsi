<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Media;
use App\Models\User;
use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SocialController extends Controller
{
   public function index()
{
    $user = Auth::user();

    return view('RéseauSocial', [
        'groups' => Group::accessibleBy($user)->with('members')->get(),
        'medias' => Media::accessibleBy($user)->latest()->get(),
        'friendRequests' => $user->receivedFriendRequests()
            ->with('sender')
            ->where('status', FriendRequest::STATUS_PENDING)
            ->get(),
        'friends' => $user->friends()->get(),
    ]);
}


    // GROUPES
    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:public,private',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'owner_id' => Auth::id(),
        ]);

        $group->members()->attach(Auth::id());

        return response()->json(['success' => true]);
    }

    public function deleteGroup($id)
    {
        $group = Group::findOrFail($id);

        if ($group->owner_id !== Auth::id()) {
            abort(403);
        }

        $group->members()->detach();
        $group->delete();

        return response()->json(['success' => true]);
    }

    // MÉDIAS
   public function uploadMedia(Request $request)
{
    $request->validate([
        'file' => 'required|file|max:10240',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'group_id' => 'nullable|exists:groups,id',
        'is_public' => 'boolean', // Ajoutez ce champ
    ]);

    $file = $request->file('file');
    $path = $file->store('media', 'public');

    Media::create([
        'title' => $request->title,
        'description' => $request->description,
        'file_path' => $path,
        'file_type' => $file->getMimeType(),
        'file_size' => $file->getSize(),
        'user_id' => Auth::id(),
        'group_id' => $request->group_id,
        'is_public' => $request->input('is_public', false), // Par défaut à false
    ]);

    return response()->json(['success' => true]);
}
    public function deleteMedia($id)
    {
        $media = Media::findOrFail($id);

        if ($media->user_id !== Auth::id()) {
            abort(403);
        }

        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return response()->json(['success' => true]);
    }

    // AMIS
    public function searchFriends(Request $request)
    {
        $query = $request->input('q');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $user = Auth::user();

        $users = User::where('id', '!=', $user->id)
            ->whereNotIn('id', $user->friends->pluck('id'))
            ->whereDoesntHave('receivedFriendRequests', function ($q) use ($user) {
                $q->where('sender_id', $user->id);
            })
            ->whereDoesntHave('sentFriendRequests', function ($q) use ($user) {
                $q->where('receiver_id', $user->id);
            })
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    public function sendFriendRequest(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id|not_in:' . Auth::id(),
        ]);

        $exists = FriendRequest::where(function ($q) use ($request) {
            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $request->receiver_id);
        })->orWhere(function ($q) use ($request) {
            $q->where('sender_id', $request->receiver_id)
              ->where('receiver_id', Auth::id());
        })->exists();

        if ($exists) {
            return response()->json(['error' => 'Une demande existe déjà.'], 400);
        }

        FriendRequest::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'status' => FriendRequest::STATUS_PENDING,
        ]);

        return response()->json(['success' => true]);
    }

    public function respondToRequest(Request $request, $id)
    {
        $friendRequest = FriendRequest::findOrFail($id);

        if ($friendRequest->receiver_id !== Auth::id()) {
            abort(403);
        }

        if ($friendRequest->status !== FriendRequest::STATUS_PENDING) {
            return response()->json(['error' => 'Cette demande a déjà été traitée.'], 400);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $friendRequest->update(['status' => $request->status]);

        if ($request->status === FriendRequest::STATUS_ACCEPTED) {
            Auth::user()->friends()->attach($friendRequest->sender_id);
            User::find($friendRequest->sender_id)->friends()->attach(Auth::id());
        }

        return response()->json(['success' => true]);
    }

    public function removeFriend($id)
    {
        $user = Auth::user();

        if (!$user->friends()->where('friend_id', $id)->exists()) {
            abort(404);
        }

        $user->friends()->detach($id);
        User::find($id)->friends()->detach($user->id);

        return response()->json(['success' => true]);
    }


    // Pour rejoindre un groupe public
public function joinGroup(Request $request, $groupId)
{
    $group = Group::findOrFail($groupId);
    
    if ($group->type !== 'public') {
        return response()->json(['error' => 'Ce groupe est privé'], 403);
    }
    
    if ($group->members()->where('user_id', Auth::id())->exists()) {
        return response()->json(['error' => 'Vous êtes déjà membre'], 400);
    }
    
    $group->members()->attach(Auth::id());
    
    return response()->json(['success' => true]);
}

// Pour les groupes publics seulement
public function publicGroups()
{
    $groups = Group::public()->with('members')->get();
    return response()->json($groups);
}

// Pour les médias publics seulement
public function publicMedia()
{
    $media = Media::public()->with(['user', 'group'])->latest()->get();
    return response()->json($media);
}

public function sendMessage(Request $request, $friendId)
{
    $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    try {
        $friend = User::findOrFail($friendId);

        if (!auth()->user()->friends()->where('friend_id', $friendId)->exists()) {
            return response()->json([
                'error' => 'Vous ne pouvez envoyer des messages qu\'à vos amis'
            ], 403);
        }

        $message = auth()->user()->sentMessages()->create([
            'receiver_id' => $friendId,
            'content' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message envoyé avec succès!',
            'data' => $message
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Une erreur est survenue: ' . $e->getMessage()
        ], 500);
    }
}

// Récupérer les messages avec un ami
public function getMessages($friendId)
{
    $friend = User::findOrFail($friendId);

    if (!auth()->user()->friends()->where('friend_id', $friendId)->exists()) {
        return response()->json(['error' => 'Accès non autorisé'], 403);
    }

    $messages = auth()->user()->messagesWith($friendId)
                    ->orderBy('created_at', 'asc')
                    ->get();

    return response()->json($messages);
}

public function indexRecrut()
{
    $user = Auth::user();

    return view('RéseauSocialRecrut', [
        'groups' => Group::accessibleBy($user)->with('members')->get(),
        'medias' => Media::accessibleBy($user)->latest()->get(),
        'friendRequests' => $user->receivedFriendRequests()
            ->with('sender')
            ->where('status', FriendRequest::STATUS_PENDING)
            ->get(),
        'friends' => $user->friends()->get(),
    ]);
}



}
