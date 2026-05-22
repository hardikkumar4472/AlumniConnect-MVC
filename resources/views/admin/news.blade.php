@extends('layouts.app')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Campus News Management</h2>
        <p>Manage announcements and news for students</p>
    </div>
    <button onclick="document.getElementById('addModal').style.display='flex'" style="padding: 0.8rem 1.5rem; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
        <i class="fa-solid fa-plus"></i> Add News
    </button>
</div>

@if(session('success'))
    <div style="padding: 1rem; background: #c6f6d5; color: #2f855a; border-radius: 8px; margin-bottom: 1rem;">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="padding: 0; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 1rem;">Title</th>
                <th style="padding: 1rem;">Date</th>
                <th style="padding: 1rem;">Snippet</th>
                <th style="padding: 1rem; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($news as $item)
            <tr style="border-bottom: 1px solid #e2e8f0;">
                <td style="padding: 1rem; font-weight: 600;">{{ $item->title }}</td>
                <td style="padding: 1rem;">{{ $item->date }}</td>
                <td style="padding: 1rem; color: #718096; font-size: 0.9rem;">{{ Str::limit($item->content, 50) }}</td>
                <td style="padding: 1rem; text-align: right;">
                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button onclick="editNews('{{ $item->_id }}', '{{ addslashes($item->title) }}', '{{ addslashes($item->date) }}', '{{ addslashes($item->content) }}')" style="padding: 0.5rem 1rem; background: #ebf8ff; color: #3182ce; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                            Edit
                        </button>
                        <form action="{{ route('admin.news.delete', $item->_id) }}" method="POST" onsubmit="return confirm('Delete this news?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 0.5rem 1rem; background: #fff5f5; color: #e53e3e; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px;">
        <h3 style="margin-top: 0;">Add Campus News</h3>
        <form action="{{ route('admin.news.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label>Title</label>
                <input type="text" name="title" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px; margin-top: 0.5rem;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label>Date (e.g. Oct 12, 2026)</label>
                <input type="text" name="date" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px; margin-top: 0.5rem;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label>Content</label>
                <textarea name="content" required rows="4" style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px; margin-top: 0.5rem;"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('addModal').style.display='none'" style="padding: 0.8rem 1.5rem; background: #e2e8f0; color: #4a5568; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Cancel</button>
                <button type="submit" style="padding: 0.8rem 1.5rem; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Save News</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px;">
        <h3 style="margin-top: 0;">Edit Campus News</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 1rem;">
                <label>Title</label>
                <input type="text" name="title" id="edit_title" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px; margin-top: 0.5rem;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label>Date</label>
                <input type="text" name="date" id="edit_date" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px; margin-top: 0.5rem;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label>Content</label>
                <textarea name="content" id="edit_content" required rows="4" style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px; margin-top: 0.5rem;"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('editModal').style.display='none'" style="padding: 0.8rem 1.5rem; background: #e2e8f0; color: #4a5568; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Cancel</button>
                <button type="submit" style="padding: 0.8rem 1.5rem; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Update News</button>
            </div>
        </form>
    </div>
</div>

<script>
function editNews(id, title, date, content) {
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_date').value = date;
    document.getElementById('edit_content').value = content;
    document.getElementById('editForm').action = '/admin/news/' + id;
    document.getElementById('editModal').style.display = 'flex';
}
</script>
@endsection
