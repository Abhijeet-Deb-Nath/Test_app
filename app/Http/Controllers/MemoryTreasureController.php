<?php

namespace App\Http\Controllers;

use App\Models\MemoryComment;
use App\Models\MemoryReflection;
use App\Models\MemoryTreasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemoryTreasureController extends Controller
{
    /**
     * Display the memory gallery.
     */
    public function index()
    {
        $user = Auth::user();
        $couple = $user->couple();

        if (!$couple) {
            return redirect()->route('dashboard')->with('error', 'You need to be in a couple to access memories.');
        }

        $memories = $couple->memories()->with(['creator', 'reflections.author'])->paginate(12);

        return view('memories.index', compact('couple', 'memories'));
    }

    /**
     * Show the form for creating a new memory.
     */
    public function create()
    {
        $user = Auth::user();
        $couple = $user->couple();

        if (!$couple) {
            return redirect()->route('dashboard')->with('error', 'You need to be in a couple to create memories.');
        }

        return view('memories.create', compact('couple'));
    }

    /**
     * Store a newly created memory.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $couple = $user->couple();

        if (!$couple) {
            return redirect()->route('dashboard')->with('error', 'You need to be in a couple to create memories.');
        }

        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:5000',
            'story_date' => 'required|date|before_or_equal:today',
            'media_type' => 'required|in:text,image,audio,video',
            'media_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp3,wav,ogg,mp4,avi,mov,wmv|max:102400', // Max 100MB
        ]);

        $mediaPath = null;

        // Handle file upload if media is provided
        if ($request->hasFile('media_file') && in_array($validated['media_type'], ['image', 'audio', 'video'])) {
            $file = $request->file('media_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $mediaPath = $file->storeAs('memories/' . $validated['media_type'], $filename, 'public');
        }

        $memory = MemoryTreasure::create([
            'couple_id' => $couple->id,
            'created_by' => $user->id,
            'heading' => $validated['heading'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'story_date' => $validated['story_date'],
            'media_type' => $validated['media_type'],
            'media_path' => $mediaPath,
        ]);

        return redirect()->route('memories.show', $memory)->with('success', 'Memory treasure created! 📸💕');
    }

    /**
     * Display a specific memory with reflections.
     */
    public function show(MemoryTreasure $memory)
    {
        $user = Auth::user();
        $couple = $user->couple();

        // Verify the memory belongs to the user's couple
        if (!$couple || $memory->couple_id !== $couple->id) {
            abort(403);
        }

        $memory->load(['creator', 'reflections.author', 'reflections.comments.author', 'comments.author']);

        return view('memories.show', compact('memory', 'couple'));
    }

    /**
     * Store a reflection (nostalgic thought) for a memory.
     */
    public function storeReflection(Request $request, MemoryTreasure $memory)
    {
        $user = Auth::user();
        $couple = $user->couple();

        // Verify the memory belongs to the user's couple
        if (!$couple || $memory->couple_id !== $couple->id) {
            abort(403);
        }

        $validated = $request->validate([
            'reflection_text' => 'required|string|max:2000',
        ]);

        MemoryReflection::create([
            'memory_treasure_id' => $memory->id,
            'user_id' => $user->id,
            'reflection_text' => $validated['reflection_text'],
        ]);

        return redirect()->route('memories.show', $memory)->with('success', 'Reflection added! 💭✨');
    }

    /**
     * Remove a memory treasure.
     */
    public function destroy(MemoryTreasure $memory)
    {
        $user = Auth::user();
        $couple = $user->couple();

        // Verify the memory belongs to the user's couple
        if (!$couple || $memory->couple_id !== $couple->id) {
            abort(403);
        }

        // Only the creator can delete the memory
        if ($memory->created_by !== $user->id) {
            return redirect()->route('memories.index')->with('error', 'Only the creator can delete this memory.');
        }

        $memory->delete();

        return redirect()->route('memories.index')->with('success', 'Memory treasure deleted.');
    }

    /**
     * Store a comment on a memory.
     */
    public function storeMemoryComment(Request $request, MemoryTreasure $memory)
    {
        $user = Auth::user();
        $couple = $user->couple();

        // Verify the memory belongs to the user's couple
        if (!$couple || $memory->couple_id !== $couple->id) {
            abort(403);
        }

        $validated = $request->validate([
            'comment_text' => 'required|string|max:1000',
        ]);

        MemoryComment::create([
            'user_id' => $user->id,
            'commentable_id' => $memory->id,
            'commentable_type' => MemoryTreasure::class,
            'comment_text' => $validated['comment_text'],
        ]);

        return redirect()->route('memories.show', $memory)->with('success', 'Comment added! 💬');
    }

    /**
     * Store a comment on a reflection.
     */
    public function storeReflectionComment(Request $request, MemoryReflection $reflection)
    {
        $user = Auth::user();
        $couple = $user->couple();
        $memory = $reflection->memoryTreasure;

        // Verify the reflection belongs to the user's couple
        if (!$couple || $memory->couple_id !== $couple->id) {
            abort(403);
        }

        $validated = $request->validate([
            'comment_text' => 'required|string|max:1000',
        ]);

        MemoryComment::create([
            'user_id' => $user->id,
            'commentable_id' => $reflection->id,
            'commentable_type' => MemoryReflection::class,
            'comment_text' => $validated['comment_text'],
        ]);

        return redirect()->route('memories.show', $memory)->with('success', 'Comment added! 💬');
    }

    /**
     * Delete a comment.
     */
    public function destroyComment(MemoryComment $comment)
    {
        $user = Auth::user();

        // Only the comment author can delete it
        if ($comment->user_id !== $user->id) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }

    /**
     * Delete a reflection.
     */
    public function destroyReflection(MemoryReflection $reflection)
    {
        $user = Auth::user();
        $couple = $user->couple();
        $memory = $reflection->memoryTreasure;

        // Verify the reflection belongs to the user's couple
        if (!$couple || $memory->couple_id !== $couple->id) {
            abort(403);
        }

        // Only the reflection author can delete it
        if ($reflection->user_id !== $user->id) {
            abort(403);
        }

        $reflection->delete();

        return redirect()->route('memories.show', $memory)->with('success', 'Reflection deleted.');
    }
}
