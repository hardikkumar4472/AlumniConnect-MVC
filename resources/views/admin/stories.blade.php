@extends('layouts.app')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Success Stories Management</h2>
        <p>Manage and highlight alumni success stories.</p>
    </div>
    <button onclick="document.getElementById('addStoryModal').style.display='block'" class="hero-btn" style="border:none; cursor:pointer;">Add Story</button>
</div>

@if(session('success'))
    <div style="background: #c6f6d5; color: #2f855a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="margin-top: 2rem;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #f1f5f9; color: #718096; font-size: 0.85rem; background: #f8fafc;">
                <th style="padding: 1.5rem;">AUTHOR / TITLE</th>
                <th style="padding: 1.5rem;">CONTENT SNIPPET</th>
                <th style="padding: 1.5rem;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stories as $story)
            <tr style="border-bottom: 1px solid #f8fafc;">
                <td style="padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ $story->image ?? 'https://ui-avatars.com/api/?name='.urlencode($story->author).'&background=random' }}" style="width:40px; height:40px; border-radius:50%;">
                        <div>
                            <span style="font-weight: 700;">{{ $story->title }}</span><br>
                            <span style="font-size: 0.85rem; color: #718096;">{{ $story->author }}</span>
                        </div>
                    </div>
                </td>
                <td style="padding: 1.5rem; color: #4a5568;">{{ Str::limit($story->content, 80) }}</td>
                <td style="padding: 1.5rem; display: flex; gap: 10px;">
                    <button onclick="document.getElementById('editStoryModal-{{ $story->id }}').style.display='flex'" style="background:none; border:none; color:#3182ce; cursor:pointer;"><i class="fa-solid fa-pen"></i></button>
                    <form action="{{ route('admin.stories.delete', $story->id) }}" method="POST" onsubmit="return confirm('Delete this story?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#e53e3e; cursor:pointer;"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div id="editStoryModal-{{ $story->id }}" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:2000; align-items:center; justify-content:center;">
                <div class="card" style="width: 500px; padding: 2rem;">
                    <h3>Edit Story</h3>
                    <form action="{{ route('admin.stories.update', $story->id) }}" method="POST" style="margin-top: 1.5rem;">
                        @csrf
                        @method('PUT')
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label>Title</label>
                            <input type="text" name="title" value="{{ $story->title }}" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label>Author</label>
                            <input type="text" name="author" value="{{ $story->author }}" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label>Image URL</label>
                            <input type="url" name="image" value="{{ $story->image }}" style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label>Content</label>
                            <textarea name="content" required rows="4" style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">{{ $story->content }}</textarea>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="hero-btn" style="flex: 1; border:none; cursor:pointer;">Save Changes</button>
                            <button type="button" onclick="document.getElementById('editStoryModal-{{ $story->id }}').style.display='none'" class="social-btn" style="flex: 1; padding:0.8rem; border:1px solid #cbd5e0; border-radius:8px; background:white; cursor:pointer;">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addStoryModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:2000; align-items:center; justify-content:center;">
    <div class="card" style="width: 500px; padding: 2rem;">
        <h3>Add New Story</h3>
        <form action="{{ route('admin.stories.store') }}" method="POST" style="margin-top: 1.5rem;">
            @csrf
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Title</label>
                <input type="text" name="title" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Author</label>
                <input type="text" name="author" required style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div class="form-group" style="margin-bottom: 1rem;">
                <label>Image URL (Optional)</label>
                <input type="url" name="image" style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;">
            </div>
            <div class="form-group" style="margin-bottom: 2rem;">
                <label>Content</label>
                <textarea name="content" required rows="4" style="width:100%; padding:0.8rem; border-radius:8px; border:1px solid #e2e8f0;"></textarea>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="hero-btn" style="flex: 1; border:none; cursor:pointer;">Add Story</button>
                <button type="button" onclick="document.getElementById('addStoryModal').style.display='none'" class="social-btn" style="flex: 1; padding:0.8rem; border:1px solid #cbd5e0; border-radius:8px; background:white; cursor:pointer;">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
