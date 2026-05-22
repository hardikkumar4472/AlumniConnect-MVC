@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <a href="{{ route('admin.dashboard') }}" style="color: #0047ab; text-decoration: none; font-size: 0.9rem; font-weight: 600;"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
    <h2 style="margin-top: 1rem;">Resource Management</h2>
    <p>Manage learning materials, guides, and templates for the alumni network.</p>
</div>

@if(session('success'))
    <div style="background: #c6f6d5; color: #2f855a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
@endif

<div class="card" style="padding: 2rem; margin-bottom: 2rem;">
    <h3 style="margin-bottom: 1rem;">Add New Resource</h3>
    <form action="{{ route('admin.resources.store') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Title</label>
                <input type="text" name="title" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Type</label>
                <input type="text" name="type" placeholder="e.g. Guide, Video, Template" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
        </div>
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Link (URL)</label>
            <input type="url" name="link" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
            <textarea name="description" rows="3" required style="width: 100%; padding: 0.8rem; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
        </div>
        <button type="submit" class="hero-btn" style="border: none; cursor: pointer;">Add Resource</button>
    </form>
</div>

<div class="card" style="padding: 2rem;">
    <h3 style="margin-bottom: 1.5rem;">Existing Resources</h3>
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        @forelse($resources as $resource)
        <div style="padding: 1.5rem; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="font-size: 1.1rem; color: #061a3d; margin-bottom: 0.3rem;">{{ $resource->title }}</h4>
                <p style="font-size: 0.85rem; color: #718096; margin-bottom: 0.5rem;"><span style="background: #e2e8f0; padding: 2px 8px; border-radius: 12px;">{{ $resource->type }}</span> • <a href="{{ $resource->link }}" target="_blank">View Link</a></p>
                <p style="font-size: 0.9rem; color: #4a5568;">{{ $resource->description }}</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <button onclick="document.getElementById('edit-{{ $resource->_id }}').style.display='block'" style="background: #e2e8f0; color: #4a5568; padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Edit</button>
                <form action="{{ route('admin.resources.delete', $resource->_id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to delete this resource?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: #fc8181; color: white; padding: 0.5rem 1rem; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Delete</button>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="edit-{{ $resource->_id }}" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
            <div style="background: white; max-width: 600px; margin: 5% auto; padding: 2rem; border-radius: 12px;">
                <h3 style="margin-bottom: 1.5rem;">Edit Resource</h3>
                <form action="{{ route('admin.resources.update', $resource->_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div style="margin-bottom: 1rem;">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $resource->title }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px;">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label>Type</label>
                        <input type="text" name="type" value="{{ $resource->type }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px;">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label>Link</label>
                        <input type="url" name="link" value="{{ $resource->link }}" required style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px;">
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label>Description</label>
                        <textarea name="description" required rows="3" style="width: 100%; padding: 0.8rem; border: 1px solid #cbd5e0; border-radius: 8px;">{{ $resource->description }}</textarea>
                    </div>
                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button type="button" onclick="document.getElementById('edit-{{ $resource->_id }}').style.display='none'" style="padding: 0.8rem 1.5rem; border: 1px solid #cbd5e0; background: white; border-radius: 8px; cursor: pointer;">Cancel</button>
                        <button type="submit" class="hero-btn" style="border: none; cursor: pointer;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <p style="text-align: center; color: #718096; padding: 2rem;">No resources found.</p>
        @endforelse
    </div>
</div>
@endsection
