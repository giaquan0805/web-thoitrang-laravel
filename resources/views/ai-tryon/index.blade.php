@extends('layouts.app')

@section('title', 'Thử đồ AI - ' . $product->name)

@section('content')

<div class="container" style="padding: 40px 15px; max-width: 950px;">

    {{-- Header --}}
    <div style="text-align: center; margin-bottom: 35px;">
        <h2 style="font-size: 26px; margin-bottom: 8px;">
            <i class="fa-solid fa-wand-magic-sparkles" style="color: #f59e0b;"></i> Thử đồ AI
        </h2>
        <p style="color: #999; font-size: 14px;">Upload ảnh của bạn để xem sản phẩm trông như thế nào trên bạn</p>
    </div>

    @if(session('error'))
        <div style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('ai.process') }}" method="POST" enctype="multipart/form-data" id="tryonForm">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div style="display: grid; grid-template-columns: 1fr 80px 1fr; gap: 20px; align-items: center;">

            {{-- Ảnh người dùng --}}
            <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; overflow: hidden;">
                <div style="padding: 15px 20px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-user" style="color: #f59e0b;"></i>
                    <span style="font-weight: 600; font-size: 14px;">Ảnh của bạn</span>
                </div>
                <div style="padding: 20px;">
                    <div id="upload-area"
                         style="border: 2px dashed #e5e5e5; border-radius: 10px; padding: 40px 20px; text-align: center; cursor: pointer; transition: 0.3s; min-height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center;"
                         onclick="document.getElementById('user_image').click()"
                         ondragover="event.preventDefault(); this.style.borderColor='#f59e0b'; this.style.background='#fffbeb';"
                         ondragleave="this.style.borderColor='#e5e5e5'; this.style.background='transparent';"
                         ondrop="event.preventDefault(); document.getElementById('user_image').files = event.dataTransfer.files; previewImage(document.getElementById('user_image')); this.style.borderColor='#e5e5e5'; this.style.background='transparent';">

                        <img id="preview" src="" alt=""
                             style="display: none; max-width: 100%; max-height: 280px; border-radius: 8px; object-fit: contain;">

                        <div id="upload-placeholder">
                            <div style="width: 60px; height: 60px; margin: 0 auto 15px; border-radius: 50%; background: #fffbeb; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size: 24px; color: #f59e0b;"></i>
                            </div>
                            <p style="font-weight: 500; color: #333; margin-bottom: 6px;">Kéo thả ảnh vào đây</p>
                            <p style="color: #999; font-size: 13px;">hoặc click để chọn file</p>
                            <p style="color: #bbb; font-size: 12px; margin-top: 8px;">JPG, PNG — Tối đa 5MB</p>
                        </div>
                    </div>

                    <input type="file" id="user_image" name="user_image"
                           accept="image/jpg,image/jpeg,image/png"
                           style="display: none;"
                           onchange="previewImage(this)">

                    <button type="button" id="btn-change" style="display: none; margin-top: 10px; width: 100%; padding: 8px; border: 1px solid #e5e5e5; border-radius: 6px; background: #fff; cursor: pointer; font-size: 13px; color: #666;"
                            onclick="document.getElementById('user_image').click()">
                        <i class="fa-solid fa-arrows-rotate"></i> Đổi ảnh khác
                    </button>
                </div>
            </div>

            {{-- Icon giữa --}}
            <div style="text-align: center;">
                <div style="width: 50px; height: 50px; margin: 0 auto; border-radius: 50%; background: #f59e0b; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-plus" style="color: #fff; font-size: 18px;"></i>
                </div>
            </div>

            {{-- Ảnh sản phẩm --}}
            <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; overflow: hidden;">
                <div style="padding: 15px 20px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-shirt" style="color: #f59e0b;"></i>
                    <span style="font-weight: 600; font-size: 14px;">Sản phẩm</span>
                </div>
                <div style="padding: 20px;">
                    <div style="min-height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <img src="{{ product_image($product->thumbnail_url) }}"
                             alt="{{ $product->name }}"
                             style="max-width: 100%; max-height: 280px; border-radius: 8px; object-fit: contain;">
                    </div>
                    <div style="margin-top: 15px; text-align: center;">
                        <h4 style="font-size: 15px; margin-bottom: 4px;">{{ $product->name }}</h4>
                        <p style="color: #f59e0b; font-weight: 700; font-size: 16px;">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Hướng dẫn --}}
        <div style="background: #fffbeb; border: 1px solid #fef3c7; padding: 14px 18px; border-radius: 10px; margin-top: 20px; display: flex; gap: 12px; align-items: start;">
            <i class="fa-solid fa-lightbulb" style="color: #f59e0b; margin-top: 2px;"></i>
            <div style="font-size: 13px; color: #92400e; line-height: 1.6;">
                <strong>Mẹo để có kết quả tốt nhất:</strong>
                Sử dụng ảnh chụp toàn thân, đứng thẳng, nền đơn giản, ánh sáng tốt. Ảnh càng rõ thì kết quả AI càng chính xác.
            </div>
        </div>

        {{-- Nút submit --}}
        <button type="submit" id="submitBtn"
                style="width: 100%; margin-top: 20px; padding: 16px; background: #f59e0b; color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fa-solid fa-wand-magic-sparkles"></i> Bắt đầu thử đồ
        </button>

        {{-- Loading overlay --}}
        <div id="loading-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 9999; display: none; align-items: center; justify-content: center;">
            <div style="background: #fff; padding: 40px 50px; border-radius: 16px; text-align: center;">
                <div class="spinner" style="width: 50px; height: 50px; border: 4px solid #f0f0f0; border-top: 4px solid #f59e0b; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
                <h3 style="margin-bottom: 8px; color: #333;">AI đang xử lý...</h3>
                <p style="color: #999; font-size: 14px;">Vui lòng đợi khoảng 30-60 giây</p>
                <p style="color: #bbb; font-size: 12px; margin-top: 6px;">Không đóng trang trong lúc xử lý</p>
            </div>
        </div>

    </form>

    {{-- Nút quay lại --}}
    <div style="text-align: center; margin-top: 15px;">
        <a href="{{ route('product.show', $product->id) }}" style="color: #999; font-size: 14px; text-decoration: none;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại sản phẩm
        </a>
    </div>

</div>

@endsection

@push('styles')
<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    #upload-area:hover {
        border-color: #f59e0b !important;
        background: #fffbeb;
    }

    #submitBtn:hover {
        background: #d97706;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    #submitBtn:disabled {
        background: #999;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
</style>
@endpush

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').style.display = 'block';
            document.getElementById('upload-placeholder').style.display = 'none';
            document.getElementById('btn-change').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('tryonForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('user_image');
    if (!fileInput.files || !fileInput.files[0]) {
        e.preventDefault();
        alert('Vui lòng chọn ảnh của bạn trước!');
        return;
    }

    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<div class="spinner" style="width:20px;height:20px;border:3px solid rgba(255,255,255,0.3);border-top:3px solid #fff;border-radius:50%;animation:spin 1s linear infinite;display:inline-block;"></div> AI đang xử lý...';
    btn.disabled = true;

    document.getElementById('loading-overlay').style.display = 'flex';
});
</script>
@endpush