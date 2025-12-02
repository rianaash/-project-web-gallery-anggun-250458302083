<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Photo;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Bookmark;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class PhotoInteraction extends Component
{
    public $photo;
    public $content;
    
    // Reply
    public $replyingTo = null;
    public $replyContent = '';

    // Report
    public $reportReason = '';
    public $showReportModal = false;

    public function mount($photoId)
    {
        $this->photo = Photo::with(['comments.user', 'comments.replies.user', 'likes'])->find($photoId);
    }

    public function render()
    {
        $comments = $this->photo->comments()
            ->whereNull('parent_comment_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return view('livewire.photo-interaction', ['comments' => $comments]);
    }

    // like
    public function toggleLike()
    {
        if (!Auth::check()) return redirect()->route('login');
        $userId = Auth::id();
        $existing = Like::where('user_id', $userId)->where('photo_id', $this->photo->id)->first();
        if ($existing) $existing->delete();
        else Like::create(['user_id' => $userId, 'photo_id' => $this->photo->id]);
        $this->photo->refresh();
    }

    // komentar
    public function submitComment()
    {
        $this->validate(['content' => 'required|min:1']);
        if (!Auth::check()) return redirect()->route('login');
        Comment::create([
            'user_id' => Auth::id(),
            'photo_id' => $this->photo->id,
            'content' => $this->content,
        ]);
        $this->content = ''; 
        $this->photo->refresh();
    }

    // reply
    public function setReply($commentId) {
        $this->replyingTo = $commentId;
        $this->replyContent = '@' . Comment::find($commentId)->user->name . ' ';
    }
    public function cancelReply() {
        $this->replyingTo = null;
        $this->replyContent = '';
    }
    public function submitReply() {
        $this->validate(['replyContent' => 'required|min:1']);
        if (!Auth::check()) return redirect()->route('login');
        Comment::create([
            'user_id' => Auth::id(),
            'photo_id' => $this->photo->id,
            'content' => $this->replyContent,
            'parent_comment_id' => $this->replyingTo
        ]);
        $this->replyingTo = null;
        $this->photo->refresh();
    }

    // bookmark
    public function toggleBookmark()
    {
        if (!Auth::check()) return redirect()->route('login');
        $userId = Auth::id();
        $exist = Bookmark::where('user_id', $userId)->where('photo_id', $this->photo->id)->first();
        if ($exist) $exist->delete();
        else Bookmark::create(['user_id' => $userId, 'photo_id' => $this->photo->id]);
        $this->photo->refresh();
    }

    // report
    public function submitReport()
    {
        $this->validate(['reportReason' => 'required|min:5']);
        if (!Auth::check()) return redirect()->route('login');
        
        // Simpan ke Database (CRUD Create untuk Report)
        Report::create([
            'reporter_user_id' => Auth::id(), 
            'reported_photo_id' => $this->photo->id,
            'reason' => $this->reportReason,
            'status' => 'pending'
        ]);

        $this->showReportModal = false;
        $this->reportReason = '';
        
        // Kirim pesan sukses ke browser (Flash Message)
        session()->flash('report_success', 'Laporan berhasil dikirim. Terima kasih telah membantu menjaga komunitas kami!');
    }
}