@extends('admin.layouts.app')

@section('title', 'Quản lý danh mục')
@section('page-title', 'Quản lý danh mục')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 20px;">

    {{-- Form thêm danh mục --}}
    <div class="card">
        <div class="card-header">
            <h5>➕ Thêm danh mục mới</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tên danh mục</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" placeholder="vd: Nam, Nữ, Trẻ em">
                    @error('name')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control"
                           value="{{ old('slug') }}" placeholder="vd: nam, nu, tre-em">
                    @error('slug')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Mô tả danh mục...">{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">💾 Lưu danh mục</button>
            </form>
        </div>
    </div>

    {{-- Danh sách danh mục --}}
    <div class="card">
        <div class="card-header">
            <h5>🏷️ Danh sách danh mục</h5>
        </div>
        <div class="card-body" style="padding: 0;">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th>Số SP</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td>#{{ $cat->id }}</td>
                        <td>{{ $cat->name }}</td>
                        <td><span style="color: #666; font-size: 13px;">{{ $cat->slug }}</span></td>
                        <td>{{ $cat->products_count }}</td>
                        <td style="display: flex; gap: 8px;">
                            <button onclick="editCategory({{ $cat->id }}, '{{ $cat->name }}', '{{ $cat->slug }}', '{{ $cat->description }}')"
                                class="btn btn-sm btn-warning">Sửa</button>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                  onsubmit="return confirm('Xóa danh mục này? Các sản phẩm liên quan cũng sẽ bị xóa!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">Chưa có danh mục nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal sửa danh mục --}}
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:10px; width:400px;">
        <h4 style="margin-bottom:20px;">✏️ Sửa danh mục</h4>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Tên danh mục</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" id="edit_slug" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
            </div>
            <div style="display:flex; gap:10px; margin-top:15px;">
                <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
                <button type="button" onclick="closeModal()" class="btn" style="background:#eee; color:#333;">Hủy</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editCategory(id, name, slug, description) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_description').value = description || '';
    document.getElementById('editForm').action = '/admin/categories/' + id;
    document.getElementById('editModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>
@endpush