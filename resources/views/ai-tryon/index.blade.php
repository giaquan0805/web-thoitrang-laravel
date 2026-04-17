@extends('layouts.app')

@section('title', 'Thử đồ AI - ' . $product->name)

@section('content')

<div class="container" style="padding: 40px 15px; max-width: 900px;">

    <h2 style="margin-bottom: 5px;">✨ Thử đồ AI</h2>
    <p style="color: #666; margin-bottom: 30px;">Upload ảnh của bạn để thử trang phục này</p>

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">

        {{-- Ảnh sản phẩm --}}
        <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <h4 style="margin-bottom: 15px;">👗 Sản phẩm</h4>
            <img src="{{ product_image($product->thumbnail_url) }}"
                 alt="{{ $product->name }}"
                 style="width: 100%; border-radius: 8px; object-fit: cover;">
            <h3 style="margin-top: 15px;">{{ $product->name }}</h3>
            <p style="color: #e44; font-weight: bold; font-size: 18px;">{{ number_format($product->price, 0, ',', '.') }}đ</p>
        </div>

        {{-- Form upload ảnh --}}
        <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <h4 style="margin-bottom: 15px;">📸 Ảnh của bạn</h4>

            <form action="{{ route('ai.process') }}" method="POST" enctype="multipart/form-data" id="tryonForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                {{-- Upload ảnh --}}
                <div style="border: 2px dashed #ddd; border-radius: 8px; padding: 30px; text-align: center; margin-bottom: 20px; cursor: pointer;"
                     onclick="document.getElementById('user_image').click()">
                    <img id="preview" src="" alt=""
                         style="display: none; width: 100%; border-radius: 8px; margin-bottom: 10px;">
                    <div id="upload-placeholder">
                        <div style="font-size: 48px; margin-bottom: 10px;">📷</div>
                        <p style="color: #666;">Click để chọn ảnh</p>
                        <p style="color: #999; font-size: 13px;">JPG, PNG - Tối đa 5MB</p>
                    </div>
                </div>
                <input type="file" id="user_image" name="user_image"
                       accept="image/jpg,image/jpeg,image/png"
                       style="display: none;"
                       onchange="previewImage(this)">

                {{-- Hướng dẫn --}}
                <div style="background: #f0f8ff; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <p style="font-weight: bold; margin-bottom: 8px;">📋 Yêu cầu ảnh:</p>
                    <ul style="color: #555; font-size: 13px; padding-left: 20px; line-height: 1.8;">
                        <li>Ảnh chụp toàn thân hoặc nửa người</li>
                        <li>Nền đơn giản, ánh sáng tốt</li>
                        <li>Đứng thẳng, nhìn thẳng vào camera</li>
                        <li>Định dạng JPG hoặc PNG</li>
                    </ul>
                </div>

                <button type="submit" id="submitBtn"
                        style="width: 100%; padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; font-weight: bold;">
                    ✨ Thử đồ ngay
                </button>
            </form>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
            document.getElementById('upload-placeholder').style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('tryonForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '⏳ Đang xử lý... (30-60 giây)';
    btn.disabled = true;
    btn.style.background = '#999';
});
</script>
@endpush