@extends('admin.layouts.app')

@section('title', 'Quản lý danh mục')
@section('page-title', 'Quản lý danh mục')

@section('content')

<div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 20px;">

    {{-- Form thêm danh mục --}}
    <div class="card">
        <div class="card-header">
            <h5><i class="fa-solid fa-plus" style="color: #28a745;"></i> Thêm danh mục mới</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Tên danh mục</label>
                    <input type="text" name="name" id="add_name" class="form-control"
                           value="{{ old('name') }}" placeholder="vd: Nam, Nữ, Trẻ em"
                           oninput="generateSlug(this.value, 'add_slug')">
                    @error('name')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                </div>
                <div class="form-group" style="display: none;">
                    <input type="text" name="slug" id="add_slug" class="form-control"
                           value="{{ old('slug') }}">
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Mô tả danh mục...">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label><i class="fa-regular fa-image" style="color: #1976d2;"></i> Banner danh mục</label>
                    <input type="file" name="banner" class="form-control" accept="image/*"
                           onchange="previewBanner(this, 'add_preview')">
                    @error('banner')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                    <div id="add_preview" style="margin-top: 10px;"></div>
                    <p style="font-size: 12px; color: #999; margin-top: 5px;">Khuyến nghị: 600x400px, tối đa 2MB (JPG, PNG, WebP)</p>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu danh mục
                </button>
            </form>
        </div>
    </div>

    {{-- Danh sách danh mục --}}
    <div class="card">
        <div class="card-header">
            <h5><i class="fa-solid fa-tags" style="color: #7b1fa2;"></i> Danh sách danh mục</h5>
        </div>
        <div class="card-body" style="padding: 0;">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Banner</th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th>Mô tả</th>
                        <th>Số SP</th>
                        <th style="text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td>#{{ $cat->id }}</td>
                        <td>
                            @if($cat->banner_url)
                                <img src="{{ asset('storage/' . $cat->banner_url) }}" alt="banner"
                                     style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span style="color: #ccc; font-size: 12px;">Chưa có</span>
                            @endif
                        </td>
                        <td style="font-weight: 500;">{{ $cat->name }}</td>
                        <td><span style="color: #666; font-size: 13px;">{{ $cat->slug }}</span></td>
                        <td><span style="color: #888; font-size: 13px;">{{ Str::limit($cat->description, 40) ?: '—' }}</span></td>
                        <td>{{ $cat->products_count }}</td>
                        <td style="text-align: center; white-space: nowrap;">
                            <button onclick="editCategory({{ $cat->id }}, '{{ $cat->name }}', '{{ $cat->slug }}', '{{ addslashes($cat->description) }}', '{{ $cat->banner_url }}')"
                                class="btn btn-sm btn-warning">Sửa</button>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                  onsubmit="return confirm('Xóa danh mục này? Các sản phẩm liên quan cũng sẽ bị xóa!')"
                                  style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #999;">Chưa có danh mục nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal sửa danh mục --}}
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:10px; width:450px; max-height:90vh; overflow-y:auto;">
        <h4 style="margin-bottom:20px;"><i class="fa-solid fa-pen-to-square" style="color: #f57c00;"></i> Sửa danh mục</h4>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Tên danh mục</label>
                <input type="text" name="name" id="edit_name" class="form-control" required
                       oninput="generateSlug(this.value, 'edit_slug')">
            </div>
            <div class="form-group" style="display: none;">
                <input type="text" name="slug" id="edit_slug" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label><i class="fa-regular fa-image" style="color: #1976d2;"></i> Banner danh mục</label>
                <div id="edit_current_banner" style="margin-bottom: 10px;"></div>
                <input type="file" name="banner" class="form-control" accept="image/*"
                       onchange="previewBanner(this, 'edit_new_preview')">
                <div id="edit_new_preview" style="margin-top: 10px;"></div>
                <div id="edit_remove_banner_wrap" style="margin-top: 8px; display: none;">
                    <label style="font-size: 13px; color: #dc3545; cursor: pointer;">
                        <input type="checkbox" name="remove_banner" value="1"> Xóa banner hiện tại
                    </label>
                </div>
            </div>
            <div style="display:flex; gap:10px; margin-top:15px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i> Cập nhật
                </button>
                <button type="button" onclick="closeModal()" class="btn" style="background:#eee; color:#333;">Hủy</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Tự động tạo slug từ tên (hỗ trợ tiếng Việt)
function generateSlug(text, targetId) {
    var slug = text.toLowerCase().trim();

    // Chuyển tiếng Việt sang không dấu
    var vietnameseMap = {
        'à':'a','á':'a','ạ':'a','ả':'a','ã':'a','â':'a','ầ':'a','ấ':'a','ậ':'a','ẩ':'a','ẫ':'a','ă':'a','ằ':'a','ắ':'a','ặ':'a','ẳ':'a','ẵ':'a',
        'è':'e','é':'e','ẹ':'e','ẻ':'e','ẽ':'e','ê':'e','ề':'e','ế':'e','ệ':'e','ể':'e','ễ':'e',
        'ì':'i','í':'i','ị':'i','ỉ':'i','ĩ':'i',
        'ò':'o','ó':'o','ọ':'o','ỏ':'o','õ':'o','ô':'o','ồ':'o','ố':'o','ộ':'o','ổ':'o','ỗ':'o','ơ':'o','ờ':'o','ớ':'o','ợ':'o','ở':'o','ỡ':'o',
        'ù':'u','ú':'u','ụ':'u','ủ':'u','ũ':'u','ư':'u','ừ':'u','ứ':'u','ự':'u','ử':'u','ữ':'u',
        'ỳ':'y','ý':'y','ỵ':'y','ỷ':'y','ỹ':'y',
        'đ':'d'
    };

    slug = slug.split('').map(function(char) {
        return vietnameseMap[char] || char;
    }).join('');

    // Thay khoảng trắng và ký tự đặc biệt bằng dấu gạch ngang
    slug = slug.replace(/[^a-z0-9\s-]/g, '');
    slug = slug.replace(/[\s]+/g, '-');
    slug = slug.replace(/-+/g, '-');
    slug = slug.replace(/^-|-$/g, '');

    document.getElementById(targetId).value = slug;
}

function editCategory(id, name, slug, description, bannerUrl) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_slug').value = slug;
    document.getElementById('edit_description').value = description || '';
    document.getElementById('editForm').action = '/admin/categories/' + id;

    // Hiển thị banner hiện tại
    var currentBanner = document.getElementById('edit_current_banner');
    var removeBannerWrap = document.getElementById('edit_remove_banner_wrap');
    document.getElementById('edit_new_preview').innerHTML = '';

    if (bannerUrl) {
        currentBanner.innerHTML = '<img src="/storage/' + bannerUrl + '" style="width:100%; max-height:150px; object-fit:cover; border-radius:6px;">' +
            '<p style="font-size:12px; color:#666; margin-top:5px;">Banner hiện tại</p>';
        removeBannerWrap.style.display = 'block';
    } else {
        currentBanner.innerHTML = '<p style="font-size:13px; color:#999;">Chưa có banner</p>';
        removeBannerWrap.style.display = 'none';
    }

    // Reset checkbox xóa banner
    var removeCheckbox = removeBannerWrap.querySelector('input[type="checkbox"]');
    if (removeCheckbox) removeCheckbox.checked = false;

    document.getElementById('editModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

function previewBanner(input, previewId) {
    var preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="width:100%; max-height:150px; object-fit:cover; border-radius:6px;">';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = '';
    }
}
</script>
@endpush